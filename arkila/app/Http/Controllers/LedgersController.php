<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ledger;
use App\Destination;
use App\Rules\checkCurrency;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use DB;
use PDF;


class LedgersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = Carbon::now();
        $ledgers = Ledger::all();
        $mainTerminal = Destination::where('is_main_terminal', 1)->get()->first();
        return view('ledger.index', compact('ledgers', 'date', 'mainTerminal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ledger.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->or == null && $request->payor == null) {
            $this->validate(request(), [
                'particulars' => 'bail|required|max:30',
                'amount' => ['bail',new checkCurrency,'numeric', 'required', 'min:0'],
                'type' => [
                    'bail',
                    'required',
                    Rule::in(['Revenue', 'Expense'])
                ],
            ]);            
        } elseif ($request->or == null) {
            $this->validate(request(), [
                'payor' => ['bail', 'max:25'],
                'particulars' => 'bail|required|max:30',
                'amount' => ['bail',new checkCurrency,'numeric', 'required', 'min:0'],
                'type' => [
                    'bail',
                    'required',
                    Rule::in(['Revenue', 'Expense'])
                ],
            ]);
        }elseif ($request->payor == null) {
            $this->validate(request(), [
                'particulars' => 'bail|required|max:30',
                'amount' => ['bail',new checkCurrency,'numeric', 'required', 'min:0'],
                'or' =>  'bail|unique:ledger,or_number|max:15',
                'type' => [
                    'bail',
                    'required',
                    Rule::in(['Revenue', 'Expense'])
                ],
            ]);
        } else {
            $this->validate(request(), [
                'payor' => ['bail', 'max:25'],
                'particulars' => 'bail|required|max:30',
                'or' =>  'bail|unique:ledger,or_number|max:15',
                'amount' => ['bail',new checkCurrency,'numeric', 'required', 'min:0'],
                'type' => [
                    'bail',
                    'required',
                    Rule::in(['Revenue', 'Expense'])
                ],
            ]);
        }

        Ledger::create([
            'payee' => $request->payor,
            'description' => $request->particulars,
            'or_number' => $request->or,
            'amount' => $request->amount,
            'type' => $request->type,
        ]);

        return redirect('/home/ledger');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Ledger $ledger)
    {
        return view('ledger.edit', compact('ledger'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Ledger $ledger)
    {
        $this->validate(request(), [
            'payor' => ['bail', 'max:25'],
            'particulars' => 'bail|required|max:30',
            'or' =>  'bail|max:15|unique:ledger,or_number,'.$ledger->ledger_id.',ledger_id',
            'amount' => ['bail',new checkCurrency,'numeric', 'required', 'min:0'],
            'type' => [
                'bail',
                'required',
                Rule::in(['Revenue', 'Expense'])
            ],
        ]);
        
        $ledger->update([
            'payee' => request('payor'),
            'description' => request('particulars'),
            'or_number' => request('or'),
            'amount' => request('amount'),
            'type' => request('type'), 
        ]);

        return redirect('/home/ledger');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ledger $ledger)
    {
        $ledger->delete();
        return back();
    }

    public function generalLedger(Request $request) {
        $start = $request->start;
        $end = $request->end;
        $date = Carbon::now();
        $thisDate = $date->setTimezone('Asia/Manila');
        $ledgers = Ledger::all();
        $bookings = Ledger::select('created_at','description', DB::raw("SUM(amount) as total_amount"))->where('description', 'Booking Fee')
        ->groupBy(DB::raw('day(created_at)'), DB::raw('month(created_at)'), DB::raw('year(created_at)'))->get();
        $sops = Ledger::select('created_at','description', DB::raw("SUM(amount) as total_amount"))->where('description', 'SOP')
        ->groupBy(DB::raw('day(created_at)'), DB::raw('month(created_at)'), DB::raw('year(created_at)'))->get();
        $expired = Ledger::select('created_at','description', DB::raw("SUM(amount) as total_amount"))->where('description', 'Expired Ticket')
        ->groupBy(DB::raw('day(created_at)'), DB::raw('month(created_at)'), DB::raw('year(created_at)'))->get();

        return view('ledger.generalLedger', compact('ledgers', 'thisDate', 'bookings', 'sops', 'expired', 'start', 'end'));
    }

    public function dateRange(Request $request) {
        $start = $request->start;
        $end = $request->end;
        if ($start == null && $end == null) {
            return redirect('/home/general-ledger');
        } elseif ($end == null) {
            return back()->withErrors('Please enter an ending date');          
        } elseif ($start == null){
            return back()->withErrors('Please enter a starting date');          
        } else {
            $date = Carbon::now();
            $thisDate = $date->setTimezone('Asia/Manila');
            $ledgers = Ledger::whereBetween('created_at', [$start . ' 00:00:00', $end .' 23:59:59'])->get();
            $bookings = Ledger::select('created_at','description', DB::raw("SUM(amount) as total_amount"))->where('description', 'Booking Fee')
            ->groupBy(DB::raw('day(created_at)'), DB::raw('month(created_at)'), DB::raw('year(created_at)'))
            ->whereBetween('created_at', [$start . ' 00:00:00', $end .' 23:59:59'])->get();
            $sops = Ledger::select('created_at','description', DB::raw("SUM(amount) as total_amount"))->where('description', 'SOP')
            ->groupBy(DB::raw('day(created_at)'), DB::raw('month(created_at)'), DB::raw('year(created_at)'))
            ->whereBetween('created_at', [$start . ' 00:00:00', $end .' 23:59:59'])->get();
            $expired = Ledger::select('created_at','description', DB::raw("SUM(amount) as total_amount"))->where('description', 'Expired Ticket')
            ->groupBy(DB::raw('day(created_at)'), DB::raw('month(created_at)'), DB::raw('year(created_at)'))
            ->whereBetween('created_at', [$start . ' 00:00:00', $end .' 23:59:59'])->get();

            return view('ledger.generalLedger', compact('ledgers', 'thisDate', 'bookings', 'sops', 'expired', 'start', 'end'));
        }
    }

    public function generatePDF(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $date = Carbon::now();
        $ledgers = Ledger::all()->where('description', '!=' , 'Booking Fee')->where('description', '!=' , 'SOP');
        $pdf = PDF::loadView('pdf.daily', compact('ledgers', 'date'));
        $pdf->setPaper('letter', 'landscape');
        return $pdf->stream('ledger.pdf');
    }
}

@extends('layouts.form')
@section('title', 'Edit Revenue/Expense')
@section('form-title', 'Edit Daily Ledger')
@section('links')
@parent
  <link rel="stylesheet" href="public\css\myOwnStyle.css">
@stop
@section('content')
@section('form-action', route('ledger.update', [$ledger->ledger_id]))
@section('method_field', method_field('PATCH'))
@section('form-body')
@section('back-link', route('ledger.index'))


<div class="form-group">
    <label for="payor">Payee/Payor:</label>
    <input type="text" class="form-control" name="payor" value="{{ $ledger->payee }}">
</div>
<div class="form-group">
    <label for="Particulars">Particulars:<span class="text-red">*</span></label>
    <input type="text" class="form-control" name="particulars" value="{{ $ledger->description }}" val-particulars required>
</div>
<div class="form-group">
    <label for="or">OR#:</label>
    <input type="text" class="form-control" name="or" value="{{ $ledger->or_number }}">
</div>
<div class="form-group">
    <label for="amount">Amount: <span class="text-red">*</span></label>
    <input type="number" class="form-control" name="amount" min="0" placeholder="Php 0.00" value="{{ $ledger->amount }}" val-partAmount required>
</div>

<div class="radio" style="margin-left: 7% ">        
    <label class="radio-inline">
    <input type="radio" name="type" id="rev" class="flat-blue" value="Revenue"  checked @if(old('type') || $ledger->type == 'Revenue') {{ 'checked' }} @endif>
    </label>
    <label class="form-check-label" for="rev"> Revenue</label>

    <label class="radio-inline">
        <input type="radio" name="type" id="exp" class="flat-blue" value="Expense" @if(old('type') || $ledger->type == 'Expense') {{ 'checked' }} @endif>
    </label>  
    <label class="form-check-label" for="exp">Expense</label>
</div>
    

@endsection
@section('form-btn')
    <button type="submit" class="btn btn-primary" data-dismiss="modal">Submit</button>

@endsection

@section('scripts')
@parent
    <script type="text/javascript">
        $(function () {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
              checkboxClass: 'icheckbox_flat-blue',
              radioClass   : 'iradio_flat-blue'
            });
        });
   </script>

@endsection

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
    <label for="Particulars">Particulars:</label>
    <input type="text" class="form-control" name="particulars" value="{{ $ledger->description }}">
</div>
<div class="form-group">
    <label for="or">OR#:</label>
    <input type="text" class="form-control" name="or"  value="{{ $ledger->or_number }}">
</div>
<div class="form-group">
    <label for="amount">Amount:</label>
    <input type="number" class="form-control" name="amount" value="{{ $ledger->amount }}">
</div>
<div class="form-group" name="revenueExpense">

<div class="form-group">
    <div class="radio">
        <label>Revenue</label>
        <div class="col-md-6">
            <label class="radio-inline">
                <input type="radio" value="Revenue" name="type" class="with-gap" @if(old('type') || $ledger->type == 'Revenue') {{ 'checked' }} @endif>
            </label>
        </div>

        <div class="col-md-6">
            <label>Expense</label>
            <label class="radio-inline">
                <input type="radio" value="Expense" name="type" class="with-gap" @if(old('type') || $ledger->type == 'Expense') {{ 'checked' }} @endif>      
            </label>
        </div>
    </div>
</div>
    
@endsection
@section('form-btn')
    
    <button type="submit" class="btn btn-primary" data-dismiss="modal">Submit</button>

    
@endsection

@section('scripts')
@parent

@endsection
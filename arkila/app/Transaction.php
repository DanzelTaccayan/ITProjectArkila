<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';
    protected $primaryKey = 'transaction_id';
    protected $guarded = ['transaction_id'];

    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::Class, 'ticket_id');
    }
    
    public function getTotalAmountAttribute()
    {
        return $this->sum('amount_paid');
    }
}

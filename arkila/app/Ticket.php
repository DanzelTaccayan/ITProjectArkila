<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'ticket';
    protected $primaryKey = 'ticket_id';
    protected $guarded = [
        'ticket_id',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::Class,'destination_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::Class, 'transaction_id');
    }

    public function selectedTicket()
    {
        return $this->hasOne(SelectedTicket::class,'ticket_id');
    }

    public function scopeShowAllSelectedTickets($query, $destinations){
        return $query->whereIn('destination_id',$destinations)->whereIn('ticket_id',SelectedTicket::all()->pluck('ticket_id'));
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use AustinHeap\Database\Encryption\Traits\HasEncryptedAttributes;

class Ticket extends Model
{
    use HasEncryptedAttributes;

    protected $table = 'ticket';
    protected $primaryKey = 'ticket_id';
    protected $guarded = [
        'ticket_id',
    ];

    protected $encrypted = [
        'reservation_code',
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

    public function soldTicket()
    {
        return $this->hasOne(SoldTicket::class, 'ticket_id');
    }

    public function scopeShowAllSelectedTickets($query, $destinations,$terminalId){
        return $query->whereIn('destination_id',$destinations)->whereIn('ticket_id',SelectedTicket::where('selected_from_terminal',$terminalId)->pluck('ticket_id'));
    }
}

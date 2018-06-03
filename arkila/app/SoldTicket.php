<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoldTicket extends Model
{
    protected $table = 'sold_ticket';
    protected $primaryKey = 'sold_ticket_id';
    protected $guarded = [
        'sold_ticket_id',
    ];

    public function ticket() {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}

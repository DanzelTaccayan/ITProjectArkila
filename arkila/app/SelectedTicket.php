<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SelectedTicket extends Model
{
    protected $table = 'selected_ticket';
    protected $primaryKey = 'selected_ticket_id';
    protected $guarded = [
        'selected_ticket_id',
    ];
    public $timestamps = false;


    public function ticket() {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}

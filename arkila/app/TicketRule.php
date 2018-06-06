<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketRule extends Model
{
    protected $table = 'ticket_rule';
    protected $primaryKey = 'id';
    protected $fillable = [
        'usable_days',
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingRules extends Model
{
    protected $table = 'booking_rules';
	protected $primaryKey = 'rule_id';
    protected $guarded = ['rule_id',];
}

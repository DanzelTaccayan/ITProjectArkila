<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservationDate extends Model
{
    protected $table = 'reservation_date';
    protected $dates = ['reservation_date'];
    protected $primaryKey = 'id';
	protected $guarded = [
    	'id',
    ]; 

    public function destination(){
    	return $this->hasOne(Destination::Class, 'destination_id', 'destination_terminal');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    //
    protected $table = 'reservation';
    protected $dates = ['expiry_date'];
    protected $primaryKey = 'id';
	protected $guarded = [
    	'id',
    ]; 
    

    public function destination(){
    	return $this->belongsTo(Destination::Class, 'destination_id');
    }
    public function date(){
    	return $this->belongsTo(ReservationDate::Class, 'destination_id', 'id');
    }

    public function reservationDate(){
    	return $this->hasOne(ReservationDate::Class, 'id', 'date_id');        
    }

    public function user(){
        return $this->belongsTo(User::Class, 'user_id', 'id');
    }

    // public function setContactNumberAttribute($value){
    //     $contactArr = explode('-',$value);
    //     $this->attributes['contact_number'] = '+63'.$contactArr[0].$contactArr[1].$contactArr[2];
    // }

    // public function getContactNumberAttribute($value){
    //     return substr($value, 3);
    // }

}

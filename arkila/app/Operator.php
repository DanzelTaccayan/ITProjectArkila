<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Operator extends Model
{
	protected $primaryKey = 'operator_id';
    protected $guarded = [
    	'operator_id',
    ];
    public function driver(){
    	return $this->hasMany(Driver::class, 'driver_id');
    }

    public function getContactNumberAttribute($value){
        return substr($value, 3);
    }

    public function getEmergencyContactnoAttribute($value){
        return substr($value, 3);
    }
}

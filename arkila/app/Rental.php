<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Van;
use App\User;

class Rental extends Model
{
    protected $table = 'rental';
    protected $primaryKey = 'rent_id';
    protected $guarded = [
        'rent_id',
    ];

    public function van(){
    	return $this->belongsTo(Van::Class, 'plate_number');
    }

    public function driver(){
    	return $this->hasOne(Member::Class, 'member_id', 'driver_id');
    }

    public function users(){
    	return $this->belongsTo(User::Class, 'driver_id', 'id');
    }

    public function getFullNameAttribute(){
        return "{$this->first_name} {$this->last_name}";
    }

    public function vanmodel(){
    	return $this->belongsTo(VanModel::Class, 'model_id');
    }

    public function user(){
        return $this->belongsTo(User::Class, 'user_id', 'id');
    }

    public function setContactNumberAttribute($value){
        $contactArr = explode('-',$value);
        $this->attributes['contact_number'] = '+63'.$contactArr[0].$contactArr[1].$contactArr[2];
    }
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Van;
use App\User;

class VanRental extends Model
{
    protected $table = 'van_rental';
    protected $primaryKey = 'rent_id';
    protected $guarded = [
        'rent_id',
    ];

    public function van(){
    	return $this->belongsTo(Van::Class, 'van_id');
    }

    public function getFullNameAttribute(){
        return "{$this->first_name} {$this->last_name}";
    }

    public function user(){
        return $this->belongsTo(User::Class, 'user_id', 'id');
    }

    public function setContactNumberAttribute($value){
        $contactArr = explode('-',$value);
        $this->attributes['contact_number'] = '+63'.$contactArr[0].$contactArr[1].$contactArr[2];
    }
}

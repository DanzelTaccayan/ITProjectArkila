<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'company_profile';
    protected $primaryKey = 'id';
    protected $guarded = [
        'id',
    ];

    public function setContactNumberAttribute($value){
        $contactArr = explode('-',$value);
        $this->attributes['contact_number'] = '+63'.$contactArr[0].$contactArr[1].$contactArr[2];
    }

}

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
}

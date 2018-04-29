<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $table = 'fee';
	protected $primaryKey = 'fee_id';    //
    protected $guarded = [
      'fee_id',
    ];

}

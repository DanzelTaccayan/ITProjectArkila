<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Destination extends Model
{
    protected $table = 'destination';
	protected $primaryKey = 'id';
    protected $guarded = ['id',];

    public function tickets(){
        return $this->hasMany(Ticket::class, 'destination_id');
    }
    //
}

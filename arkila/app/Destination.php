<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Destination extends Model
{
    protected $table = 'destination';
	protected $primaryKey = 'destination_id';
    protected $guarded = ['destination_id',];

    public function transaction(){
      return $this->hasMany(Transaction::class, 'transaction_id');
    }

    public function reservation(){
    	return $this->hasOne(Reservation::class, 'id');
    }

    public function terminal(){
    	return $this->belongsTo(Terminal::class, 'terminal_id');
    }

    public function trip(){
        return $this->hasMany(Trip::class, 'trip_id');
    }
    //
}

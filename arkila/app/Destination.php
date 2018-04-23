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

    public function termOrigin(){
        return $this->belongsTo(Terminal::class, 'origin', 'terminal_id');
    }

    public function termDestination(){
        return $this->belongsTo(Terminal::class, 'destination', 'terminal_id');
    }

    public function route(){
        return $this->belongsToMany(Route::class,'destination_route','id','route_id');
    }
    //
}

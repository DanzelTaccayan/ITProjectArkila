<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    //
    protected $table = 'terminal';
    protected $primaryKey = 'terminal_id';
    protected $guarded = [
    	'terminal_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function destination() {
    	return $this->hasMany(Destination::class, 'destination_id');
    }

    public function trips(){
        return $this->hasMany(Trip::class,'terminal_id');
    }

}

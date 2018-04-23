<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    protected $table = 'terminal';
    protected $primaryKey = 'terminal_id';
    protected $guarded = [
        'terminal_id',
    ];

    public function destOrigin(){
        return $this->hasMany(Destination::class, 'terminal_id', 'origin');
    }

    public function destination(){
        return $this->hasMany(Destination::class, 'terminal_id', 'destination');
    }


}

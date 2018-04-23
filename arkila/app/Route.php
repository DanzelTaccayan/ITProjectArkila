<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $table = 'route';
    protected $primaryKey = 'route_id';
    protected $guarded = [
        'route_id',
    ];

    public function destination(){
        return $this->belongsToMany(Destination::class,'destination_route','route_id','id');
    }
}

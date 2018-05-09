<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Destination extends Model
{
    protected $table = 'destination';
	protected $primaryKey = 'destination_id';
    protected $guarded = ['destination_id',];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'destination_id');
    }

    public function routeOrigin()
    {
        return $this->belongsToMany(Destination::class,'route_terminal','route','terminal_origin')
        ->withPivot('terminal_destination');
    }

    public function routeDestination()
    {
        return $this->belongsToMany(Destination::class,'route_terminal','route','terminal_destination')
        ->withPivot('terminal_origin');
    }

    public function routeFromOrigin()
    {
        return $this->belongsToMany(Destination::class,'route_terminal','terminal_origin','route')
        ->withPivot('terminal_destination');
    }

    public function routeFromDestination()
    {
        return $this->belongsToMany(Destination::class,'route_terminal','terminal_destination','route')
        ->withPivot('terminal_origin');
    }

    public function terminalOrigin()
    {
        return $this->belongsToMany(Destination::class,'route_terminal','terminal_destination','terminal_origin')
        ->withPivot('route');
    }

    public function terminalDestination()
    {
        return $this->belongsToMany(Destination::class,'route_terminal','terminal_origin','terminal_destination')
        ->withPivot('route');
    }

    public function vanQueue()
    {
        return $this->hasMany(VanQueue::class, 'destination_id');
    }

    public static function scopeAllTerminal($query)
    {
        return $query->where([
            ['is_terminal','1'],
            ['is_main_terminal', '0'],
        ]);
    }

    public static function scopeWithMainTerminal($query)
    {
        return $query->where('is_terminal', '1');
    }

    public static function scopeAllRoute($query)
    {
        return $query->where('is_terminal','0');
    }

    // public function route(){
    //     return $this->belongsToMany(Destination::class,'route_terminal','destination_id','route');
    // }

    // public function termDestination(){
    //     return $this->belongsToMany(Destination::class, 'route_terminal','destination_id','terminal_destination');
    // }
    //
}

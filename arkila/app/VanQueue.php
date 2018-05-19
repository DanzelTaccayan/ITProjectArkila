<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VanQueue extends Model
{
    protected $table = 'van_queue';
    protected $guarded = ['van_queue_id',];
    protected $primaryKey = 'van_queue_id';
    public $timestamps = false;

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destination_id');
    }

    public function van(){
        return $this->belongsTo(Van::class,'van_id');
    }
    public function driver(){
        return $this->belongsTo(Member::class,'driver_id', 'member_id');
    }

}

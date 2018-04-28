<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VanQueue extends Model
{
    protected $table = 'van_queue';

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destination_id');
    }
}

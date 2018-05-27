<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use AustinHeap\Database\Encryption\Traits\HasEncryptedAttributes;

class Van extends Model
{
    use HasEncryptedAttributes;

    protected $table = 'van';
	protected $primaryKey = 'van_id';
    protected $guarded = [
    	'van_id',
	];
    protected $encrypted = [
        'plate_number','seating_capacity'
    ];

	//

    public function members()
    {
        return $this->belongsToMany(Member::class,'member_van','van_id','member_id');
    }
    public function rental()
    {
    	return $this->hasOne(VanRental::Class, 'rent_id');
    }

    public function model()
    {
        return $this->belongsTo(VanModel::Class, 'model_id');
    }

    public function archivedMember()
    {
        return $this->belongsToMany(Member::class,'van_history','van_id','member_id')->withTimestamps();
    }

    public function driver()
    {
        return $this->members()->where('role','Driver');
    }

    public function operator()
    {
        return $this->members()->where('role','Operator');
    }

    public function vanQueue()
    {
    	return $this->hasMany(VanQueue::Class, 'van_id','van_id');
    }

    public function updateQueue($queue_number)
    {
        $queue_number+=1;
        if(!is_null($this->vanQueue()->where('queue_number','!=',null)->first()))
        {
            $this->vanQueue()->where('queue_number','!=',null)->first()->update(compact('queue_number'));
        }
    }

    public function setPlateNumberAttribute($value)
    {
        $this->attributes['plate_number'] = strtoupper($value);
    }

}

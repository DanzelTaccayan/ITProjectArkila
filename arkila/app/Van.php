<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Rental;
class Van extends Model
{
    protected $table = 'van';
	protected $primaryKey = 'plate_number';
	public $incrementing = false;
	protected $keyType = 'String';
    protected $fillable = [
    	'plate_number',
        'model_id',
        'seating_capacity',
        'status',
	];  
	//

    public function members(){
        return $this->belongsToMany(Member::class,'member_van','plate_number','member_id');
    }
    public function rental(){
    	return $this->hasOne(Rental::Class, 'rent_id');
    }

    public function vanModel() {
        return $this->belongsTo(VanModel::Class, 'model_id');
            
    }

    public function archivedMember(){
        return $this->belongsToMany(Member::class,'archive_van','plate_number','member_id')->withTimestamps();
    }

    public function driver(){
        return $this->members()->where('role','Driver');
    }

    public function operator(){
        return $this->members()->where('role','Operator');
    }

    public function trips(){
    	return $this->hasMany(Trip::Class, 'plate_number');
    }

    public function updateQueue($queue_number){
        $queue_number+=1;
        if(!is_null($this->trips()->where('queue_number','!=',null)->first())){
            $this->trips()->where('queue_number','!=',null)->first()->update(compact('queue_number'));
        }
    }

}

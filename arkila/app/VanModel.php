<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VanModel extends Model
{

    protected $table = 'van_model';
    protected $primaryKey = 'model_id';
    protected $fillable = [
        'description',
    ];
    public function van() {
    	return $this->hasMany(Van::Class, 'plate_number');
        
    }

    public function rental(){
    	return $this->belongsTo(Rental::Class, 'rent_id');
    }

}

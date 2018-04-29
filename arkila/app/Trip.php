<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
class Trip extends Model
{
    
    protected $table = 'trip';
    protected $primaryKey = 'trip_id';
    protected $guarded = [
        'trip_id',
    ];

    public function van(){
    	return $this->belongsTo(Van::class, 'van_id');
    }

    public function driver(){
      return $this->belongsTo(Member::class,  'driver_id', 'member_id');
    }

    public function transactions()
    {
      return $this->hasMany(Transaction::class, 'trip_id');
    }

    public function getDateDepartedAttribute($value)
    {
      return Carbon::parse($value)->toFormattedDateString();
    }

    public function getTimeDepartedAttribute($value)
    {
      return Carbon::parse($value)->format('g:i A');
    }

    public function scopeDeparted($query)
    {
      return $query->where('status', '=','Departed');  
    }
    
    public function scopePending($query)
    {
      return $query->where('report_status', '=','Pending');  
    }
    
    public function scopeAccepted($query)
    {
      return $query->where('report_status', '=','Accepted');  
    }
    
    public function setDateDepartedAttribute($value)
    {
      $this->attributes['date_departed'] = Carbon::parse($value);
    }


}

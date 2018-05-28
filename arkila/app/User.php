<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification;
class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'username','email', 'password', 'terminal_id', 'user_type', 'status', 'model_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function member()
    {
        return $this->hasOne(Member::class, 'user_id', 'id');
    }

    public function verifyUser()
    {
        return $this->hasOne('App\VerifyUser');
    }

    public function reservation()
    {
      return $this->hasMany(Reservation::class, 'user_id', 'id');
    }

    public function rental()
    {
      return $this->hasMany(VanRental::class, 'user_id', 'id');
    }

    public function scopeStatusEnable($query)
    {
      return $query->where('status', '=', 'enable');
    }

    public function scopeSuperAdmin($query)
    {
      return $query->where('user_type', '=', 'Super-Admin');
    }

    public function scopeAdmin($query)
    {
        return $query->where('user_type', '=','Admin');
    }

    public function scopeDriver($query)
    {
        return $query->where('user_type', '=', 'Driver');
    }

    public function scopeCustomer($query)
    {
        return $query->where('user_type', '=', 'Customer');
    }

    public function isEnable()
    {
      return $this->status === 'enable';
    }

    public function isSuperAdmin()
    {
      return $this->user_type === 'Super-Admin';
    }

    public function isAdmin()
    {
      return $this->user_type === 'Admin';
    }

    public function isDriver()
    {
      return $this->user_type === 'Driver';
    }

    public function isCustomer()
    {
      return $this->user_type === 'Customer';
    }

    public function getFullNameAttribute()
    {
        return "{$this->last_name}, {$this->first_name} {$this->middle_name}";
    }
    
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}

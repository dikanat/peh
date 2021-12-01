<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Access;

class User extends Authenticatable implements MustVerifyEmail {

  use Notifiable, LogsActivity;

  protected $fillable = [
    'id_access',
    'name',
    'username',
    'password',
    'remember_token',
    'email',
    'phone',
    'address_1',
    'address_2',
    'email_verified_at',
    'active',
    'status',
    'photo_profile'
  ];


  protected $hidden = ['password', 'remember_token', 'api_token'];
  protected $casts = ['email_verified_at' => 'datetime'];

  protected static $logAttributes = ['*'];

  public function roles(){
    return $this->belongsTo(Role::class, 'id_role');
  }

  public function sendPasswordResetNotification($token) {
    $this->notify(new ResetPasswordNotification($token));
  }

}

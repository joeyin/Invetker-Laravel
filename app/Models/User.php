<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'role',
    'email',
    'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
    'created_at',
    'email_verified_at',
    'updated_at',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'role' => Role::class,
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  protected function getAvatarAttribute()
  {
    $email = $this->email;
    $default = 'mp';
    $size = 40;
    $url = 'https://www.gravatar.com/avatar/' . hash('sha256', strtolower(trim($email))) . '?d=' . urlencode($default) . '&s=' . $size;
    return $url;
  }
}

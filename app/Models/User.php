<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');

    }

    public function favorites()
    {
        return $this->belongsToMany(Favorite::class, 'favorites', 'user_id', 'favorite_user_id');
    }

    public function favorite()
    {
        return $this->belongsToMany(User::class, 'favorites', 'favorite_user_id', 'user_id')
                        ->where('user_id', auth()->user()->id);
    }

    public function allusers()
    {
         return $this->inRandomOrder()
                        ->where('id','!=',auth()->user()->id)
                        ->with(['favorite'])
                        ->get();

    }

}

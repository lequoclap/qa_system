<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function createOrUpdate($data)
    {
        $user = self::where(['email' => $data['email']])->first();
        if (!$user) {
            $user = new User();
            $user->name         = $data['name'];
            $user->email        = $data['email'];
            $user->password     = $data['password'];
            }
        $user->save();
        return $user;
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

}

<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','subscriber', 'administrator', //DB fields
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [                   //hides token and pw    
        'password', 'remember_token',
    ];

    protected $casts= [                 //changes to boolean
        'subscriber'=>'boolean',
        'administrator' => 'boolean',
    ];
    public function posts(){                //relation with posts
        return $this->hasMany('App\Post');
    }
    public function streams(){                //relation with streams
        return $this->hasMany('App\Stream');
    }

}

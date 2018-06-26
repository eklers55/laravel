<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
           // Table Name
           protected $table = 'streams';
           // Primary Key
           public $primaryKey = 'id';
           // Timestamps
           public $timestamps = true;
               //relation with user
            public function user(){
                return $this->belongsTo('App\User');
            }
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Stream extends Model
{
            use LogsActivity;

            protected static $recordEvents = ['deleted', 'created', 'updated'];
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

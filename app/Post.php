<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
class Post extends Model
{
        use LogsActivity;

        protected static $recordEvents = ['deleted', 'created', 'updated'];
        // Table Name
        protected $table = 'posts';
        // Primary Key
        public $primaryKey = 'id';
        // Timestamps
        public $timestamps = true;
        
        public function user(){
            return $this->belongsTo('App\User'); //realtion with users
        }
}

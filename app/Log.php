<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model {

    protected $fillable = ['date', 'message', 'user_id'];
    
    public $timestamps = true;

    public function user() {
	return $this->belongsTo('App\User');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'positions';
	
	public $timestamps = false;
	
	public function contacts()
	{
		return $this->hasMany('App\Contact', 'positions_id');
	}
}

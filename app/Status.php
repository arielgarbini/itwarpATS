<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';
	
	public $timestamps = false;
	
	public function offers()
	{
		return $this->hasMany('App\Offer', 'status_id');
	}
}

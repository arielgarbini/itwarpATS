<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    protected $table = 'benefits';
	
	public $timestamps = false;

	public function offers()
	{
		return $this->hasMany('App\Offer', 'benefits_id');
	}
	
}

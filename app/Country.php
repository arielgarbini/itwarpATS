<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
	
	public $timestamps = false;
	
	public function states()
	{
		return $this->hasMany('App\State','countries_id');
	}

	public function addresses()
	{
		return $this->hasMany('App\Address','countries_id');
	}
}

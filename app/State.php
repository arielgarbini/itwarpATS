<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';

	public $timestamps = false;
	
	public function country()
	{
		return $this->belongsTo('App\Country','countries_id');
	}

	public function addresses()
	{
		return $this->hasMany('App\Address','states_id');
	}
}

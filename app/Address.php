<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';
	
	public $timestamps = false;
	
	public function country()
	{
		return $this->belongsTo('App\Country', 'countries_id');
	}

	public function state()
	{
		return $this->belongsTo('App\State', 'states_id');
	}

	public function customers()
	{
		return $this->hasMany('App\Customer', 'addresses_id');
	}

	public function offers()
	{
		return $this->hasMany('App\Offer', 'addresses_id');
	}

	public function candidates()
	{
		return $this->hasMany('App\Candidate', 'addresses_id');
	}
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
	
	public $timestamps = false;
	
	public function address()
	{
		return $this->belongsTo('App\Address', 'addresses_id');
	}

	public function created_by()
	{
		return $this->belongsTo('App\User', 'created_by');
	}

	public function owned_by()
	{
		return $this->belongsTo('App\User', 'owned_by');
	}

	public function contacts()
	{
		return $this->hasMany('App\Contact', 'customers_id');
	}
}

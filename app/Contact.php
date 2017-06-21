<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';
	
	public $timestamps = false;
	
	public function position()
	{
		return $this->belongsTo('App\Position', 'positions_id');
	}

	public function customer()
	{
		return $this->belongsTo('App\Customer', 'customers_id');
	}

	public function offers()
	{
		return $this->hasMany('App\Offer', 'contacts_id');
	}
}

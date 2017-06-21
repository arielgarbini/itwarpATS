<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelOfferRecruiter extends Model
{
    protected $table = 'rel_offers_recruiters';
	
	public $timestamps = false;
	
	public function recruiter()
	{
		return $this->belongsTo('App\User', 'recruiter');
	}

	public function offer()
	{
		return $this->belongsTo('App\Offer', 'offers_id');
	}
}

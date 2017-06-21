<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelOfferBenefit extends Model
{
    protected $table = 'rel_offers_benefits';
	
	public $timestamps = false;
	
	public function offer()
	{
		return $this->belongsTo('App\Offer', 'offers_id');
	}

	public function benefit()
	{
		return $this->belongsTo('App\Benefit', 'benefits_id');
	}
}

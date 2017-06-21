<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelOfferPositonType extends Model
{
    protected $table = 'rel_offers_positiontypes';
	
	public $timestamps = false;
	
	public function offer()
	{
		return $this->belongsTo('App\Offer', 'offers_id');
	}

	public function positionType()
	{
		return $this->belongsTo('App\PositionType', 'positiontypes_id');
	}
}

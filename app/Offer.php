<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = 'offers';

    public $timestamps = false;

    public function address()
	{
		return $this->belongsTo('App\Address', 'addresses_id');
	}

	public function created_by()
	{
		return $this->belongsTo('App\User', 'created_by');
	}
	
	public function status()
	{
		return $this->belongsTo('App\OfferStatus', 'offerstatus_id');
	}

	public function contact()
	{
		return $this->belongsTo('App\Contact', 'contacts_id');
	}

	public function recruiters()
	{
		return $this->hasMany('App\RelOfferRecruiter', 'offers_id');
	}

	public function candidates()
	{
		return $this->hasMany('App\RelOfferCandidate', 'offers_id');
	}

	public function benefits()
	{
		return $this->hasMany('App\RelOfferBenefit', 'offers_id');
	}

	public function positionTypes()
	{
		return $this->hasMany('App\RelOfferPositionType', 'offers_id');
	}

	public function comments()
	{
		return $this->hasMany('App\OfferComment', 'offers_id');
	}
}

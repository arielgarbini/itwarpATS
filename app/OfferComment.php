<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferComment extends Model
{
    protected $table = 'offercomments';
	
	public function user()
	{
		return $this->belongsTo('App\User', 'users_id');
	}

	public function offer()
	{
		return $this->belongsTo('App\Offer', 'offers_id');
	}


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CandidateOfferComment extends Model
{
    protected $table = 'candidateoffercomments';


   public function relOC()
	{
		return $this->belongsTo('App\RelOfferCandidate', 'rel_offers_candidates_id');
	}

	public function user()
	{
		return $this->belongsTo('App\User', 'created_by');
	}
}

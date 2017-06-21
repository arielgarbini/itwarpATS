<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelOfferCandidate extends Model
{
    protected $table = 'rel_offers_candidates';
	
	public function candidate()
	{
		return $this->belongsTo('App\Candidate', 'candidates_id');
	}

	public function recruiters()
	{
		return $this->belongsTo('App\User', 'recruiter');
	}

	public function statusActual()
	{
		return $this->belongsTo('App\RelStatusCandidateOffer', 'rel_status_candidate_offer_id');
	}

	public function offer()
	{
		return $this->belongsTo('App\Offer', 'offers_id');
	}

	public function statusHistory()
	{
		return $this->hasMany('App\RelStatusCandidateOffer', 'rel_offers_candidates');
	}
}

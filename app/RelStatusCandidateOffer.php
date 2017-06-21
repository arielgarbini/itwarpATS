<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelStatusCandidateOffer extends Model
{
    protected $table = 'rel_status_candidate_offer';
	
	public function candidate()
	{
		return $this->belongsTo('App\Candidate', 'candidates_id');
	}

	public function user()
	{
		return $this->belongsTo('App\User', 'users_id');
	}

	public function status()
	{
		return $this->belongsTo('App\Status', 'status_id');
	}

	public function offer()
	{
		return $this->belongsTo('App\Offer', 'offers_id');
	}
}

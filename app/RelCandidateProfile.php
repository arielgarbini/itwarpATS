<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelCandidateProfile extends Model
{
   	protected $table = 'rel_candidates_profiles';
	
	public $timestamps = false;
	
	public function candidate()
	{
		return $this->belongsTo('App\Candidate', 'candidate_id');
	}

	public function profile()
	{
		return $this->belongsTo('App\Profile', 'profiles_id');
	}

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CandidateComment extends Model
{
    protected $table = 'candidatecomments';
	
	public function user()
	{
		return $this->belongsTo('App\User', 'users_id');
	}

	public function candidate()
	{
		return $this->belongsTo('App\Offer', 'candidates_id');
	}


}

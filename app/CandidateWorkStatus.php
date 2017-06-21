<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CandidateWorkStatus extends Model
{
    protected $table = 'candidateworkstatus';
	
	public function candidates()
	{
		return $this->hasMany('App\Candidate', 'candidateworkstatus_id');
	}

}

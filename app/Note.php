<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'notes';
	
	public function candidate()
	{
		return $this->belongsTo('App\Candidate', 'candidate');
	}

	public function recruiter()
	{
		return $this->belongsTo('App\User', 'recruiter');
	}
}

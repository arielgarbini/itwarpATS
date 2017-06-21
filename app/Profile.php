<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';
	
	public $timestamps = false;
	
	public function candidates()
	{
		return $this->hasMany('App\RelCandidateProfile', 'profiles_id');
	}
}

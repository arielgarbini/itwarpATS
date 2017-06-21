<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $table = 'sources';
	
	public $timestamps = false;
	
	public function candidates()
	{
		return $this->hasMany('App\Candidate', 'sources_id');
	}
}

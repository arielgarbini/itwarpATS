<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';
	
	public $timestamps = false;
	
	public function users()
	{
		return $this->hasMany('App\User', 'roles_id');
	}
}

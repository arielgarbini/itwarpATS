<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PositionType extends Model
{
    protected $table = 'positiontypes';
	
	public $timestamps = false;
	
	public function offers()
	{
		return $this->hasMany('App\RelOfferPositionType', 'positiontypes_id');
	}
}

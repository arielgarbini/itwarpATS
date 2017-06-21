<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    public $timestamps = false;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function rol()
    {
        return $this->belongsTo('App\Rol', 'roles_id');
    }

    public function candidatesNominated()
    {
        return $this->hasMany('App\RelOfferCandidate', 'recruiter');
    }

    public function notes()
    {
        return $this->hasMany('App\Note', 'recruiter');
    }

    public function offers()
    {
        return $this->hasMany('App\RelOfferRecruiter', 'recruiter');
    }

    public function createdCustomers()
    {
        return $this->hasMany('App\Customer', 'created_by');
    }

    public function createdOffers()
    {
        return $this->hasMany('App\Offer', 'created_by');
    }

    public function customers()
    {
        return $this->hasMany('App\Customer', 'owned_by');
    }

    public function candidates()
    {
        return $this->hasMany('App\Candidate', 'created_by');
    }

     


}

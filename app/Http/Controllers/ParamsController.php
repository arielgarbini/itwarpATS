<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Request;
use Session;
use Auth;

class ParamsController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	} 


	public function getProfiles($id = null){

		$profiles = \App\Profile::where('is_active','=',1)->orderBy('profile','ASC')->get();

		if($id==null){

			return view('params.profiles')
			->with('profiles',$profiles);

		}else{

			$profile = \App\Profile::find($id);
			return view('params.profiles')
			->with('profile',$profile)
			->with('profiles',$profiles);			

		}
		
		
	}

	public function postProfile(){

		if (Input::has('profile_id'))
		{
			
			$profile = \App\Profile::find(Input::has('profile_id'));
  			$profile->profile = Input::get('profile');
  			if($profile->save()){
  				Session::flash('message', 'Perfil actualizado correctamente!!');
				return Redirect::to('profiles');
  			}
		}else{

			$rules = array(
				'profile' => 'required|max:255|unique:profiles',
				);

			$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('profiles')
			->withErrors($validator);
		} else {

                                $profile = \App\Profile::where('profile','=',Input::get('profile'))->first();
                                if($profile==null){
				$profile = new \App\Profile;
				$profile->profile = Input::get('profile');
				if($profile->save()){
  				Session::flash('message', 'Perfil creado correctamente!!');
				return Redirect::to('profiles');
                                 }else{
                                Session::flash('message', 'El perfil ya existe!!');
				return Redirect::to('profiles');
                                 
                                  }
  				}
			}

		}



	}

	public function getDelteProfile( $id = null )
	{
	
		$profile = \App\Profile::find($id);

		if($profile!=null){

		$profile->is_active = 0;

		if($profile->save()) {
					Session::flash('message', 'Perfil eliminado correctamente!!');
					return Redirect::to('profiles');
				}


		}else{
				
				return view('home');
			
		}
	}

	

}
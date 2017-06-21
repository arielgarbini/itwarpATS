<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Request;
use Session;
use Auth;

class UserController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	 public function __construct()
	{
		$this->middleware('auth');
	} 

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function getEditProfile($id = null)
	{	

		$user = \App\User::find($id);
		if($user!=null){
			if(Auth::user()->roles_id == 1 || Auth::user()->id == $id){
				$roles = \App\Rol::all();
				return view('users.edit')
				->with('user',$user)
				->with('roles',$roles);
			}else{
				Session::flash('message', 'No cuenta con los permisos necesarios!');
				return Redirect::to('/');
			}
		}else{
			Session::flash('message', 'No existe el usuario!');
			return Redirect::to('/');
		}

	}

	public function postEditProfile()
	{	

		$id = Input::get('user_id');
		if(Auth::user()->roles_id==1){
		$rules = array(
				'name' => 'required|max:255',
				'surname' => 'required|max:255',
				'email' => 'required|email|max:255',
				);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('profile/'.$id)
			->withErrors($validator);
		} else {

			$user = \App\User::find($id);
		
			$user->name = Input::get('name');
			$user->surname = Input::get('surname');
			$user->email = Input::get('email');
			$user->roles_id = Input::get('rol');
			$password = Input::get('password');
			if(!empty($password)){
				$user->password = bcrypt($password);
				}
			}
		}else {
			$user = \App\User::find($id);
			$password = Input::get('password');
			if(!empty($password)){
				$user->password = bcrypt($password);
				}
			}
			
			if($user->save()){
				Session::flash('message', 'Usuario actualizado correctamente!!');
				return Redirect::to('profile/'.$id);
			}
}


	public function getAddUser()
	{
		$roles = \App\Rol::all();
		return view('users.new')
		->with('roles',$roles);

	}

	public function postAddUser()
	{

		$rules = array(
			'name' => 'required|max:255',
			'surname' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:8',
			);

		$id = Input::get('user_id');
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('adduser')
			->withErrors($validator)
			->withInput();
		} else {
		
			$user = new \App\User;

			$user->name = Input::get('name');
			$user->surname = Input::get('surname');
			$user->email = Input::get('email');
			$user->password = bcrypt(Input::get('password'));
			$user->roles_id = Input::get('rol');
			$user->is_active = 1;

			if($user->save()){
				Session::flash('message', 'Usuario creado correctamente!!');
				return Redirect::to('adduser');
			}

		}
	}

	public function listUsers()
	{

		$usuarios = \App\User::where('is_active','=','1')
		->get();

		return view('users.list')->with('usuarios',$usuarios);

	}

	public function getDeleteUser( $id = null )
	{

		$user = \App\User::find($id);
				
		if($user!=null){

			if(Auth::user()->roles_id==1){ 
				$user->is_active = 0;			
				if($user->save()) {
					Session::flash('message', 'Usuario eliminado correctamente!!');
					return Redirect::to('users');
				}
			}else{
				return view('home');
			}

		}else{
			return view('home');
		}

	}


}

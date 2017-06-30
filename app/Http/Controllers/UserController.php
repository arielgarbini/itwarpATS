<?php 

namespace App\Http\Controllers;

use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
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
	private $roles;

	private $users;

	public function __construct(RoleRepository $roles, UserRepository $users)
	{
	    $this->roles = $roles;
	    $this->users = $users;
		$this->middleware('auth');
	} 

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function getEditProfile($id = null)
	{	

		$user = $this->users->find($id);
		if($user!=null){
			if(Auth::user()->roles_id == 1 || Auth::user()->id == $id){
				$roles = $this->roles->search()->get();
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

			$user = $this->users->find($id);
		    $this->users->update($user, ['name' => Input::get('name'), 'surname' => Input::get('surname'),
                'email' => Input::get('email'), 'roles_id' => Input::get('rol'),
                'password' => Input::get('password')]);
			if(!empty($password)){
				$user->password = bcrypt($password);
				}
			}
		}else {
			$user = $this->users->find($id);
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
		$roles = $this->roles->search()->get();
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
		    $user = $this->users->create(['name' => Input::get('name'), 'surname' => Input::get('surname'),
                'email' => Input::get('email'), 'password' => Input::get('password'),
                'roles_id' => Input::get('rol'), 'is_active' => 1]);

			if($user->save()){
				Session::flash('message', 'Usuario creado correctamente!!');
				return Redirect::to('adduser');
			}

		}
	}

	public function listUsers()
	{

		$usuarios = $this->users->search(['is_active' => '1'])->get();

		return view('users.list')->with('usuarios',$usuarios);

	}

	public function getDeleteUser( $id = null )
	{

		$user = $this->users->find($id);
				
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

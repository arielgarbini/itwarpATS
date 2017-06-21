<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Request;
use Session;
use Auth;

class CustomerController extends Controller {

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
	public function getEditCompany($id = null)
	{	

		$cliente = \App\Customer::find($id);
		if($cliente!=null){
			if(Auth::user()->roles_id == 1 || Auth::user()->id == $cliente->created_by || Auth::user()->id == $cliente->owned_by){
				
				$countries = \App\Country::all();
				
				$users = \App\User::where('roles_id','=',1)
				->orWhere('roles_id','=',4)
				->get();

				$states = \App\State::where('countries_id','=',$cliente->address->countries_id)->get();

				return view('customers.edit')
				->with('cliente',$cliente)
				->with('countries',$countries)
				->with('states',$states)
				->with('users',$users);

			}else{
				Session::flash('message', 'No cuenta con los permisos necesarios!');
				return Redirect::to('/');
			}
		}else{
			Session::flash('message', 'No existe el cliente!');
			return Redirect::to('/');
		}

	}

	public function postEditCompany()
	{	

		$id = Input::get('customer_id');

		$rules = array(
				'company_name' => 'required|max:255',
				'owned_by' => 'required',
				'country' => 'required',
				'state' => 'required',
				);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('customer/'.$id)
			->withErrors($validator);
		} else {

			$customer = \App\Customer::find($id);
			
			$customer->company_name = Input::get('company_name');
			$customer->company_description = Input::get('company_description');
			$customer->owned_by = Input::get('owned_by');
			$customer->is_active = 1;

			if (Request::hasFile('logo')){
				$imageName = Input::get('company_name').'.'.Request::file('logo')
				->getClientOriginalExtension();
                Request::file('logo')->move('logos', $imageName);
				$customer->logo = $imageName;				
			}

			$customer->address->countries_id = Input::get('country');
			$customer->address->states_id = Input::get('state');
			$customer->address->city = Input::get('city');
			$customer->address->address = Input::get('address');
			$customer->address->post_code = Input::get('post_code');


			if($customer->push()){
				Session::flash('message', 'Cliente actualizado correctamente!!');
				return Redirect::to('customer/'.$id);
			}
		}
}


	public function getAddCompany()
	{
		$countries = \App\Country::all();
		$users = \App\User::where('roles_id','=',1)
		->orWhere('roles_id','=',4)
		->get();

		return view('customers.new')
		->with('countries',$countries)
		->with('users',$users);

	}

	public function postAddCompany()
	{

		$rules = array(
			'company_name' => 'required|max:255',
			'owned_by' => 'required',
			'country' => 'required',
			'state' => 'required',
			);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('addcustomer')
			->withErrors($validator)
			->withInput();
		} else {
			
			$created_by = Auth::user()->id;
			
			$address = new \App\Address;

			$address->countries_id = Input::get('country');
			$address->states_id = Input::get('state');
			$address->city = Input::get('city');
			$address->address = Input::get('address');
			$address->post_code = Input::get('post_code');

			$address->save();

			$customer = new \App\Customer;

			if (Request::hasFile('logo')){
				$imageName = Input::get('company_name').'.'.Request::file('logo')
				->getClientOriginalExtension();
                Request::file('logo')->move('logos', $imageName);
				$customer->logo = $imageName;				
			}

			$customer->company_name = Input::get('company_name');
			$customer->company_description = Input::get('company_description');
			$customer->addresses_id = $address->id;
			$customer->created_by = $created_by;
			$customer->owned_by = Input::get('owned_by');
			$customer->is_active = 1;

			if($customer->save()){
				Session::flash('message', 'Cliente creado correctamente!!');
				return Redirect::to('addcustomer');
			}

		}
	}

	public function listCustomers()
	{

		
			$clientes = \App\Customer::where('is_active','=','1')->orderBy('company_name','ASC')->get();
		
		return view('customers.list')->with('clientes',$clientes);

	}

	public function getDeleteCustomer( $id = null )
	{

		$customer = \App\Customer::find($id);
				
		if($customer!=null){

				$customer->is_active = 0;
				$contacts = \App\Contact::where('customers_id','=',$customer->id)->get();	

				foreach ($contacts as $contact) {
							$contact->is_active = 0;
							$contact->save();
							$offers = \App\Offer::where('contacts_id','=',$contact->id)->get();

							foreach ($offers as $offer) {
								$offer->is_active = 0;
								$offer->save();
							}
						}

				if($customer->save()) {
					Session::flash('message', 'Cliente eliminado correctamente!!');
					return Redirect::to('customers');
				}
			
		}else{
				
				return view('home');
		
		}

	}


}

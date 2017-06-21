<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Request;
use Session;
use Auth;

class ContactController extends Controller {

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
	public function getEditContact($id = null)
	{	

		$contact = \App\Contact::find($id);
		if($contact!=null)
			{
				$roles = \App\Position::all();
				return view('contacts.edit')
				->with('contact',$contact)
				->with('roles',$roles);
			}else{
			Session::flash('message', 'No existe el contacto!');
			return Redirect::to('/');
		}
	}

	public function postEditContact()
	{	

		$rules = array(
			'name' => 'required|max:255',
			'surname' => 'required|max:255',
			'email' => 'required|max:255',
			'rol' => 'required',
			);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('profile/'.$id)
			->withErrors($validator);
		} else {

			$contact = \App\Contact::find(Input::get('contact_id'));

			$contact->name = Input::get('name');
			$contact->surname = Input::get('surname');
			$contact->email = Input::get('email');
			$contact->mobile = Input::get('mobile');
			$contact->telephone = Input::get('telephone');
			$contact->positions_id = Input::get('rol');
			
			if($contact->save()){
				Session::flash('message', 'Cpmtactp actualizado correctamente!!');
				return Redirect::to('contact/'.$contact->id);
			}
}

}


	public function getAddContact($customer_id = null)
	{
		$customer = \App\Customer::find($customer_id);
		$roles = \App\Position::all();

		return view('contacts.new')
		->with('roles',$roles)
		->with('customer',$customer);

	}

	public function postAddContact()
	{

		$rules = array(
			'name' => 'required|max:255',
			'surname' => 'required|max:255',
			'email' => 'required|max:255',
			'rol' => 'required',
			);

		
		$validator = Validator::make(Input::all(), $rules);
		$customer_id = Input::get('customer_id');

		if ($validator->fails()) {
			return Redirect::to('addcontact/'.$customer_id)
			->withErrors($validator)
			->withInput();
		} else {
			
			$contact = new \App\Contact;

			$contact->name = Input::get('name');
			$contact->surname = Input::get('surname');
			$contact->email = Input::get('email');
			$contact->mobile = Input::get('mobile');
			$contact->telephone = Input::get('telephone');
			$contact->positions_id = Input::get('rol');
			$contact->customers_id = $customer_id;
			$contact->is_active = 1;

			if($contact->save()){
				Session::flash('message', 'Contacto creado correctamente!!');
				return Redirect::to('addcontact/'.$customer_id);
			}

		}
	}

	public function listContacts($customer_id = null)
	{
		if($customer_id!=null){
			$contacts = \App\Contact::where('customers_id','=',$customer_id)
			->where('is_active','=',1)
			->get();
			
			return view('contacts.list')
			->with('customer_id',$customer_id)
			->with('contacts',$contacts);
		}else{
			$contacts = \App\Contact::where('is_active','=',1)->orderBy('name','ASC')->get();
			
			return view('contacts.listAll')
			->with('contacts',$contacts);
		}
				

	}

	public function getDeleteContact( $id = null )
	{


		$contact = \App\Contact::find($id);

		if($contact!=null){

		$offers = \App\Offer::where('contacts_id','=',$contact->id)->get();

		foreach ($offers as $offer) {
								$offer->is_active = 0;
								$offer->save();
							}
		
		$contact->is_active = 0;

		if($contact->save()) {
					Session::flash('message', 'Contacto eliminado correctamente!!');
					return Redirect::to('contacts');
				}


		}else{
				
				return view('home');
			
		}
	}


}
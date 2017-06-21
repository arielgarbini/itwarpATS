<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Request;
use Session;
use Auth;

class OfferController extends Controller {

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
	public function getEditOffer($id = null)
	{	

		$offer = \App\Offer::find($id);
		if($offer!=null){
			if(Auth::user()->roles_id == 1 || Auth::user()->roles_id == 3  || Auth::user()->id == $offer->created_by){
			
			$recruiters = \App\User::where('roles_id','=',2)
			->orWhere('roles_id','=',3)->where('is_active','=',1)->get();

			$direccion = "";
			$direccion .= $offer->contact->customer->address->address . ', ';
			$direccion .= $offer->contact->customer->address->city. ' ('. $offer->contact->customer->address->post_code . ')' .   ', ';
			$direccion .= $offer->contact->customer->address->state->state. ', ';
			$direccion .= $offer->contact->customer->address->country->country . '.';
			
			$offerStatus = \App\OfferStatus::all();

			$recs = \App\RelOfferRecruiter::where('offers_id','=',$offer->id)->get();
        	$reclutadores = array();
        foreach ($recs as $rec) {
        	$reclutadores[] = $rec->recruiter;
        }

				return view('offers.edit')
				->with('offer',$offer)
				->with('reclutadores',$reclutadores)
				->with('offerStatus',$offerStatus)
				->with('recruiters',$recruiters)
				->with('direccion',$direccion);

			}else{
				Session::flash('message', 'No cuenta con los permisos necesarios!');
				return Redirect::to('/');
			}
		}else{
			Session::flash('message', 'No existe la oferta!');
			return Redirect::to('/');
		}

	}

	public function getViewOffer($id = null){

		$offer = \App\Offer::find($id);
		if($offer!=null){
			$recruiters = \App\User::where('roles_id','=',2)
			->orWhere('roles_id','=',3)->where('is_active','=',1)
			->get();

			$direccion = "";
			$direccion .= $offer->contact->customer->address->address . ', ';
			$direccion .= $offer->contact->customer->address->city. ' ('. $offer->contact->customer->address->post_code . ')' .   ', ';
			$direccion .= $offer->contact->customer->address->state->state. ', ';
			$direccion .= $offer->contact->customer->address->country->country . '.';
			
			$offerStatus = \App\OfferStatus::all();

			$recs = \App\RelOfferRecruiter::where('offers_id','=',$offer->id)->get();
       		$reclutadores = array();
        foreach ($recs as $rec) {
        	$reclutadores[] = $rec->recruiter;
        }

				return view('offers.view')
				->with('offer',$offer)
				->with('reclutadores',$reclutadores)
				->with('offerStatus',$offerStatus)
				->with('recruiters',$recruiters)
				->with('direccion',$direccion);

	
		}else{
			Session::flash('message', 'No existe la oferta!');
			return Redirect::to('/');
		}

	}

	public function postEditOffer()
	{	

		$id = Input::get('offer_id');

		$rules = array(
				'title' => 'required|max:255',
				'contact_id' => 'required',
			);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('offer/'.$id)
			->withErrors($validator);
		} else {

			$offer = \App\Offer::find($id);
			
			$contact = \App\Contact::find(Input::get('contact_id'));
			
			if (Request::hasFile('job_description')){
				$fileName = Input::get('title').'.'.Request::file('job_description')
				->getClientOriginalExtension();
                Request::file('job_description')->move('jds', $fileName);
				$offer->job_description = $fileName;				
			}

			$offer->title = Input::get('title');
			$offer->description = Input::get('description');
			$offer->open_positions = Input::get('open_positions');
			$offer->addresses_id = $contact->customer->addresses_id;
			$offer->from_hr = Input::get('from_hr');
			$offer->to_hr = Input::get('to_hr');
			$offer->salary_min = Input::get('salary_min');
			$offer->salary_max = Input::get('salary_max');
			$offer->contacts_id = Input::get('contact_id');
			$offer->offerstatus_id = Input::get('offerstatus');
		
			if($offer->save()){
				
                    \App\RelOfferRecruiter::where('offers_id','=',$offer->id)->delete();
                    foreach (Input::get('recruiters') as $recruiter) {
					$relOR = new \App\RelOfferRecruiter;
					$relOR->recruiter = $recruiter;
					$relOR->offers_id = $offer->id;
					$relOR->save();
				}
				Session::flash('message', 'Oferta actualizada correctamente!!');
				return Redirect::to('offer/'.$id);
			}
		}
}


	public function getAddOffer()
	{
	
		$recruiters = \App\User::where('roles_id','=',2)
		->orWhere('roles_id','=',3)->where('is_active','=',1)
		->get();
		$offerStatus = \App\OfferStatus::all();

		return view('offers.new')
		->with('offerStatus',$offerStatus)
		->with('recruiters',$recruiters);

	}

	public function postAddOffer()
	{	
		
		$rules = array(
			'title' => 'required|max:255',
			'contact_id' => 'required',
			);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('addoffer')
			->withErrors($validator)
			->withInput();
		} else {
			
			$created_by = Auth::user()->id;
			$contact = \App\Contact::find(Input::get('contact_id'));
			$offer = new \App\Offer;

			if (Request::hasFile('job_description')){
				$fileName = Input::get('title').'.'.Request::file('job_description')
				->getClientOriginalExtension();
                Request::file('job_description')->move('jds', $fileName);
				$offer->job_description = $fileName;				
			}

			$offer->title = Input::get('title');
			$offer->description = Input::get('description');
			$offer->open_positions = Input::get('open_positions');
			$offer->addresses_id = $contact->customer->addresses_id;
			$offer->from_hr = Input::get('from_hr');
			$offer->to_hr = Input::get('to_hr');
			$offer->open_date = Input::get('open_date');
			$offer->salary_min = Input::get('salary_min');
			$offer->salary_max = Input::get('salary_max');
			$offer->created_by = $created_by;
			$offer->contacts_id = Input::get('contact_id');
			$offer->is_active = 1;
			$offer->offerstatus_id = Input::get('offerstatus');

			if($offer->save()){
				
				if(Input::has('recruiters')){
				foreach (Input::get('recruiters') as $recruiter) {
					$relOR = new \App\RelOfferRecruiter;
					$relOR->recruiter = $recruiter;
					$relOR->offers_id = $offer->id;
					$relOR->save();
				}
				}
				
				Session::flash('message', 'Oferta creada correctamente!!');
				return Redirect::to('addoffer');
			}

		}
	}

	public function listOffers()
	{

        $offers = null;

		if(Auth::user()->roles_id==1 || Auth::user()->roles_id==3 || Auth::user()->roles_id==4){
			$offers = \App\Offer::where('is_active','=','1')
                ->where('offerstatus_id','!=',7)
                ->where('offerstatus_id','!=',8)
                ->where('offerstatus_id','!=',9)
			->orderBy('offerstatus_id', 'asc')
			->get();
		}
		
		if(Auth::user()->roles_id==2){
			$offers = \App\RelOfferRecruiter::where('recruiter','=',Auth::user()->id)->where('is_active','=','1')->get();
		}
		
		return view('offers.list')->with('offers',$offers);

	}

	public function getOfferClosed(){


        $offers = null;

		if(Auth::user()->roles_id==1 || Auth::user()->roles_id==3 || Auth::user()->roles_id==4){
			$offers = \App\Offer::where('is_active','=','1')
                ->where('offerstatus_id','=',7)
                ->orWhere('offerstatus_id','=',8)
                ->orWhere('offerstatus_id','=',9)
			->orderBy('offerstatus_id', 'asc')
			->get();
		}
		
		if(Auth::user()->roles_id==2){
			$offers = \App\RelOfferRecruiter::where('recruiter','=',Auth::user()->id)->where('is_active','=','1')->get();
		}
		
		return view('offers.closed')->with('offers',$offers);
 }

	public function autocompleteCustomer(){
		$term = Input::get('term');	
		$results = array();
		$contacts = \App\Contact::where('is_active', '=',1)
		->where('name', 'LIKE', '%'.$term.'%')
		->orWhere('surname', 'LIKE', '%'.$term.'%')
		->take(5)->get();

		foreach ($contacts as $contact)
		{
			$direccion = "";
			$direccion .= $contact->customer->address->address . ', ';
			$direccion .= $contact->customer->address->city. ' ('. $contact->customer->address->post_code . ')' .   ', ';
			$direccion .= $contact->customer->address->state->state. ', ';
			$direccion .= $contact->customer->address->country->country . '.';
			$contacto = $contact->name . ' ' . $contact->surname;
			$telefono = $contact->telephone;
			$celu = $contact->mobile;
			$email = $contact->email;
			$results[] = [ 'id' => $contact->id, 'dire' => $direccion, 'label' => $contacto, 'company_name' =>$contact->customer->company_name, 'telefono' => $telefono, 'celu' => $celu, 'email' => $email];
		}

		return $results;
	}

public function getDeleteOffer($id = null){

		$offer = \App\Offer::find($id);
				
		if($offer!=null){

				$offer->is_active = 0;			
				if($offer->save()) {
					Session::flash('message', 'Oferta eliminado correctamente!!');
					return Redirect::to('offers');
				}
			}else{
				return view('home');
			}

		}

	


}
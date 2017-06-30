<?php 

namespace App\Http\Controllers;

use App\Repositories\AddressRepository;
use App\Repositories\CandidateOfferCommentRepository;
use App\Repositories\CandidateRepository;
use App\Repositories\CandidateWorkStatusRepository;
use App\Repositories\ContactRepository;
use App\Repositories\CountryRepository;
use App\Repositories\OfferRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\RelCandidateProfileRepository;
use App\Repositories\SourceRepository;
use App\Repositories\StateRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Request;
use Session;
use Auth;
use DB;

class CandidateController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */

    private $users;

    private $countries;

    private $offers;

    private $states;

    private $contacts;

    private $candidates;

    private $candidatesOfferComments;

    private $profiles;

    private $sources;

    private $address;

    private $candidatesWorkStatus;

    private $relCandidatesProfiles;

    public function __construct(UserRepository $users, CountryRepository $countries,
            OfferRepository $offers, StateRepository $states, ContactRepository $contacts,
            CandidateRepository $candidates, CandidateOfferCommentRepository $candidatesOfferComments,
            ProfileRepository $profiles, SourceRepository $sources,
            CandidateWorkStatusRepository $candidatesWorkStatus, AddressRepository $address,
            RelCandidateProfileRepository $relCandidatesProfiles)
	{
        $this->countries = $countries;
        $this->users = $users;
        $this->offers = $offers;
        $this->states = $states;
        $this->contacts = $contacts;
        $this->candidates = $candidates;
        $this->candidatesOfferComments = $candidatesOfferComments;
        $this->profiles = $profiles;
        $this->sources = $sources;
        $this->candidatesWorkStatus = $candidatesWorkStatus;
        $this->relCandidatesProfiles = $relCandidatesProfiles;
        $this->address = $address;
		$this->middleware('auth');
	}


	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */

	public function getCandidateOfferComments($id = null){


		$id_relOC = explode("-", $id)[0];
		$id_offer = explode("-", $id)[1];
		$id_candidate = explode("-", $id)[2];
		
		$comments = $this->candidatesOfferComments->search(['rel_offers_candidates_id' => $id_relOC])->get();
        $offer = $this->offers->find($id_offer);
        $candidate = $this->candidates->find($id_candidate);

		return view('comments.CandidateOfferComments')
		->with('id_relOC',$id_relOC)
		->with('comments',$comments)
		->with('offer',$offer)
		->with('candidate',$candidate);

	}

	public function postCandidateOfferComments(){

    	    $created_by = Auth::user()->id;
    	    $candidate_id = Input::get('candidate_id');
    	    $offer_id = Input::get('offer_id');
            $CandidateComment = $this->candidatesOfferComments->create(['created_by' => $created_by,
                'rel_offers_candidates_id' => Input::get('relOC'),
                'comment' => Input::get('comment')]);
	        
            if($CandidateComment){
            	Session::flash('message', 'Comentario creado correctamente!!');
				return Redirect::to('commentCO/'.Input::get('relOC').'-'. $offer_id.'-'.$candidate_id);
            }
        }

	public function getDeleteCandidate($id = null){

		$candidate = $this->candidates->find($id);

		if($candidate!=null){

            $candidate->is_active = 0;

            if($candidate->save()) {
                Session::flash('message', 'Candidato eliminado correctamente!!');
                return Redirect::to('candidates');
            }
		}else{

				return view('home');

		}
	}

	public function getEditOffer($id = null)
	{	

		$offer = $this->offers->find($id);
		if($offer!=null){
			if(Auth::user()->roles_id == 1 || Auth::user()->id == $offer->created_by){
			
			$recruiters = $this->users->search(['roles_id' => 2])->orWhere('roles_id','=',3)->get();

			$direccion = "";
			$direccion .= $offer->contact->customer->address->address . ', ';
			$direccion .= $offer->contact->customer->address->city. ' ('. $offer->contact->customer->address->post_code . ')' .   ', ';
			$direccion .= $offer->contact->customer->address->state->state. ', ';
			$direccion .= $offer->contact->customer->address->country->country . '.';

				return view('offers.edit')
				->with('offer',$offer)
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

			$offer = $this->offers->find($id);
			
			$contact = $this->contacts->find(Input::get('contact_id'));
			
			if (Request::hasFile('job_description')){
				$fileName = Input::get('title').'.'.Request::file('job_description')
				->getClientOriginalExtension();
                Request::file('job_description')->move('jds', $fileName);
				$offer->job_description = $fileName;				
			}
            $this->offers->update($offer, ['title' =>  Input::get('title'),
                'description' =>  Input::get('description'),
                'open_positions' => Input::get('open_positions'),
                'addresses_id' => $contact->customer->addresses_id,
                'from_hr' => Input::get('from_hr'), 'to_hr' => Input::get('to_hr'),
                'salary_min' => Input::get('salary_max'), 'salary_max' => Input::get('salary_max'),
                'contacts_id' => Input::get('contact_id')]);
			
			if($offer){
				Session::flash('message', 'Oferta actualizada correctamente!!');
				return Redirect::to('offer/'.$id);
			}
		}
}

	public function getAddCandidateOffer($id = null)
	{
		$offer = $this->offers->find($id);

		return view('candidates.assignCandidateOffer')
		->with('offer',$offer);

	}

	public function getAddOfferCandidate($id = null)
	{
		$candidate = $this->candidates->find($id);

		return view('candidates.assignOfferCandidate')
		->with('candidate',$candidate);

	}


	public function getAddCandidate()
	{
	
		$profiles = $this->profiles->search(['is_active' => 1])->get();
		$countries = $this->countries->search()->get();
		$sources = $this->sources->search()->get();
		$workstatus = $this->candidatesWorkStatus->search()->get();

		return view('candidates.new')
		->with('countries',$countries)
		->with('workstatus',$workstatus)
		->with('sources',$sources)
		->with('profiles',$profiles);

	}

	public function getEditCandidate($id = null)
	{
		
		$candidate = $this->candidates->find($id);
		$profiles = $this->profiles->search(['is_active' => 1])->get();
		$countries = $this->countries->search()->get();
		$states = $this->states->search(['countries_id' => $candidate->address->countries_id])->get();
		$sources = $this->sources->search()->get();
		$workstatus = $this->candidatesWorkStatus->search()->get();
		$profiles_c = $this->relCandidatesProfiles->search(['candidates_id' => $candidate->id])->get();
        
        foreach ($profiles_c as $profile) {
        	$candidate_profile[] = $profile->profiles_id;
        }

		return view('candidates.edit')
		->with('candidate',$candidate)
		//->with('candidate_profile',$candidate_profile)
		->with('workstatus',$workstatus)
		->with('countries',$countries)
		->with('states',$states)
		->with('sources',$sources)
		->with('profiles',$profiles);

	}

	public function getViewCandidate($id = null)
	{
		
		$candidate = $this->candidates->find($id);
		
		return view('candidates.view')
		->with('candidate',$candidate);

	}

		
		public function postAddCandidate(Request $request)
	{	
		
		$rules = array(
			'name' => 'required',
			'surname' => 'required',
			'email' => 'required|unique:users',
			'country' => 'required',
			'state' => 'required',
			);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('addcandidate')
			->withErrors($validator)
			->withInput();
		} else {
			
			$created_by = Auth::user()->id;
			$data = [];

			if (Request::hasFile('original_resume')){
				$fileName = Input::get('name').Input::get('surname').'-original.'.Request::file('original_resume')
				->getClientOriginalExtension();
                Request::file('original_resume')->move('cv_originales', $fileName);
				$data['original_resume'] = $fileName;
			}

			if (Request::hasFile('itwarp_resume')){
				$fileName = Input::get('name').Input::get('surname').'-ITWformated.'.Request::file('itwarp_resume')
				->getClientOriginalExtension();
                Request::file('itwarp_resume')->move('cv_formateados', $fileName);
				$data['itwarp_resume'] = $fileName;
			}

            $address = $this->address->create(['countries_id' => Input::get('country'),
                'states_id' => Input::get('state'), 'city' => Input::get('city'),
                'address' => Input::get('address'), 'post_code' => Input::get('post_code')]);

            $candidate = $this->candidates->create(array_merge($data, ['name' => Input::get('name'),
                'surname' => Input::get('surname'), 'email' => Input::get('email'),
                'cellphone' => Input::get('cellphone'), 'telephone' => Input::get('telephone'),
                'resume' => Input::get('resume'), 'current_salary' => Input::get('current_salary'),
                'intended_salary' => Input::get('intended_salary'), 'sources_id' => Input::get('sources_id'),
                'created_by' => $created_by, 'experience_year' => Input::get('experience_year'),
                'is_active' => 1, 'candidateworkstatus_id' => Input::get('candidateworkstatus'),
                'addresses_id' => $address->id]));

			if($candidate){
				
				$profiles = explode(",", Input::get('profiles'));
                if(isset($request->profiles) && Input::get('profiles')!='') {
                    foreach ($profiles as $profile) {
                        $profile_id = $this->profiles->search(['profile' => $profile,
                            'is_active' => 1])->first()->id;
                        $relOR = $this->relCandidatesProfiles->create(['candidates_id' => $candidate->id,
                            'profiles_id' => $profile_id]);
                    }
                }
				
				Session::flash('message', 'Candidato creado correctamente!!');
				return Redirect::to('addcandidate');
			}

		}
	}

	public function getDeleteCandidateOffer($id = null){

		$id_offer = explode("-", $id)[0];
		$id_candidate = explode("-", $id)[1];

		$relOC = \App\RelOfferCandidate::where('offers_id','=',$id_offer)
			->where('candidates_id','=',$id_candidate)->first();

		$relOC->is_active = 0;

		$relOC->save();
		Session::flash('message', 'Candidato desasignado correctamente!!');
		return Redirect::to('candidates/'.$id_offer);

	}

	public function postEditCandidate(Request $request)
	{	
		
		$rules = array(
			'name' => 'required',
			'surname' => 'required',
			'email' => 'required',
			'resume' => 'required',
			'country' => 'required',
			'state' => 'required',
			);
		$candidate_id = Input::get('candidate_id');

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('candidate/'.$candidate_id)
			->withErrors($validator)
			->withInput();
		} else {
			
			$candidate = \App\Candidate::find($candidate_id);

			if (Request::hasFile('original_resume')){
				$fileName = Input::get('name').Input::get('surname').'-original.'.Request::file('original_resume')
				->getClientOriginalExtension();
                Request::file('original_resume')->move('cv_originales', $fileName);
				$candidate->original_resume = $fileName;				
			}

			if (Request::hasFile('itwarp_resume')){
				$fileName = Input::get('name').Input::get('surname').'-ITWformated.'.Request::file('itwarp_resume')
				->getClientOriginalExtension();
                Request::file('itwarp_resume')->move('cv_formateados', $fileName);
				$candidate->itwarp_resume = $fileName;				
			}

			$candidate->name = Input::get('name');
			$candidate->surname = Input::get('surname');
			$candidate->email = Input::get('email');
			$candidate->cellphone = Input::get('cellphone');
			$candidate->telephone = Input::get('telephone');
			$candidate->resume = Input::get('resume');

			$candidate->address->countries_id = Input::get('country');
			$candidate->address->states_id = Input::get('state');
			$candidate->address->city = Input::get('city');
			$candidate->address->address = Input::get('address');
			$candidate->address->post_code = Input::get('post_code');


			$candidate->current_salary = Input::get('current_salary');
			$candidate->intended_salary = Input::get('intended_salary');
			$candidate->sources_id = Input::get('sources_id');
			$candidate->experience_year = Input::get('experience_year');
			$candidate->candidateworkstatus_id = Input::get('candidateworkstatus');	

			if($candidate->push()){
				
				\App\RelCandidateProfile::where('candidates_id','=',$candidate->id)->delete();
				$profiles = explode(",", Input::get('profiles'));
				if(isset($request->profiles) && Input::get('profiles')!='') {
                    foreach ($profiles as $profile) {
                        $profile_id = \App\Profile::where('profile', 'LIKE', '%' . $profile . '%')
                            ->where('is_active', '=', 1)
                            ->first()->id;
                        $relOR = new \App\RelCandidateProfile;
                        $relOR->candidates_id = $candidate->id;
                        $relOR->profiles_id = $profile_id;
                        $relOR->save();
                    }
                }
				
				Session::flash('message', 'Candidato actualizado correctamente!!');
				return Redirect::to('candidate/'.$candidate_id);
			}

		}
	}

	public function listCandidates($id=null)
	{

		if($id==null){

		$profiles = \App\Profile::where('is_active','=',1)->get();
		$status = \App\CandidateWorkStatus::all();
		$candidates = \App\Candidate::where('is_active','=','1')->paginate(15);
		$recruiters = \App\User::where('roles_id','=',2)
		->orWhere('roles_id','=',3)
		->get();

			return view('candidates.list')
			->with('candidates',$candidates)
			->with('status',$status)
			->with('profiles',$profiles)
			->with('recruiters',$recruiters);

		}else{
			$offer = \App\Offer::find($id);
			$offerTitle = $offer->title;
			$offerID = $offer->id;
			$candidates = \App\RelOfferCandidate::where('is_active','=',1)->where('offers_id','=',$offerID)->get();

			$status = \App\Status::orderBy('status','ASC')->get();
			return view('candidates.listByOffer')
			->with('offerID',$offerID)
			->with('offerTitle',$offerTitle)
			->with('status',$status)
			->with('candidates',$candidates);
	}
		
		

	}

	public function listCandidatesRCV()
	{

			$candidates = \App\RelOfferCandidate::where('is_active','=',1)->get();
			$status = \App\Status::orderBy('status','ASC')->get();

			return view('revision.list')
			->with('status',$status)
			->with('candidates',$candidates);
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

	public function postAddCandidateOffer()
	{

		$offer = \App\Offer::find(Input::get('offers_id'));
				
		$rules = array(
			'candidates_id' => 'required',
			'offers_id' => 'required',
			);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('addCandidateOffer/'.$offer->id)
			->withErrors($validator)
			->withInput();
		} else {
			
			$relOC =\App\RelOfferCandidate::where('offers_id','=',$offer->id)
			->where('candidates_id','=',Input::get('candidates_id'))->first();
			if($relOC==null){

			$created_by = Auth::user()->id;
			$relOC = new \App\RelOfferCandidate;

			$relOC->offers_id = $offer->id;
			$relOC->candidates_id = Input::get('candidates_id');
			$relOC->recruiter = $created_by;	
			

			if($relOC->save()){

				$rsco = new \App\RelStatusCandidateOffer;
			    $rsco->rel_offers_candidates = $relOC->id;
			    $rsco->users_id = Auth::user()->id;
			    $rsco->status_id = 1;
			    $rsco->save();
			
				$relOC->rel_status_candidate_offer_id = $rsco->id;
				$relOC->save();

				Session::flash('message', 'Candidato asignado correctamente!!');
				return Redirect::to('candidates/'.$offer->id);
			}
		}else{
			Session::flash('message', 'El candidato ya se encuentra asignado!!');
			return Redirect::to('candidates/'.$offer->id);
		}

		}

	}

	public function postAddOfferCandidate()
	{

		$offer = \App\Offer::find(Input::get('offers_id'));
		if(!$offer){
		    return redirect()->back()->withErrors('No existe la oferta a asignar');
        }
				
		$rules = array(
			'candidates_id' => 'required',
			'offers_id' => 'required',
			);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('addCandidateOffer/'.$offer->id)
			->withErrors($validator)
			->withInput();
		} else {
			$relOC =\App\RelOfferCandidate::where('offers_id','=',$offer->id)
			->where('candidates_id','=',Input::get('candidates_id'))->first();
			if($relOC==null){
			
			$created_by = Auth::user()->id;
			$relOC = new \App\RelOfferCandidate;

			$relOC->offers_id = $offer->id;
			$relOC->candidates_id = Input::get('candidates_id');
			$relOC->recruiter = $created_by;
		
			if($relOC->save()){

				$rsco = new \App\RelStatusCandidateOffer;
			    $rsco->rel_offers_candidates = $relOC->id;
			    $rsco->users_id = Auth::user()->id;
			    $rsco->status_id = 1;
			    $rsco->save();
			
				$relOC->rel_status_candidate_offer_id = $rsco->id;
				$relOC->save();
		
				Session::flash('message', 'Candidato asignado correctamente!!');
				return Redirect::to('candidates/'.$offer->id);
			}
		}else{
			Session::flash('message', 'El candidato ya se encuentra asignado!!');
			return Redirect::to('candidates/'.$offer->id);
		}

		}

}

	public function autocompleteCandidate(){
		$term = Input::get('term');	
		$results = array();
		if(Auth::user()->roles_id==1){
			$candidates = \App\Candidate::where('is_active', '=',1)
			->where('name', 'LIKE', '%'.$term.'%')
			->orWhere('surname', 'LIKE', '%'.$term.'%')
			->take(5)->get();
		}else{
			$candidates = \App\Candidate::where('is_active', '=',1)
			->where('name', 'LIKE', '%'.$term.'%')
			->orWhere('surname', 'LIKE', '%'.$term.'%')
			->take(5)->get();
		}
		

		foreach ($candidates as $candidate)
		{
			$can = $candidate->name . ' ' . $candidate->surname;
			$results[] = [ 'id' => $candidate->id, 'label' => $can ];
		}

		return $results;
	}

	public function autocompleteProfiles(){
		$term = Input::get('term');	
		$results = array();
			$profiles = \App\Profile::where('profile', 'LIKE', '%'.$term.'%')
			->where('is_active','=',1)
			->take(5)->get();
		foreach ($profiles as $profile)
		{
			$results[] = [ 'label' => $profile->profile ];
		}

		return $results;
	}

	public function autocompleteOffer(){
		$term = Input::get('term');	
		$results = array();
		$offers = \App\Offer::where('is_active', '=',1)
		->where('title', 'LIKE', '%'.$term.'%')
		->orWhere('description', 'LIKE', '%'.$term.'%')
		->take(5)->get();
		
		foreach ($offers as $offer)
		{
			$results[] = [ 'id' => $offer->id, 'label' => $offer->title ];
		}

		return $results;
	}

	public function postFilterCandidates(){


		$statu = Input::get('status');
		$find = Input::get('find');
		$rec = Input::get('recruiter');
		$prof = Input::get('profile');

		$query = \App\Candidate::where('is_active','=',1);

		if($prof!=0){
			
		$candidates_id = array();
			
		$list = \App\RelCandidateProfile::where('profiles_id','=',$prof)->get();

		foreach ($list as $ls)
		{
			$candidates_id[] = $ls->candidates_id;
		}

		$query->whereIn('id',$candidates_id)->get();

		}
		

		if($statu!=0){
            $query->where('candidateworkstatus_id', $statu);
        }

	    if($find!=""){
	        $query->where('name', 'LIKE', '%'.Input::get('find').'%')->orWhere('surname', 'LIKE', '%'.Input::get('find').'%')->orWhere('resume', 'LIKE', '%'.Input::get('find').'%');
	    }
	       
	    if($rec!=0){
		    $query->where('created_by', $rec);
		}
   		
		$candidates = $query->get();

		$filter = 1;

		$profiles = \App\Profile::where('is_active','=',1)->get();
		$status = \App\CandidateWorkStatus::all();
		$recruiters = \App\User::where('roles_id','=',2)
		->orWhere('roles_id','=',3)
		->get();

			return view('candidates.list')
			->with('statu',$statu)
			->with('filter',$filter)
			->with('find',$find)
			->with('rec',$rec)
			->with('prof',$prof)
			->with('candidates',$candidates)
			->with('status',$status)
			->with('profiles',$profiles)
			->with('recruiters',$recruiters);

	}


}

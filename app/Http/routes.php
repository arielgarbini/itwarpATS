<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
Route::get('changePass', function()
{
	$user = \App\User::find(6);
        $user->password = bcrypt("qazwsx1243");
        $user->save();
    		
});


Route::get('csv', function(){


    $handle = fopen('baseCandidatos.csv', "r");
    $i = 0;
    while (($data = fgetcsv($handle,4096,';')) !== FALSE) {
                         if(trim(utf8_encode($data[0]))){
	                $candidate = new \App\Candidate;
                        $candidate->name = utf8_encode($data[0]);
			$candidate->email = utf8_encode($data[1]);
			$candidate->telephone = utf8_encode($data[2]);
                        $candidate->sources_id = 2;
			$candidate->created_by = 1;

			$address = new \App\Address;
			$address->countries_id = 1;
			$address->states_id = utf8_encode($data[5]);
                        $address->save();
                        $candidate->is_active = 1;
			$candidate->addresses_id = $address->id;
			$candidate->candidateworkstatus_id = 1;	
                        $candidate->save();

                        $relOR = new \App\RelCandidateProfile;
			$relOR->candidates_id = $candidate->id;
		        $relOR->profiles_id = utf8_encode($data[4]);
			$relOR->save();

        $i++;
}
    }
echo $i;


});
*/
Route::get('/home', function () {

	$offers = null;

		$offers = \App\Offer::where('is_active','=','1')
                ->where('offerstatus_id','!=',7)
                ->where('offerstatus_id','!=',8)
                ->where('offerstatus_id','!=',9)
		->orderBy('offerstatus_id', 'asc')
		->get();
		
	return view('home')->with('offers',$offers);
});
Route::get('/', function (){	

 if(Auth::check()){
	$offers = null;

		$offers = \App\Offer::where('is_active','=','1')
                ->where('offerstatus_id','!=',7)
                ->where('offerstatus_id','!=',8)
                ->where('offerstatus_id','!=',9)
		->orderBy('offerstatus_id', 'asc')
		->get();
		
	return view('home')->with('offers',$offers);	
}else{

	return view('home');
}
});

Route::get('offerClosed', 'OfferController@getOfferClosed');
// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Users
Route::get('profile/{id}', 'UserController@getEditProfile');
Route::post('profile', 'UserController@postEditProfile');
Route::get('adduser', 'UserController@getAddUser');
Route::post('adduser', 'UserController@postAddUser');
Route::get('users', 'UserController@listUsers');
Route::get('deleteuser/{id}', 'UserController@getDeleteUser');


// Customers
Route::get('customer/{id}', 'CustomerController@getEditCompany');
Route::post('customer', 'CustomerController@postEditCompany');
Route::get('addcustomer', 'CustomerController@getAddCompany');
Route::post('addcustomer', 'CustomerController@postAddCompany');
Route::get('customers', 'CustomerController@listCustomers');
Route::get('deletecustomer/{id}', 'CustomerController@getDeleteCustomer');

// Contacts
Route::get('contact/{id}', 'ContactController@getEditContact');
Route::post('contact', 'ContactController@postEditContact');
Route::get('addcontact/{customer_id}', 'ContactController@getAddContact');
Route::post('addcontact', 'ContactController@postAddContact');
Route::get('contacts/{customer_id?}', 'ContactController@listContacts');
Route::get('deletecontact/{id}', 'ContactController@getDeleteContact');

// Offers
Route::get('offer/{id}', 'OfferController@getEditOffer');
Route::post('offer', 'OfferController@postEditOffer');
Route::get('addoffer', 'OfferController@getAddOffer');
Route::post('addoffer', 'OfferController@postAddOffer');
Route::get('offers', 'OfferController@listOffers');
Route::get('autocompleteCustomer', 'OfferController@autocompleteCustomer');
Route::get('deleteoffer/{id}', 'OfferController@getDeleteOffer');
Route::get('viewoffer/{id}', 'OfferController@getViewOffer');

// Candidates
Route::get('candidate/{id}', 'CandidateController@getEditCandidate');
Route::get('viewCandidate/{id}', 'CandidateController@getViewCandidate');
Route::post('candidate', 'CandidateController@postEditCandidate');
Route::get('addcandidate', 'CandidateController@getAddCandidate');
Route::post('addcandidate', 'CandidateController@postAddCandidate');
Route::get('candidates/{id?}', 'CandidateController@listCandidates');
Route::get('autocompleteCandidate', 'CandidateController@autocompleteCandidate');
Route::get('autocompleteOffer', 'CandidateController@autocompleteOffer');
Route::get('deletecandidate/{id}', 'CandidateController@getDeleteCandidate');
Route::get('addCandidateOffer/{id}', 'CandidateController@getAddCandidateOffer');
Route::post('addCandidateOffer', 'CandidateController@postAddCandidateOffer');
Route::get('addOfferCandidate/{id}', 'CandidateController@getAddOfferCandidate');
Route::post('addOfferCandidate', 'CandidateController@postAddOfferCandidate');
Route::post('filterCandidates', 'CandidateController@postFilterCandidates');
Route::get('autocompleteProfiles', 'CandidateController@autocompleteProfiles');
Route::get('commentCO/{id}', 'CandidateController@getCandidateOfferComments');
Route::post('candidateByOfferComments', 'CandidateController@postCandidateOfferComments');
Route::get('deletecandidateOffer/{id}', 'CandidateController@getDeleteCandidateOffer');

Route::get('revision', 'CandidateController@listCandidatesRCV');

//OfferComments
Route::get('offerComments/{id}', 'CommentController@listOComments');
Route::post('offerComments', 'CommentController@addOComments');


//CandidateOfferStatusHistory
Route::get('candidateOfferHistory/{id}', 'StatusController@getStatusCandidate');


//CandidateComments
Route::get('candidateComments/{id}', 'CommentController@listCComments');
Route::post('candidateComments', 'CommentController@addCComments');


//Ajax Calls!
Route::post('state', function()
{
	if(Request::ajax()){  
	$address = \App\State::where('countries_id','=',Input::get('id'))->orderBy('state','ASC')->get();
	return $address;
  }	
});

Route::post('changeCandidateStatus', function()
{
	if(Request::ajax()){  
		$arr = explode("_",Input::get('status_RelID'));
		$relOC = \App\RelOfferCandidate::find($arr[1]);
		$rsco = new \App\RelStatusCandidateOffer;
		$rsco->rel_offers_candidates = $relOC->id;
		$rsco->users_id = Auth::user()->id;
		$rsco->status_id = $arr[0];
		$rsco->save();
		$relOC->rel_status_candidate_offer_id = $rsco->id;
		$relOC->save();
        if($arr[0]==8){
         Mail::send('emails.newCandidate', ['relOC' => $relOC], function ($m) {
            $m->from('no-reply@itwarp.com', 'ITWarp Consulting - ATS');

            $m->to('etatay@itwarp.com', 'Eduardo Tatay')->subject('Nuevo candidato para postular!' . ' ' .  date("d-m-Y G:i"));
        });
        }
        if($arr[0]==9){
         Mail::send('emails.newRevision', ['relOC' => $relOC], function ($m) {
            $m->from('no-reply@itwarp.com', 'ITWarp Consulting - ATS');

            $m->to('ariel@itwarp.com', 'Ariel Garbini')->cc('pablo@itwarp.com', 'Pablo Di Giovanni')->cc('lschraifer@itwarp.com', 'Leila Schraifer')->subject('Nuevo candidato para revisar!' . ' ' . date("d-m-Y G:i"));
        });
        }
        if($arr[0]==3 || $arr[0]==5 || $arr[0]==12 || $arr[0]==14 || $arr[0]==4 || $arr[0]==2 || $arr[0]==7 || $arr[0]==13){
         Mail::send('emails.newState', ['relOC' => $relOC], function ($m) use ($relOC) {
            $m->from('no-reply@itwarp.com', 'ITWarp Consulting - ATS');
            $email = $relOC->recruiters->email;
            $nombre = $relOC->recruiters->name . ' ' . $relOC->recruiters->surname;
            $m->to($email, $nombre)->subject('Candidato para revisar!' . ' ' . date("d-m-Y G:i"));
        });
        }
        if($arr[0]==6){
         Mail::send('emails.newState', ['relOC' => $relOC], function ($m) use ($relOC) {
            $m->from('no-reply@itwarp.com', 'ITWarp Consulting - ATS');
            $email = $relOC->recruiters->email;
            $nombre = $relOC->recruiters->name . ' ' . $relOC->recruiters->surname;
            $m->to('lschraifer@itwarp.com', 'Leila Schraifer')->cc($email, $nombre)->subject('Candidato para revisar!' . ' ' .  date("d-m-Y G:i"));
        });
        }
        if($arr[0]==11){
         Mail::send('emails.newFeedback', ['relOC' => $relOC], function ($m) {
            $m->from('no-reply@itwarp.com', 'ITWarp Consulting - ATS');

            $m->to('lschraifer@itwarp.com', 'Leila Schraifer')->subject('Solicitar Feedback a Cliente!' . ' ' .  date("d-m-Y G:i"));
        });
        }
        if($arr[0]==15){
         Mail::send('emails.newFeedback', ['relOC' => $relOC], function ($m) {
            $m->from('no-reply@itwarp.com', 'ITWarp Consulting - ATS');

            $m->to('etatay@itwarp.com', 'Eduardo Tatay')->subject('Solicitar Feedback a Cliente!' . ' ' .  date("d-m-Y G:i"));
        });
        }
	return "ok";
  }	
});


Route::get('mailRMdiario', function()
{
            $relOC = \App\RelOfferCandidate::where('status_id','=',8)->get();
            if($relOC->count()){
            
            Mail::send('emails.reminderCandidates', ['relOC' => $relOC], function ($m) {
            $m->from('no-reply@itwarp.com', 'ITWarp Consulting - ATS');

            $m->to('etatay@itwarp.com', 'Eduardo Tatay')->subject('Candidatos para postular!' . date("d-m-Y G:i"));
            });
           }

});


//Reportes
Route::get('reportesOportunidades', 'ReportController@getReports');
Route::get('reportesRecruiters', 'ReportController@getReportsRecruiter');
Route::post('postReportRecruiter', 'ReportController@postReportsRecruiter');


// Params - Profiles
Route::get('profiles/{id?}', 'ParamsController@getProfiles');
Route::get('deleteprofile/{id}', 'ParamsController@getDelteProfile');
Route::post('profile', 'ParamsController@postProfile');


Route::get('newStatusTable', function(){

	$rocs = \App\RelOfferCandidate::all();

	foreach($rocs as $roc){

		$rsco = new \App\RelStatusCandidateOffer;
		$rsco->rel_offers_candidates = $roc->id;
		$rsco->status_id = $roc->rel_status_candidate_offer_id;
		$rsco->users_id = $roc->recruiter;
		if($rsco->save()){
			$roc->rel_status_candidate_offer_id = $rsco->id;
			$roc->save();
		}
	}
});
<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Request;
use Session;
use Auth;

class StatusController extends Controller {

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
	public function getStatusCandidate($id = null)
	{	

		$status = \App\RelStatusCandidateOffer::where('rel_offers_candidates','=',$id)->get();
		$relOC = \App\RelOfferCandidate::find($id);
		return view('reports.history')
		->with('relOC',$relOC)
		->with('status',$status);
	}


}
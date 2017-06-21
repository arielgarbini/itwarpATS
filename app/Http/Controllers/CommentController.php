<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Request;
use Session;
use Auth;

class CommentController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function listOComments($id = null){

		$offer = \App\Offer::find($id);

		return view('comments.COlist')->with('offer',$offer);

	}


    public function addOComments(){

    	    $created_by = Auth::user()->id;
    	    $offer_id = Input::get('offer_id');
			$offerComment = new \App\OfferComment;

			$offerComment->users_id = $created_by;
			$offerComment->offers_id = $offer_id;
			$offerComment->comment = Input::get('comment');
	        
            if($offerComment->save()){
            	Session::flash('message', 'Comentario creado correctamente!!');
				return Redirect::to('offerComments/'.$offer_id);
            }

    }

    public function listCComments($id = null){

		$candidate = \App\Candidate::find($id);
                $offers= array();
               
                $relOC = \App\RelOfferCandidate::where('candidates_id','=',$id)->get();
                
                foreach ($relOC as $rel) {
        	$offers[] = $rel->id;
                }
                
                $comments = \App\CandidateOfferComment::whereIn('rel_offers_candidates_id',$offers)->get();
                
		return view('comments.CClist')->with('candidate',$candidate)->with('comments',$comments);

	}


    public function addCComments(){

    	    $created_by = Auth::user()->id;
    	    $candidate_id = Input::get('candidate_id');
			$CandidateComment = new \App\CandidateComment;

			$CandidateComment->users_id = $created_by;
			$CandidateComment->candidates_id = $candidate_id;
			$CandidateComment->comment = Input::get('comment');
	        
            if($CandidateComment->save()){
            	Session::flash('message', 'Comentario creado correctamente!!');
				return Redirect::to('candidateComments/'.$candidate_id);
            }

    }

}
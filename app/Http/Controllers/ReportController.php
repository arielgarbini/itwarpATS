<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Request;
use Session;
use DB;
use Auth;

class ReportController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	} 


	public function getReports(){

		$positions = \App\Offer::where('is_active','=',1)->where('offerstatus_id','!=',7)->where('offerstatus_id','!=',8)->where('offerstatus_id','!=',9)->orderBy('open_date','ASC')->get();

		return view('reports.view')->with('positions',$positions);
	}

        public function getReportsRecruiter(){

		$recruiters = \App\User::where('roles_id','=',2)->where('is_active','=',1)->get();
		$candidatos = null;

		return view('reports.recruiter')->with('recruiters',$recruiters)->with('candidatos',$candidatos);
	}
	
	 public function postReportsRecruiter(){

		$recruiters = \App\User::where('roles_id','=',2)->where('is_active','=',1)->get();
		$rango[0] = Input::get('desde');
		$rango[1] = Input::get('hasta');
		$recruiter_id = Input::get('recruiter_id');

		$candidatos = DB::table('candidates')->select(DB::raw("DATE(created_at) as date, count(*) as total"))
		->where('is_active','=','1')->where('created_by','=',$recruiter_id)
		->whereBetween('created_at',$rango)->groupBy('date')->get();
	 

		return view('reports.recruiter')->with('recruiters',$recruiters)->with('candidatos',$candidatos);
	}

	

}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use DB;
use Response;

class AdminController extends Controller
{
	public function index() {
	  return view('contents.indexadmin');
	}
	public function getLogout() {
		Auth::logout();
		return redirect()->route('authlogin');
	}

	public function seeNotification($id) {
		DB::beginTransaction();
		try{
			$notif = DB::table('notifications')->where('id',$id)->first();
			DB::table('notifications')->where('id',$id)->update(['date_seen'=>Date('Y-m-d H:i:s')]);
			DB::commit();
			return Response::json(['code'=>200,'notif'=>$notif]);
		} catch (Exception $e) {
			DB::rollback();
			return Response::json(['code'=>500,'message'=>$e->getMessage()]);
		}

	}
}

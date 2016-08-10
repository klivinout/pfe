<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

class AdminController extends Controller
{
    public function index() {
        return view('contents.indexadmin');
    }
    public function getLogout() {
    	Auth::logout();

      return redirect()->route('authlogin');
    }
}

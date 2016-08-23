<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use DB;

class AuthController extends Controller
{
    public function getLogin() {

        if (Auth::viaRemember()) {
            return redirect()->route('acceuil');
        } else {
            return view('auth.login');
        }
    }

    public function postLogin(Request $request) {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!Auth::attempt($request->only(['email','password']),$request->has('remember'))) {
            return redirect()->back()->with('info' , 'Vos informations sont incorrect');
        } else {
            $user = Auth::User();
            switch ($user->type) {
                case 1:
                    return redirect()->route('listcondidate');
                    break;
                case 2:
                    return redirect()->route('liststagiaires');
                    break;
                case 3:
                    return redirect()->route('listtache');
                    break;
                case 10:
                    return redirect()->route('listcondidate');
                    break;
            }
            return redirect()->route('adminindex');
        }
    }
}

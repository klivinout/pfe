<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use Auth;
use DB;
use View;

class AuthController extends Controller
{
    public function getLogin() {

        /*DB::table('users')->insert([
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345'),
            'nom' => 'Benbakh',
            'prenom' => 'Med Salah',
            'departement' => 1
        ]);*/

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

    public function getProfile() {
        $departements = DB::table('departements')->get();
        return View::make('contents.profile.profile',['departements' => $departements]);
    }

    public function postProfile(Request $request) {
        DB::beginTransaction();
        try {

            if(!Auth::attempt(
                [
                    'email' => Auth::User()->email , 
                    'password' => $request->input('password')
                ])
            ) {
                return redirect()->back()->with('error_psw','1');
            }

            $this->validate($request, [ 
                'nom' => 'required',
                'prenom' => 'required',
                'email' => 'required | email',
                'departement' => 'required',
                'password' => 'required'
            ]);

            $image = json_decode(Auth::User()->image);

            if($request->hasfile('image')) {

                //upload image
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $mime_image = $file->getClientMimeType();
                $image = '/images_profile/'.Auth::User()->id.'-'.$request->input('nom').'-'.$request->input('prenom').'.'.$extension;
                Storage::disk('upload')->put($image,  File::get($file));

                $image = ['image' => $image , 'mime' => $mime_image];
            }

            $updateProfile = [
                'nom' => $request->input('nom'),
                'prenom' => $request->input('prenom'),
                'email' => $request->input('email'),
                'departement' => $request->input('departement'),
                'image' => json_encode($image),
                'updated_at' => Date('Y-m-d H:i:s')
            ];

            if($request->input('new_psw') != '') {
                if( $request->input('new_psw') != $request->input('confirm_psw') ){
                    return redirect()->back()->with('error_confirmpsw','1');
                } else {
                    $updateProfile['password'] = bcrypt($request->input('new_psw'));
                }
            }
                
            DB::table('users')->where('id',Auth::User()->id)->update($updateProfile);

        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger','Erreur survenu : ' . $e->getMessage());
        }
        DB::commit();
        return redirect()->back()->with('info', 'Profile mis à jour' );
    }

    public function getImage($id) {
        $image = DB::table('users')->where('id',$id)->value('image');
        $image = json_decode($image);
        $file = Storage::disk('upload')
                ->get($image->image);
        return Response($file, 200 , ['Content-Type' => $image->mime]);
    }
}

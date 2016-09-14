<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use View;
use Response;
use Auth;
use Input;

class ResponsableController extends Controller
{
    public function getNew() {
        $departements = DB::table('departements')->get();
        $villes = DB::table('villes')->get();
        return View::make('contents.parametres.new',['departements' => $departements , 'villes' => $villes]);
    }

    public function postNewResp(Request $request) {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'nom' => 'required',
                'prenom' => 'required',
                'email' => 'required | email',
                'departement' => 'required | exists:departements,id'
                ]);
            if($request->input('departement') == 2)
                $type = 1;
            else
                $type = 2;

            $insertResp = [
                'nom' => $request->input('nom'),
                'prenom' => $request->input('prenom'),
                'email' => $request->input('email'),
                'departement' => $request->input('departement'),
                'password' => bcrypt($request->input('email')),
                'type' => $type,
                'created_at' => Date('Y-m-d H:i:s')
            ];
            $resp = DB::table('users')->insertGetId($insertResp);
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        DB::commit();
        return redirect()->back()->with('info',"Responsable ajouter avec success");
    }

    public function postNewDept(Request $request) {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'dep_nom' => 'required'
            ]);

            DB::table('departements')->insert(['nom' => $request->input('dep_nom')]);
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        DB::commit();
        return redirect()->back()->with('info',"Division ajouter avec success");
    }

    public function postModifyResp($id,Request $request) {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'nom' => 'required',
                'prenom' => 'required',
                'email' => 'required | email',
                'departement' => 'required | exists:departements,id'
            ]);
            $updateResp = [
                'nom' => $request->input('nom'),
                'prenom' => $request->input('prenom'),
                'email' => $request->input('email'),
                'departement' => $request->input('departement'),
                'updated_at' => Date('Y-m-d H:i:s')
            ];
            $n = DB::table('users')->where('id',$id)->update($updateResp);
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        DB::commit();
        if($n == 1)
            return redirect()->back()->with('info',"Responsable modifier avec success");
        elseif($n==0)
            return redirect()->back()->with('info',"Informations non modifier");
    }

    public function postNewCity(Request $request) {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'city_nom' => 'required',
                'city_codepostal' => 'required'
            ]);

            DB::table('villes')->insert([
                'nom' => $request->input('city_nom') , 
                'code_postal' => $request->input('city_codepostal')
            ]);
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        DB::commit();
        return redirect()->back()->with('info',"Ville ajouter avec success");
    }

    public function postNewDegree(Request $request) {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'diplome_nom' => 'required'
            ]);

            DB::table('diplomes')->insert([
                'nom' => $request->input('diplome_nom')
            ]);
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        DB::commit();
        return redirect()->back()->with('info',"Diplôme ajouter avec success");
    }

    public function postNewSchool(Request $request) {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'school_nom' => 'required',
                'school_adress' => 'required',
                'school_email' => 'required',
                'school_phone' => 'required'
            ]);

            DB::table('etablissements')->insert([
               'nom' => $request->input('school_nom'),
               'adresse' => $request->input('school_adress'),
               'email' => $request->input('school_email'),
               'telephone' => $request->input('school_phone')
            ]);
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        DB::commit();
        return redirect()->back()->with('info',"Etablissement ajouter avec success");
    }

    public function theList(Request $request) {
        $type_list = $request->input('type_list');
        $departements = DB::table('departements')->get();

        if($type_list == 'responsables'){
            $resps = DB::table('users as u')
                ->join('departements as d','d.id','=','u.departement')
                ->select('u.id','u.nom','u.prenom','u.email','u.departement','d.nom as dept_nom')
                ->where('type','<>',3)
                ->get();

            
            return View::make('contents.parametres.list',[
                'resps'=>$resps,
                'type_list' => 'responsables',
                'departements' => $departements
            ]);
        } else if($type_list == 'etablissements'){
            $etablissements = DB::table('etablissements')->get();

            return View::make('contents.parametres.list',[
                'etablissements'=>$etablissements,
                'type_list' => 'etablissements'
            ]);
        } else if($type_list == 'divisions'){
            $departements = DB::table('departements')->get();
            
            return View::make('contents.parametres.list',[
                'departements'=>$departements,
                'type_list' => 'divisions'
            ]);
        } else if($type_list == 'diplomes'){
            $diplomes = DB::table('diplomes')->get();
            
            return View::make('contents.parametres.list',[
                'diplomes'=>$diplomes,
                'type_list' => 'diplomes'
            ]);
        } else if($type_list == 'villes'){
            $villes = DB::table('villes')->get();

            return View::make('contents.parametres.list',[
                'villes'=>$villes,
                'type_list' => 'villes'
            ]);
        } else {
            return View::make('contents.parametres.list',[
                'type_list' => ''
            ]);
        }
    }


    public function getModifyResp($id) {
        try{
            $data = DB::table('users')->where('id',$id)->first();
            return Response::json(['code' => 200 , 'data' => $data , 'message' => '']);
        } catch (Exception $e) {
            return Response::json(['code' => '502' , 'data' => '' , 'message' => $e->getMessage()]);
        }
    }
    public function getModifyCity($id) {
        try{
            $data = DB::table('villes')->where('id',$id)->first();
            return Response::json(['code' => 200 , 'data' => $data , 'message' => '']);
        } catch (Exception $e) {
            return Response::json(['code' => '502' , 'data' => '' , 'message' => $e->getMessage()]);
        }
    }
    public function getModifySchool($id) {
        try{
            $data = DB::table('etablissements')->where('id',$id)->first();
            return Response::json(['code' => 200 , 'data' => $data , 'message' => '']);
        } catch (Exception $e) {
            return Response::json(['code' => '502' , 'data' => '' , 'message' => $e->getMessage()]);
        }
    }
    public function getModifyDept($id) {
        try{
            $data = DB::table('departements')->where('id',$id)->first();
            return Response::json(['code' => 200 , 'data' => $data , 'message' => '']);
        } catch (Exception $e) {
            return Response::json(['code' => '502' , 'data' => '' , 'message' => $e->getMessage()]);
        }
    }
    public function getModifyDegree($id) {
        try{
            $data = DB::table('diplomes')->where('id',$id)->first();
            return Response::json(['code' => 200 , 'data' => $data , 'message' => '']);
        } catch (Exception $e) {
            return Response::json(['code' => '502' , 'data' => '' , 'message' => $e->getMessage()]);
        }
    }
}

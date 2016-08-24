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
        return View::make('contents.responsable.new',['departements' => $departements]);
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
        return redirect()->back()->with('info',"Responsable ajouter avec success");
    }

    public function getModify($id) {
        $departements = DB::table('departements')->get();
        $resp = DB::table('users')->select('id','nom','prenom','email','departement')->where('id',$id)->first();
        return View::make('contents.responsable.modify',['departements' => $departements,'resp'=>$resp]);
    }

    public function postModify($id,Request $equest) {
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
                'type' => 2,
                'updated_at' => Date('Y-m-d H:i:s')
            ];
            $n = DB::table('users')->where('id',$id)->update($updateResp);
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        DB::commit();
        if($n == 1)
            return redirect()->back()->with('info',"Responsable ajouter avec success");
        elseif($n==0)
            return redirect()->back()->with('info',"Informations non modifier");
    }

    public function theList() {
        $resps = DB::table('users as u')
        ->join('departements as d','d.id','=','u.departement')
        ->select('u.id','u.nom','u.prenom','u.email','u.departement','d.nom as dept_nom')
        ->where('type',2)
        /*->where(function ($query) use ($departement = "tout"){
            if($departement != 'tout') {
                $query->where('departement',$departement);
            }
        })*/
        ->get();
        return View::make('contents.responsable.list',['resps'=>$resps]);
    }
}

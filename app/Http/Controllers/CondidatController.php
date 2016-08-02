<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use DB;
use Response;
use Auth;

class CondidatController extends Controller
{
    public function getNew() {
        $departements = DB::table('departements')->get();
        return View::make('contents.condidate.new' , ['departements' => $departements]);
    }

    public function postNew(Request $request) {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'nom' => 'required',
                'prenom' => 'required',
                'email' => 'required | email',
                'etablissement' => 'required',
                'datefrom' => 'required | date',
                'dateend' => 'required | date',
                'division' => '',
                'observation' => '',
            ]);
            $insertCondidat = [
                'nom' => $request->input('nom'),
                'prenom' => $request->input('prenom'),
                'email' => $request->input('email'),
                'etablissement' => $request->input('etablissement'),
                'datefrom' => $request->input('datefrom'),
                'dateend' => $request->input('dateend'),
                'departement' => $request->input('division'),
                'observation' => $request->input('observation'),
                'created_at' => Date('Y-m-d H:i:s')
            ];
            $condidat = DB::table('condidats')->insertGetId($insertCondidat);
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        DB::commit();
        return redirect()->back()->with('info',"Condidat ajouter avec success");
    }

    public function getModify($id) {
        $departements = DB::table('departements')->get();
        $condidat = DB::table('condidats')->where('id',$id)->first();
        return View::make('contents.condidate.modify' , ['departements' => $departements , 'condidat' => $condidat]);
    }

    public function postModify($id,Request $request) {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'nom' => 'required',
                'prenom' => 'required',
                'email' => 'required | email',
                'etablissement' => 'required',
                'datefrom' => 'required | date',
                'dateend' => 'required | date',
                'division' => '',
                'observation' => '',
            ]);
            $modifyCondidat = [
                'nom' => $request->input('nom'),
                'prenom' => $request->input('prenom'),
                'email' => $request->input('email'),
                'etablissement' => $request->input('etablissement'),
                'datefrom' => $request->input('datefrom'),
                'dateend' => $request->input('dateend'),
                'departement' => $request->input('division'),
                'observation' => $request->input('observation'),
                'updated_at' => Date('Y-m-d H:i:s')
            ];
            DB::table('condidats')->where('id',$id)->update($modifyCondidat);
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        DB::commit();
        return redirect()->back()->with('info',"Condidat modifier avec success");
    }

    public function theList() {
        $list = DB::table('condidats as c')
            ->join('departements as d','d.id','=','c.departement')
            ->select('c.id','c.nom','c.prenom','c.email','c.etablissement','c.datefrom','c.dateend','d.nom as departement','c.etat')
            ->get();
        return View::make('contents.condidate.list' , ['condidats' => $list]);
    }

    public function api_listCondidate() {
        $list = DB::table('condidats as c')
            ->join('departements as d','d.id','=','c.departement')
            ->select('c.id','c.nom','c.prenom','c.email','c.etablissement','c.datefrom','c.dateend','d.nom as departement')
            ->get();
        return Response::json($list);
    }

}

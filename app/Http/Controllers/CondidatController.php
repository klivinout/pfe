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
        if(Auth::User()->type != 10 && Auth::User()->type !=1) {
            return redirect()->back()->with('danger','vous n\'avez pas le droit d\'access');
        }
        $departements = DB::table('departements')->get();
        return View::make('contents.condidate.new' , ['departements' => $departements]);
    }

    public function postNew(Request $request) {
        if(Auth::User()->type != 10 && Auth::User()->type !=1) {
            return redirect()->back()->with('danger','vous n\'avez pas le droit d\'access');
        }
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'nom' => 'required',
                'prenom' => 'required',
                'email' => 'required | email',
                'etablissement' => 'required',
                'datefrom' => 'required | date',
                'dateend' => 'required | date',
                'division' => 'required',
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
            $insertNotification = [
                'broadcast' => 1,
                'from' => Auth::User()->id,
                'to' => $request->input('division'),
                'type' => 10,
                'date_add' => Date('Y-m-d H:i:s'),
                'lien' => route('modifycondidat',['id'=>$condidat]),
                'created_at' => Date('Y-m-d H:i:s')
            ];
            DB::table('notifications')->insert($insertNotification);
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        DB::commit();
        return redirect()->back()->with('info',"Condidat ajouter avec success");
    }

    public function getModify($id) {
        if(Auth::User()->type ==3) {
            return redirect()->back()->with('danger','vous n\'avez pas le droit d\'access');
        }
        $departements = DB::table('departements')->get();
        $condidat = DB::table('condidats')->where('id',$id)->first();
        return View::make('contents.condidate.modify' , ['departements' => $departements , 'condidat' => $condidat]);
    }

    public function postModify($id,Request $request) {
        if(Auth::User()->type != 10 && Auth::User()->type !=1) {
            return redirect()->back()->with('danger','vous n\'avez pas le droit d\'access');
        }
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'nom' => 'required',
                'prenom' => 'required',
                'email' => 'required | email',
                'etablissement' => 'required',
                'datefrom' => 'required | date',
                'dateend' => 'required | date',
                'division' => 'required',
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
            $insertNotification = [
                'broadcast' => 1,
                'from' => Auth::User()->id,
                'to' => $request->input('division'),
                'type' => 12,
                'date_add' => Date('Y-m-d H:i:s'),
                'lien' => route('modifycondidat',['id'=>$id]),
                'created_at' => Date('Y-m-d H:i:s')
            ];
            DB::table('notifications')->insert($insertNotification);
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
        }
        DB::commit();
        return redirect()->back()->with('info',"Condidat modifier avec success");
    }

    public function theList() {
        if(Auth::User()->type != 10 && Auth::User()->type == 3) {
            return redirect()->back()->with('danger','vous n\'avez pas le droit d\'access');
        }
        $user = Auth::User();
        $list = DB::table('condidats as c')
            ->join('departements as d','d.id','=','c.departement')
            ->where(function ($query) {
                if(Auth::User()->type != 10)
                    $query->where('c.departement',Auth::User()->departement);
            })
            ->select('c.id','c.nom','c.prenom','c.email','c.etablissement','c.datefrom','c.dateend','d.nom as departement','c.etat')
            ->get();

        return View::make('contents.condidate.list' , ['condidats' => $list]);
    }

}

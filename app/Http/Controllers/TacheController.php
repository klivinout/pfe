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

class TacheController extends Controller
{
    public function getNew($id,$tache){
        if($id != 'tout') {
            $stage = DB::table('stages')->where('id',$id)->first();
            $stagiaire = DB::table('condidats as c')
                ->join('departements as d','d.id','=','c.departement')
                ->select('c.*','d.id as dep_id','d.nom as dep_nom')
                ->where('c.user',$stage->stagiaire)
                ->first();
            $responsable = DB::table('users as u')
                ->join('departements as d','d.id','=','u.departement')
                ->select('u.id','u.nom','u.prenom','u.email','u.departement','d.id as dep_id','d.nom as dep_nom')
                ->where('u.id',$stage->responsable)
                ->first();
            $sujet = DB::table('sujets')->where('id',$stage->sujet)->first();
            $taches = DB::table('taches as t')
                ->join('users as u','u.id','=','t.from')
                ->select('t.*','u.nom as from_nom')
                ->where('t.stage',$id)
                ->get();

            if($tache != 'tout') {
                $tache = DB::table('taches')->where('id',$tache)->first();
                if(empty($tache))
                    return redirect()->route('newtache',['id'=>$id,'tache'=>'tout'])->with('danger','aucune tache corespondante');
                return View::make('contents.tache.new' , [
                    'stage' => $stage,
                    'stagiaire' => $stagiaire,
                    'responsable' => $responsable,
                    'sujet' => $sujet,
                    'taches' => $taches,
                    'tache_modif' => $tache
                ]);
            } else {
                return View::make('contents.tache.new' , [
                    'stage' => $stage,
                    'stagiaire' => $stagiaire,
                    'responsable' => $responsable,
                    'sujet' => $sujet,
                    'taches' => $taches
                ]);
            }

        } else {
            $stages = DB::table('stages as s')
                ->join('condidats as stg','stg.user','=','s.stagiaire')
                ->select('s.id as stage','stg.nom','stg.prenom','stg.datefrom')
                ->get();
            return View::make('contents.tache.new' , ['stages' => $stages]);
        }
    }

    public function postNew($id,$tache,Request $request) {
        if($tache == 'tout') {
            DB::beginTransaction();
            try {
                $this->validate($request, [
                    'objet' => 'required',
                    'description' => 'required',
                    'delai' => 'required'
                ]);
                $insertTask = [
                    'from' => Auth::User()->id,
                    'stage' => $id,
                    'objet' => $request->input('objet'),
                    'description' => $request->input('description'),
                    'delai' => $request->input('delai'),
                    'created_at' => Date('Y-m-d H:i:s')
                ];
                $condidat = DB::table('taches')->insertGetId($insertTask);

            } catch (Exception $e) {
                DB::rollback();
                dd($e);
            }

            DB::commit();
            return redirect()->back()->with('info',"Tache ajouter avec success");
        } else {
            DB::beginTransaction();
            try {
                $this->validate($request, [
                    'objet' => 'required',
                    'description' => 'required',
                    'delai' => 'required'
                ]);
                $updateTask = [
                    'from' => Auth::User()->id,
                    'stage' => $id,
                    'objet' => $request->input('objet'),
                    'description' => $request->input('description'),
                    'delai' => $request->input('delai'),
                    'updated_at' => Date('Y-m-d H:i:s')
                ];
                DB::table('taches')->where('id',$tache)->update($updateTask);

            } catch (Exception $e) {
                DB::rollback();
                dd($e);
            }

            DB::commit();
            return redirect()->route('newtache',['id'=>$id,'tache'=>$tache])->with('info',"Tache Modifier avec success");
        }
    }

    public function theList() {
        $stages = DB::table('stages as s')
            ->join('condidats as stg','stg.user','=','s.stagiaire')
            ->join('users as resp','resp.id','=','s.responsable')
            ->join('departements as dep','dep.id','=','resp.departement')
            ->join('sujets','sujets.id','=','s.sujet','left outer')
            ->select('s.id as stage','s.created_at','s.statut',
                'stg.id as stg','stg.nom as stg_nom','stg.prenom as stg_prenom',
                'resp.id as resp','resp.nom as resp_nom','resp.prenom as resp_prenom','resp.type as resp_type',
                'dep.nom as dep_nom',
                'sujets.id as sujet','sujets.objet as sujet_objet'
                )
            ->orderBy('s.id')
            ->get();
        return View::make('contents.tache.list' , ['stages' => $stages]);
    }


    //ajax functions :

        /**theListByStage
         * returns list of tasks by stage
         *
         * @param  id of Stage  $id
         * @return \Illuminate\Http\Response
         */
            public function theListByStage($id) {

                $taches = DB::table('taches')->where('stage',$id)->get();

                if(!empty($taches))
                    return Response::json(['code' => 200 ,'taches' => $taches]);
                else 
                    return Response::json(['code' => 501 ,'taches' => $taches]);

            }

        /**getModify
         * returns array/obj of task's info
         *
         * @param  id of Tache  $id
         * @return \Illuminate\Http\Response
         */
            public function getModify($id) {
                $tache = DB::table('taches')->where('id',$id)->first();
                if(empty($tache))
                    return redirect()->route('newtache',['id'=>$id,'tache'=>'tout'])->with('danger','aucune tache corespondante');
                return Response::json(['code'=>200,'tache'=>$tache]);
            }

        /**postStatut
         * returns result of request of task's modifying statut
         *
         * @param  id of Tache  $id
         * @return \Illuminate\Http\Response
         */
            public function postStatut($id) {
                $statut = Input::get('statut');
                $statut = '['.$statut.','.Auth::User()->id.']';
                $n = DB::table('taches')->where('id',$id)->update(['statut' => $statut]);
                return Response::json($n);
            }
}

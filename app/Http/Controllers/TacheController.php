<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use DB;
use View;
use Response;
use Auth;
use Input;

use SnappyImage;
use PDF;

class TacheController extends Controller
{
    public function getNew($id,$tache){

        if($id != 'tout') {
            $stage = DB::table('stages')->where('id',$id)->first();
            $user = Auth::User();
            if($user->type == 2) {
                if($user->id != $stage->responsable && $user->type != 10)
                    return redirect()->back()->with('info','Vous n\'avez pas le droit d\'access !!');
            } else if($user->type==3){
                if($user->id != $stage->stagiaire && $user->type != 10)
                    return redirect()->back()->with('info','Vous n\'avez pas le droit d\'access !!');
            }
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
                ->where('s.responsable',Auth::User()->id)
                ->where('s.statut',0)
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

                //NOTIFICATION 50
                $notif_stagiaire = DB::table('stages')->where('id',$id)->first();
                $insertNotification = [
                    'broadcast' => 0,
                    'from' => Auth::User()->id,
                    'to' => $notif_stagiaire->stagiaire,
                    'type' => 50,
                    'date_add' => Date('Y-m-d H:i:s'),
                    'lien' => route('newtache',['id'=>$id,'tache'=>$tache]),
                    'created_at' => Date('Y-m-d H:i:s')
                ];
                DB::table('notifications')->insert($insertNotification);

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
            ->where(function ($query) {
                if(Auth::User()->type == 2) {
                    $query->where('s.responsable',Auth::User()->id);
                } else if(Auth::User()->type == 3) {
                    $query->where('s.stagiaire',Auth::User()->id);
                }
            })
            ->where('s.responsable',Auth::User()->id)
            ->orderBy('s.id')
            ->get();
        return View::make('contents.tache.list' , ['stages' => $stages]);
    }

    public function imprimer($id) {
        $stage = DB::table('stages')->where('id',$id)->first();
        $stagiaire = DB::table('condidats as c')
            ->join('departements as d','d.id','=','c.departement')
            ->where('c.id',$stage->stagiaire)
            ->select('c.*','d.nom as dept_nom')
            ->first();
        $pdf = PDF::loadView('pdf.attestation_ms', ['stagiaire' => $stagiaire]);
        $file = $pdf->save('pdf.pdf',true);
        Storage::disk('upload')->put('/documents_stagiaire/certificats/attestation_ms_'.$id.'.pdf', $file);
        return $pdf->inline();
    }

    //ajax functions :

        /**theListByStage
         * returns list of tasks by stage
         *
         * @param  id of Stage  $id
         * @return \Illuminate\Http\Response
         */
            public function theListByStage($id) {

                $stage = DB::table('stages')->where('id',$id)->first();
                $user = Auth::User();
                if($user->type == 2) {
                    if($user->id != $stage->responsable && $user->type != 10)
                        return Response::json([
                            'code' => 400 ,
                            'taches' => $taches,
                            'msgError' => 'Vous n\'avez pas le droit de consulter les taches de ce Stage !!']);
                } else if($user->type==3){
                    if($user->id != $stage->stagiaire && $user->type != 10)
                        return Response::json([
                            'code' => 400 ,
                            'taches' => $taches,
                            'msgError' => 'Vous n\'avez pas le droit de consulter les taches de ce Stage !!']);
                }

                $taches = DB::table('taches')->where('stage',$id)->get();

                if(!empty($taches))
                    return Response::json(['code' => 200 ,'taches' => $taches]);
                else
                    return Response::json([
                        'code' => 501 ,
                        'taches' => $taches,
                        'msgError' => 'Ce stage n\'a encore aucune tache'
                        ]);

            }

            /**getModify
            * returns array/obj of task's info
            *
            * @param  id of Tache  $id
            * @return \Illuminate\Http\Response
            */
                public function getModify($id) {
                    try{
                        $tache = DB::table('taches')->where('id',$id)->first();
                        if(empty($tache))
                            return Response::json(['code'=>401,'tache'=> [] ]);
                        return Response::json(['code'=>200,'tache'=>$tache]);
                    }catch(Exception $e){
                        return Response::json(['code'=>501,'message' => $e->getMessage()]);
                    }

                }

        /**postStatut
         * returns result of request of task's modifying statut
         *
         * @param  id of Tache  $id
         * @return \Illuminate\Http\Response
         */
            public function postStatut($id) {
                try{
                    DB::beginTransaction();
                    $statut = Input::get('statut');
                    $statutJson = '['.$statut.','.Auth::User()->id.']';
                    $n = DB::table('taches')->where('id',$id)->update(['statut' => $statutJson]);
                    if($n == 1){
                        //NOTIFICATION 5*
                        $notif_statut = 50;
                        switch ($statut) {
                            case 10:
                                $notif_statut = 51;
                                break;
                            case 1:
                                $notif_statut = 53;
                                break;
                            case -1:
                                $notif_statut = 52;
                                break;
                        }
                        $stage = DB::table('taches')->where('id',$id)->first();
                        $notif_stagiaire = DB::table('stages')->where('id',$stage->stage)->first();

                        if($notif_statut != 53)
                            $notif_to = $notif_stagiaire->stagiaire;
                        else
                            $notif_to = $notif_stagiaire->responsable;
                        $insertNotification = [
                            'broadcast' => 0,
                            'from' => Auth::User()->id,
                            'to' => $notif_to,
                            'type' => $notif_statut,
                            'date_add' => Date('Y-m-d H:i:s'),
                            'lien' => route('newtache',['id'=>$stage->stage,'tache'=>$id]),
                            'created_at' => Date('Y-m-d H:i:s')
                        ];
                        DB::table('notifications')->insert($insertNotification);
                        DB::commit();
                        return Response::json(['code' => 200,'newstatut' => $statut,'tache'=>$id]);
                    }
                    if($n == 0){
                        return Response::json(['code' => 201,'newstatut' => $statut,'tache'=>$id]);
                    }
                    else{
                        return Response::json(['code' => 501]);
                    }
                }catch(Exception $e){
                    DB::rollback();
                    return $e->getMessage();
                }
            }

        /**postStatut
         * returns result of request of task's modifying statut
         *
         * @param  id of Tache  $id
         * @return \Illuminate\Http\Response
         */
            public function getRefreshStatut($id) {
                try {
                    $statut = DB::table('taches')->where('id',$id)->value('statut');
                    $statut = json_decode($statut);
                    return Response::json(['code' => 200,'statut' => $statut[0],'tache'=>$id]);
                } catch (Exception $e) {
                    return Response::json(['code' => 501 , 'message' => $e->getMessage()]);
                }
            }
}

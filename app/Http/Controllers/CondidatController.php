<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
        $etablissements = DB::table('etablissements')->get();
        $villes = DB::table('villes')->get();
        $diplomes = DB::table('diplomes')->get();
        $data = [
            'departements' => $departements,
            'etablissements' => $etablissements,
            'villes' => $villes,
            'diplomes' => $diplomes,
        ];
        return View::make('contents.condidate.new' , $data);
    }

    public function getCurriculumVitae($id) {
        if(Auth::User()->type ==3) {
         return redirect()->back()->with('danger','vous n\'avez pas le droit d\'access');
        }
        try {
            $document = DB::table('condidats')->where('id',$id)->value('documents');
            $document = json_decode($document);

            $file = Storage::disk('upload')
                ->get('/documents_stagiaire/curriculumvitae/'.$document->cv->document);

            return Response($file, 200 , ['Content-Type' => $document->cv->mime]);
        } catch (Exception $e) {
            return Response('Unautorized' , 401);
        }
    }

    public function postNew(Request $request) {
        if(Auth::User()->type != 10 && Auth::User()->type !=1) {
            return redirect()->back()->with('danger','vous n\'avez pas le droit d\'access');
        }
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'nom' => 'required',
                'cin' => 'required',
                'prenom' => 'required',
                'email' => 'required | email',
                'etablissement' => 'required',
                'ville' => 'required',
                'diplome' => 'required',
                'stg_diplome' => 'required',
                'datefrom' => 'required | date',
                'dateend' => 'required | date',
                'division' => 'required',
                'observation' => '',
            ]);

            
            $cv =NULL;

            if($request->hasfile('cv')) {
                $file = $request->file('cv');
                $extension = $file->getClientOriginalExtension();
                $mime_cv = $file->getClientMimeType();
                $cv = Auth::User()->id.'-'.$request->input('nom').'-'.$request->input('prenom').'-cv-'.time().'.'.$extension;
                Storage::disk('upload')->put('/documents_stagiaire/curriculumvitae/'.$cv,  File::get($file));
                $cv = json_encode(['cv' => ['document' => $cv , 'mime' => $mime_cv]]);
            }

            $insertCondidat = [
                'nom' => $request->input('nom'),
                'prenom' => $request->input('prenom'),
                'email' => $request->input('email'),
                'etablissement' => $request->input('etablissement'),
                'cin' => $request->input('cin'),
                'ville' => $request->input('ville'),
                'diplome' => $request->input('diplome'),
                'stg_diplome' => $request->input('stg_diplome'),
                'datefrom' => $request->input('datefrom'),
                'dateend' => $request->input('dateend'),
                'departement' => $request->input('division'),
                'documents' => $cv,
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
        $etablissements = DB::table('etablissements')->get();
        $villes = DB::table('villes')->get();
        $cv = $condidat->documents;
        $diplomes = DB::table('diplomes')->get();

        return View::make('contents.condidate.modify' , [
            'departements' => $departements , 
            'condidat' => $condidat,
            'etablissements' => $etablissements,
            'villes' => $villes,
            'diplomes' => $diplomes,
            'cv' => $cv
        ]);
    }

    public function postModify($id,Request $request) {
        if(Auth::User()->type != 10 && Auth::User()->type !=1) {
            return redirect()->back()->with('danger','vous n\'avez pas le droit d\'access');
        }
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'nom' => 'required',
                'cin' => 'required',
                'prenom' => 'required',
                'email' => 'required | email',
                'etablissement' => 'required',
                'ville' => 'required',
                'diplome' => 'required',
                'stg_diplome' => 'required',
                'datefrom' => 'required | date',
                'dateend' => 'required | date',
                'division' => 'required',
                'observation' => '',
            ]);

            if($request->hasfile('cv')) {
                $file = $request->file('cv');
                $extension = $file->getClientOriginalExtension();
                $mime_cv = $file->getClientMimeType();
                $cv = Auth::User()->id.'-'.$request->input('nom').'-'.$request->input('prenom').'-cv-'.time().'.'.$extension;
                Storage::disk('upload')->put('/documents_stagiaire/curriculumvitae/'.$cv,  File::get($file));
                $cv = json_encode(['cv' => ['document' => $cv , 'mime' => $mime_cv]]);

                $modifyCondidat = [
                    'nom' => $request->input('nom'),
                    'prenom' => $request->input('prenom'),
                    'email' => $request->input('email'),
                    'etablissement' => $request->input('etablissement'),
                    'cin' => $request->input('cin'),
                    'ville' => $request->input('ville'),
                    'diplome' => $request->input('diplome'),
                    'stg_diplome' => $request->input('stg_diplome'),
                    'datefrom' => $request->input('datefrom'),
                    'dateend' => $request->input('dateend'),
                    'departement' => $request->input('division'),
                    'documents' => $cv,
                    'observation' => $request->input('observation'),
                    'updated_at' => Date('Y-m-d H:i:s')
                ];
            } else {
                $modifyCondidat = [
                    'nom' => $request->input('nom'),
                    'prenom' => $request->input('prenom'),
                    'email' => $request->input('email'),
                    'etablissement' => $request->input('etablissement'),
                    'cin' => $request->input('cin'),
                    'ville' => $request->input('ville'),
                    'diplome' => $request->input('diplome'),
                    'stg_diplome' => $request->input('stg_diplome'),
                    'datefrom' => $request->input('datefrom'),
                    'dateend' => $request->input('dateend'),
                    'departement' => $request->input('division'),
                    'observation' => $request->input('observation'),
                    'updated_at' => Date('Y-m-d H:i:s')
                ];
            }

            
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

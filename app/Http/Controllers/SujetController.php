<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use DB;
use View;
use Response;
use Auth;

class SujetController extends Controller
{
    public function getNew() {
        if(Auth::User()->type ==3) {
            return redirect()->back()->with('danger','vous n\'avez pas le droit d\'access');
        }
        return view('contents.sujet.new');
    }

    public function postNew(Request $request) {
        if(Auth::User()->type ==3) {
            return redirect()->back()->with('danger','vous n\'avez pas le droit d\'access');
        }
        DB::beginTransaction();
        try {
            $this->validate($request , [
                'objet' => 'required',
                'description' => 'required'
            ]);

            $attachement = NULL;
            $mime = NULL;

            if($request->hasFile('attachement')) {
                $this->validate($request , [
                    'attachement' => 'mimes:jpeg,png,doc,docx,pdf'
                ]);
                $file = $request->file('attachement');
                $extension = $file->getClientOriginalExtension();
                $mime = $file->getClientMimeType();
                $attachement = Auth::User()->id.'-'.$request->input('objet').'-'.time().'.'.$extension;
                Storage::disk('upload')->put('/sujet/'.$attachement,  File::get($file));
            }

            $id = DB::table('sujets')->insertGetId([
                'proposer_par' => Auth::User()->id,
                'objet' => $request->input('objet'),
                'description' => $request->input('description'),
                'pieces_jointe' => $attachement,
                'mime' => $mime,
                'etat' => 0,
                'created_at' => Date('Y-m-d H:i:s')
            ]);
            $insertNotification = [
                'broadcast' => 1,
                'from' => Auth::User()->id,
                'to' => Auth::User()->departement,
                'type' => 40,
                'date_add' => Date('Y-m-d H:i:s'),
                'lien' => route('modifysujet',['id'=>$id]),
                'created_at' => Date('Y-m-d H:i:s')
            ];
            DB::table('notifications')->insert($insertNotification);
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger','Erreur survenu : ' . $e->getMessage());
        }
        
        DB::commit();
        
        return redirect()->back()->with('info','Sujet ajouter avec success !!');
    }

    public function getModify($id) {
        $data = DB::table('sujets')->where('id',$id)->first();  
        return View::make('contents.sujet.modify' , ['sujet' => $data]);
    }

    public function getAttachement($id) {
        $data = DB::table('sujets')->where('id',$id)->first();  
        $file = Storage::disk('upload')->get('/sujet/'.$data->pieces_jointe);
 
        return Response($file, 200 , ['Content-Type' => $data->mime]);
    }

    public function postModify($id,Request $request) {
        if(Auth::User()->type ==3) {
            return redirect()->back()->with('danger','vous n\'avez pas le droit d\'access');
        }
        DB::beginTransaction();
        try {
            $this->validate($request , [
                'objet' => 'required',
                'description' => 'required'
            ]);

            $attachement = NULL;
            $mime = NULL;

            if($request->hasFile('attachement')) {

                $file = $request->file('attachement');
                $extension = $file->getClientOriginalExtension();
                $mime = $file->getClientMimeType();
                $attachement = Auth::User()->id.'-'.$request->input('objet').'-'.time().'.'.$extension;
                Storage::disk('upload')->put('/sujet/'.$attachement,  File::get($file));
            }

            DB::table('sujets')->where('id',$id)->update([
                'proposer_par' => Auth::User()->id,
                'objet' => $request->input('objet'),
                'description' => $request->input('description'),
                'pieces_jointe' => $attachement,
                'mime' => $mime,
                'updated_at' => Date('Y-m-d H:i:s')
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger','Erreur survenu : ' . $e->getMessage());
        }
        
        DB::commit();
        
        return redirect()->back()->with('info','Sujet modifier avec success !!');
    }

    public function theList() {
        $data = DB::table('sujets as s')
            ->join('users as u','u.id','=','s.proposer_par')
            ->join('departements as d','d.id','=','u.departement')
            ->select('s.*','u.nom','u.prenom','u.email','d.nom as departement')
            ->get();
        //dd($data);
        return View::make('contents.sujet.list' , ['sujets' => $data]);
    }

    public function modifyEtat($id,$etat) {
        if(Auth::User()->type ==3) {
            return redirect()->back()->with('danger','vous n\'avez pas le droit d\'access');
        }
        if($etat > 3 || $etat < 0) {
            return redirect()->back()->with('danger','indice de statut non valide');
        } else {
            DB::beginTransaction();
            try {
                DB::table('sujets')->where('id',$id)->update([
                    'etat' => $etat,
                    'updated_at' => Date('Y-m-d H:i:s')
                ]);
            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()->with('danger','Erreur survenu : ' . $e->getMessage());
            }
            DB::commit();
            return redirect()->back()->with('info','statut modifier avec success');
        }
    }
}

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

class StagiaireController extends Controller
{
	public function index($id) {
		if(Auth::User()->type ==3) {
         return redirect()->back()->with('danger','vous n\'avez pas le droit d\'access');
     	}
		$condidat = DB::table('condidats')->where('id',$id)->first();
		$departements = DB::table('departements')->get();
		$document = 0;
		if($condidat->documents != null) {
			$document = json_decode($condidat->documents);
		}
		return View::make('contents.stagiaire.new' , [
			'condidat' => $condidat , 
			'departements' => $departements,
			'document' => $document
		]);
	}


	public function getAttachement($id,$type) {
		if(Auth::User()->type ==3) {
         return redirect()->back()->with('danger','vous n\'avez pas le droit d\'access');
     	}
		$document = DB::table('condidats')->where('id',$id)->value('documents');
		$document = json_decode($document);
	  	if($type == 'assurence') {
			$file = Storage::disk('upload')
				->get('/documents_stagiaire/'.$type.'/'.$document->assurence->document);

			return Response($file, 200 , ['Content-Type' => $document->assurence->mime]);
		} else if($type == 'convention') {
			$file = Storage::disk('upload')
				->get('/documents_stagiaire/'.$type.'/'.$document->convention->document);

			return Response($file, 200 , ['Content-Type' => $document->convention->mime]);
		} else {
			return Response('Unautorized' , 401);
		}
	}

	public function postNew($id , Request $request) {
		if(Auth::User()->type ==3) {
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
                'assurence' => 'mimes:jpeg,jpg,png,doc,docx,pdf',
                'convention' => 'mimes:jpeg,jpg,png,doc,docx,pdf'
            ]);

				$user = DB::table('condidats')->where('id',$id)->first();
				$documents_old = json_decode($user->documents);

            if($request->hasfile('assurance')) {
            //upload assurance
	            $file = $request->file('assurence');
					$extension = $file->getClientOriginalExtension();
					$mime_assurence = $file->getClientMimeType();
					$assurence = Auth::User()->id.'-'.$id.'-'.$request->input('nom').'-'.$request->input('prenom').'-'.time().'.'.$extension;
					Storage::disk('upload')->put('/documents_stagiaire/assurence/'.$assurence,  File::get($file));
					$assurence = ['document' => $assurence , 'mime' => $mime_assurence];
				} else {
					if($documents_old->assurence != null)
						$assurence = $documents_old->assurence;
					else 
						$assurence = null;
				}

				if($request->hasfile('assurance')) {
					//upload convention
					$file = $request->file('convention');
					$extension = $file->getClientOriginalExtension();
					$mime_convention = $file->getClientMimeType();
					$convention = Auth::User()->id.'-'.$id.'-'.$request->input('nom').'-'.$request->input('prenom').'-'.time().'.'.$extension;
					Storage::disk('upload')->put('/documents_stagiaire/convention/'.$convention,  File::get($file));

					$convention = ['document' => $convention , 'mime' => $mime_convention];
				} else {
					if($documents_old->convention != null)
						$convention = $documents_old->convention;
					else 
						$convention = null;
				}



				if($user->user == null) {
					//grant access to platform
					$user_id = DB::table('users')->insertGetId([
						'nom' => $request->input('nom'),
						'prenom' => $request->input('prenom'),
						'email' => $request->input('email'),
						'departement' => $request->input('division'),
						'password' => bcrypt($request->input('nom')),
						'created_at' => Date('Y-m-d H:i:s')
					]);
					//add the stage
					$stage_id = DB::table('stages')->insertGetId([
						'stagiaire' => $user_id,
						'responsable' => $request->input('responsable'),
						'sujet' => $request->input('sujet'),
						'observation' => $request->input('observation'),
						'created_at' => Date('Y-m-d H:i:s')
	 				]);

					//NOTIFICATION 30
	 				$insertNotification = [
						'broadcast' => 0,
						'from' => Auth::User()->id,
						'to' => $request->input('responsable'),
						'type' => 30,
						'date_add' => Date('Y-m-d H:i:s'),
						'lien' => route('newtache',['id'=>$user_id , 'tache'=>'tout']),
						'created_at' => Date('Y-m-d H:i:s')
	            ];
	            DB::table('notifications')->insert($insertNotification);

				} else {
					//grant access to platform
					DB::table('users')->where('id',$user->user)->update([
						'nom' => $request->input('nom'),
						'prenom' => $request->input('prenom'),
						'email' => $request->input('email'),
						'departement' => $request->input('division'),
						'password' => bcrypt($request->input('nom')),
						'type' => 3,
						'updated_at' => Date('Y-m-d H:i:s')
					]);

					$user_id = $user->user;

					//modify the stage
					DB::table('stages')->where('stagiaire' , $user_id)->update([
						'responsable' => $request->input('responsable'),
						'sujet' => $request->input('sujet'),
						'observation' => $request->input('observation'),
						'updated_at' => Date('Y-m-d H:i:s')
	 				]);
				}

				$documents = json_encode(['assurence' => $assurence , 'convention' => $convention]);
				
				//modify stat of condidat to 1 and add
				DB::table('condidats')->where('id',$id)->update([
					'documents' => $documents,
					'etat' => 1,
					'user' => $user_id,
					'updated_at' => Date('Y-m-d H:i:s')
				]);
				//NOTIFICATION 21
				$insertNotification = [
                'broadcast' => 0,
                'from' => Auth::User()->id,
                'to' => $request->input('responsable'),
                'type' => 21,
                'date_add' => Date('Y-m-d H:i:s'),
                'lien' => route('newstagiaire',['id'=>$user_id]),
                'created_at' => Date('Y-m-d H:i:s')
            ];
            DB::table('notifications')->insert($insertNotification);

         } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('danger','Erreur survenu : ' . $e->getMessage());
        	}
        	DB::commit();
        	if($user->user == null) {
     			return redirect()->back()->with('info', $request->input('nom').' '.$request->input('prenom').' est maintenant stagiaire !!' );
     		} else {
     			return redirect()->back()->with('info', 'Les informations de '.$request->input('nom').' '.$request->input('prenom').' sont modifie avec success !!' );
     		}
	}

	public function theList() {
		if(Auth::User()->type ==3) {
         return redirect()->back()->with('danger','vous n\'avez pas le droit d\'access');
     	}
     	$list = DB::table('condidats as c')
         ->join('departements as d','d.id','=','c.departement')
         ->join('stages as st','st.stagiaire','=','c.user')
         ->join('users as resp','resp.id','=','st.responsable','left outer')
         ->join('sujets as sj','sj.id','=','st.sujet','left outer')
         ->select('c.id','c.nom','c.prenom','c.email','c.etablissement','c.datefrom','c.dateend','c.etat',
         	'd.nom as departement',
         	'resp.nom as resp_nom','resp.prenom as resp_prenom',
         	'sj.id as sujet','sj.objet'
         	)
         ->where('c.etat',1)
         ->get();
     	return View::make('contents.stagiaire.list' , ['stagiaires' => $list]);
    }

	//ajax functions :

		/**
	     * returns list of sujets and responsables of a departement
	     *
	     * @param  id of Departement  $id
	     * @return \Illuminate\Http\Response
	     */
		public function ajaxDeptsRespAndSujets($id) {
			if(Auth::User()->type ==3) {
				return Response::json(['code'=>400 , 'msgError'=>'danger','vous n\'avez pas le droit d\'access']);
     		}	
     		
			$resps = DB::table('users')
				->select('id','nom','prenom')
				->where('departement',$id)
				->where('type','<>',3) //not a trainer
				->get();

			$sujets = DB::table('sujets as s')
				->join('users as u','u.id','=','s.proposer_par')
				->join('departements as d','d.id','=','u.departement')
				->select('s.id','s.objet')
				->where('d.id',$id)
				->where('s.etat','<',3) //in pending statut
				->get();

			return Response::json(['code' => 200 , 'responsables' => $resps , 'sujets' => $sujets]);
		}
}

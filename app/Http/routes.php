<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*
Route::get('/', function () {
	return view('welcome');
});
*/

Route::get('/auth/login' , [
	'uses' => 'AuthController@getLogin',
	'as' => 'authlogin'
]);

Route::post('/auth/login' , [
	'uses' => 'AuthController@postLogin'
]);

Route::group(['middleware' => 'auth','prefix' => 'admin'] , function () {

	Route::get('/' , [
		'uses' => 'AdminController@index',
		'as' => 'adminindex'
	]);

	Route::get('/logout' , [
		'uses' => 'AdminController@getLogout',
		'as' => 'logout'
	]);

	Route::post('/notification/{id}',[
		'uses' => 'AdminController@seeNotification',
		'as' => 'seennotification'
	]);

	Route::group(['prefix' => 'profile'] , function () {
		Route::get('/',[
			'uses' => 'AuthController@getProfile',
			'as' => 'profile'
		]);
		Route::post('/',[
			'uses' => 'AuthController@postProfile'
		]);
		Route::get('/image/{image}',[
			'uses' => 'AuthController@getImage',
			'as' => 'profileimage'
		]);
	});

	Route::group(['prefix' => 'condidat'] , function () {
		Route::get('/' , [
			'uses' => 'CondidatController@getNew',
			'as' => 'newcondidat'
		]);

		Route::post('/' , [
			'uses' => 'CondidatController@postNew',
		]);

		Route::get('/modifier/{id}' , [
			'uses' => 'CondidatController@getModify',
			'as' => 'modifycondidat'
		]);

		Route::post('/modifier/{id}' , [
			'uses' => 'CondidatController@postModify'
		]);

		Route::get('/liste' , [
			'uses' => 'CondidatController@theList',
			'as' => 'listcondidate'
		]);

		Route::get('/curriculumvitae/{id}' , [
			'uses' => 'CondidatController@getCurriculumVitae',
			'as' => 'downloadcurriculumvitae'
		]);
	});

	Route::group(['prefix' => 'sujet'] , function () {
		Route::get('/' , [
			'uses' => 'SujetController@getNew',
			'as' => 'newsujet'
		]);
		Route::post('/' , [
			'uses' => 'SujetController@postNew'
		]);
		Route::get('/modifier/{id}' , [
			'uses' => 'SujetController@getModify',
			'as' => 'modifysujet'
		]);
		Route::post('/modifier/{id}' , [
			'uses' => 'SujetController@postModify'
		]);
		Route::get('/attachement/{id}' , [
			'uses' => 'SujetController@getAttachement',
			'as' => 'downloadsujetattachement'
		]);
		Route::get('/liste' , [
			'uses' => 'SujetController@theList',
			'as' => 'listsujet'
		]);
		Route::get('/modifieretat/{id}/{etat}' , [
			'uses' => 'SujetController@modifyEtat',
			'as' => 'modifysujetetat'
		]);
	});

	Route::group(['prefix' => 'stagiaire'] , function () {
		Route::get('/condidat/{id}' , [
			'uses' => 'StagiaireController@index',
			'as' => 'newstagiaire'
		]);
		Route::post('/condidat/{id}' , [
			'uses' => 'StagiaireController@postNew'
		]);

		Route::get('/condidat/{id}/documents/{type}' , [
			'uses' => 'StagiaireController@getAttachement',
			'as' => 'downloadcondidatattachement'
		]);

		Route::get('/liste',[
			'uses' => 'StagiaireController@theList',
			'as' => 'liststagiaires'
		]);


		//ajax routes

		route::get('/ajax/deptsrespsujets/{id}' , [
			'uses' => 'StagiaireController@ajaxDeptsRespAndSujets',
			'as' => 'ajaxdeptrespanssujets',
		]);
	});

	Route::group(['prefix' => 'tache','middleware' => 'TachesACL'] , function () {
		Route::get('/stage/{id}/{tache}' , [
			'uses' => 'TacheController@getNew',
			'as' => 'newtache'
		]);
		Route::post('/stage/{id}/{tache}' , [
			'uses' => 'TacheController@postNew'
		]);
		

		Route::group(['prefix' => 'liste'] , function () {
			Route::get('/' , [
				'uses' => 'TacheController@theList',
				'as' => 'listtache'
			]);

			Route::get('/imprimer/stage/{id}',[
				'uses' => 'TacheController@imprimer',
				'as' => 'imprimercertificat'
			]);

			//ajax routes
			Route::group(['prefix' => 'ajax'] , function () {
				Route::get('/stage/{id}' , [
					'uses' => 'TacheController@theListByStage',
					'as' => 'ajaxlisttachebystage'
				]);
				Route::get('/refrechtache/{id}' , [
					'uses' => 'TacheController@getRefreshStatut',
					'as' => 'ajaxrefrechtache'
				]);
			});
		});
		Route::group(['prefix' => 'modifier'] , function () {
			//ajax routes
			Route::group(['prefix' => 'ajax'] , function () {
				Route::get('/tache/{id}' , [
					'uses' => 'TacheController@getModify',
					'as' => 'ajaxmodifiertache'
				]);
				Route::post('/statut/{id}' , [
					'uses' => 'TacheController@postStatut',
					'as' => 'ajaxmodifiertachestatut'
				]);
			});
		});
	});

	Route::group(['prefix' => 'parametre'] , function () {
		Route::get('/',[
			'uses' => 'ResponsableController@getNew',
			'as' => 'getparametres'
		]);

		Route::group(['prefix' => 'responsable'] , function () {
			Route::post('/',[
				'uses' => 'ResponsableController@postNewResp',
				'as' => 'newresponsable'
			]);

			Route::post('modifier/{id}',[
				'uses' => 'ResponsableController@postModifyResp',
				'as' => 'modifyresponsable'
			]);

			Route::get('modifier/{id}',[
				'uses' => 'ResponsableController@getModifyResp',
				'as' => 'modifyresponsable'
			]);

		});

		Route::group(['prefix' => 'ville'] , function () {
			Route::post('/nouveau',[
				'uses' => 'ResponsableController@postNewCity',
				'as' => 'newcity'
			]);
			Route::post('/modifier/{id}',[
				'uses' => 'ResponsableController@postModifyCity',
				'as' => 'modifycity'
			]);
			Route::get('/modifier/{id}',[
				'uses' => 'ResponsableController@getModifyCity',
				'as' => 'modifycity'
			]);

		});

		Route::group(['prefix' => 'etablissement'] , function () {

			Route::post('/nouveau/etablissement',[
				'uses' => 'ResponsableController@postNewSchool',
				'as' => 'newschool'
			]);
			Route::post('/modifier/{id}',[
				'uses' => 'ResponsableController@postModifySchool',
				'as' => 'modifyschool'
			]);
			Route::get('/modifier/{id}',[
				'uses' => 'ResponsableController@getModifySchool',
				'as' => 'modifyschool'
			]);

		});

		Route::group(['prefix' => 'departement'] , function () {
			Route::post('/nouveau',[
				'uses' => 'ResponsableController@postNewDept',
				'as' => 'newdepartement'
			]);

			Route::post('/modifier/{id}',[
				'uses' => 'ResponsableController@postModifyDept',
				'as' => 'modifydepartement'
			]);
			Route::get('/modifier/{id}',[
				'uses' => 'ResponsableController@getModifyDept',
				'as' => 'modifydepartement'
			]);
		});

		Route::group(['prefix' => 'diplome'] , function () {
			Route::post('/nouveau',[
				'uses' => 'ResponsableController@postNewDegree',
				'as' => 'newdegree'
			]);

			Route::post('/modifier/{id}',[
				'uses' => 'ResponsableController@postModifyDegree',
				'as' => 'modifydegree'
			]);

			Route::get('/modifier/{id}',[
				'uses' => 'ResponsableController@getModifyDegree',
				'as' => 'modifydegree'
			]);

		});		

		Route::get('/liste',[
			'uses' => 'ResponsableController@theList',
			'as' => 'listparametres'
		]);
	});

});

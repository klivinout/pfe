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
			'as' => 'newresponsable'
		]);
		Route::post('/nouveau/responsable',[
			'uses' => 'ResponsableController@postNewResp'
		]);
		Route::get('modifier/responsable/{id}',[
			'uses' => 'ResponsableController@getModify',
			'as' => 'modifyresponsable'
		]);
		Route::post('modifier/responsable/{id}',[
			'uses' => 'ResponsableController@postModify'
		]);

		Route::post('/nouveau/departement',[
			'uses' => 'ResponsableController@postNewDept',
			'as' => 'newdepartement'
		]);

		Route::get('/responsable/liste',[
			'uses' => 'ResponsableController@theList',
			'as' => 'listresponsable'
		]);
	});

});

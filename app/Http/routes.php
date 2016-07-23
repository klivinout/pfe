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

Route::get('/', function () {
	return view('welcome');
});

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

		Route::group(['prefix' => 'api'] , function () {
			Route::get('/listcondidats' , [
				'uses' => 'CondidatController@api_listCondidate',
				'as' => 'api_listcondidate'
			]);
		});

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


});

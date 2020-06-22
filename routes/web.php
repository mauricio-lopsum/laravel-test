<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false]);


Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', function () {
        return view('home');
    });

    Route::get('/employees', function () {
        return view('home', ['view' => 'employees']);
    });

    Route::get('/companies', function () {
        return view('home', ['view' => 'companies']);
    });

    Route::post('newcompany', 'DataController@newcompany')->name('newcompany');
    Route::post('editcompany', 'DataController@editcompany')->name('editcompany');
    Route::post('newemployee', 'DataController@newemployee')->name('newemployee');
    Route::post('editemployee', 'DataController@editemployee')->name('editemployee');


    Route::get('/new/company', function () {
        return view('newcompany');
    });

    Route::get('/new/employee', function () {
        return view('newemployee');
    });

    Route::get('/company/{id}', function ($id) {
        return view('company', ['id' => $id]);
    });

    Route::get('/employee/{id}', function ($id) {
        return view('employee', ['id' => $id]);
    });

    Route::get('delete/employee/{id}', function ($id) {
        DB::table('employees')->where('id', $id)->delete();
        return back();
    });

    Route::get('delete/company/{id}', function ($id) {
        DB::table('company')->where('id', $id)->delete();
        DB::table('employees')->where('company_id', $id)->delete();
        return back();

    });

});

Route::group(['middleware' => ['guest']], function () {

    Route::get('/', function () {
        return view('login');
    });

    Route::post('logincheck', function(){
        $credentials = [
            'email' => $_POST['username'],
            'password' => $_POST['password']
        ];

            
        $r = Auth::attempt($credentials);
        if($r){
            return redirect()->intended('/');
        }else{
            return redirect()->intended('/?error=1');
        }
    });
    
    // Route::get('{any}', function ($any) {
    //     return view('login');
    // })->where('any', '.*');

});
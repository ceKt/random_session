<?php

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
use App\Contents_List;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

Route::get('/', 'DBController@home');

Route::post('/matchstart', 'DBController@match_start');
Route::get('/matchcheck', 'DBController@match_check');
Route::get('/matchstop', 'DBController@match_stop');

Route::get('/contents/{content_name}', 'DBController@contents');

Route::get('/make_contents', function(){
        return view('make_contents');
    });

Route::post('/make_contents/make_contents', 'DBController@make_contents');

Route::get('/make_sessionlists', 'DBController@make_sessionlists1');

Route::post('/make_sessionlists/make_sessionlists', 'DBController@make_sessionlists2');

Route::get('/chat', 'DBController@chat_start');

Route::get('/chat/chatting', 'DBController@chatting');

Route::post('/chat/send_message', 'DBController@sendmessage');

Route::post('/chat/chat_end', 'DBController@chat_end');

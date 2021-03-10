<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'WebsiteController@index')->name('index');
Route::get('category/{slug}', 'WebsiteController@category')->name('category');
Route::get('post/{slug}', 'WebsiteController@post')->name('post');
Route::get('page/{slug}', 'WebsiteController@page')->name('page');
Route::get('contact', 'WebsiteController@showContactForm')->name('contact.show');
Route::post('contact','WebsiteController@submitContactForm')->name('contact.submit');
Route::get('/search', 'WebsiteController@search')->name('search');
Route::post('/comment', 'WebsiteController@saveComment')->name('saveComment');
Route::post('/commentReply', 'WebsiteController@saveCommentReply')->name('saveCommentReply');


Route::get('/send-mail', function () {
    $details = [
        'title' => 'Đây là tiêu đề.',
        'body' => 'Đây là nội dung.'
    ];

    Mail::to('cungcodenao684@gmail.com')->send(new \App\Mail\VisitorContact($details));
    
    echo "Gửi thành công.";
});

Route::get('/admin', 'HomeController@index')->name('index');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    Route::resource('categories', 'CategoryController');
    Route::resource('posts', 'PostController');
    Route::resource('pages', 'PageController');
    Route::resource('user', 'UserController');
    Route::resource('comments', 'CommentController');
    Route::resource('replies', 'CommentReplyController');
});
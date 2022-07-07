<?php

use App\Mail\NewPostCreated;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
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

/* Route::get('/', function () {
    return view('welcome');
}); */

Auth::routes();

/* Route::get('/home', 'Admin\HomeController@index')->name('home'); */

Route::middleware('auth')->prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/', 'HomeController@index')->name('dashboard');
    // Admin Posts
    Route::resource('posts', 'PostController');
});

/* Route::get('mailable', function() {
    $post = Post::findOrFail(1);

    return new NewPostCreated($post);
}); */

Route::get('{any?}', function () {
    return view('guest.home');
})->where('any', '.*');

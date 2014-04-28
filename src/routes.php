<?php

/*
 * iziBoard
 * Copyright (C) 2014  Andreas Göransson
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

use Wetcat\Board\Models\Marker;
use Wetcat\Board\Models\News;
use Wetcat\Board\Models\Page;
use Wetcat\Board\Models\Photo;
use Wetcat\Board\Models\Text;
use Wetcat\Board\Models\Category;
use Wetcat\Board\Models\Blogpost;
use Wetcat\Board\Models\Footer;
use Wetcat\Board\Models\Accordion;



/* ============ AUTH ============= */

Route::resource('authenticate', 'AuthenticationController');



/* ============ PAGE ============= */

Route::get('pages', function(){
  return Page::with(array('texts', 'images', 'markers', 'blogposts', 'blogposts.images', 'blogposts.texts', 'accordions'))->get();
});

Route::group(array('before' => 'iziAuth|iziAdmin'), function()
{
  Route::post('pages', function(){
    $page = Page::create(Input::all());
    return Page::with(array('texts', 'images', 'markers'))->where('id', $page->id)->first();
  });

  Route::put('pages', function(){
    $page = Page::find(Input::get('id'))->update(Input::only('title', 'body'));
    $texts = Input::get('texts');

    foreach($texts as $text){
      $txt = Text::find($text['id'])->update($text);
    }
  });

  Route::delete('pages/{id}', function($id){
    $page = Page::find($id);
    $page->delete();
    return $page;
  });
});





/* ============ TEXT (able) ============= */

Route::group(array('before' => 'iziAuth|iziAdmin'), function()
{
  Route::post('textables', function(){
    $text = Text::create(Input::only('description'));

    if( Input::has('id') && Input::get('id') != 'undefined' ){
      $containerId = Input::get('id');
      $containerType = 'Wetcat\\Board\\Models\\'.Input::get('type');
      $container = $containerType::find($containerId);
      $container->texts()->save($text);
    }

    return $text;
  });

  Route::delete('textables/{id}', function($id){
    $text = Text::find($id)->delete();
  });

  Route::put('textables', function(){
    $text = Text::find(Input::get('id'));
    $text->update(Input::all());
  });
});




/* ============ IMAGE (able) ============= */

Route::group(array('before' => 'iziAuth|iziAdmin'), function()
{
  Route::post('imageable', function(){
    $path = public_path();

    if( Input::has('updatefile') ){

      $photo = Photo::find(Input::get('updatefile'));

      $file = Input::file('file');

      $originalName = $file->getClientOriginalName();

      $date = new DateTime();
      $name = $date->getTimestamp();
      $ext = $file->getClientOriginalExtension();

      $filename = $name . '.' . $ext;

      $image = \Image::make(Input::file('file')->getRealPath());

      File::exists($path.'/uploads/') or File::makeDirectory($path.'/uploads/');

      $image->save($path.'/uploads/'.$name.'.'.$ext);

      $image->resize(null, 200, true)->crop(100, 100);

      $image->save($path.'/uploads/'.$name.'_thumb.'.$ext);

      $thumbnail = $name.'_thumb.'.$ext;

      $data = array(
        'originalname' => $originalName,
        'name' => $name,
        'ext' => $ext,
        'filename' => $filename,
        'thumbnail' => $thumbnail
      );

      $photo->update($data);

    }else{

      if( count(Input::file('file')) > 0 ){
        $file = Input::file('file');

        $originalName = $file->getClientOriginalName();

        $date = new DateTime();
        $name = $date->getTimestamp();
        $ext = $file->getClientOriginalExtension();

        $filename = $name . '.' . $ext;

        $image = \Image::make(Input::file('file')->getRealPath());

        File::exists($path.'/uploads/') or File::makeDirectory($path.'/uploads/');

        $image->save($path.'/uploads/'.$name.'.'.$ext);

        $image->resize(null, 200, true)->crop(100, 100);

        $image->save($path.'/uploads/'.$name.'_thumb.'.$ext);

        $thumbnail = $name.'_thumb.'.$ext;

        $data = array(
          'originalname' => $originalName,
          'name' => $name,
          'ext' => $ext,
          'filename' => $filename,
          'thumbnail' => $thumbnail
        );
      } else {
        $data = Input::all();
      }

      $photo = Photo::create($data);

      if( Input::has('id') && Input::get('id') != 'undefined' ){
        $containerId = Input::get('id');
        $containerType = 'Wetcat\\Board\\Models\\'.Input::get('type');
        $container = $containerType::find($containerId);
        $container->images()->save($photo);
      }
    }

    return $photo;
  });

  Route::put('imageable', function () {
    return "PUT DOES NOT WORK!";
  });
});



/* ============ NEWS ============= */

Route::get('news', function(){
  return News::with('categories', 'images')->orderBy('created_at', 'DESC')->get();
});

Route::group(array('before' => 'iziAuth|iziAdmin'), function()
{
  Route::post('news', function(){

    $data = Input::only('title', 'body');
    $news = News::create($data);

    if( Input::has('images') && count(Input::get('images')) > 0 ){
      $photo = Photo::find(Input::get('images')[0]['id']);
      $news->images()->save($photo);    
    }

    $cat = Input::get('tags');
    $category = Category::find($cat['id']);
    $news->categories()->attach($category);

    return News::with(array('images', 'categories'))->where('id', $news->id)->get()->first();
  });

  Route::delete('news/{id}', function($id){
    $news = News::find($id)->delete();
  });

  Route::put('news', function(){
    $news = News::find(Input::get('id'));
    $news->update(Input::all());
  });
});




/* ============ MARKERS ============= */

Route::get('markers/{id}', function($id){
  $page = Page::with('markers')->find($id);
  //$markers = $page->markers();
  return $page;
});

Route::group(array('before' => 'iziAuth|iziAdmin'), function()
{
  Route::post('markers', function(){
    $page = Page::find(Input::get('id'));
    $marker = Marker::create(Input::all());
    $page->markers()->save($marker);
    return $marker;
  });

  Route::put('markers', function(){
    $marker = Marker::find(Input::get('id'));
    $marker->update(Input::all());
  });

  Route::delete('markers/{id}', function($id){
    $marker = Marker::find($id)->delete();
  });
});



/* ============ CATEGORIES ============= */

Route::get('categories', function(){
  return Category::all();
});

Route::group(array('before' => 'iziAuth|iziAdmin'), function()
{
  Route::post('categories', function(){
    $category = Category::create(Input::all());
    return $category;
  });
});



/* ============ POSTS ============= */

Route::get('posts/{id}', function($id){
  $page = Page::find($id);
  return $page->blogposts();
});

Route::group(array('before' => 'iziAuth|iziAdmin'), function()
{
  Route::post('posts', function(){
    $page = Page::find(Input::get('id'));
    $blogpost = Blogpost::create(Input::all());
    $page->blogposts()->save($blogpost);
    return $blogpost;
  });
});




/* ============ USERS ============= */

Route::post('users/login', function(){

  $user = null;
  $messages = [];

  try {
      $user = \Sentry::authenticate(Input::only(['email', 'password']), false);
      $token = hash('sha256', Str::random(10), false);
      $user->api_token = $token;
      $user->save();

      return Response::json([
        'token' => $token, 
        'user' => $user->toArray(),
        'permissions' => $user->getMergedPermissions()
      ], 202);
  } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
      $messages[] = 'Login field is required.';
  } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
      $messages[] = 'Password field is required.';
  } catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
      $messages[] = 'Wrong password, try again.';
  } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
      $messages[] = 'User was not found.';
  } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
      $messages[] = 'User is not activated.';
  } catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
      $messages[] = 'User is suspended.';
  } catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
      $messages[] = 'User is banned.';
  }


  return Response::json([
    'type' => 'danger',
    'messages' => $messages
  ], 401);

});

Route::post('users/register', function(){
  return "Register";
});

Route::group(array('before' => 'iziAuth'), function()
{
  Route::post('users/logout', function(){
    \Sentry::logout();
    
    return Response::json([
      'flash' => 'you have been disconnected'],
      200
    );
  });

  Route::put('users', function(){
    return "Update";
  });
});




/* ============ FOOTER ============= */

Route::get('footer/{id}', function($id){
  $footer = Footer::find($id);
  return $footer;
});

Route::get('footers', function(){
  $footers = Footer::all();
  return $footers;
});

Route::group(array('before' => 'iziAuth|iziAdmin'), function()
{
  Route::post('footer', function(){
    $footer = Footer::create(Input::only('type', 'title'));
    return $footer;
  });

  Route::put('footer', function(){
    $footer = Footer::find(Input::get('id'));
    $footer->update(Input::all());
    return $footer;
  });
});


Route::group(array('before' => 'iziAuth|iziAdmin'), function()
{
  Route::post('accordions', function(){
    $accordion = Accordion::create(Input::only('title', 'body'));

    if( Input::has('id') && Input::get('id') != 'undefined' ){
      $containerId = Input::get('id');
      $containerType = 'Wetcat\\Board\\Models\\'.Input::get('type');
      $container = $containerType::find($containerId);
      $container->accordions()->save($accordion);
    }

    return $accordion;
  });

  Route::put('accordions', function(){
    $accordion = Accordion::find(Input::get('id'));
    $accordion->update(Input::all());
    return $accordion;
  });

  Route::delete('accordions/{id}', function($id){
    $accordion = Accordion::find($id);
    $accordion->delete();
    return $accordion;
  });
});



/* ============ ROOT ============= */

Route::get('/', function()
{
  return View::make('board::index');
});

Route::any('{all}', function($uri)
{
  return Redirect::to('/');
})->where('all', '.*');
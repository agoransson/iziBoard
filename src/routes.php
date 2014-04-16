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

Route::get('/', function()
{
  return View::make('board::index');
});

Route::get('pages', function(){
  return Page::with(array('texts', 'images', 'markers'))->get();
});

Route::post('pages', function(){
  $page = Page::create(Input::all());
  return Page::with(array('texts', 'images', 'markers'))->where('id', $page->id)->first();
});

Route::put('pages', function(){
  $page = Page::find(Input::get('id'))->update(Input::all());
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

Route::post('textables', function(){
  $page = Page::find(Input::get('id'));
  $text = Text::create(Input::all());
  $page->texts()->save($text);
  return $text;
});

Route::delete('textables/{id}', function($id){
  $text = Text::find($id)->delete();
});

Route::post('imageable', function(){
  $path = public_path();

  $file = Input::file('file');

  $originalName = $file->getClientOriginalName();

  $date = new DateTime();
  $name = $date->getTimestamp();
  $ext = $file->getClientOriginalExtension();

  $filename = $name . '.' . $ext;

  $image = \Image::make(Input::file('file')->getRealPath());

  File::exists($path.'/uploads/') or File::makeDirectory($path.'/uploads/');

  $image->save($path.'/uploads/'.$name.'.'.$ext);

  $page = Page::find(Input::get('id'));
  $photo = Photo::create(array('originalname' => $originalName, 'name' => $name, 'ext' => $ext, 'filename' => $filename ));
  $page->images()->save($photo);

  return $photo;
});

Route::get('news', function(){
  return News::orderBy('created_at', 'DESC')->get();
});

Route::post('news', function(){
  $news = News::create(Input::all());
});

Route::delete('news/{id}', function($id){
  $news = News::find($id)->delete();
});

Route::put('news', function(){
  $news = News::find(Input::get('id'));
  $news->update(Input::all());
});

Route::post('markers', function(){
  $page = Page::find(Input::get('id'));
  $marker = Marker::create(Input::all());
  $page->markers()->save($marker);
  return $marker;
});

Route::get('markers/{id}', function($id){
  $page = Page::with('markers')->find($id);
  //$markers = $page->markers();
  return $page;
});

Route::put('markers', function(){
  $marker = Marker::find(Input::get('id'));
  $marker->update(Input::all());
});

Route::delete('markers/{id}', function($id){
  $marker = Marker::find($id)->delete();
});
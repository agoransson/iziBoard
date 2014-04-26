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

Route::filter('iziAuth', function($route, $request){

  $payload = $request->header('X-Auth-Token');

  $userModel = Sentry::getUserProvider()->createModel();

  $user =  $userModel->where('api_token', $payload)->first();

  if(!$user) {
    
    $response = Response::json([
      'error' => true,
      'message' => 'Not authenticated',
      'code' => 401
      ], 401
    );

    $response->header('Content-Type', 'application/json');
    
    return $response;
  }

});

Route::filter('iziAdmin', function($route, $request){

  $payload = $request->header('X-Auth-Token');

  $userModel = Sentry::getUserProvider()->createModel();

  $user =  $userModel->where('api_token', $payload)->first();

  if(!$user) {
    
    $response = Response::json([
      'error' => true,
      'message' => 'Not authenticated',
      'code' => 401
      ], 401
    );

    $response->header('Content-Type', 'application/json');
    
    return $response;
  }

  if( !$user->hasAccess('admin') ) {
    
    $response = Response::json([
      'error' => true,
      'message' => 'Not authorized',
      'code' => 401
      ], 401
    );

    $response->header('Content-Type', 'application/json');
    
    return $response;
  }

});



Route::filter('iziCSRF',function(){

  if (Session::token() != Request::header('csrf_token')) {
    return Response::json(
      [
        'message' => 'I’m a teapot !!! you stupid hacker :D '
      ],
      418);
    }

});
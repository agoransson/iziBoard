{{--
  iziBoard
  Copyright (C) 2014  Andreas Göransson

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License along
  with this program; if not, write to the Free Software Foundation, Inc.,
  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 --}}
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ Config::get('board::app.name') }}</title>

    {{-- Always attempt to load local bootstrap styles before going to CDN --}}
    @if( file_exists('public/css/bootstrap.min.css') )
      {{ HTML::style('css/bootstrap.min.css') }}
    @elseif( file_exists('public/css/bootstrap.css') )
      {{ HTML::style('css/bootstrap.css') }}
    @else
      {{ HTML::style(Config::get('board::cdn.bootstrap')) }}
    @endif

    {{ HTML::style('packages/wetcat/board/lib/angular-tagger.css') }}
    {{ HTML::style('packages/wetcat/board/lib/hotkeys.min.css') }}

    {{ HTML::style('packages/wetcat/board/css/iziboard.css') }}

    {{-- Include the custom styles for this installation --}}
    @if( file_exists('public/css/'.Config::get('board::app.name').'.min.css'))
      {{ HTML::style('css/'.Config::get('board::app.name').'.min.css') }}
    @elseif( file_exists('public/css/'.Config::get('board::app.name').'.css'))
      {{ HTML::style('css/'.Config::get('board::app.name').'.css') }}
    @endif

  </head>
  <body>

    <div class="container main-content">
      @section('content')
      @show
    </div>

    <div id="footer">
      <div class="container">
        @section('footer')
        @show
      </div>
    </div>

  </body>
</html>

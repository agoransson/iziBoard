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
<html lang="en" ng-app="izi">
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
  <body ng-controller="UserController">


    <div ng-controller="PageController">

      @include('board::layouts.nav')

      
      <alert ng-repeat="alert in alerts" type="alert.type" close="closeAlert($index)">@{{ alert.msg }}</alert>
      

      <div class="container main-content" ng-controller="NewsController">
        @section('content')
        @show
      </div>

      <div id="footer">
        <div class="container">
          @section('footer')
          @show
        </div>
      </div>

    </div>

    {{-- Core libraries --}}
    {{ HTML::script(Config::get('board::cdn.angular')) }}
    {{ HTML::script(Config::get('board::cdn.angular-bootstrap')) }}
    
    {{ HTML::script('//maps.googleapis.com/maps/api/js?sensor=false') }}

    {{-- Libs --}}
    {{ HTML::script('packages/wetcat/board/lib/angular-file-upload-shim.min.js') }}
    {{ HTML::script('packages/wetcat/board/lib/placeholders-0.0.1-SNAPSHOT.min.js') }}
    {{ HTML::script('packages/wetcat/board/lib/angular-file-upload.min.js') }}
    {{ HTML::script('packages/wetcat/board/lib/hotkeys.min.js') }}
    {{ HTML::script('packages/wetcat/board/lib/underscore-min.js') }}
    {{ HTML::script('packages/wetcat/board/lib/angular-google-maps.min.js') }}
    {{ HTML::script('packages/wetcat/board/lib/angular-sanitize.min.js') }}
    {{ HTML::script('packages/wetcat/board/lib/showdown.js') }}
    {{ HTML::script('packages/wetcat/board/lib/elastic.js') }}
    {{ HTML::script('packages/wetcat/board/lib/angular-tagger.js') }}
    {{-- HTML::script('packages/wetcat/board/lib/angular-route.js') --}}
    {{ HTML::script('packages/wetcat/board/lib/ngStorage.min.js') }}

    {{-- App --}}
    {{ HTML::script('packages/wetcat/board/js/controllers.js') }}
    {{ HTML::script('packages/wetcat/board/js/services.js') }}
    {{ HTML::script('packages/wetcat/board/js/filters.js') }}
    {{ HTML::script('packages/wetcat/board/js/directives.js') }}
    {{ HTML::script('packages/wetcat/board/js/factories.js') }}
    {{ HTML::script('packages/wetcat/board/js/app.js') }}

    <script type="text/javascript">
    angular.module("izi").constant("CSRF_TOKEN", '{{ csrf_token() }}');
    </script>
  </body>
</html>

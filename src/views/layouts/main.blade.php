<!DOCTYPE html>
<html lang="en" ng-app="ekkogourmet">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    {{ HTML::style(Config::get('board::cdn.bootstrap')) }}
    {{ HTML::style('packages/wetcat/board/css/iziboard.css') }}

    {{-- General styles --}}
    <style type="text/css">
      .nav, .pagination, .carousel, .panel-title a { cursor: pointer; }
      .img-responsive {
        margin: 0 auto;
      }
      .main-content {
        margin-top: 4em;
      }
    </style>

    <style type="text/css">
      .fix-heading {
        display: inline;
      }
      .fix-heading > .glyphicon {
        cursor: pointer;
      }
      .fix-heading .glyphicon:hover {
        color: #ccc;
      }
    </style>

    {{-- Toolbox popup --}}
    <style type="text/css">
      .edit-menu {
        border:1px solid transparent;
      }
      .edit-menu:hover {
        border-left: 1px solid #000;
      }
      .edit-toolbox {
        background: #fff;
        position: absolute;
        top: 0px;
        left: 0px;
        padding: 2px 5px 2px 5px;
        border: 1px solid #000;
        display: inline-block;
        z-index: 1000;
      }
      .edit-toolbox > span:hover {
        cursor: pointer;
        color: #ccc;
      }
    </style>

    {{-- News styles --}}
    <style type="text/css">
    .news-container {
    }
    .news-container .glyphicon {
      cursor: pointer;
    }
    .news-container .glyphicon:hover {
      color: #ccc;
    }
    .news-item {
    }
    </style>

    {{-- Page selection dropdown --}}
    <style type="text/css">
    .page-type-selection {
      list-style: none;
    }
    </style>

    {{-- Map styles --}}
    <style type="text/css">
      .angular-google-map-container { height: 400px; }
      .marker-item > h3 {
        display: inline;
      }
      .marker-item > h3 .glyphicon {
        cursor: pointer;
      }
      .marker-item > h3 .glyphicon:hover {
        color: #ccc;
      }
    </style>

  </head>
  <body ng-controller="PageController" >

    @include('board::layouts.nav')

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

    {{ HTML::script('packages/wetcat/board/js/angular-file-upload-shim.min.js') }}
    {{ HTML::script(Config::get('board::cdn.angular')) }}
    {{ HTML::script(Config::get('board::cdn.angular-bootstrap')) }}
    {{ HTML::script('packages/wetcat/board/js/placeholders-0.0.1-SNAPSHOT.min.js') }}
    {{ HTML::script('packages/wetcat/board/js/angular-file-upload.min.js') }}

    {{ HTML::script('//maps.googleapis.com/maps/api/js?sensor=false') }}
    {{ HTML::script('packages/wetcat/board/js/underscore-min.js') }}
    {{ HTML::script('packages/wetcat/board/js/angular-google-maps.min.js') }}
    {{ HTML::script('packages/wetcat/board/js/angular-sanitize.min.js') }}

    

    {{ HTML::script('packages/wetcat/board/js/main.js') }}
    {{ HTML::script('packages/wetcat/board/js/controllers.js') }}
    {{ HTML::script('packages/wetcat/board/js/filters.js') }}
  </body>
</html>

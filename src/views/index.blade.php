@extends('board::layouts.main')

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

@section('content')
  {{-- Pages --}}
  <div ng-repeat="page in pages">
    @include('board::templates.page')
  </div>
@stop

@section('footer')
  <div class="row" ng-controller="FooterController">

    {{-- Footer administration links --}}
    <div class="col-xs-12" ng-if="isAdmin()">
      <h1><small><span class="glyphicon glyphicon-plus-sign" ng-click="newFooter('Lipsum...', 'text')" tooltip="Add footer item" tooltip-placement="bottom"></span></small></h1>
    </div>

    {{-- Footer items --}}
    <div class="col-md-@{{ 12 / footers.length }}" ng-repeat="footer in footers">
      <footer-item ng-include="'packages/wetcat/board/templates/footers/footer-'+footer.type+'.html'"></footer-item>
    </div>

  </div>
@stop
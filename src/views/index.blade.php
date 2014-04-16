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
  <div ng-repeat="page in pages">
    @include('board::templates.page')
  </div>
@stop

@section('footer')
  <div class="row">
    <div class="col-md-3">
      <h1><span class="glyphicon glyphicon-heart"></span></h1>
      <ul class="list-unstyled">
        <li>Item 1</li>
        <li>Item 2</li>
        <li>Item 3</li>
      </ul>
    </div>
    <div class="col-md-3">
      <h1><span class="glyphicon glyphicon-globe"></span></h1>
      <ul class="list-unstyled">
        <li>Item 1</li>
        <li>Item 2</li>
        <li>Item 3</li>
      </ul>
    </div>
    <div class="col-md-3">
      <h1><span class="glyphicon glyphicon-fire"></span></h1>
      <ul class="list-unstyled">
        <li>Item 1</li>
        <li>Item 2</li>
        <li>Item 3</li>
      </ul>
    </div>
    <div class="col-md-3">
      <h1><span class="glyphicon glyphicon-road"></span></h1>
      <address>
        <strong>Company, Inc.</strong><br>
        Street 123<br>
        123 45, City<br>
        <abbr title="Phone">P:</abbr> (123) 456-7890
      </address>
    </div>
  </div>
@stop
@extends('board::layouts.mail')

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
  <div class="col-xs-12">
    <h1>Contact message from {{ $name }}</h1>
    <p>{{ $from }}</p>
    <p>{{ $body }}</p>
  </div>
@stop

@section('footer')
  {{-- Copy notice --}}
  <div class="col-xs-12">
    <p style="text-align: center;"><span class="glyphicon glyphicon-copyright-mark"></span> {{ Config::get('board::app.copy') }}</p>
  </div>
@stop
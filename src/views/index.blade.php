@extends('board::layouts.main')

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
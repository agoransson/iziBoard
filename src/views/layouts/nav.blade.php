<nav class="navbar navbar-default" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href ng-click="showPage(pages[0])">Brand</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav" ng-repeat="page in pages | filter: {type: '!product'}">

        <li><a href ng-click="showPage(page)">@{{ page.title }}</a></li>
        
      </ul>
      
      <ul class="nav navbar-nav navbar-left">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Products <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href ng-click="showPage(page)" ng-repeat="page in pages | filter: {type: 'product'}">@{{ page.title }}</a></li>
          </ul>
        </li>
      </ul>

      {{-- TODO: should hide for normal users --}}
      @if( true )
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href ng-click="newPage()"><span class="glyphicon glyphicon-plus"></span> Add page</a></li>
            <li><a href ng-click="deletePage(selectedPage)"><span class="glyphicon glyphicon-minus"></span> Remove page</a></li>
            <li><a href ng-click="savePage(selectedPage)"><span class="glyphicon glyphicon-check"></span> Save page</a></li>
            <li class="divider"></li>
            <li><a href ng-click="newProduct()"><span class="glyphicon glyphicon-plus"></span> Add product</a></li>
          </ul>
        </li>
      </ul>
      @endif

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

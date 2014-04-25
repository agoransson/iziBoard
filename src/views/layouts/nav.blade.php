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
      <ul class="nav navbar-nav" ng-repeat="page in pages | filter: {type: '!product'} | filter: {type: '!blog'}">

        <li><a href ng-click="showPage(page)">@{{ page.title }}</a></li>
        
      </ul>
      
      <ul class="nav navbar-nav navbar-left">
        <li class="dropdown" ng-if="(productsEnabled && (pages | filter: {type: 'product'}).length > 0)">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Products <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href ng-click="showPage(page)" ng-repeat="page in pages | filter: {type: 'product'}">@{{ page.title }}</a></li>
          </ul>
        </li>

        <li ng-if="(blogsEnabled && (pages | filter: {type: 'blog'}).length > 0)" ng-repeat="page in pages | filter: {type: 'blog'}"><a href ng-click="showPage(page)">@{{ page.title }}</a></li>

      </ul>

      {{-- Render admin --}}
      <ul class="nav navbar-nav navbar-right" ng-controller="UserController">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Config::get('board::app.name') }}  <b class="caret"></b></a>
          <ul class="dropdown-menu">

            @if( \Auth::check() /* && add roles to auth and check for admin privileges */ )
              {{-- Pages --}}
              <li><a href ng-click="newPage()"><span class="glyphicon glyphicon-plus"></span> Add page</a></li>
              <li><a href ng-click="deletePage(selectedPage)"><span class="glyphicon glyphicon-minus"></span> Remove page</a></li>
              <li><a href ng-click="savePage(selectedPage)"><span class="glyphicon glyphicon-check"></span> Save page</a></li>
              
              {{-- Products --}}
              <li class="divider"></li>
              <li><a href ng-click="toggleProducts()"><span ng-class="{'glyphicon-check': productsEnabled, 'glyphicon-unchecked': !productsEnabled}" class="glyphicon"></span> @{{ productsEnabled ? 'Disable' : 'Enable' }} products</a></li>
              <li ng-if="productsEnabled"><a href ng-click="newProduct()"><span class="glyphicon glyphicon-plus"></span> Add product</a></li>
              <li ng-if="productsEnabled"><a href ng-click="deleteProduct(selectedPage)"><span class="glyphicon glyphicon-minus"></span> Remove product</a></li>

              {{-- Blogs --}}
              <li class="divider"></li>
              <li><a href ng-click="toggleBlogs()"><span ng-class="{'glyphicon-check': blogsEnabled, 'glyphicon-unchecked': !blogsEnabled}" class="glyphicon"></span> @{{ blogsEnabled ? 'Disable' : 'Enable' }} blogs</a></li>
              <li ng-if="blogsEnabled"><a href ng-click="newBlog()"><span class="glyphicon glyphicon-plus"></span> Add blog</a></li>
              <li ng-if="blogsEnabled"><a href ng-click="deleteBlog(selectedPage)"><span class="glyphicon glyphicon-minus"></span> Remove blog</a></li>

              {{-- Extra divider for the user actions --}}
              <li class="divider"></li>
            @endif

            {{-- Display registration link if not logged in and registration is enabled --}}
            @if( !\Auth::check() && Config::get('board::app.user-registration') == 'yes' )
              <li><a href ng-click="register()"><span class="glyphicon glyphicon-plus"></span> Register</a></li>
            @endif

            {{-- Display login if not logged in, otherwise display logout --}}
            @if( !\Auth::check() )
              <li><a href ng-click="login()"><span class="glyphicon glyphicon-minus"></span> Login</a></li>
            @else
              <li><a href ng-click="logout()"><span class="glyphicon glyphicon-check"></span> Logout</a></li>
            @endif

          </ul>
        </li>
      </ul>


    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

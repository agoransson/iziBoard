/*
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
 */
 
var iziControllers = angular.module('iziControllers', ['ui.bootstrap', 'google-maps', 'placeholders', 'angularFileUpload', 'ngSanitize', 'tagger', 'cfp.hotkeys', 'ngStorage']);


iziControllers.controller('PageController', function ($scope, $http, CSRF_TOKEN, hotkeys) {

  // Init save action on ctrl+s
  hotkeys.add({
    combo: 'ctrl+s',
    description: 'Save the page',
    callback: function(event) {
      event.preventDefault();
      $http.put('pages', $scope.selectedPage);
    }
  });

  $http.get('pages').success(function (pages){
    $scope.pages = pages;
    $scope.selectedPage = $scope.pages[0];
  }); 

  $scope.pageTypes = ['front', 'text', 'news', 'carousel', 'maps'];

  // TODO: Do a GET on settings for products (if it's enabled)
  $scope.productsEnabled = true;
  if( $scope.productsEnabled ){
    $scope.pageTypes.push('product');
  }

  // TODO: Do a GET on settings for blogs (if it's enabled)
  $scope.blogsEnabled = true;
  if( $scope.blogsEnabled ){
    $scope.pageTypes.push('blog');
  }

  $scope.newPage = function () {
    var page = {
      type: $scope.pageTypes[0],
      title: 'my title',
      heading: 'my heading',
      description: 'my description'
    };
    $http.post('pages', page).success(function (data){
      $scope.pages.push(data);
      $scope.selectedPage = data;
    });
  }

  $scope.showPage = function (page) {
    $scope.selectedPage = page;
  }

  $scope.savePage = function (page) {
    $http.put('pages', page);
  }

  $scope.deletePage = function (page) {
    /*var index = $scope.pages.indexOf(page);
    $scope.pages.splice(index,1);
    if( $scope.pages.length > 0 )
      $scope.selectedPage = $scope.pages[0];*/
    $http.delete('pages/'+page.id).success(function (data){
      var index = $scope.pages.indexOf(page);
      $scope.pages.splice(index,1);
      if( $scope.pages.length > 0 )
        $scope.selectedPage = $scope.pages[index-1];
    });
  }

  $scope.setPageType = function (type) {
    $scope.selectedPage.type = type;
  }

  /* Product type */
  $scope.newProduct = function () {
    var page = {
      type: 'product',
      title: 'my product',
      heading: 'my product',
      description: 'my product description'
    };
    $http.post('pages', page).success(function (data){
      $scope.pages.push(data);
      $scope.selectedPage = data;
    });
  }

  $scope.deleteProduct = function (page) {
    if( $scope.selectedPage.type == 'product' ){
      $http.delete('pages/'+page.id).success(function (data){
        var index = $scope.pages.indexOf(page);
        $scope.pages.splice(index,1);
        if( $scope.pages.length > 0 )
          $scope.selectedPage = $scope.pages[index-1];
      });  
    } else {
      // TODO: Make dialog feedback saying that the page is not a product
    }
  }

  $scope.toggleProducts = function () {
    $scope.productsEnabled = !$scope.productsEnabled;
    if( $scope.productsEnabled ){
      $scope.pageTypes.push('product');
    } else {
      $scope.pageTypes.pop('product');
    }
  }

  /* Blogs type */
  $scope.newBlog = function () {
    var page = {
      type: 'blog',
      title: 'my blog',
      heading: 'my blog',
      description: 'my blog description'
    };
    $http.post('pages', page).success(function (data){
      $scope.pages.push(data);
      $scope.selectedPage = data;
    });
  }

  $scope.deleteBlog = function (page) {
    if( $scope.selectedPage.type == 'blog' ){
      $http.delete('pages/'+page.id).success(function (data){
        var index = $scope.pages.indexOf(page);
        $scope.pages.splice(index,1);
        if( $scope.pages.length > 0 )
          $scope.selectedPage = $scope.pages[index-1];
      });  
    } else {
      // TODO: Make dialog feedback saying that the page is not a blog
    }
  }

  $scope.toggleBlogs = function () {
    $scope.blogsEnabled = !$scope.blogsEnabled;
    if( $scope.blogsEnabled ){
      $scope.pageTypes.push('blog');
    } else {
      $scope.pageTypes.pop('blog');
    }
  }

});

iziControllers.controller('TextController', function ($scope, $http, hotkeys) {

  // This should be fixed for polymorhpism
  $scope.newTextable = function (container, containerType, text) {
    if( $scope.selectedPage.texts.length < 4 ){
      var txt = {id: container.id, type: containerType, description: text};
      $http.post('textables', txt).success(function (data){
        $scope.selectedPage.texts.push(data);
      });  
    }
  }

  $scope.deleteText = function (text) {
    var index = $scope.selectedPage.texts.indexOf(text);
    $scope.selectedPage.texts.splice(index,1);
    $http.delete('textables/'+text.id);
  }

  $scope.numCombined = "2p3s";

});



iziControllers.controller('MapCtrl', function ($scope, $http) {

  $scope.markers = $scope.selectedPage.markers;

  angular.extend($scope, {
      map: {
          center: {
            latitude: 55.615497,
            longitude: 12.950347,
          },
          options: {
              streetViewControl: false,
              panControl: false,
              maxZoom: 20,
              minZoom: 3
          },
          zoom: 10,
          dragging: false,
          bounds: {},
          doClusterRandomMarkers: true,
          doUgly: true, //great name :)
          markers: $scope.selectedPage.markers,
          clickedMarker: {
              title: 'You clicked here',
              latitude: null,
              longitude: null
          },
          events: {
              tilesloaded: function (map, eventName, originalEventArgs) {
              },
              click: function (mapModel, eventName, originalEventArgs) {
                  // 'this' is the directive's scope
                  console.log("user defined event: " + eventName, mapModel, originalEventArgs);

                  var e = originalEventArgs[0];

                  if (!$scope.map.clickedMarker) {
                      $scope.map.clickedMarker = {
                          title: 'You clicked here',
                          latitude: e.latLng.lat(),
                          longitude: e.latLng.lng()
                      };
                  }
                  else {
                      $scope.map.clickedMarker.latitude = e.latLng.lat();
                      $scope.map.clickedMarker.longitude = e.latLng.lng();
                      var marker = {
                        id: $scope.selectedPage.id,
                        title: 'New marker',
                        description: 'Lipsum...',
                        latitude: e.latLng.lat(),
                        longitude: e.latLng.lng()
                      }
                      $http.post('markers', marker).success(function (data){
                        $scope.selectedPage.markers.push(data);
                      });
                  }

                  $scope.$apply();
              }
          }
      },
      toggleColor: function (color) {
          return color == 'red' ? '#6060FB' : 'red';
      }

  });

  // Fix for google maps resize problem...      
  window.setTimeout(function (){                                
    $scope.showMap = true;
  },100);
});




iziControllers.controller('MarkerController', function ($scope, $http) {

  $scope.saveMarker = function (marker) {
    $http.put('markers', marker).success(function (data){
      console.log('sparad');
    });
  }

  $scope.deleteMarker = function (marker) {
    var index = $scope.selectedPage.markers.indexOf(marker);
    $scope.selectedPage.markers.splice(index,1); 
    $http.delete('markers/'+marker.id);
  }

});



iziControllers.controller('ImageController', function ($scope, $upload) {  
  $scope.onFilePost = function ($files, imageOwner, ownerType, updatefile) {

    //$files: an array of files selected, each file has name, size, and type.
    for (var i = 0; i < $files.length; i++) {
      var file = $files[i];

      $scope.upload = $upload.upload({
        url: 'imageable', //upload.php script, node.js route, or servlet url
        method: 'POST',
        // headers: {'header-key': 'header-value'},
        // withCredentials: true,
        data: {id: imageOwner.id, type: ownerType, updatefile: (updatefile ? updatefile.id : '')},
        file: file, // or list of files: $files for html5 only
        /* set the file formData name ('Content-Desposition'). Default is 'file' */
        //fileFormDataName: myFile, //or a list of names for multiple files (html5).
        /* customize how data is added to formData. See #40#issuecomment-28612000 for sample code */
        //formDataAppender: function (formData, key, val){}
      }).progress(function (evt) {
        console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
      }).success(function (data, status, headers, config) {
        // file is uploaded successfully
        //$scope.selectedPage.images.push(data);
        if( typeof imageOwner.images != 'undefined' ){
          imageOwner.images.push(data);
        }else if(updatefile){
          updatefile = data;
        }else{
          imageOwner.images = [];
          imageOwner.images.push(data);
        }
      });
      //.error(...)
      //.then(success, error, progress); 
      //.xhr(function (xhr){xhr.upload.addEventListener(...)})// access and attach any event listener to XMLHttpRequest.
    }
    /* alternative way of uploading, send the file binary with the file's content-type.
       Could be used to upload files to CouchDB, imgur, etc... html5 FileReader is needed. 
       It could also be used to monitor the progress of a normal http post/put request with large data*/
    // $scope.upload = $upload.http({...})  see 88#issuecomment-31366487 for sample code.
  };

  $scope.onFilePut = function ($files, file) {
    //$files: an array of files selected, each file has name, size, and type.
    for (var i = 0; i < $files.length; i++) {
      var file = $files[i];

      $scope.upload = $upload.upload({
        url: 'imageable', //upload.php script, node.js route, or servlet url
        method: 'PUT',
        // headers: {'header-key': 'header-value'},
        // withCredentials: true,
        data: {id: file.id},
        file: file, // or list of files: $files for html5 only
        /* set the file formData name ('Content-Desposition'). Default is 'file' */
        //fileFormDataName: myFile, //or a list of names for multiple files (html5).
        /* customize how data is added to formData. See #40#issuecomment-28612000 for sample code */
        //formDataAppender: function (formData, key, val){}
      }).progress(function (evt) {
        console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
      }).success(function (data, status, headers, config) {
        // file is uploaded successfully
        //$scope.selectedPage.images.push(data);
      });
      //.error(...)
      //.then(success, error, progress); 
      //.xhr(function (xhr){xhr.upload.addEventListener(...)})// access and attach any event listener to XMLHttpRequest.
    }
    /* alternative way of uploading, send the file binary with the file's content-type.
       Could be used to upload files to CouchDB, imgur, etc... html5 FileReader is needed. 
       It could also be used to monitor the progress of a normal http post/put request with large data*/
    // $scope.upload = $upload.http({...})  see 88#issuecomment-31366487 for sample code.
  };
});




iziControllers.controller('NewsController', function ($scope, $http, $modal, $log) {

  $scope.orderProp = 'created_at';
  $scope.quantity = 3;
  $scope.orderType = true; //false = ASC, true = DESC

  $http.get('news').success(function (news){
    $scope.news = news;
  });

  $scope.openNewsModal = function (news){

    var modalInstance = $modal.open({
      templateUrl: 'packages/wetcat/board/templates/newsModalContent.html',
      controller: NewsInstanceCtrl,
      resolve: {
        item: function () {
          return news;
        }
      }
    });

    modalInstance.result.then(function (selectedItem) {
      if( $scope.news.indexOf(selectedItem) == -1 ){
        // If news doesn't exist, splice and POST
        var d = new Date().toMysqlFormat();
        selectedItem['created_at'] = d;
        $scope.news.splice(0, 0, selectedItem);
        if( $scope.news.length > 3 )
          $scope.news.pop();      
        $http.post('news', selectedItem);
      }else{
        // If news exist, just PUT
        $http.put('news', selectedItem);
      }

    }, function () {
      $log.info('Modal dismissed at: ' + new Date());
    });
  };

  $scope.deleteNews = function (news) {
    var index = $scope.news.indexOf(news);
    $scope.news.splice(index,1); 
    $http.delete('news/'+news.id);
  }

});




// Please note that $modalInstance represents a modal window (instance) dependency.
// It is not the same as the $modal service used above.

var NewsInstanceCtrl = function ($scope, $modalInstance, $http, item) {

  if( item ){
    $scope.newsitem = item;
  }else{
    $scope.newsitem = {};
  }

  $scope.newsModalOk = function () {
    $modalInstance.close($scope.newsitem);
  };

  $scope.newsModalCancel = function () {
    $modalInstance.dismiss('cancel');
  };

  function twoDigits(d) {
      if(0 <= d && d < 10) return "0" + d.toString();
      if(-10 < d && d < 0) return "-0" + (-1*d).toString();
      return d.toString();
  }

  Date.prototype.toMysqlFormat = function () {
      return this.getUTCFullYear() + "-" + twoDigits(1 + this.getUTCMonth()) + "-" + twoDigits(this.getUTCDate()) + " " + twoDigits(this.getUTCHours()) + ":" + twoDigits(this.getUTCMinutes()) + ":" + twoDigits(this.getUTCSeconds());
  };
}





iziControllers.controller('FooterController', function ($scope, $http){

});



iziControllers.controller('CategoryController', function ($scope, $http){
  $http.get('categories').success(function (categories){
    $scope.categories = categories;
  });
  $scope.tags = [];
});



iziControllers.controller('BlogController', function ($scope, $http){

  $scope.selectedPage.currentBlogpost = $scope.selectedPage.blogposts[0];

  $scope.newBlogpost = function () {
    var blogpost = {
      id: $scope.selectedPage.id,
      title: 'my post title'
    };
    $http.post('posts', blogpost).success(function (data){
      $scope.selectedPage.blogposts.push(data);
    });
  }

  $scope.showBlogpost = function (post) {
    $scope.selectedPage.currentBlogpost = post;
  }

  $scope.getBlogitems = function (post) {
    var items = [];

    if( typeof post != 'undefined' ){
      items = items.concat(post.images);
      items = items.concat(post.texts);
    }

    items.sort(compare);

    return items;
  }

  $scope.addBlogImage = function (post, dropfile) {
    var image = {
      id: post.id,
      type: 'Blogpost',
      originalName: '',
      name: '',
      ext: '',
      filename: '',
      thumbnail: '',
      file: dropfile
    };

    $http.post('imageable', image).success(function (data) {
      post.images.push(image);
    });
  }

  $scope.addBlogText = function (post) {
    console.log(post);
    var text = {
      id: post.id,
      type: 'Blogpost',
      description: 'My text'
    };

    $http.post('textables', text).success(function (data) {
      post.texts.push(data);
    });
  }

  function compare(a,b) {
    if (a.created_at < b.created_at)
       return -1;
    if (a.created_at > b.created_at)
      return 1;
    return 0;
  }


});




iziControllers.controller('UserController', function ($scope, $http, $sessionStorage, CSRF_TOKEN, $modal, $log) {

  $scope.$storage = $sessionStorage;
  $scope.$storage.permission = [];

  $http.defaults.headers.common['X-Auth-Token'] = $scope.$storage.token;

  $scope.register = function () {
    var user = {
      _token: CSRF_TOKEN
    };
    $http.post('users/register', user).success(function (data) {
      console.log(data);
    });
  }

  $scope.login = function () {
    // Open modal
    var modalInstance = $modal.open({
      templateUrl: 'packages/wetcat/board/templates/loginModalContent.html',
      controller: LoginInstanceCtrl,
      resolve: {
        item: function () {
          return '';
        }
      }
    });

    modalInstance.result.then(function (selectedItem) {
      var user = {
        _token: CSRF_TOKEN,
        email: selectedItem.email,
        password: selectedItem.password
      };
      $http.post('users/login', user)
      .success(function (data, status, headers, config) {
        setToken(data.token, data.permissions);
      })
      .error(function (data, status, headers, config) {
        delToken();
      });

    }, function () {
      $log.info('Modal dismissed at: ' + new Date());
    });
  }

  $scope.logout = function () {
    var user = {
      _token: CSRF_TOKEN
    };
    $http.post('users/logout', user).success(function (data) {
      delToken();
    });
  }

  function setToken (token, permissions) {
    $scope.$storage.token = token;
    $http.defaults.headers.common['X-Auth-Token'] = token;
    $scope.$storage.permissions = permissions;

    console.log( $scope.$storage.permissions );
  }

  function delToken () {
    delete $scope.$storage.token;
  }

  $scope.isAdmin = function () {
    return $scope.$storage.token && ('admin' in $scope.$storage.permissions) && ($scope.$storage.permissions.admin == 1);
  }

  $scope.isUser = function () {
    return $scope.$storage.token && ('user' in $scope.$storage.permissions) && ($scope.$storage.permissions.user == 1);
  }

  $scope.isPublic = function () {
    return !$scope.$storage.token;
  }


});


// Please note that $modalInstance represents a modal window (instance) dependency.
// It is not the same as the $modal service used above.

var LoginInstanceCtrl = function ($scope, $modalInstance, item) {

  if( item ){
    $scope.useritem = item;
  }else{
    $scope.useritem = {};
  }

  $scope.loginModalOk = function () {
    $modalInstance.close($scope.useritem);
  };

  $scope.loginModalCancel = function () {
    $modalInstance.dismiss('cancel');
  };

}
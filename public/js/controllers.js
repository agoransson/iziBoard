var controllers = angular.module('ekkogourmetControllers', ['ui.bootstrap', 'google-maps', 'placeholders', 'angularFileUpload', 'ngSanitize']);



controllers.controller('PageController', function($scope, $http) {

  $http.get('pages').success(function(pages){
    $scope.pages = pages;
    $scope.selectedPage = $scope.pages[0];
  });

  $scope.pageTypes = ['front', 'text', 'news', 'carousel', 'maps', 'product'];

  $scope.newPage = function() {
    var page = {
      type: $scope.pageTypes[0],
      title: 'my title',
      heading: 'my heading',
      description: 'my description'
    };
    $http.post('pages', page).success(function(data){
      $scope.pages.push(data);
      $scope.selectedPage = data;
    });
  }

  $scope.newProduct = function() {
    var page = {
      type: 'product',
      title: 'my product',
      heading: 'my product',
      description: 'my product description'
    };
    $http.post('pages', page).success(function(data){
      $scope.pages.push(data);
      $scope.selectedPage = data;
    });
  }

  $scope.showPage = function(page) {
    $scope.selectedPage = page;
  }

  $scope.savePage = function(page) {
    $http.put('pages', page);
  }

  $scope.deletePage = function(page) {
    /*var index = $scope.pages.indexOf(page);
    $scope.pages.splice(index,1);
    if( $scope.pages.length > 0 )
      $scope.selectedPage = $scope.pages[0];*/
    $http.delete('pages/'+page.id).success(function(data){
      var index = $scope.pages.indexOf(page);
      $scope.pages.splice(index,1);
      if( $scope.pages.length > 0 )
        $scope.selectedPage = $scope.pages[index-1];
    });
  }

  $scope.setPageType = function(type) {
    $scope.selectedPage.type = type;
  }

});

controllers.controller('TextController', function($scope, $http) {

  // This should be fixed for polymorhpism
  $scope.newTextable = function(page, text) {
    if( $scope.selectedPage.texts.length < 4 ){
      var txt = {id: page.id, description: text};
      $http.post('textables', txt).success(function(data){
        $scope.selectedPage.texts.push(data);
      });  
    }
  }

  $scope.deleteText = function(text) {
    var index = $scope.selectedPage.texts.indexOf(text);
    $scope.selectedPage.texts.splice(index,1);
    $http.delete('textables/'+text.id);
  }

  $scope.numCombined = "2p3s";

});



controllers.controller('MapCtrl', function($scope, $http) {

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
                      $http.post('markers', marker).success(function(data){
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
  window.setTimeout(function(){                                
    $scope.showMap = true;
  },100);
});




controllers.controller('MarkerController', function($scope, $http) {

  $scope.saveMarker = function(marker) {
    console.log(marker);
    $http.put('markers', marker).success(function(data){
      console.log('sparad');
    });
  }

  $scope.deleteMarker = function(marker) {
    var index = $scope.selectedPage.markers.indexOf(marker);
    $scope.selectedPage.markers.splice(index,1); 
    $http.delete('markers/'+marker.id);
  }

});



controllers.controller('ImageController', function($scope, $upload) {  
  $scope.onFileSelect = function($files, page) {
    //$files: an array of files selected, each file has name, size, and type.
    for (var i = 0; i < $files.length; i++) {
      var file = $files[i];

      $scope.upload = $upload.upload({
        url: 'imageable', //upload.php script, node.js route, or servlet url
        method: 'POST',
        // headers: {'header-key': 'header-value'},
        // withCredentials: true,
        data: {id: page.id},
        file: file, // or list of files: $files for html5 only
        /* set the file formData name ('Content-Desposition'). Default is 'file' */
        //fileFormDataName: myFile, //or a list of names for multiple files (html5).
        /* customize how data is added to formData. See #40#issuecomment-28612000 for sample code */
        //formDataAppender: function(formData, key, val){}
      }).progress(function(evt) {
        console.log('percent: ' + parseInt(100.0 * evt.loaded / evt.total));
      }).success(function(data, status, headers, config) {
        // file is uploaded successfully
        $scope.selectedPage.images.push(data);
      });
      //.error(...)
      //.then(success, error, progress); 
      //.xhr(function(xhr){xhr.upload.addEventListener(...)})// access and attach any event listener to XMLHttpRequest.
    }
    /* alternative way of uploading, send the file binary with the file's content-type.
       Could be used to upload files to CouchDB, imgur, etc... html5 FileReader is needed. 
       It could also be used to monitor the progress of a normal http post/put request with large data*/
    // $scope.upload = $upload.http({...})  see 88#issuecomment-31366487 for sample code.
  };
});




controllers.controller('NewsController', function($scope, $http, $modal, $log) {

  $scope.orderProp = 'created_at';
  $scope.quantity = 3;
  $scope.orderType = true; //false = ASC, true = DESC

  $http.get('news').success(function(news){
    $scope.news = news;
  });

  $scope.openNewsModal = function(news){

    var modalInstance = $modal.open({
      templateUrl: 'newsModalContent.html',
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

  $scope.deleteNews = function(news) {
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

  Date.prototype.toMysqlFormat = function() {
      return this.getUTCFullYear() + "-" + twoDigits(1 + this.getUTCMonth()) + "-" + twoDigits(this.getUTCDate()) + " " + twoDigits(this.getUTCHours()) + ":" + twoDigits(this.getUTCMinutes()) + ":" + twoDigits(this.getUTCSeconds());
  };
}





controllers.controller('FooterController', function($scope, $http){

});
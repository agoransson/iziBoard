var filters = angular.module('ekkogourmetFilters', []);

filters.filter('brDateFilter', function() {
  return function(str) {
    return str.substr(0,10);
  };
});

filters.filter('firstLineHeading', function() {
  return function(str) {
    var index = str.indexOf('<br>');
    if( index != -1 ){
      var firstLine = str.substr(0, index);
      var len = firstLine.length;
      firstLine = '<h4>'+firstLine+'</h4>';
      return firstLine + str.substr(index+4);
    }
    return str;
  };
});

filters.filter('bold', function() {
  return function(str) {
    return '<b>' + str + '</b>';
  };
});

filters.filter('firstLine', function() {
  return function(str) {
    var index = str.indexOf('<br>');
    return '<b>'+str.substr(0, index)+'</b>';
  };
});
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
 
var iziFilters = angular.module('iziFilters', ['ngSanitize']);

iziFilters.filter('brDateFilter', function () {
  return function(str) {
    return str.substr(0,10);
  };
});

iziFilters.filter('firstLineHeading', function () {
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

iziFilters.filter('bold', function () {
  return function(str) {
    return '<b>' + str + '</b>';
  };
});

iziFilters.filter('firstLine', function () {
  return function(str) {
    var index = str.indexOf('<br>');
    return '<b>'+str.substr(0, index)+'</b>';
  };
});


iziFilters.filter('NavBarFilter', function () {
  return function(items) {
    var result = {};

    console.log(items);

    return result;
  };
});

iziFilters.filter("nl2br", function ($sce) {
 return function(data) {
   if (!data) return data;
   return data.replace(/\n\r?/g, $sce.trustAsHtml('<br />'));
 };
});

iziFilters.filter('paragraphs', function ($sce) {
  return function (str) {
    return str.split('\n');
  };
});


iziFilters.filter("bb", function ($sce) {
 return function(data) {
   if (!data) return data;
   var out = data;

   out = out.replace(/\[?/g, $sce.trustAsHtml('<'));
   out = out.replace(/\]?/g, $sce.trustAsHtml('>'));

   return out;
 };
});
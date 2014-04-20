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
 
var iziDirectives = angular.module('iziDirectives', ['ngSanitize']);

iziDirectives.directive("contenteditable", function() {
  return {
    restrict: "A",
    require: "ngModel",
    link: function(scope, element, attrs, ngModel) {

      function read() { 
        var html = element.html();
        // When we clear the content editable the browser
        // leaves a <br> behind
        // If strip-br attribute is provided then we strip this out
        /*if( attrs.stripBr && html == '<br>' ) {
          html = '';
        } else if( attrs.stripBr ){
          //html = html.replace("<br>","");
        }*/

        // Prevent adding <div> (Issue in Chrome)
        html = html.replace(/<div>/g, '');
        html = html.replace(/<\/div>/g, '<br>');


        // Always remove the last <br>, if there is one...
        if( html.endsWith('<br>') ){
          html = html.substring(0, html.length - 4);  
        }else if( html.endsWith('<br/>') ){
          html = html.substring(0, html.length - 5);  
        }

        ngModel.$setViewValue(html);
      }

      ngModel.$render = function() {
        element.html(ngModel.$viewValue || "");
      };

      element.bind("blur keyup change", function() {
        scope.$apply(read);
      });

      String.prototype.endsWith = function(suffix) {
        return this.indexOf(suffix, this.length - suffix.length) !== -1;
      };
    }
  };
});

iziDirectives.directive('autoSizeInput', function() {
  return {
    replace: true,
    scope: {
      value: '=inputValue'
    },  
    templateUrl: 'packages/wetcat/board/templates/directives/autoSizeInput.html',
    link: function(scope, element, attrs) {
      var elInput = element.find('input');
      var elSpan = element.find('span');
      elSpan.html(elInput.val());

      scope.$watch('value', function(value) {
        if(value) {
          elSpan.html(elInput.val());
          elInput.css('width', (elSpan[0].offsetWidth + 10) + 'px');
        }   
      }); 
    }   
  };  
});



iziDirectives.directive('typeahead', function($timeout) {
  return {
    restrict: 'AEC',
    scope: {
      items: '=',
      prompt: '@',
      title: '@',
      subtitle: '@',
      model: '=',
      onSelect: '&'
    },
    link: function(scope, elem, attrs) {
      scope.handleSelection = function(selectedItem) {
        console.log("handleSelection");
        console.log(selectedItem);
        console.log('---');
        scope.model = selectedItem;
        scope.current = 0;
        scope.selected = true;
        $timeout(function() {
          scope.onSelect();
        }, 200);
      };
      scope.current = 0;
      scope.selected = true; // hides the list initially
      scope.isCurrent = function(index) {
        return scope.current == index;
      };
      scope.setCurrent = function(index) {
        console.log('setCurrent: ' + index);
        scope.current = index;
      };
    },
    templateUrl: 'packages/wetcat/board/templates/typeahead-template.html'
  };
});


/*
 * angular-markdown-directive v0.2.0
 * (c) 2013 Brian Ford http://briantford.com
 * License: MIT
 */

'use strict';

iziDirectives.directive('btfMarkdown', function ($sanitize) {
  var converter = new Showdown.converter();
  return {
    restrict: 'AE',
    link: function (scope, element, attrs) {
      if (attrs.btfMarkdown) {
        scope.$watch(attrs.btfMarkdown, function (newVal) {
          var html = newVal ? $sanitize(converter.makeHtml(newVal)) : '';
          element.html(html);
        });
      } else {
        var html = $sanitize(converter.makeHtml(element.text()));
        element.html(html);
      }
    }
  };
});

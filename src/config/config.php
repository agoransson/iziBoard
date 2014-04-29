<?php

/*
 * iziBoard
 * Copyright (C) 2014  Andreas Göransson
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

return [
  
  /**
   * Change these variable to update the style, and the script versions.
   */
  'cdn' => array(

    'bootstrap' => '//netdna.bootstrapcdn.com/bootswatch/3.1.1/yeti/bootstrap.min.css',

    'angular'   => 'https://ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular.min.js',
  
    'angular-bootstrap' => '//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.10.0/ui-bootstrap-tpls.min.js',

  ),


  'app' => array(

    /*
     * Set the title of this website.
     */
    'name'  =>  'iziBoard',

    /*
     * This setting will allow new users to register on the website. The 
     * 'admin' user will however always be created for you if you follow
     * the setup instructions.
     */
    'user-registration'  =>  'yes',

    /*
     * This is the default webmaster email.
     */
    'contact-email' =>  'contact@iziboard.se',

    /*
     * This is the copyright information seen at the bottom of the footer
     */
    'copy'  =>  'Wetcat corp.'
  ),

];
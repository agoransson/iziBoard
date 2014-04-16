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

{{-- TODO: add check for user-rights, if user is admin we should add possibility to edit page --}}
@if( true )
  <page-item ng-include="'packages/wetcat/board/templates/admin/page-'+page.type+'.html'" ng-show="selectedPage == page"></page-item>
@else
  <page-item ng-include="'packages/wetcat/board/templates/user/page-'+page.type+'.html'" ng-show="selectedPage == page"></page-item>
@endif

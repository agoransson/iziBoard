{{-- TODO: add check for user-rights, if user is admin we should add possibility to edit page --}}
@if( true )
  <page-item ng-include="'packages/wetcat/board/templates/admin/page-'+page.type+'.html'" ng-show="selectedPage == page"></page-item>
@else
  <page-item ng-include="'packages/wetcat/board/templates/user/page-'+page.type+'.html'" ng-show="selectedPage == page"></page-item>
@endif

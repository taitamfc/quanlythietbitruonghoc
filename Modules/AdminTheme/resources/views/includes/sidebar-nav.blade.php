<!--navigation-->
<ul class="metismenu" id="menu">
    @if( request()->route()->getPrefix() != '/admin' )
        @include('admintheme::includes.nav.nav-teacher')
    @endif

    @if( request()->route()->getPrefix() == '/admin' )
        @include('admintheme::includes.nav.nav-admin')
    @endif
</ul>
<!--end navigation-->
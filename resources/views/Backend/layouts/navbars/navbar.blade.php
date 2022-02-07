@auth()
    @include('Backend.layouts.navbars.navs.auth')
@endauth

@guest()
    @include('Backend.layouts.navbars.navs.guest')
@endguest

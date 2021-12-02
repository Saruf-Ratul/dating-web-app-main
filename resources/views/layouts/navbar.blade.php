<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top"> <i style="color: red;" class="fa fa-heart fa-pulse "
                aria-hidden="true"></i> Dating WebApps</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#userAround">USERS AROUND YOU</a>
                </li>
                @if (empty(Auth::user()->image))
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="{{ route('image-up') }}">UPLOAD PROFILE PHOTO</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="{{ route('logout') }}"><i class="fa fa-sign-out"
                            aria-hidden="true"></i> LOGOUT</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

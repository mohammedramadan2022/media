<nav class="navbar navbar-expand-lg navbar-light ">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('public/front/images/logo-m.png') }}" data-src="{{ asset('public/front/images/logo-m.png') }}" class="lazyload" alt=""></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <ul class="menu-bars">
                            <li><span></span></li>
                            <li><span></span></li>
                            <li><span></span></li>
                        </ul>
                    </span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Home <span class="sr-only">(current)</span></a>
                </li>

                @auth
                    <li class="nav-item {{ request()->is('my-albums') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('front.my-albums') }}"> My Albums</a>
                    </li>
                    <li class="nav-item {{ request()->is('profile') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('front.profile') }}"> Profile</a>
                    </li>
                @endauth

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('front.register') }}"> Register</a>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-gradiant">
                            <a href="{{ route('sign-in') }}">login</a>
                        </button>
                    </li>
                @else
                    <li class="nav-item">
                        <button class="btn btn-gradiant">
                            <a href="{{ route('user.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                @lang('back.logout')
                            </a>

                            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </button>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

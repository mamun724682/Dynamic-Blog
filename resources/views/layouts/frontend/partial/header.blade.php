<header>
    <div class="container-fluid position-relative no-side-padding">

        {{-- <a href="#" class="logo"><img src="images/logo.png" alt="Logo Image"></a> --}}
        <a href="/" class="logo">Blog</a>

        <div class="menu-nav-icon" data-nav-menu="#main-menu"><i class="ion-navicon"></i></div>

        <ul class="main-menu visible-on-click" id="main-menu">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('posts') }}">Posts</a></li>
            <li><a href="#">Features</a></li>
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @else
                @if (Auth::user()->role->id == 1)
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                @else
                    <li><a href="{{ route('author.dashboard') }}">Dashboard</a></li>
                @endif
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    Sign Out
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                    </form>
                </li>
            @endguest
        </ul><!-- main-menu -->

        <div class="src-area">
            <form method="GET" action="{{ route('search') }}">
                <button class="src-btn" type="submit"><i class="ion-ios-search-strong"></i></button>
                <input class="src-input" name="query" value="{{ isset($query) ? $query : '' }}" type="text" placeholder="Type of search">
            </form>
        </div>

    </div><!-- conatiner -->
</header>
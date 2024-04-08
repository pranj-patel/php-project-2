<header class="header">
    <nav class="navbar">
        <div class="logo">
            <a href="{{ Asset('/') }}">WIL Allocation</a>
        </div>

        @php
            $user = \Auth::user();
        @endphp
        @if($user)
        <span class="username">Welcome <b>{{ $user->username }}</b> ({{ ucwords($user->user_type) }})</span>
        @endif
        <ul class="nav-list">
            <li><a class="@yield('home_status')"  href="{{ Asset('/') }}">Home</a></li>
        @if($user)            

            @if($user->user_type == 'student')
            <li><a class="@yield('profile_status')" href="{{ Asset('student-profile').'/'.$user->id }}">Profile</a></li>
            @endif
            <li><a class="@yield('list_status')" href="{{ Asset('project-list') }}">Project List</a></li>
           <li><a href="{{ Asset('logout') }}">Logout</a></li>
        @else
            <li><a class="@yield('login_status')" href="{{ Asset('login') }}">Login</a></li>
            <li><a class="@yield('register_status')" href="{{ Asset('register') }}">Register</a></li>
        @endif

        </ul>
    </nav>
</header>
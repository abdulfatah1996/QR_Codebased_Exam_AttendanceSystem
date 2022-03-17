<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Attendance Recording | @yield('title')</title>



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!--fontawesome-->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="{{ asset('assets/js/instascan.min.js')}}"></script>
    <!--toastr-->
    <link rel="stylesheet" href="{{ asset('assets/toastr/toastr.min.css') }}" />

    <!--sweetalert2-->
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}" />
    @yield('styles')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <span class="me-2 text-primary"><i class="fa-solid fa-qrcode"></i></span>
                    Attendance Recording
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link  @yield('activeProfile')"
                                    href="{{ route('profile.index') }}">{{ __('My Profile') }}</a>
                            </li>
                            @if (Auth::user()->role == 'Administrator')
                                <li class="nav-item">
                                    <a class="nav-link  @yield('activeUsers')"
                                        href="{{ route('users.index') }}">{{ __('Users') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  @yield('activeHalls')"
                                        href="{{ route('halls.index') }}">{{ __('Halls') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  @yield('activeCourses')"
                                        href="{{ route('courses.index') }}">{{ __('Courses') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  @yield('activeStudents')"
                                        href="{{ route('students.index') }}">{{ __('Students') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  @yield('activeColleges')"
                                        href="{{ route('colleges.index') }}">{{ __('Colleges') }}</a>
                                </li>
                            @endif
                            @if (Auth::user()->role == 'Teacher')
                                <li class="nav-item">
                                    <a class="nav-link  @yield('activeStudentExam')"
                                        href="{{ route('studentExam.index') }}">{{ __('Exams Table') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  @yield('activeExams')"
                                        href="{{ route('exams.index') }}">{{ __('Exams') }}
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu  dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item text-danger"
                                            type="submit">{{ __('Logout') }}</button>
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <!--scripts-->
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!--jquery-->
    <script src="{{ asset('assets/js/jquery-3.6.0.js') }}"></script>
    <!--fontawesome-->
    <script src="{{ asset('assets/fontawesome/js/all.min.js') }}"></script>
    <script src="{{ asset('assets/toastr/toastr.min.js') }}"></script>
    <!--sweetalert2-->
    <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/tableToexcel/dist/tableToExcel.js') }}"></script>
    @yield('scripts')
</body>

</html>

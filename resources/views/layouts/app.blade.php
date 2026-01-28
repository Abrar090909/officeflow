<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>OfficeFlow - Task Management System</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' fill='%230d6efd'/%3E%3Ctext x='50' y='70' font-size='60' font-family='Arial, sans-serif' font-weight='bold' fill='white' text-anchor='middle'%3EO%3C/text%3E%3C/svg%3E">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar { background-color: #ffffff; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); margin-bottom: 20px; }
        .task-status { font-weight: bold; }
        .status-Pending { color: #ffc107; }
        .status-In-Review { color: #17a2b8; }
        .status-Completed { color: #28a745; }
        .status-Approved { color: #007bff; }
        .status-Rejected { color: #dc3545; }
        #flash-message { position: fixed; top: 20px; right: 20px; z-index: 1050; display: none; }
    </style>
</head>
<body>
    <div id="flash-message" class="alert"></div>

    <nav class="navbar navbar-expand-lg navbar-light mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">OfficeFlow</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="#">{{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        @yield('content')
        @yield('activity_feed')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showMessage(message, type = 'success') {
            $('#flash-message').text(message).removeClass('alert-success alert-danger').addClass('alert-' + type).fadeIn();
            setTimeout(function() { $('#flash-message').fadeOut(); }, 3000);
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Student Events' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('events.index') }}">
            Student Events
        </a>

        <div>
            <a class="btn btn-outline-light btn-sm" href="{{ route('events.index') }}">
                Events
            </a>

            @auth
                <a class="btn btn-outline-light btn-sm" href="{{ route('events.create') }}">
                    Create Event
                </a>

                @if (auth()->user()->isAdmin())
                    <a class="btn btn-warning btn-sm" href="{{ route('categories.index') }}">
                        Manage Categories
                    </a>
                @endif

                <span class="text-white ms-2">
                    {{ auth()->user()->name }} ({{ auth()->user()->role }})
                </span>

                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm">
                        Logout
                    </button>
                </form>
            @else
                <a class="btn btn-outline-light btn-sm" href="{{ route('login') }}">
                    Login
                </a>

                <a class="btn btn-success btn-sm" href="{{ route('register') }}">
                    Register
                </a>
            @endauth
        </div>
    </div>
</nav>

<main class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{ $slot }}
</main>

</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'DevBossMail') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #1a1a2e;
            /* Dark Purple Theme */
            color: #e0e0e0;
        }

        .bg-card {
            background-color: #16213e;
        }

        .btn-primary {
            background-color: #0f3460;
            color: white;
        }

        .btn-primary:hover {
            background-color: #e94560;
        }
    </style>
</head>

<body class="antialiased">
    <div class="min-h-screen flex flex-col">
        <nav class="bg-card p-4 shadow-md">
            <div class="container mx-auto flex justify-between items-center">
                <a href="{{ url('/') }}" class="text-xl font-bold text-white">DevBossMail</a>
                <div>
                    @if(Auth::guard('admin')->check())
                        <span class="mr-4">Admin</span>
                        <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-gray-300 hover:text-white">Logout</button>
                        </form>
                    @elseif(Auth::guard('web')->check())
                        <span class="mr-4">{{ Auth::user()->name }}</span>
                        <form action="{{ route('user.logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-gray-300 hover:text-white">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('user.login') }}" class="text-sm text-gray-300 hover:text-white mr-4">Login</a>
                        <a href="{{ route('admin.login') }}" class="text-sm text-gray-300 hover:text-white">Admin Login</a>
                    @endif
                </div>
            </div>
        </nav>

        <main class="flex-grow container mx-auto p-4">
            @yield('content')
        </main>

        <footer class="bg-card p-4 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} DevBossPanel
        </footer>
    </div>
</body>

</html>
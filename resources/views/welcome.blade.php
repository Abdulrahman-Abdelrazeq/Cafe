<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cafeteria</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: url('https://images.unsplash.com/photo-1542181961-9590d0c79dab?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            text-align: center;
            background: rgba(255, 255, 255, 0.6);
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        h1 {
            font-size: 3rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 1rem;
        }

        p {
            font-size: 1.25rem;
            line-height: 1.5;
            color: #4a5568;
            margin-bottom: 2rem;
        }

        .actions {
            margin-top: 2rem;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            color: #fff;
            background-color: #f56565;
            border-radius: 0.375rem;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #e53e3e;
        }

        .selection\:bg-red-500 *::selection {
            --tw-bg-opacity: 1;
            background-color: #f56565;
        }

        .selection\:text-white *::selection {
            --tw-text-opacity: 1;
            color: #fff;
        }

        .selection\:bg-red-500::selection {
            --tw-bg-opacity: 1;
            background-color: #f56565;
        }

        .selection\:text-white::selection {
            --tw-text-opacity: 1;
            color: #fff;
        }
    </style>
</head>
<body class="antialiased">
    <div class="container">
        @if (Route::has('login'))
            <div class="p-6 text-right">
                @auth
                    <a href="{{ url('/home') }}" class="btn focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 btn focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <h1>Welcome to Our Cafe Website</h1>
        <p>Start ordering now</p>
        <div class="actions">
            <!-- Add any additional actions or buttons here -->
        </div>
    </div>
</body>
</html>

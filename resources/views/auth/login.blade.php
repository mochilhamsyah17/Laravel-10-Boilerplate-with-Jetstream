<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f3f4f6;
            font-family: Arial, sans-serif;
        }

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            padding: 2rem;
        }

        .logo {
            width: 40vh;
            height: 5vh;
            object-fit: cover;
            display: block;
            margin-bottom: 2rem;
        }

        .logo img {
            max-width: 150px;
        }

        .title {
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: #4b5563;
            margin-bottom: 1rem;
        }

        .input-group {
            display: flex;
            flex-direction: column;
        }

        .input-group label {
            font-weight: bold;
            color: #4b5563;
        }

        .input-group input {
            padding: 0.5rem;
            border: 1px solid #1d4ed8;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .checkbox {
            display: flex;
            align-items: center;
            justify-items: center;
            gap: 4px;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
        }

        .btn {
            background-color: #2563eb;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #1d4ed8;
        }

        .forgot-password {
            font-size: 12px;
            color: #4b5563;
            text-decoration: none;
        }

        .forgot-password:hover {
            color: #1d4ed8;
        }

        .section {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        .remember-me {
            font-size: 12px;
            color: #4b5563;
        }

        .errors {
            color: red;
            font-size: 12px;
            list-style: none;
            text-decoration: none;
            list-style-type: none;
        }
    </style>
</head>

<body>
    <section class="section">
        <div class="">
        </div>
        <div class="card">
            @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                </div>
                <div class="checkbox">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me" class="remember-me">Remember me</label>
                </div>
                <div class="actions">
                    @if (Route::has('password.request'))
                    <a class="forgot-password" href="{{ route('password.request') }}">Forgot your password?</a>
                    @endif
                    <button type="submit" class="btn">Login</button>
                </div>
            </form>
        </div>
    </section>
</body>

</html>
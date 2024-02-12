<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
    @import url('/css/app.css');
</style>

<div class="login-page">

    <body>
        <form class="login-form" method="POST" action="{{ route('login') }}">
            @csrf
            <h2 style="text-align: center;color:rgb(2,17,79)">Recon Login</h2>

            @if ($errors->any())
            <div style="color: red; text-align: center;">
                @foreach ($errors->all() as $error)
                {{ $error }}<br>
                @endforeach
            </div>
            @endif

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <div style="text-align: center;">
            <button class="login-button" type="submit">Login</button>
            </div>
        </form>
    </body>
</div>

</html>
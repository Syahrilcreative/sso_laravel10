<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSO Login</title>
</head>

<body>
    <h1>Login via SSO</h1>

    @if ($errors->any())
        <div>
            <strong>Error:</strong> {{ $errors->first('error') }}
        </div>
    @endif

    <form action="{{ url('/login') }}" method="POST">
        @csrf
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>
    <h1>Welcome, {{ $user['name'] }}</h1>

    <p>Email: {{ $user['email'] }}</p>
    <a href="http://127.0.0.1:9000/dashboard?token={{ session('token') }}">Go to Client 2</a>
    <br><br>
    <a href="{{ url('/logout') }}">Logout</a>
</body>

</html>

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
    <a href="{{ url('/logout') }}">Logout</a>
</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
</head>
<body>
    <p>{{ $employeeName }}</p>
    @foreach($managers as $m)
        <p>{{ $m['name'] }}</p>
    @endforeach
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
{{-- this is a comment --}}
<body>
    <h1> <h1>Contact details </h1> </h1>
    <div>
        <a href='{{route('admin.contacts.index')}}'>Back </a>
    </div>
    <div>
        <p>Name: {{ $contact['name']}} </p>
        <p>Phone: {{ $contact['phone']}} </p>
    </div>
</body>
</html>
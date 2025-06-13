<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>pdf</title>
</head>
<body>
    <h2>Book List</h2>
    <table border="1" width="100%" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>Book ID</th>
                <th>Cover Image</th>
                <th>Title</th>
                <th>Language</th>
                <th>Price</th>
                <th>Country</th>
                <th>State</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                <td>{{ $book->book_id }}</td>
                <td><img src="{{ public_path('/storage/images/'.$book->book_cover) }}" width="50" height="50"></td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->language }}</td>
                <td>{{ $book->price }}</td>
                <td>{{ $book->country->name }}</td>
                <td>{{ $book->state->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>

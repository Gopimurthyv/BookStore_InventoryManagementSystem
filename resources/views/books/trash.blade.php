@extends('layout.layout')
@section('title', 'trash')
@section('heading','Deleted Books')

@section('table')
    <div class="table-responsive card shadow-lg">
        <table class="table table-borderd">
            <thead class="table-dark">
                <tr>
                    <th>Book ID</th>
                    <th>Cover</th>
                    <th>Title</th>
                    <th>ISBN</th>
                    <th>Price</th>
                    <th>Categories</th>
                    <th>Total Stock</th>
                    <th>Authors</th>
                    <th>Supplier</th>
                    <th>Deleted At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($trashedBooks as $book)
                    <tr>
                        <td>{{ $book->book_id }}</td>
                        <td><img src="{{ asset('storage/images/'.$book->book_cover) }}" width="50" height="50"></td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->isbn }}</td>
                        <td>₹{{ $book->price }}</td>
                        <td>
                            @foreach (json_decode($book->categories) as $category)
                                <span class="badge bg-info">{{ $category }}</span>
                            @endforeach
                        </td>
                        <td>{{ $book->stocks->sum('quantity') }}</td>
                        <td>
                            @foreach($book->authors as $author)
                                <div>{{ $author->name }}({{ $author->email }})</div>
                            @endforeach
                        </td>
                        <td>{{ $book->supplier->name ?? 'N/A' }}</td>
                        <td>{{ $book->deleted_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('books.restore',$book->id) }}" class="btn btn-sm btn-warning">Restore</a>
                            <a href="{{ route('books.delete',$book->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete?');">Delete Permanently</a>
                        </td>
                    </tr>
                @empty
                    <tr><td class="text-center" colspan="10">No Books Found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-3">
        {{ $trashedBooks->links() }}
    </div>
@endsection

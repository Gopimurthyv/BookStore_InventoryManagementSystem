@forelse ($books as $book)
    <tr>
        <td>{{ $book->book_id }}</td>
        <td><img src="{{ asset('storage/images/'.$book->book_cover) }}" width="50" height="50"></td>
        <td>{{ $book->title }}</td>
        <td>{{ $book->isbn }}</td>
        <td>₹{{ $book->price }}</td>
        <td>{{ $book->published_date }}</td>
        <td>{{ $book->language }}</td>
        <td>
            @foreach (json_decode($book->categories) as $category)
                <span class="badge bg-info">{{ $category }}</span>
            @endforeach
        </td>
        <td>{{ $book->stocks->sum('quantity') }}</td>
        <td>{{ $book->country->name }}</td>
        <td>{{ $book->state->name }}</td>
        <td>{{ $book->authors->pluck('name')->implode(', ') }}</td>
        <td>{{ $book->supplier->name ?? 'N/A' }}</td>
        <td >
            <div class="d-flex gap-2">
                <a href="{{ route('books.edit',$book->id) }}" class="btn btn-sm "><img src="{{ asset('document-edit_114472.ico') }}" width="35"></a>
                <a href="{{ route('books.destroy',$book->id) }}" class="btn  btn-sm" onclick="return confirm('Are you sure you want to delete?');"><img src="{{ asset('delete.png') }}" width="35"></a>
            </div>
        </td>
    </tr>
@empty
    <tr><td class="text-center" colspan="10">No Books Found.</td></tr>
@endforelse

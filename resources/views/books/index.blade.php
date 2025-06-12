@extends('layout.layout')
@section('title', 'index')
@section('heading','Book List')

@section('table')
    <div>
        <form method="GET" class="mb-4">
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    <select name="category" id="categoryFilter" class="form-select">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" {{ $categoryFilter == $category ? 'selected' :'' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary">Filter</button>
                    <a href="{{ route('books.export.excel') }}" class="btn btn-warning fw-bold">Export to Excel <img src="{{ asset('excel.png') }}" width="25"></a>
                    <a href="{{ route('books.export.pdf') }}" class="btn btn-success fw-bold ">Download PDF <img src="{{ asset('arrow.png') }}" width="15"></a>
                </div>
                <div class="col-end text-end">
                    <a href="{{ route('books.create') }}" class="btn btn-success btn-sm">Add Books</a>
                </div>
            </div>
        </form>
        <table class="table table-borderd">
            <thead class="table-dark">
                <tr class="text-center">
                    <th class="border-end">Book ID</th>
                    <th class="border-end">Cover</th>
                    <th class="border-end">Title</th>
                    <th class="border-end">ISBN</th>
                    <th class="border-end">Price</th>
                    <th class="border-end">Published Date</th>
                    <th class="border-end">Language</th>
                    <th class="border-end">Categories</th>
                    <th class="border-end">Total Stock</th>
                    <th class="border-end">Country</th>
                    <th class="border-end">State</th>
                    <th class="border-end">Authors</th>
                    <th class="border-end">Supplier</th>
                    <th class="border-end">Actions</th>
                </tr>
            </thead>
            <tbody>
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
                        <td>
                            @foreach($book->authors as $author)
                                <div>{{ $author->name }}({{ $author->email }})</div>
                            @endforeach
                        </td>
                        <td>{{ $book->supplier->name ?? 'N/A' }}</td>
                        <td class="d-flex gap-2">
                            <a href="{{ route('books.edit',$book->id) }}" class="btn btn-sm "><img src="{{ asset('document-edit_114472.ico') }}" width="35"></a>
                            <a href="{{ route('books.destroy',$book->id) }}" class="btn  btn-sm" onclick="return confirm('Are you sure you want to delete?');"><img src="{{ asset('delete.png') }}" width="35"></a>
                        </td>
                    </tr>
                @empty
                    <tr><td class="text-center" colspan="10">No Books Found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

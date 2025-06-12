@extends('layout.form')
@section('title','Update Form')
@section('heading', 'Update Book')

@section('content')
    <div class="card-body">
        <form action="{{ route('books.update',$book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Book ID</label>
                <input type="text" name="book_id" value="{{ $book->book_id }}" class="form-control" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Title</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title',$book->title) }}">
                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">ISBN</label>
                <input type="text" name="isbn" class="form-control @error('isbn') is-invalid @enderror" value="{{ old('isbn',$book->isbn) }}" maxlength="13">
                @error('isbn')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Book Cover</label>
                <img src="{{ asset('storage/images/'.$book->book_cover) }}" width="50" height="50">
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                @error('image')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Price</label>
                <input type="number" name="price" step="1" class="form-control @error('price') is-invalid @enderror" value="{{ old('price',$book->price) }}">
                @error('price')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Published Date</label>
                <input type="date" name="published_date" class="form-control @error('published_date') is-invalid @enderror" value="{{ old('published_date',$book->published_date) }}">
                @error('published_date')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Language</label>
                <select name="language" id="language" class="form-select @error('language') is-invalid @enderror">
                    <option value="">--SELECT LANGUAGE--</option>
                    @foreach (['English','Tamil','Hindi','Malayalam'] as $lang)
                        <option value="{{ $lang }}" {{ old('language',$book->language) == $lang ? 'selected' :'' }}>{{ $lang }}</option>
                    @endforeach
                </select>
                @error('language')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Categories</label>
                @foreach ($categories as $category)
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="categories[]" class="form-check-input" value="{{ $category }}" {{ in_array($category,json_decode($book->categories)) ? 'checked' :'' }}>
                        <label class="form-check-label">{{ $category }}</label>
                    </div>
                @endforeach
                @error('categories')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Country</label>
                <select name="country" id="country" class="form-select @error('country') is-invalid @enderror">
                    <option value="">--SELECT COUNTRY--</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}" {{ old('country',$book->country_id)==$country->id ? 'selected' : ''  }}>{{ $country->name }}</option>
                    @endforeach
                </select>
                @error('country')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">State</label>
                <select name="state" id="state" class="form-select @error('state') is-invalid @enderror" disabled>
                    <option value="">--SELECT STATE--</option>
                </select>
            </div>
            <hr>
            <div class="mb-3">
                <label class="form-label fw-bold">Authors</label>
                <div id="authors">
                    @php
                        $oldAuthors = old('authors',$book->authors->toArray());
                    @endphp

                    @foreach ($oldAuthors as $index=>$author)
                        <div class="row mb-2 author-row">
                            <div class="col">
                                <input type="text" name="authors[{{ $index }}][name]" class="form-control @error("authors.$index.name") is-invalid @enderror" placeholder="Name" value="{{ old("authors.$index.name",$author['name']) }}" required>
                            </div>
                            <div class="col">
                                <input type="email" name="authors[{{ $index }}][email]" class="form-control @error("authors.$index.email") is-invalid @enderror" value="{{ old("authors.$index.email",$author['email']) }}" placeholder="Email" required>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-danger removeAuthor ">Remove</button>
                            </div>
                        </div>
                    @endforeach

                </div>
                <button class="btn btn-sm btn-secondary" type="button" id="addAuthor">Add Author</button>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Supplier</label>
                <select name="supplier_id" id="supplier" class="form-select @error('supplier_id') is-invalid @enderror">
                    <option value="">--SELECT SUPPLIER--</option>
                    @foreach ($suppliers as $sup)
                        <option value="{{ $sup->id }}" {{ old('supplier_id',$book->supplier_id) == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
                    @endforeach
                </select>
                @error('supplier_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <hr>
            <div class="mb-3">
                <lable class="form-label fw-bold">Stock Details</lable>
                <table class="table table-bordered" id="stock_detail">
                    <thead class="table-dark">
                        <tr>
                            <th>Location</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $oldStocks = old('stocks',$book->stocks->map(function($s){
                                return ['location' => $s->store_location, 'quantity' => $s->quantity];
                            })->toArray());
                        @endphp

                        @foreach ($oldStocks as $index=>$stock)
                            <tr>
                                <td>
                                    <input type="text"
                                        name="stocks[{{ $index }}][location]"
                                        class="form-control @error("stocks.$index.location") is-invalid @enderror"
                                        value="{{ old("stocks.$index.location", $stock['location'] ?? '') }}">
                                </td>
                                <td>
                                    <input type="number"
                                        class="form-control @error("stocks.$index.quantity") is-invalid @enderror"
                                        name="stocks[{{ $index }}][quantity]"
                                        value="{{ old("stocks.$index.quantity", $stock['quantity'] ?? '') }}">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger removeStock">Remove</button>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="text-end">
                    <button id="addStock" class="btn btn-secondary btn-sm" type="button">Add Stock</button>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
        <script>
            let authorCount = 1;
            let stockCount = 1;

            $('#addAuthor').click(function(){
                if(authorCount < 3){
                    $('#authors').append(`
                        <div class="row mb-2 author-row">
                            <div class="col">
                                <input type="text" name="authors[${authorCount}][name]" class="form-control" placeholder="Name" required>
                            </div>
                            <div class="col">
                                <input type="email" name="authors[${authorCount}][email]" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-danger removeAuthor">Remove</button>
                            </div>
                        </div>
                    `);
                    $('.removeAuthor').removeClass('d-none');
                    authorCount++;
                }
            });

            $('#authors').on('click','.removeAuthor',function(){
                $(this).closest('.author-row').remove();
                authorCount--;
            });

            $('#addStock').click(function(){
                if(stockCount < 3){
                    $('#stock_detail tbody').append(`
                        <tr>
                            <td><input type="text" name="stocks[${stockCount}][location]" class="form-control"></td>
                            <td><input type="number" name="stocks[${stockCount}][quantity]" class="form-control"></td>
                            <td><button type="button" class="btn btn-danger removeStock">Remove</button></td>
                        </tr>
                    `);
                    $('.removeStock').removeClass('d-none');
                    stockCount++;
                } else {
                    alert("Maximum 3 Stock Entries Allowed");
                }
            });

            $(document).on('click','.removeStock',function(){
                $(this).closest('tr').remove();
                stockCount--;
            });

            // Country -> State AJAX
            $(document).ready(function(){

                let state = $('#state');
                let selectedCountryId = "{{ $book->country_id }}";
                let selectedStateId = "{{ $book->state_id }}";

                function loadStates(countryId,selectedStateId){
                    state.prop('disabled',true).html('<option value="">--Loading--</option>')

                    if(countryId){
                        $.ajax({
                            url: '/get-states/' + countryId,
                            type: 'GET',
                            success: function(states){
                                let options = "<option value=''>--SELECT STATE--</option>";
                                $.each(states, function(index, state){
                                    let selected = (state.id == selectedStateId) ? 'selected' :'';
                                    options += "<option value='" + state.id +"'"+selected+ ">" + state.name + "</option>";
                                });
                                state.prop('disabled', false).html(options);
                            },
                            error: function(){
                                state.html("<option value=''>--ERROR LOADING STATES--</option>");
                            }
                        });
                    } else {
                        state.prop('disabled', true).html('<option value="">--SELECT STATE--</option>');
                    }
                }

                if(selectedCountryId){
                    loadStates(selectedCountryId,selectedStateId);
                }

                $('#country').on('change',function(){
                    let country = $(this).val();
                    loadStates(country);
                });
            });

    </script>
@endpush

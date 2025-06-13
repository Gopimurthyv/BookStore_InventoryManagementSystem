<?php

namespace App\Http\Controllers;

use App\Exports\BookExport;
use App\Models\Book;
use App\Models\BookAuthors;
use App\Models\Category;
use App\Models\Country;
use App\Models\State;
use App\Models\StockDetails;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class BookController extends Controller
{
    public function index(Request $request){

        $categoryFilter = $request->get('category');

        $books = Book::with(['authors','stocks','supplier'])
                ->when($categoryFilter,function($query,$categoryFilter){
                    return $query->whereJsonContains('category', $categoryFilter);
                })
                ->whereNull('deleted_at')
                ->paginate(5)
                ->appends($request->all());

        $categories = Category::pluck('name');

        return view('books.index',compact('books','categories','categoryFilter'));
    }

    public function create(){

        $categories = Category::all();
        $suppliers = Supplier::all();
        $countries = Country::all();
        return view('books.create',compact('categories','suppliers','countries'));
    }
    public function store(Request $request){

        $request->validate([
            'title'=> 'required|string',
            'isbn'=> 'required|digits:13|unique:books,isbn',
            'image'=> 'required|image|mimes:jpg,png|max:350',
            'price'=> 'required|integer',
            'published_date'=> 'nullable|date',
            'language'=> 'required|in:English,Tamil,Hindi,Malayalam',
            'categories'=> 'required|array|min:1',
            'country'=> 'required',
            'state'=> 'required',
            'supplier_id'=> 'required',
            'authors'=> 'required|array|min:1|max:3',
            'authors.*.name'=> 'required|string',
            'authors.*.email'=> 'required|email',
            'stocks'=> 'required|array|min:1|max:3',
            'stocks.*.location'=> 'required|string',
            'stocks.*.quantity'=> 'required|integer|min:1',
        ]);

        $bookId = rand(100000, 999999);
        while(Book::where('book_id',$bookId)->exists()){
            $bookId = rand(100000,999999);
        }

        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time().'.'.$image->extension();
            $image->storeAs('images/', $filename,'public');
        }

        $book = Book::create([
            'book_id'=> $bookId,
            'title'=> $request->title,
            'isbn'=> $request->isbn,
            'book_cover'=> $filename,
            'price'=> $request->price,
            'published_date'=> $request->published_date,
            'language'=> $request->language,
            'categories'=> json_encode($request->categories),
            'country_id'=> $request->country,
            'state_id'=> $request->state,
            'supplier_id'=> $request->supplier_id,
        ]);

        foreach($request->authors as $author){
            BookAuthors::create([
                'book_id'=> $book->id,
                'name'=> $author['name'],
                'email'=> $author['email'],
            ]);
        }

        foreach($request->stocks as $stock){
            StockDetails::create([
                'book_id'=> $book->id,
                'store_location'=> $stock['location'],
                'quantity'=> $stock['quantity'],
            ]);
        }

        return redirect()->route('books.index')->with('success','Book Added Successfully!..');
    }
    public function edit($id){
        $book = Book::with(['authors','stocks'])->findOrFail($id);
        $suppliers = Supplier::all();
        $categories = Category::pluck('name');
        $countries = Country::all();
        return view('books.edit', compact('book','suppliers','categories','countries'));
    }

    public function update(Request $request, $id){

        $request->validate([
            'title'=> 'required|string',
            'isbn'=> 'required|digits:13|unique:books,isbn'.$id,
            'image'=> 'required|image|mimes:jpg,png|max:350',
            'price'=> 'required|integer',
            'published_date'=> 'nullable|date',
            'language'=> 'required|in:English,Tamil,Hindi,Malayalam',
            'categories'=> 'required|array|min:1',
            'country'=> 'required',
            'state'=> 'required',
            'supplier_id'=> 'required',
            'authors'=> 'required|array|min:1|max:3',
            'authors.*.name'=> 'required|string',
            'authors.*.email'=> 'required|email',
            'stocks'=> 'required|array|min:1|max:3',
            'stocks.*.location'=> 'required|string',
            'stocks.*.quantity'=> 'required|integer|min:1',
        ]);

        $book = Book::findOrFail($id);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time() .'.'. $file->extension();
            $file->storeAs('images/', $filename,'public');
            $book->image = $filename;
        }

        $book->update([
            'title'=> $request->title,
            'isbn'=>$request->isbn,
            'price'=> $request->price,
            'published_date'=> $request->published_date,
            'language'=> $request->language,
            'categories'=> json_encode($request->categories),
            'country_id'=>$request->country,
            'state_id'=> $request->state,
            'supplier_id'=> $request->supplier_id,
            'book_cover'=> $book->image,
        ]);

        BookAuthors::where('book_id', $book->id)->delete();
        foreach($request->authors as $author){
            BookAuthors::create([
                'book_id'=> $book->id,
                'name'=> $author['name'],
                'email'=> $author['email'],
            ]);
        }

        StockDetails::where('book_id',$book->id)->delete();
        foreach($request->stocks as $stock){
            StockDetails::create([
                'book_id'=> $book->id,
                'store_location'=> $stock['location'],
                'quantity'=> $stock['quantity'],
            ]);
        }

        return redirect()->route('books.index')->with('success','Book Updated Successfully');
    }

    public function destroy($id){
        $book = Book::findOrFail($id);

        if(File::exists(public_path('storage/images/'.$book->image))){
            File::delete(public_path('storage/images/'.$book->image));
        }

        $book->delete();
        return redirect()->route('books.index')->with('success','Book Deleted Successfully');
    }

    public function getStates($country){
        $states = State::where('country_id', $country)->get();
        return response()->json($states);
    }

//soft deletes....
    public function trash(){
        $trashedBooks = Book::onlyTrashed()->paginate(10);
        return view('books.trash', compact('trashedBooks'));
    }

    public function restore($id){
        $book = Book::onlyTrashed()->findOrFail($id);
        $book->restore();
        return redirect()->route('books.trash')->with('success','Books Restored Successfully!..');
    }

    public function forceDelete($id){
        $book = Book::onlyTrashed()->findOrFail($id);
        $book->forceDelete();
        return redirect()->route('books.trash')->with('success','Books Deleted Permanently..');
    }

// Export to Excel ...
    public function exportExcel(){
        return Excel::download(new BookExport,'books.xlsx');
    }
// Download PDF
    public function exportPdf(){
        $books = Book::all();
        $pdf = Pdf::loadView('books.pdf',compact('books'));
        return $pdf->download('books_list.pdf');
    }

// Ajax Search/Filter
    public function bookCategory(Request $request){
        $query = Book::with(['authors','supplier','stocks','country','state'])->whereNull('deleted_at');

        if($request->filled('category')){
            $query->where('categories', 'like', '%'.$request->category.'%');
        }

        $books = $query->latest()->get();

        return view('books.book-list', compact('books'))->render();
    }

    public function bookSearch(Request $request){
        $query = $request->search;
        $books = Book::with(['authors','supplier'])
                    ->where('title','like',"%{$query}%")
                    ->orWhereHas("authors",function($a) use ($query){
                        $a->where('name',"like","%{$query}%");
                    })
                    ->orWhereHas("supplier",function($s) use ($query){
                        $s->where('name',"like","%{$query}%");
                    })
                    ->get();

        return view('books.book-searchTable', compact('books'))->render();
    }
}

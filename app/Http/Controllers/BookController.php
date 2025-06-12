<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookAuthors;
use App\Models\Category;
use App\Models\Country;
use App\Models\State;
use App\Models\StockDetails;
use App\Models\Supplier;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request){

        $categoryFilter = $request->get('category');

        $books = Book::with(['authors','stocks','supplier'])
                ->where($categoryFilter,function($query,$categoryFilter){
                    return $query->whereJsonContains('category', $categoryFilter);
                })
                ->whereNull('deleted_at')
                ->get();

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
            'isbn'=> 'required|digit:13|unique:books,isbn',
            'image'=> 'required|image|mimes:jpg,png|max:350',
            'price'=> 'required|numeric',
            'published_date'=> 'nullable|date',
            'language'=> 'required|in:English,Tamil,Hindi,Malayalam',
            'categories'=> 'required|array|min:1',
            'country'=> 'required',
            'state'=> 'required',
            'supplier_id'=> 'required|exists:suppliers,id',
            'authors'=> 'required|array|min:1|max:3',
            'authors.*.name'=> 'required|string',
            'authors.*.email'=> 'required|email',
            'stocks'=> 'required|array|min:1|max:3',
            'stocks.*.location'=> 'required|string',
            'stocks.*.quantity'=> 'required|integer|min:1',
        ]);

        $bookId = rand(100000, 999999);
        while(Book::where('book_id',$bookId)->exist()){
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
    public function edit($id){}
    public function update(Request $request){}
    public function destroy($id){}

    public function getStates($country){
        $states = State::where('country_id', $country)->get();
        return response()->json($states);
    }
}

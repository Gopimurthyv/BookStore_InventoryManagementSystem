<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/books')->group(function(){
    Route::get('/',[BookController::class,'index'])->name('books.index');
    Route::get('/create',[BookController::class,'create'])->name('books.create');
    Route::post('/',[BookController::class,'store'])->name('books.store');
    Route::get('/edit/{id}',[BookController::class,'edit'])->name('books.edit');
    Route::post('/edit/{id}',[BookController::class,'update'])->name('books.update');
    Route::get('/delete/{id}',[BookController::class,'destroy'])->name('books.destroy');
    Route::get('/trash',[BookController::class,'trash'])->name('books.trash');
    Route::post('/restore/{id}',[BookController::class,'restore'])->name('books.restore');
    Route::get('/permanent-delete/{id}',[BookController::class,'forceDelete'])->name('books.delete');

    Route::get('/export-excel',[BookController::class,'exportExcel'])->name('books.export.excel');
    Route::get('/export-pdf',[BookController::class,'exportPdf'])->name('books.export.pdf');

    Route::get('/list', [BookController::class, 'bookCategory'])->name('books.category.filter');
    Route::get('/search',[BookController::class,'bookSearch'])->name('books.search');

});

Route::get('/get-states/{country}',[BookController::class,'getStates'])->name('books.getStates');


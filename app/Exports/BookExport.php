<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Book::with(['authors', 'stocks', 'supplier', 'country', 'state'])->get();
    }
    public function headings(): array
    {
        return [
            'Book ID',
            'Title',
            'ISBN',
            'Categories',
            'Price',
            'Published Date',
            'Language',
            'Authors',
            'Total Stock',
            'Country',
            'State',
            'Supplier'
        ];
    }
    public function map($book): array
    {
        return [
            $book->book_id,
            $book->title,
            $book->isbn,
            implode(', ', json_decode($book->categories ?? '[]')),
            $book->price,
            $book->published_date,
            $book->language,
            $book->authors->map(fn($a) => $a->name . ' (' . $a->email . ')')->implode(', '),
            $book->stocks->sum('quantity'),
            $book->country->name ?? '',
            $book->state->name ?? '',
            $book->supplier->name ?? 'N/A',
        ];
    }
}

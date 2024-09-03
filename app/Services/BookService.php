<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use App\Models\Book;
use App\Traits\apiResponseTrait;
use Illuminate\Support\Facades\Log;

class BookService{

    use apiResponseTrait;
    public function getAllBook(array $data)
    {
        $query = Book::where('availability_of_book','available')->withAvg('ratings', 'rating');
        //filter with author
        if (isset($data['author'])) {
            $query->where('author', $data['author']);
        }
        $books = $query->get();
        $books = $books->map(function ($book) {
            $book->ratings_avg_rating = (float) $book->ratings_avg_rating;
            return $book;
        });
        return $books;
    }

    public function addBook(array $data,Book $book)
    {
        $book = Book::create([
            'title'=>$data['title'],
            'author' =>$data['author'],
            //i put this steatment because when i put data in postman it confirmed to string so i use casting to avoid this problem
            'category_id'=>isset($data['category_id']) ? (int)$data['category_id'] : $book->category_id,
            'description'=>$data['description'],
            'published_at'=>isset($data['published_at']) ? Carbon::parse($data['published_at'])->format('Y-m-d') : $book->published_at ,
            'availability_of_book'=>$data['availability_of_book'] 
        ]);
        return $book;
    }

    public function oneBook(Book $book)
    {
        if ($book->availability_of_book !== 'available') {
           return new Exception('this book not available');
        }
        $book->load('ratings');
        $averageRating = $book->ratings->avg('rating');
        $book->ratings_avg_rating = (float) $averageRating;

        return $book;
    }

    public function updateBook(array $data , Book $book)
    {
        $updateBook = array_filter([
            'title'=>$data['title'] ?? $book->title,
            'author' =>$data['author'] ?? $book->author,
            //i put this steatment because when i put data in postman it confirmed to string so i use casting to avoid this problem
            'category_id'=>isset($data['category_id']) ? (int)$data['category_id'] : $book->category_id ,
            'description'=>$data['description'] ?? $book->description,
            'published_at'=>isset($data['published_at']) ? Carbon::parse($data['published_at'])->format('Y-m-d') : $book->published_at ,
            'availability_of_book'=>$data['availability_of_book'] ?? $book->availability_of_book,
        ]);
        $book->update($updateBook);
        return $book;
    }
    public function deleteBook(Book $book)
    {
        $book->delete();
        return $book;
    }
}
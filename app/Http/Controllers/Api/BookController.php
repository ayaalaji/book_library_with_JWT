<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\BookService;
use App\Traits\apiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;

class BookController extends Controller
{
    use apiResponseTrait;
    
    /**
     * Constructor to inject Book Service Class
     * @param \App\Services\BookService $bookService
     */
    protected $bookService;
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }
    /**
     * Display all Books in Database but the only available .
     * @param Request $request
     * @return /Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // retrieve the filtering data from the request 
        $data = $request->all();
        $books = $this->bookService->getAllBook($data);
        return $this->responseApi($books,'this is all books that available',200);
    }

    /**
     * Store a newly created Book.
     * @param StoreBookRequest  $request
     * @param Book  $book
     * @return /Illuminate\Http\JsonResponse
     */
    public function store(StoreBookRequest $request,Book $book)
    {
        $validatedData = $request->validated();
        $book = $this->bookService->addBook($validatedData,$book);
        return $this->responseApi($book,'you add book successfully',201);
    }

    /**
     * Display the specified Book.
     * @param Book $book
     * @return /Illuminate\Http\JsonResponse
     */
    public function show(Book $book)
    {
        $book = $this->bookService->oneBook($book);
        return $book;
    }

    /**
     * Update the specified book.
     * @param UpdateBookRequest $request 
     * @param Book $book
     * @return /Illuminate\Http\JsonResponse
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $validatedData = $request->validated();
        $book =$this->bookService->updateBook($validatedData,$book);
        return $this->responseApi($book,'you Updated Book Successfully',201);
    }

    /**
     * Remove the specified book.
     * @param Book $book
     * @return /Illuminate\Http\JsonResponse
     */
    public function destroy(Book $book)
    {
        if(auth()->user()->role !=='admin')
        {
            return response()->json([
                'message' => 'You are not authorized to delete this book'
            ], 403);
        }
        $bookDelete= $this->bookService->deleteBook($book);
        return $this->responseApi(null,null,204);
    }
}

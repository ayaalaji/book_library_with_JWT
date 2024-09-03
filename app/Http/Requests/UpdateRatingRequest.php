<?php

namespace App\Http\Requests;

use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRatingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role == 'member';
    }

    public function prepareForValidation(){
        $this->merge([
            'user_id' => auth()->user()->id,
        ]);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'book_id' =>'nullable|integer|exists:books,id',
            'rating' =>'nullable|integer|min:1|max:5'
        ];
    }

    public function FaildValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = $validator->errors()->all();
        $response = response()->json([
           'status' => 'error',
           'message' => 'There was an error with your submission. Please review the errors below:',
           'errors' => $errors
        ], 422);
        throw new HttpResponseException($response);

    }

    public function attributes()
    {
        //to translate book id to the name of this book
        $bookTitle = 'الكتاب غير موجود';
    
        if ($this->has('book_id')) {
            $bookId = $this->input('book_id');
            $book =Book::find($bookId);
            $bookTitle = $book ? $book->title : $bookTitle;
        }
        return [
            'book_id' =>$bookTitle ,
            'user_id' => auth()->user()->name,
            'rating' =>'تقييم الكتاب'
        ];
    }

    public function messages()
    {
        return [
            'integer' => 'حقل :attribute يجب أن يكون قيمة عددية.',
            'exists' => 'حقل :attribute يجب أن يكون موجوداً في جدول التصنيف.',
            'min' => 'حقل :attribute يجب أن يحتوي على الأقل :min حرفاً.',
            'max' => 'حقل :attribute لا يمكن أن يتجاوز :max حرفاً.',
        ];
    }
}

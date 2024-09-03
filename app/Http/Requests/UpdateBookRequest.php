<?php

namespace App\Http\Requests;


use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role == 'admin';
    }

    public function prepareForValidation(){
        $this->merge([
            'title' => ucwords($this->input('title')),
            'author' => ucwords($this->input('author')),
            'published_at' => $this->has('published_at') ? 
                Carbon::createFromFormat('d-m-Y', $this->input('published_at'))->format('Y-m-d') : null,
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
            'title' =>'nullable|string|min:5|max:100',
            'author' =>'nullable|string|min:3|max:100',
            'category_id' =>'nullable|integer|exists:Categories,id',
            'description' =>'nullable|string|min:10|max:255',
            'published_at' =>['nullable', 'date_format:Y-m-d'],
            'availability_of_book' =>'nullable|in:available,not_available',
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
        $categoryName = 'التصنيف غير موجود';
    
        if ($this->has('category_id')) {
            $categoryId = $this->input('category_id');
            $category =Category::find($categoryId);
            $categoryName = $category ? $category->name : $categoryName;
        }
        return [
            'title' =>'اسم الكتاب',
            'author' =>'اسم المؤالف',
            'category_id' =>$categoryName,
            'description' => 'وصف الكتاب',
            'published_at' => 'تاريخ النشر',
            'availability_of_book' =>'توافرية الكتاب'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'حقل :attribute هو حقل إجباري.',
            'string' => 'حقل :attribute يجب أن يكون قيمة نصية.',
            'integer' => 'حقل :attribute يجب أن يكون قيمة عددية.',
            'exists' => 'حقل :attribute يجب أن يكون موجوداً في جدول التصنيف.',
            'in' => 'حقل :attribute يجب أن يكون واحداً من القيم التالية: :values.',
            'min' => 'حقل :attribute يجب أن يحتوي على الأقل :min حرفاً.',
            'max' => 'حقل :attribute لا يمكن أن يتجاوز :max حرفاً.',
            'date_format' => 'حقل :attribute يجب أن يكون بتنسيق dd-mm-yyyy.',
            'published_at.date_format' => 'تاريخ النشر يجب أن يكون بتنسيق dd-mm-yyyy.',
        ];
    }
}

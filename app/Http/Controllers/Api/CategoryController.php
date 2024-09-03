<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\apiResponseTrait;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    use apiResponseTrait;

     /**
     * Constructor to inject Book Service Class
     * @param \App\Services\CategoryService $categoryService
     */
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService =$categoryService;
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
        $books = $this->categoryService->getAllCategories($data);
        return $this->responseApi($books,'this is all books that available',200);
    }

    /**
     * Store a newly created Category.
     * @param StoreCategoryRequest  $request
     * @param Category  $category
     * @return /Illuminate\Http\JsonResponse
     */
    public function store(StoreCategoryRequest $request,Category $category)
    {
        $validatedData = $request->validated();
        $category = $this->categoryService->addCategory($validatedData,$category);
        return $this->responseApi($category,'you add category successfully',201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified category.
     * @param UpdateCategoryRequest $request 
     * @param Category $category
     * @return /Illuminate\Http\JsonResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validatedData = $request->validated();
        $category =$this->categoryService->updateCategory($validatedData,$category);
        return $this->responseApi($category,'you Updated Category Successfully',201);
    }

    /**
     * Remove the specified Category.
     * @param Category $category
     * @return /Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        if(auth()->user()->role !=='admin')
        {
           return response()->json([
               'message' => 'You are not authorized to delete this category'
            ], 403);
        }
        $categoryDelete= $this->categoryService->deleteCategory($category);
        return $this->responseApi(null,null,204);
    }
}

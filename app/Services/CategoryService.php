<?php


namespace App\Services;

use App\Models\Category;

class CategoryService{

    public function getAllCategories(array $data)
    {
        $query = Category::query();
        //filtering using name
        if (isset($data['name'])) {
            $query->where('name', $data['name']);
        }
        $categories = $query->get();
        return $categories;
    }
    public function addCategory(array $data,Category $category)
    {
        $category = Category::create([
            'name' => $data['name']
        ]);
        return $category;
    }
    public function updateCategory(array $data ,Category $category)
    {
        $updateCategory = array_filter([
            'name' =>$data['name'] ?? $category->name,
        ]);
        $category->update($updateCategory);
        return $category;
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
        return $category;
    }
}


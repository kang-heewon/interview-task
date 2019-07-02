<?php

namespace App\Http\Services;

use App\Category;

class CategoryService
{
  public static function getCategories()
  {
    return Category::all();
  }
  public static function getBooksByCategory($id)
  {
    return Category::where('id', $id)->get()->books;
  }

  public static function createCategory($category)
  {
    if (Category::where('name', $category)->count() == 0) {
      $newCategory = new Category();
      $newCategory->category = $category;
      $newCategory->save();
      return $newCategory->id;
    } else {
      return Category::where('name', $category)->get()->id;
    }
  }
}

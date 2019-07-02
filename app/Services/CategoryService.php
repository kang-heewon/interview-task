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
    return Category::find($id)->books;
  }

  public static function createCategory($category)
  {
    if (Category::where('category', $category)->count() == 0) {
      $newCategory = new Category();
      $newCategory->category = $category;
      $newCategory->save();
      return $newCategory->id;
    } else {
      return Category::where("category", $category)->get()[0]->id;
    }
  }
}

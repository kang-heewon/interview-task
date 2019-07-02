<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Http\Services\CategoryService;
use App\Http\Services\BookService;
use App\Book;
use App\Category;

class DatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $contents = Storage::disk('public')->get('forte/books.json');
    $jsonContents = json_decode($contents);
    $sortedContents = Arr::sort($jsonContents, function ($value) {
      return $value->id;
    });
    foreach ($jsonContents as $book) {
      $newBook = new stdClass();
      $categoryId = CategoryService::createCategory($book->category);
      $newBook->categoryId = $categoryId;
      $newBook->name = $book->name;
      $newBook->price = $book->price;
      BookService::createBook($newBook);
    }
  }
}

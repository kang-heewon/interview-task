<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
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
      $newCategory = new Category();
      $newCategory->category = $book->category;
      $newCategory->save();
      $newBook = new Book();
      $newBook->name = $book->name;
      $newBook->categories_id = $newCategory->id;
      $newBook->price = $book->price;
      $newBook->save();
    }
  }
}

<?php

namespace App\Http\Services;

use App\Book;

class BookService
{
  public static function getBooks()
  {
    return Book::all();
  }
  public static function getBooksById($id)
  {
    return Book::where('id', $id)->get();
  }
  public static function createBook($book)
  {
    $newBook = new Book();
    $newBook->name = $book->name;
    $newBook->categories_id = $categoryId;
    $newBook->price = $book->price;
    $newBook->save();
    return $newBook;
  }
  public static function updateBook($book)
  {
    $updateBook = Book::find($book->id);
    $updateBook->name = $book->name;
    $updateBook->categories_id = $categoryId;
    $updateBook->price = $book->price;
    $updateBook->save();
    return $updateBook;
  }
  public static function deleteBook($id)
  {
    $deleteBook = Book::find($id);
    $deleteBook->delete();
    return $deleteBook;
  }
}

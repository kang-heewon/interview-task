<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Http\Services\BookService;
use App\Http\Services\CategoryService;
class BookController extends Controller
{
  /**
   * Display a listing of the resource.
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return BookService::getBooks();
  }
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $category = $request->input('category');
    $categoryId = CategoryService::createCategory($category);
    $book = new \stdClass();
    $book->categoryId = $categoryId;
    $book->name = $request->input('name');
    $book->price = $request->input('price');
    return BookService::createBook($book);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    return BookService::getBooksById($id);
  }
  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $data["book"] = BookService::getBooksById($id);
    return view('edit', $data);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $category = $request->input('category');
    $categoryId = CategoryService::createCategory($category);
    $book = new \stdClass();
    $book->id = $id;
    $book->categoryId = $categoryId;
    $book->name = $request->input('name');
    $book->price = $request->input('price');
    return BookService::updateBook($book);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    BookService::deleteBook($id);
    return redirect()->route('books');
  }

  /**
   * category 의 price 를 모두 합쳐 result1.json 에 저장하는 메서드
   *
   * @return mixed
   */
  public function convertCategoriesPrice()
  {
    $contents = Storage::disk('public')->get('forte/books.json');
    $jsonContents = json_decode($contents);
    $categoryPrices = [];
    foreach ($jsonContents as $bookJson) {
      $categoryPrices = Arr::add($categoryPrices, $bookJson->category, 0);
      $categoryPrices[$bookJson->category] =
        $categoryPrices[$bookJson->category] + $bookJson->price;
    }
    $result = [];
    foreach ($categoryPrices as $category => $Price) {
      array_push($result, [
        "name" => $category,
        "price" => $Price,
      ]);
    }
    $resultJson = json_encode($result);
    Storage::disk('public')->put('forte/result1.json', $resultJson);
  }
  /**
   * category 의 동일한 name 을 컴마로 구분하여 result2.json 에 저장하는 메서드
   * 순서는 id 기준으로 내림차순
   */
  public function mergeCategoriesName()
  {
    $contents = Storage::disk('public')->get('forte/books.json');
    $jsonContents = json_decode($contents);
    $sortedContents = array_reverse(
      Arr::sort($jsonContents, function ($value) {
        return $value->id;
      }),
      "id"
    );
    $categoryNames = [];
    foreach ($sortedContents as $bookJson) {
      $categoryNames = Arr::add($categoryNames, $bookJson->category, "");
      $categoryNames[$bookJson->category] =
        $categoryNames[$bookJson->category] .
        ($categoryNames[$bookJson->category] == ""
          ? $bookJson->name
          : "," . $bookJson->name);
    }
    $result = [];
    foreach ($categoryNames as $category => $Price) {
      array_push($result, [
        "name" => $category,
        "price" => $Price,
      ]);
    }
    $resultJson = json_encode($result);
    Storage::disk('public')->put('forte/result2.json', $resultJson);
  }
}

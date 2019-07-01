<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BookController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
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
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
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

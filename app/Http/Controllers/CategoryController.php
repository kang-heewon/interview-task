<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\CategoryService;
class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return CategoryService::getCategories();
  }
  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    return CategoryService::getBooksByCategory($id);
  }
}

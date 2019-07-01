<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\BookController;

class BookUpdater extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'book:update';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = '';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   * @param  \App\Http\Controllers\BookController $books
   * @return mixed
   */
  public function handle(BookController $books)
  {
    $books->convertCategoriesPrice();
    $books->mergeCategoriesName();
  }
}

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/cms', function(){
  return redirect('cms/products');
});

Route::prefix('cms')->group(function(){
  Route::namespace('CMS')->group(function(){
    Route::resource('home_carousel', 'HomeCarouselController')->except(['show']);
    Route::resource('contents', 'ContentsController')->only(['index', 'edit', 'update']);
    Route::resource('branch_offices', 'BranchOfficesController')->except(['show']);
    Route::resource('budgets', 'BudgetsController')->only(['index', 'show', 'update', 'destroy']);
    Route::any('home', 'HomeController@index');
    Route::resource('garages', 'GaragesController')->except(['show']);
    Route::resource('news', 'NewsController')->except(['show']);
    Route::resource('product_images', 'ProductImagesController')->only(['show', 'destroy']);
    Route::resource('product_colors', 'ProductColorsController')->only(['show', 'destroy']);
    Route::any('products/import', 'ProductsController@import');
    Route::resource('products', 'ProductsController')->except(['show']);
    Route::resource('used_products', 'UsedProductsController')->except(['show']);
    Route::resource('users', 'UsersController')->except(['show']);
  });
});

Route::get('/data.json', 'HomeController@data');
Route::post('/budgets', 'HomeController@budgets');
Route::post('/contact', 'HomeController@contact');

Route::get('/status', function() {
    return 'ok';
});

Auth::routes();

Route::get('/{any}', function() {
  return view('web.main');
})->where('any', '.*');

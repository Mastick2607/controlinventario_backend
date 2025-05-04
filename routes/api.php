<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\MovementsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;

use App\Models\Customer;

/*

|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum', 'role:super_admin|admin'])->group(function () {

// Route products
Route::get('/products',[ProductController::class,('index')]);
Route::get('/products/totalstock',[ProductController::class,('totalStock')]);
Route::get('/products/low-stock',[ProductController::class,('lowStock')]);
Route::get('/products/{id}',[ProductController::class,('show')]);
Route::post('/products',[ProductController::class,('store')]);
Route::put('/products/{id}',[ProductController::class,('update')]);
Route::patch('/products/{id}',[ProductController::class,('updatePartial')]);
Route::delete('/products/{id}',[ProductController::class,('destroy')]);

// Route categories
Route::get('/categories',[CategoriesController::class,('index')]);
Route::get('/categories/{id}',[CategoriesController::class,('show')]);
Route::post('/categories',[CategoriesController::class,('store')]);
Route::put('/categories/{id}',[CategoriesController::class,('update')]);
Route::patch('/categories/{id}',[CategoriesController::class,('updatePartial')]);
Route::delete('/categories/{id}',[CategoriesController::class,('destroy')]);

// Route suppliers
Route::get('/suppliers',[SuppliersController::class,('index')]);
Route::get('/suppliers/{id}',[SuppliersController::class,('show')]);
Route::post('/suppliers',[SuppliersController::class,('store')]);
// Route::put('/suppliers/{id}',[SuppliersController::class,('update')]);
Route::patch('/suppliers/{id}',[SuppliersController::class,('update')]);
Route::delete('/suppliers/{id}',[SuppliersController::class,('destroy')]);


// Route customer
Route::get('/customer',[CustomerController::class,('index')]);
Route::get('/customer/{id}',[CustomerController::class,('show')]);
Route::post('/customer',[CustomerController::class,('store')]);
// Route::put('/customer/{id}',[CustomerController::class,('update')]);
Route::patch('/customer/{id}',[CustomerController::class,('update')]);
Route::delete('/customer/{id}',[CustomerController::class,('destroy')]);

// Route purchases
Route::get('/purchases',[PurchasesController::class,('index')]);
Route::get('/purchases/{id}',[PurchasesController::class,('show')]);
Route::post('/purchases',[PurchasesController::class,('store')]);
// Route::put('/purchases/{id}',[PurchasesController::class,('update')]);
Route::patch('/purchases/{id}',[PurchasesController::class,('update')]);
Route::delete('/purchases/{id}',[PurchasesController::class,('destroy')]);


// Route sales
Route::get('/sales',[SalesController::class,('index')]);
Route::get('/sales/latestsales',[SalesController::class,('latestSales')]);
Route::get('/sales/totalsales',[SalesController::class,('totalSales')]);
Route::get('/sales/totalrevenue',[SalesController::class,('totalRevenue')]);
Route::get('/sales/{id}',[SalesController::class,('show')]);
Route::post('/sales',[SalesController::class,('store')]);
Route::put('/sales/{id}',[SalesController::class,('update')]);
Route::patch('/sales/{id}',[SalesController::class,('updatePartial')]);
Route::delete('/sales/{id}',[SalesController::class,('destroy')]);
Route::get('/SalesByProduct/{id}',[SalesController::class,('getSalesByProduct')]);


// Route movements
Route::get('/movements',[MovementsController::class,('index')]);
Route::get('/movements/{id}',[MovementsController::class,('show')]);
// Route::post('/movements',[MovementsController::class,('store')]);
// Route::put('/suppliers/{id}',[MovementsController::class,('update')]);
// Route::patch('/movements/{id}',[MovementsController::class,('update')]);
// Route::delete('/movements/{id}',[MovementsController::class,('destroy')]);


Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/me', [AuthController::class, 'me']);


});

Route::post('/register', [AuthController::class,('register')]);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



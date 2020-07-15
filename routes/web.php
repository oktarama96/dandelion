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


Route::get('pos/login', 'Auth\PosController@showLoginForm')->name('pos.login');
Route::post('pos/login', 'Auth\PosController@login')->name('pos.login');
Route::post('pos/logout', 'Auth\PosController@logout')->name('pos.logout');

//Route Khusus Admin
Route::group(['prefix' => 'pos/admin', 'middleware' => ['auth:pengguna', 'is_admin']], function() {
    //Route::get('/', 'PenggunaController@adminDash')->name('admin.dash');
    // Route::get('/blabalbalabl', 'Admin\Blalbalal@index')->name('admin.xxxx');
    Route::resource('/pengguna', 'PenggunaController');

    Route::resource('/kategoriproduk', 'KategoriProdukController');

    Route::resource('/warnaproduk', 'WarnaController');

    Route::resource('/ukuranproduk', 'UkuranController');

    Route::resource('/kupondiskon', 'KuponDiskonController');

    Route::resource('/produk', 'ProdukController');
    Route::patch('/produk/{id}/stok', 'ProdukController@managestok');
    Route::delete('/produk/{id}/stok', 'ProdukController@hapusstok');

    Route::resource('/pelanggan', 'PelangganController');
    Route::post('/pelanggan/add/provinsi/{id}', 'PelangganController@tampilkabupaten');
    Route::post('/pelanggan/add/kabupaten/{id}', 'PelangganController@tampilkecamatan');

    Route::get('/report/transaksi', 'LaporanController@transaksiReport');
    Route::get('/report/stokproduk', 'LaporanController@stokprodukReport');
    Route::get('/report/stokhabis', 'LaporanController@stokhabisReport');
    Route::get('/report/stoklaris', 'LaporanController@stoklarisReport');

    Route::delete('/transaksi/{id}/', 'TransaksiController@hapustransaksi');
});

//Route Khusus Kasir
Route::group(['prefix' => 'pos/', 'middleware' => ['auth:pengguna']], function() {
    //Route::get('/', 'PenggunaController@kasirDash')->name('kasir.dash');
    Route::get('/', 'DashboardController@index')->name('kasir.index');

    Route::get('/pointofsale', 'TransaksiController@pointofsale');
    Route::get('/pointofsale/acproduk', 'TransaksiController@acproduk');
    Route::get('/pointofsale/addproduk/{id}', 'TransaksiController@addproduk');
    Route::get('/pointofsale/addukuran/{id}', 'TransaksiController@addukuran');
    Route::post('/pointofsale/addtransaksi', 'TransaksiController@simpantransaksi');

    Route::get('/transaksi', 'TransaksiController@index');
    Route::get('/transaksi/detailtransaksi/{id}', 'TransaksiController@showdetailtrans'); 
});


// Route::get('/login', function () {
//     return view('pos.login');
// });

// Route::post('/login/auth', 'AuthPOSController@login');

// End-user route
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/profile-management', function () {
    return view('pos.profile');
})->name('profile');

Route::get('/', 'IndexController@index')->name('index');
Route::get('/produk/detail/{id}','ProdukController@edit');
Route::get('/shop', 'ShopController@index');

Route::post('/shop', 'ShopController@index');
Route::get('/shop/product-detail/{id}', 'ShopController@productdetail');

Route::get('/shop/add-cart', 'ShopController@filterProduk');

Route::get('/shop/cart', 'ShopController@showcart');

Route::get('/shop/checkout', 'ShopController@showcheckout');


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



Route::get('/pos/login', function () {
    return view('pos.login');
});

Route::post('/pos/login/auth', 'AuthPOSController@login');

Route::get('/pos', 'DashboardController@index')->name('index');

Route::resource('/pos/pages/pengguna', 'PenggunaController');

Route::resource('/pos/pages/kategoriproduk', 'KategoriProdukController');

Route::resource('/pos/pages/warnaproduk', 'WarnaController');

Route::resource('/pos/pages/ukuranproduk', 'UkuranController');

Route::resource('/pos/pages/kupondiskon', 'KuponDiskonController');

Route::resource('/pos/pages/produk', 'ProdukController');
Route::patch('/pos/pages/produk/{id}/stok', 'ProdukController@managestok');
Route::delete('/pos/pages/produk/{id}/stok', 'ProdukController@hapusstok');

Route::resource('/pos/pages/pelanggan', 'PelangganController');
Route::post('/pos/pages/pelanggan/add/provinsi/{id}', 'PelangganController@tampilkabupaten');
Route::post('/pos/pages/pelanggan/add/kabupaten/{id}', 'PelangganController@tampilkecamatan');

Route::get('/pos/pages/pos', 'TransaksiController@pointofsale');
Route::get('/pos/pages/pos/acproduk/', 'TransaksiController@acproduk');
Route::get('/pos/pages/pos/addproduk/{id}', 'TransaksiController@addproduk');
Route::get('/pos/pages/pos/addukuran/{id}', 'TransaksiController@addukuran');
Route::post('/pos/pages/pos/addtransaksi', 'TransaksiController@simpantransaksi');

Route::get('/pos/pages/transaksi', 'TransaksiController@index');
Route::get('/pos/pages/transaksi/detailtransaksi/{id}', 'TransaksiController@showdetailtrans');
Route::delete('/pos/pages/transaksi/{id}/', 'TransaksiController@hapustransaksi');

Route::get('/pos/pages/report/transaksi', 'LaporanController@transaksiReport');
Route::get('/pos/pages/report/stokproduk', 'LaporanController@stokprodukReport');
Route::get('/pos/pages/report/stokhabis', 'LaporanController@stokhabisReport');
Route::get('/pos/pages/report/stoklaris', 'LaporanController@stoklarisReport');

Route::get('/pos/profile-management', function () {
    return view('pos.profile');
})->name('profile');

Route::get('/', 'IndexController@index');
Route::get('/produk/detail/{id}','ProdukController@edit');
Route::get('/shop', 'ShopController@index');
Route::post('/shop', 'ShopController@index');
Route::get('/shop/product-detail/{id}', 'ShopController@productdetail');

Route::get('/shop/add-cart', 'ShopController@filterProduk');
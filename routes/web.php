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
    Route::get('/detailtransaksi/{id}', 'DashboardController@showdetailtrans');

    Route::patch('/updatetransaksi/{id}', 'TransaksiController@updatetransaksi');
    Route::get('/pointofsale', 'TransaksiController@pointofsale');
    Route::get('/pointofsale/acproduk', 'TransaksiController@acproduk');
    // Route::get('/pointofsale/addproduk/{id}', 'TransaksiController@addproduk');
    // Route::get('/pointofsale/addukuran/{id}', 'TransaksiController@addukuran');
    Route::get('/pointofsale/addproduk/{IdProduk}', 'ProdukController@getDetail');
    Route::get('/pointofsale/addukuran/{IdProduk}/{IdWarna}', 'ProdukController@getUkuran');

    Route::post('/pointofsale/addtransaksi', 'TransaksiController@simpantransaksi');

    Route::get('/transaksi', 'TransaksiController@index');
    Route::get('/transaksi/{id}', 'TransaksiController@loaddata');
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
Route::post('/register', 'Auth\LoginController@register')->name('register');
Route::post('/register/add/provinsi/{id}', 'Auth\LoginController@tampilkabupaten');
Route::post('/register/add/kabupaten/{id}', 'Auth\LoginController@tampilkecamatan');

Route::get('/', 'IndexController@index')->name('index');
Route::get('/produk/detail/{id}','ProdukController@edit');
Route::get('/shop', 'ShopController@index');

Route::post('/shop', 'ShopController@index');
Route::get('/shop/product-detail/{id}', 'ShopController@productdetail');
Route::get('/shop/get-warna/{IdProduk}', 'ProdukController@getDetail');
Route::get('/shop/get-ukuran/{IdProduk}/{IdWarna}', 'ProdukController@getUkuran');

Route::group(['middleware' => ['auth:web']], function() {
    Route::get('/shop/cart', 'ShopController@showcart');
    Route::get('/shop/get-cart', 'ShopController@getCart');
    Route::get('/shop/delete-cart/{id_cart}', 'ShopController@deleteCartItem');
    Route::post('/shop/add-cart', 'ShopController@addCartItem');

    Route::get('/shop/checkout', 'ShopController@showcheckout')->name('checkout');
    Route::post('/transaksi/online', 'TransaksiController@simpantransaksionline');

    Route::post('/midtrans/finish', function(){
        return redirect()->route('checkout')->with('status', 'Pembayaran Sukses!');;
    })->name('checkout.finish');
    Route::post('/midtrans/notification/handler', 'TransaksiController@notificationHandler')->name('notification.handler');

    Route::get('/my-account/{id_pelanggan}', 'PelangganController@tampilakun');
    Route::patch('/my-account/{id_pelanggan}', 'PelangganController@update');
    Route::post('/my-account/add/provinsi/{id}', 'PelangganController@tampilkabupaten');
    Route::post('/my-account/add/kabupaten/{id}', 'PelangganController@tampilkecamatan');
});


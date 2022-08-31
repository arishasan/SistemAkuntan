<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application- These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'AuthController@showFormLogin');
Route::get('login', 'AuthController@showFormLogin')->name('login');
Route::post('login', 'AuthController@login')->name('login');

Route::group(['middleware' => 'auth'], function(){
	Route::get('logout', 'AuthController@logout')->name('logout');

	// ADMIN

	// KATEGORI

	Route::get('master/kategori', 'KategoriController@index')->name('kategori');
	Route::post('master/kategori/simpan', 'KategoriController@store')->name('simpan-kategori');
	Route::post('master/kategori/update', 'KategoriController@update')->name('update-kategori');
	Route::get('master/kategori/edit/{id}', 'KategoriController@edit');
	Route::get('master/kategori/delete/{id}', 'KategoriController@delete');

	// END OF KATEGORI

	// PRODUK

	Route::get('master/produk', 'ProdukController@index')->name('produk');
	Route::post('master/produk/simpan', 'ProdukController@store')->name('simpan-produk');
	Route::post('master/produk/update', 'ProdukController@update')->name('update-produk');
	Route::get('master/produk/detail/{id}', 'ProdukController@detail');
	Route::get('master/produk/delete/{id}', 'ProdukController@delete');
	Route::get('master/produk/edit/{id}', 'ProdukController@edit');

	// END OF PRODUK

	// ADMINISTRASI

		// ADM PEMESANAN

		Route::get('administrasi/pemesanan', 'AdmPemesananController@index')->name('adm_pemesanan');
		Route::post('administrasi/pemesanan', 'AdmPemesananController@index')->name('adm_pemesanan_filter');
		Route::post('administrasi/pemesanan/simpan', 'AdmPemesananController@store')->name('simpan-pemesanan');
		Route::get('administrasi/pemesanan/detail/{id}', 'AdmPemesananController@detail');
		Route::get('administrasi/pemesanan/delete/{id}', 'AdmPemesananController@delete');
		Route::get('administrasi/pemesanan/edit/{id}', 'AdmPemesananController@edit');
		Route::post('administrasi/pemesanan/update', 'AdmPemesananController@update')->name('update-pemesanan');

		// ADM PEMASUKAN

		Route::get('administrasi/pemasukan', 'AdmPemasukanController@index')->name('adm_pemasukan');
		Route::post('administrasi/pemasukan/simpan', 'AdmPemasukanController@store')->name('simpan-pemasukan');
		Route::post('administrasi/pemasukan/update', 'AdmPemasukanController@update')->name('update-pemasukan');
		Route::get('administrasi/pemasukan/edit/{id}', 'AdmPemasukanController@edit');
		Route::get('administrasi/pemasukan/delete/{id}', 'AdmPemasukanController@delete');
		Route::post('administrasi/pemasukan', 'AdmPemasukanController@index')->name('adm_pemasukan_filter');

		// ADM PENGELUARAN

		Route::get('administrasi/pengeluaran', 'AdmPengeluaranController@index')->name('adm_pengeluaran');
		Route::post('administrasi/pengeluaran/simpan', 'AdmPengeluaranController@store')->name('simpan-pengeluaran');
		Route::post('administrasi/pengeluaran/update', 'AdmPengeluaranController@update')->name('update-pengeluaran');
		Route::get('administrasi/pengeluaran/edit/{id}', 'AdmPengeluaranController@edit');
		Route::get('administrasi/pengeluaran/delete/{id}', 'AdmPengeluaranController@delete');
		Route::post('administrasi/pengeluaran', 'AdmPengeluaranController@index')->name('adm_pengeluaran_filter');

		// ADM PIUTANG

		Route::get('administrasi/piutang', 'AdmPiutangController@index')->name('adm_piutang');
		Route::get('administrasi/piutang/delete/{id}', 'AdmPiutangController@delete');
		Route::post('administrasi/piutang', 'AdmPiutangController@index')->name('adm_piutang_filter');
		Route::post('administrasi/piutang/bayar', 'AdmPiutangController@bayar')->name('simpan-bayar-piutang');

		// ADM JURNAL
		Route::get('administrasi/jurnal', 'AdmJurnalController@index')->name('adm_jurnal');
		Route::post('administrasi/jurnal', 'AdmJurnalController@index')->name('adm_jurnal_filter');
		Route::get('administrasi/jurnal/get_trx/{tgl}', 'AdmJurnalController@get_trx_list');
		Route::post('administrasi/jurnal/store', 'AdmJurnalController@store')->name('simpan-jurnal');
		Route::get('administrasi/jurnal/detail/{id}', 'AdmJurnalController@detail');
		Route::get('administrasi/jurnal/delete/{id}', 'AdmJurnalController@delete');

		// ADM NERACA
		Route::get('administrasi/neraca', 'AdmNeracaController@index')->name('adm_neraca');
		Route::post('administrasi/neraca', 'AdmNeracaController@index')->name('adm_neraca_filter');
		Route::get('administrasi/neraca/get_detail/{bln}/{thn}', 'AdmNeracaController@get_data');


	// END OF ADMINISTRASI
	

	// END OF ADMIN ACCESS

	Route::get('my_account', 'UserController@myacc')->name('myacc');
	Route::get('sys/users', 'UserController@index')->name('users');
	Route::post('sys/users/simpan', 'UserController@store')->name('simpan-user');
	Route::post('sys/users/update', 'UserController@update')->name('update-user');
	Route::post('sys/users/my_acc/update', 'UserController@myacc_update')->name('update-myacc');
	Route::get('sys/user/delete/{id}', 'UserController@delete');
	Route::get('sys/user/edit/{id}', 'UserController@edit');

	Route::get('sys/update_saldo', 'AdminController@update_saldo_index')->name('update_saldo');
	Route::post('sys/update_saldo/post', 'AdminController@update_saldo_execute')->name('update-saldo-now');
	Route::get('landing_admin', 'AdminController@index')->name('landing-admin');
	Route::post('landing_admin', 'AdminController@index')->name('dashboard-filter');

	// DASHBOARD


	// END OF DASHBOARD
});
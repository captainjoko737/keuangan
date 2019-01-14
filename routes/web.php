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


Route::group(['middleware' => 'web'], function () {

	Auth::routes();

	Route::get('/', 'HomeController@index')->name('home');

	Route::get('/mahasiswa', 'Mahasiswa@mahasiswa')->name('mahasiswa');
	Route::get('/list/mahasiswa', 'Mahasiswa@mahasiswa')->name('list.mahasiswa');
	Route::get('/mahasiswa/detail', 'Mahasiswa@detail')->name('mahasiswa.detail');
	Route::post('/mahasiswa/save', 'Mahasiswa@save')->name('mahasiswa.save');

	# TAGIHAN
	Route::group(['prefix' => 'tagihan'], function() {
		Route::get('/', 'Tagihan@index')->name('tagihan');
		Route::get('/create', 'Tagihan@create')->name('tagihan.create');
		Route::post('/store', 'Tagihan@store')->name('tagihan.store');
		Route::get('/edit', 'Tagihan@edit')->name('tagihan.edit');
		Route::post('/save', 'Tagihan@save')->name('tagihan.save');
		Route::delete('/delete', 'Tagihan@drop')->name('tagihan.drop');
	});

	# PENGGUNA
	Route::group(['prefix' => 'pengguna'], function() {
		Route::get('/', 'Pengguna@index')->name('pengguna');
		Route::get('/create', 'Pengguna@create')->name('pengguna.create');
		Route::post('/store', 'Pengguna@store')->name('pengguna.store');
		Route::get('/edit', 'Pengguna@edit')->name('pengguna.edit');
		Route::post('/save', 'Pengguna@save')->name('pengguna.save');
		Route::delete('/delete', 'Pengguna@drop')->name('pengguna.drop');
	});
	
	Route::group(['prefix' => 'laporan'], function() {

		# LAPORAN PER MAHASISWA
		Route::group(['prefix' => 'mahasiswa'], function() {
			Route::get('/', 'Mahasiswa@index')->name('laporan.mahasiswa');
			Route::post('/', 'Mahasiswa@laporan')->name('laporan.mahasiswa.result');
			Route::get('/print', 'Mahasiswa@laporan')->name('laporan.mahasiswa.print');
		});

		# LAPORAN PER PROGRAM STUDI
		Route::group(['prefix' => 'program_studi'], function() {
			Route::get('/', 'ProgramStudi@index')->name('laporan.program_studi');
			Route::post('/', 'ProgramStudi@laporan')->name('laporan.program_studi.result');
			Route::get('/print', 'ProgramStudi@laporan')->name('laporan.program_studi.print');
		});

		# LAPORAN PER SEMESTER
		Route::group(['prefix' => 'semester'], function() {
			Route::get('/', 'Semester@index')->name('laporan.semester');
			Route::post('/', 'Semester@laporan')->name('laporan.semester.result');
			Route::get('/print', 'Semester@laporan')->name('laporan.semester.print');
		});

		# LAPORAN PER ANGKATAN
		Route::group(['prefix' => 'angkatan'], function() {
			Route::get('/', 'Angkatan@index')->name('laporan.angkatan');
			Route::post('/', 'Angkatan@laporan')->name('laporan.angkatan.result');
			Route::get('/print', 'Angkatan@laporan')->name('laporan.angkatan.print');
		});

		# LAPORAN PER TAHUN
		Route::group(['prefix' => 'tahun'], function() {
			Route::get('/', 'Tahun@index')->name('laporan.tahun');
			Route::post('/', 'Tahun@laporan')->name('laporan.tahun.result');
			Route::get('/print', 'Tahun@laporan')->name('laporan.tahun.print');
		});

		# LAPORAN PER KASIR
		Route::group(['prefix' => 'kasir'], function() {
			Route::get('/', 'Kasir@index')->name('laporan.kasir');
			Route::post('/', 'Kasir@laporan')->name('laporan.kasir.result');
			Route::get('/print', 'Kasir@laporan')->name('laporan.kasir.print');
		});

		# LAPORAN PER JENIS TRANSAKSI
		Route::group(['prefix' => 'jenis_transaksi'], function() {
			Route::get('/', 'JenisTransaksi@index')->name('laporan.jenis_transaksi');
			Route::post('/', 'JenisTransaksi@laporan')->name('laporan.jenis_transaksi.result');
			Route::get('/print', 'JenisTransaksi@laporan')->name('laporan.jenis_transaksi.print');
		});

		# LAPORAN REKAPITULASI
		Route::group(['prefix' => 'rekapitulasi'], function() {
			Route::get('/', 'Rekapitulasi@index')->name('laporan.rekapitulasi');
			Route::post('/', 'Rekapitulasi@laporan')->name('laporan.rekapitulasi.result');
			Route::get('/print', 'Rekapitulasi@laporan')->name('laporan.rekapitulasi.print');
		});



		
	});
	

});


<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::dashboard', ['filter' => 'login']);
$routes->post('/dashboard', 'Home::dashboard', ['filter' => 'login']);
$routes->get('/dashboard', 'Home::dashboard', ['filter' => 'login']);

// Kumpulan Daftar
$routes->get('/daftar_pasien', 'DaftarPasienController::index', ['filter' => 'login']);
$routes->get('/daftar_poli', 'DaftarPoliController::index', ['filter' => 'login']);
$routes->get('/daftar_karyawan', 'DaftarKaryawanController::index', ['filter' => 'login']);
$routes->get('/daftar_pengguna', 'DaftarPenggunaController::index', ['filter' => 'login']);

// Kumpulan Create
$routes->get('/create_pasien', 'DaftarPasienController::create_pasien', ['filter' => 'login']);
$routes->get('/create_poli', 'DaftarPoliController::create_poli', ['filter' => 'login']);
$routes->get('/create_karyawan', 'DaftarKaryawanController::create_karyawan', ['filter' => 'login']);
$routes->get('/create_pengguna', 'DaftarPenggunaController::create_pengguna', ['filter' => 'login']);

//Kumpulan Save
$routes->post('/save_pasien', 'DaftarPasienController::save_pasien', ['filter' => 'login']);
$routes->post('/save_poli', 'DaftarPoliController::save_poli', ['filter' => 'login']);
$routes->post('/save_karyawan', 'DaftarKaryawanController::save_karyawan', ['filter' => 'login']);
$routes->post('/save_pengguna', 'DaftarPenggunaController::save_pengguna', ['filter' => 'login']);

// Kumpulan Edit
$routes->get('/edit_pasien/(:num)', 'DaftarPasienController::edit_pasien/$1', ['filter' => 'login']);
$routes->get('/edit_poli/(:num)', 'DaftarPoliController::edit_poli/$1', ['filter' => 'login']);
$routes->get('/edit_karyawan/(:num)', 'DaftarKaryawanController::edit_karyawan/$1', ['filter' => 'login']);
$routes->get('/edit_pengguna/(:num)', 'DaftarPenggunaController::edit_pengguna/$1', ['filter' => 'login']);

//Kumpulan Update
$routes->put('/update_pasien/(:num)', 'DaftarPasienController::update_pasien/$1', ['filter' => 'login']);
$routes->put('/update_poli/(:num)', 'DaftarPoliController::update_poli/$1', ['filter' => 'login']);
$routes->put('/update_karyawan/(:num)', 'DaftarKaryawanController::update_karyawan/$1', ['filter' => 'login']);
$routes->put('/update_pengguna/(:num)', 'DaftarPenggunaController::update_pengguna/$1', ['filter' => 'login']);

// Daftar Delete
$routes->get('/delete_pasien/(:num)', 'DaftarPasienController::delete_pasien/$1', ['filter' => 'login']);
$routes->get('/delete_poli/(:num)', 'DaftarPoliController::delete_poli/$1', ['filter' => 'login']);
$routes->get('/delete_karyawan/(:num)', 'DaftarKaryawanController::delete_karyawan/$1', ['filter' => 'login']);
$routes->get('/delete_pengguna/(:num)', 'DaftarPenggunaController::delete_pengguna/$1', ['filter' => 'login']);

// Nomor Antrian
$routes->get('/nomor_antrian', 'DaftarNoAntrianController::index', ['filter' => 'login']);
$routes->get('/nomorantrian_poli', 'DaftarNoAntrianController::nomorantrian_poli', ['filter' => 'login']);
$routes->get('/ambil-nomor-antrian/(:segment)', 'DaftarNoAntrianController::ambilNomorAntrian/$1', ['filter' => 'login']);
$routes->get('/antrian_selesai/(:num)/(:num)', 'DaftarNoAntrianController::antrian_selesai/$1/$2', ['filter' => 'login']);
$routes->post('/fetchDataByJenisPoli', 'DaftarNoAntrianController::fetchDataByJenisPoli', ['filter' => 'login']);

// Transaksi
$routes->get('/daftar_transaksi', 'DaftarTransaksiController::index', ['filter' => 'login']);
$routes->post('/daftar_transaksi/saveTransaksi', 'DaftarTransaksiController::saveTransaksi', ['filter' => 'login']);

// Laporan
$routes->get('/laporan_transaksi', 'DaftarLaporanTransaksiController::index', ['filter' => 'login']);
$routes->get('/detail_laporan/(:num)', 'DaftarLaporanTransaksiController::detail_laporan/$1', ['filter' => 'login']);
$routes->get('/laporanTransaksi/(:num)', 'DaftarLaporanTransaksiController::laporanTransaksi/$1', ['filter' => 'login']);
/*
* --------------------------------------------------------------------
* Additional Routing
* --------------------------------------------------------------------
*
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

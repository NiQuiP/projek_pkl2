<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->setAutoRoute(true);
$routes->setDefaultNamespace('App\Controllers');


$routes->group('user/', ['filter' => 'auth'], function ($routes) {
    $routes->get('my-profile', 'user\user::index');
    $routes->get('attendance', 'user\user::attendance');
    $routes->add('attendanceProccess', 'user\user::attendanceProcess');
    $routes->get('permission', 'user\user::permission');
    $routes->post('permission', 'user\user::permissionProcess');
    $routes->add('history', 'user\user::history');
    $routes->get('setting', 'user\user::setting');
    $routes->add('settingProccess', 'user\user::settingProcess');
    $routes->add('admin', 'user\auth::admin');

});
$routes->get('/', 'user\auth::login', ['filter' => 'noauth']);
$routes->group('/', ['filter' => 'noauth'], function ($routes) {
    $routes->get('login', 'user\auth::login');
    $routes->post('login', 'user\auth::loginProcess');
    $routes->add('forgetpassword', 'user\auth::forgetPassword');
    $routes->add('resetpassword', 'user\auth::resetPassword');
    $routes->post('resetpassword', 'user\auth::resetPasswordProcess', ['as' => 'user.resetpassword']);
    $routes->add('user/verifikasi', 'user\auth::verifikasi');
    $routes->add('resetpassword', 'user\auth::resetPassword');

});

$routes->group('user/', ['filter' => 'authregister'], function ($routes) {
    $routes->get('index', 'user\auth::index');
    $routes->post('index', 'user\auth::indexHandler');
});


$routes->group('/', ['filter' => 'noauthregister'], function ($routes) {
    $routes->get('register', 'user\auth::register');
    $routes->post('register', 'user\auth::registerProcess');
});


$routes->add('user/kirim_ulang', 'user\auth::kirim_ulang_token');
$routes->add('user/logout', 'user\auth::logout');
$routes->add('/logout', 'user\auth::logout');
$routes->add('/resetStatus', 'user\auth::resetStatus');

$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'admin\admin::dashboard');
    $routes->get('data-absen', 'admin\admin::data_absen');
    $routes->get('data-siswa', 'admin\admin::data_siswa');
    $routes->post('tambahUser', 'admin\admin::tambahUser');
    $routes->get('data-mahasiswa', 'admin\admin::data_mahasiswa');
    // $routes->add('tambahUser', 'admin\admin::tambahUser');
    // $routes->get('editUser', 'admin\admin::editUser');
});
// $routes->get('admin/dashboard', 'admin\admin::dashboard', ['filter' => 'filterrole']);
// $routes->get('user/my-profile', 'admin\admin::dashboard', ['filter' => 'filterrole']);




// $routes->group('/', function ($routes) {
//     $routes->add('login', 'User\Auth::login');
//     $routes->add('registrasi', 'User\Auth::registrasi');
// });

// $routes->group('user', function ($routes) {
//     $routes->add('sukses', 'User\user::sukses');
//     $routes->add('logout', 'User\user::logout');
//     $routes->add('passwordlupa', 'User\user::user_lupapassword');
//     $routes->add('passwordreset', 'User\user::user_resetpassword');

// });
// $routes->add('admin/logout', 'Admin\admin::logout');

// $routes->group('admin', ['filter' => 'noauth'], function ($routes) {
//     $routes->add('login', 'Admin\admin::login');
//     $routes->add('lupapassword', 'Admin\admin::lupapassword');
//     $routes->add('resetpassword', 'Admin\admin::resetpassword');
// });

// $routes->group('admin', ['filter' => 'auth'], function ($routes) {
//     $routes->add('sukses', 'Admin\admin::sukses');
//     $routes->add('article', 'Admin\article::index');
//     $routes->add('article/tambah', 'Admin\article::tambah');
//     $routes->add('article/edit', 'Admin\article::edit');
//     $routes->add('siswa', 'Admin\article::siswa');
//     $routes->add('siswa/tambah', 'Admin\Article::siswa_tambah');
// });
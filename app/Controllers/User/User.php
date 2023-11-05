<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\MemberModel;
use App\Models\Absensi;
use App\Validations\CustomRules;


class User extends BaseController
{
    protected $member;
    protected $absensi;
    protected $helpers = (['url', 'form', 'global_fungsi_helper']);

    function __construct()
    {
        $pager = \Config\Services::pager();
    }

    public function index()
    {

        $data['halaman'] = 'User | My Profile';
        $data['title'] = 'My Profile';
        $data['namaFile'] = session()->get('member_foto');
        echo view('user/v_my-profile', $data);
    }
    public function attendance()
    {
        $data['halaman'] = 'User | Attendance';
        $data['title'] = 'Attendance';
        $data['namaFile'] = session()->get('member_foto');
        echo view('user/v_attendance', $data);
    }

    public function attendanceProcess()
    {
        $absensi = new Absensi();
        $member = new MemberModel();
        $sesi_nis = session()->get('member_nim_nis');
        $memberInfo = $member->where('nim_nis', $sesi_nis)->first();

        $lat = $this->request->getVar('lat');
        $long = $this->request->getVar('long');
        $today = date('Y-m-d');
        $currentTime = date('H:i:s');
        $foto = $this->request->getPost('photostore');

        if ($this->request->getVar('checkin')) {
            if ($currentTime < '06:00:00') {
                notif_swal('error', 'Belum masuk waktu absen');
                return redirect()->back();
            }
            if ($currentTime < '17:00:00') {
                $encoded_data = $_POST['photoStore'];
                $binary_data = base64_decode($encoded_data, true);
                $photoname = date("Y.m.d") . " - " . date("h.i.sa") . '.jpeg';
                $lokasi = ('lat: ' . $lat . ', long: ' . $long);
                file_put_contents(FCPATH . 'uploadFoto/' . $photoname, $binary_data);
                $data = $member->where('nim_nis', $sesi_nis)->first();

                $updateData = [
                    'nama_lengkap' => $memberInfo['nama_lengkap'],
                    'email' => $memberInfo['email'],
                    'instansi_pendidikan' => $memberInfo['instansi_pendidikan'],
                    'nama_instansi' => $memberInfo['nama_instansi'],
                    'nim_nis' => $memberInfo['nim_nis'],
                    'lokasi' => $lokasi,
                    'status' => 'Masuk',
                    'keterangan' => '',
                    'foto_absen' => $photoname,
                    'jenis_user' => $data['jenis_user'],
                ];
                $absensi->insert($updateData);
                notif_swal_tiga('success', $currentTime, 'Berhasil Check-in');
                return redirect()->to('user/attendance');
            } else {
                notif_swal('error', 'Melewati batas waktu absen');
                return redirect()->back();
            }
        }

        if ($this->request->getVar('checkout')) {
            if ($currentTime > '16:00:00') {
                $encoded_data = $_POST['photoStore'];
                $binary_data = base64_decode($encoded_data, true);
                $photoname = date("Y.m.d") . " - " . date("h.i.sa") . '.jpeg';
                $lokasi = ('lat: ' . $lat . ', long: ' . $long);
                file_put_contents(FCPATH . 'uploadFoto/' . $photoname, $binary_data);

                $updateData = [
                    'checkout_time' => $currentTime,
                ];
                $absensi->where('nim_nis', $sesi_nis)->set($updateData)->update();
                notif_swal('success', 'Berhasil Check-in');
                return redirect()->to('user/attendance');
            } else {
                notif_swal('error', 'Belum masuk waktu checkout');
                return redirect()->back();
            }
            if ($currentTime > '18:00:00') {
                $encoded_data = $_POST['photoStore'];
                $binary_data = base64_decode($encoded_data, true);
                $photoname = date("Y.m.d") . " - " . date("h.i.sa") . '.jpeg';
                $lokasi = ('lat: ' . $lat . ', long: ' . $long);
                file_put_contents(FCPATH . 'uploadFoto/' . $photoname, $binary_data);

                $updateData = [
                    'checkout_time' => 'Overtime : ' . $currentTime,
                ];
                $absensi->where('nim_nis', $sesi_nis)->set($updateData)->update();
                notif_swal('success', 'Berhasil Check-in');
                return redirect()->to('user/attendance');
            }
        }


    }
    public function permission()
    {
        $data['halaman'] = 'User | Permission';
        $data['title'] = 'Permission';
        $data['namaFile'] = session()->get('member_foto');
        echo view('user/v_permission', $data);
    }
    public function permissionProcess()
    {
        $absensi = new Absensi();
        $member = new MemberModel();
        $sesi_nis = session()->get('member_nim_nis');
        $memberInfo = $member->where('nim_nis', $sesi_nis)->first();
        $absensiInfo = $absensi->where('nim_nis', $sesi_nis)->orderBy('id', 'desc')->first();

        $status = $this->request->getVar('menu');
        $keterangan = $this->request->getVar('keterangan');
        $lat = $this->request->getVar('lat');
        $long = $this->request->getVar('long');
        $lokasi = ('lat: ' . $lat . ', long: ' . $long);
        $fotoAbsen = $this->request->getFile('foto_absen');

        $today = date('Y-m-d');
        $currentTime = date('H:i:s');

        /**Validasi Checkout */
        if ($this->request->getVar('checkout')) {
            if ($currentTime > '16:00:00') {
                if (!empty($absensiInfo)) { // Pengecekan apakah data user ada atau tidak
                    if ($absensiInfo['waktu_absen'] == $today) { // Pengecekan apakah user sudah checkin pada hari ini 
                        if ($absensiInfo['checkout_time'] != '') { // Pengecekan apakah user sudah checkout hari ini 
                            notif_swal('error', 'Anda sudah checkout hari ini');
                            return redirect()->back();
                        } else {
                            $dataUpdate = [
                                'checkout_time' => $currentTime,
                            ];
                            $id_user = $absensiInfo['id'];
                            $absensi->where('id', $id_user)->set($dataUpdate)->update();

                            notif_swal_tiga('success', $currentTime, 'Berhasil Checkout');
                            return redirect()->back();
                        }
                    } else {
                        notif_swal('error', 'Anda belum checkin');
                        return redirect()->back();
                    }
                } else {
                    notif_swal('error', 'Anda belum checkin');
                    return redirect()->back();
                }
            } else {
                notif_swal('error', 'Belum masuk waktu checkout'); // Error jika belum masuk waktu checkout (pulang)
                return redirect()->back();
            }
        }

        /**Validasi Checkin */
        if ($this->request->getVar('checkin')) {
            if ($currentTime < '10:00:00') {
                if (!empty($absensiInfo)) {
                    if ($absensiInfo['waktu_absen'] == $today) {
                        notif_swal('error', 'Anda sudah checkin hari ini');
                        return redirect()->back();
                    }
                }

                if ($fotoAbsen == '') {
                    notif_swal('error', 'Foto Tidak Boleh Kosong');
                    return redirect()->back();
                }
                if ($keterangan == '' or $status == '') {
                    notif_swal('error', 'Status dan Keterangan Tidak Boleh Kosong');
                    return redirect()->back();
                } else {
                    $namaFile = $fotoAbsen->getRandomName();
                    $fotoAbsen->move(LOKASI_UPLOAD, $namaFile);

                    $updateData = [
                        'nama_lengkap' => $memberInfo['nama_lengkap'],
                        'email' => $memberInfo['email'],
                        'instansi_pendidikan' => $memberInfo['instansi_pendidikan'],
                        'nama_instansi' => $memberInfo['nama_instansi'],
                        'nim_nis' => $memberInfo['nim_nis'],
                        'lokasi' => $lokasi,
                        'status' => $status,
                        'keterangan' => $keterangan,
                        'foto_absen' => $namaFile,
                    ];
                    $absensi->insert($updateData);
                    notif_swal_tiga('success', $currentTime, 'Berhasil Checkin');
                    return redirect()->back();
                }
            } else {
                notif_swal('error', 'Melewati batas waktu checkin'); // Error jika melewati batas waktu checkin (masuk)
                return redirect()->back();
            }
        }
    }
    public function history()
    {
        $absensi = new Absensi();
        $sesi_email = session()->get('member_email');
        $jumlahBaris = 10;
        $currentPage = $this->request->getVar('page_absensi');
        $data = [
            'halaman' => 'User | Hitory Absen',
            'title' => 'History Absen',
            'namaFile' => session()->get('member_foto'),
            'aktif_history' => 'aktif',
            'dataAbsen' => $absensi->where('email', $sesi_email)->orderBy('id', 'desc')->paginate($jumlahBaris, 'absensi'),
            'pager' => $absensi->pager,
            'nomor' => nomor($currentPage, $jumlahBaris)
        ];
        return view('user/v_history', $data);
    }
    public function setting()
    {
        $username = session()->get('member_username');
        $member = new MemberModel();
        $data = $member->where('username', $username)->first();
        $email = $data['email'];
        $username = $data['username'];
        $data = [
            'validation' => null,
            'username' => $username,
            'email' => $email,
            'halaman' => 'User  | Setting & Privacy',
            'title' => 'Setting & Privacy',
            'namaFile' => session()->get('member_foto'),
            'aktif_setting' => 'aktif',
        ];
        return view('user/v_setting', $data);
    }
    public function settingProcess()
    {
        $email = $this->request->getVar('email');
        $username = $this->request->getVar('username');
        $password_new = $this->request->getVar('password_new');

        $sesi_email = session()->get('member_email');
        $sesi_username = session()->get('member_username');

        /** Validasi Email */
        if ($email != $sesi_email) {
            $rules = $this->validate([
                'email' => [
                    'rules' => 'required|is_unique[member.email]',
                    'errors' => [
                        'required' => 'Email harus diisi',
                        'is_unique' => 'Email yang dimasukkan sudah terdaftar'
                    ]
                ],
                'password_old' => [
                    'rules' => 'required|check_old_password[password_old]',
                    'errors' => [
                        'required' => 'Current Password harus diisi',
                        'check_old_password' => 'Current Password tidak sesuai'
                    ]
                ]
            ]);
        }
        /** Validasi Username */
        if ($username != $sesi_username) {
            $rules = $this->validate([
                'username' => [
                    'rules' => 'required|is_unique[member.username]|regex_match[/^\S+$/]',
                    'errors' => [
                        'required' => 'Username harus diisi',
                        'is_unique' => 'Username yang dimasukkan sudah terdaftar',
                        'regex_match' => 'Username tidak boleh menggunakan spasi'
                    ]
                ]
            ]);
        }

        /**Validasi password */
        if ($password_new != '') {
            $rules = $this->validate([
                'password_old' => [
                    'rules' => 'required|check_old_password[password_old]',
                    'errors' => [
                        'required' => 'Current Password harus diisi',
                        'check_old_password' => 'Current Password tidak sesuai'
                    ]
                ],
                'password_new' => [
                    'rules' => 'min_length[5]|alpha_numeric',
                    'errors' => [
                        'min_length' => 'Minimun panjang password adalah 5 karakter',
                        'alpha_numeric' => 'Hanya angka, huruf, dan beberapa simbol saja yang diperbolehkan',
                    ]
                ],
                'konfirmasi_password_new' => [
                    'rules' => 'matches[password_new]',
                    'errors' => [
                        'matches' => 'Konfirmasi Password tidak sesuai'
                    ]
                ]
            ]);
        }
        /**JIka tidak ada yang diubah maka akan di redirect kembali tanpa mengubah data apapun */
        if ($username == $sesi_username and $email == $sesi_email and $password_new == '') {
            return redirect()->back();
        }
        /**JIka ada validasi yang error makan akan mengeluarkan errors nya */
        if (!$rules) {
            return view('user/v_setting', [
                'validation' => $this->validator->getErrors(),
                'halaman' => 'User  | Setting & Privacy',
                'title' => 'Setting & Privacy',
                'namaFile' => session()->get('member_foto'),
                'aktif_setting' => 'aktif',
            ]);
        } else {
            /**JIka proses validasi tidak ditemukan error maka akan mengupdate sesuai data yang diubah oleh user  */
            $member = new MemberModel();
            $dataUsername = session()->get('member_username');
            /** Jika email diubah maka akan melakukan update */
            if ($email != $sesi_email) {
                $dataUpdate = [
                    'email' => $email,
                ];
                $member->where('username', $dataUsername)->set($dataUpdate)->update();
                session()->set('member_email', $email);
                notif_swal('success', 'Berhasil Update Data');
                return redirect()->back();
            }
            /** Jika username diubah maka akan melakukan update */
            if ($username != $sesi_username) {
                $dataUpdate = [
                    'username' => $username,
                ];
                $member->where('username', $dataUsername)->set($dataUpdate)->update();
                session()->set('member_username', $username);
                notif_swal('success', 'Berhasil Update Data');
                return redirect()->back();
            }
            /** Jika password diubah maka akan melakukan update */
            if ($password_new != '') {
                $dataUpdate = [
                    'password' => $password_new
                ];
                $member->where('username', $dataUsername)->set($dataUpdate)->update();
                notif_swal('success', 'Berhasil Update Data');
                return redirect()->back();
            }
        }
    }
}
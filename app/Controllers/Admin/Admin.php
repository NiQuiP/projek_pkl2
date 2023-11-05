<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Models\MemberModel;
use App\Models\UserModel;
use App\Models\Absensi;

// use CodeIgniter\Pager\Pager;
// use CodeIgniter\HTTP\RequestInterface;
// use Config\Services;

class Admin extends BaseController
{
    protected $validation;
    protected $helpers = (['url', 'form']);
    function __construct()
    {
        $this->m_admin = new AdminModel();
        $this->m_user = new UserModel();
        $this->validation = \Config\Services::validation();
        helper("cookie");
        helper("global_fungsi_helper");
    }
    public function login()
    {
        if (get_cookie('cookie_username') && get_cookie('cookie_password')) {
            $username = get_cookie('cookie_username');
            $password = get_cookie('cookie_password');

            $dataAkun = $this->m_admin->getData($username);
            if ($password != $dataAkun['password']) {
                $err[] = 'Akun yang kamu masukkan tidak sesuai';
                return redirect()->to('admin/login');
            }

            $akun = [
                'akun_username' => $dataAkun['username'],
                'akun_nama_lengkap' => $dataAkun['nama_lengkap'],
                'akun_email' => $dataAkun['email'],
            ];
            session()->set($akun);
            return redirect()->to('admin/sukses');
        }
        $data = [];
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'username' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'username harus diisi'
                    ]
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'password harus diisi'
                    ]
                ]
            ];
            if (!$this->validate($rules)) {
                session()->setFlashdata('warning', $this->validation->getErrors());
                return redirect()->to('admin/login');
            }

            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
            $remember_me = $this->request->getVar('remember_me');

            $dataAkun = $this->m_admin->getData($username);
            if (!password_verify($password, $dataAkun['password'])) {
                $err[] = 'Akun yang anda masukkan tidak sesuai';
                session()->setFlashdata('username', $username);
                session()->setFlashdata('warning', $err);
                return redirect()->to('admin/login');
            }

            if ($remember_me == '1') {
                set_cookie('cookie_username', $username, 3600 * 24 * 30);
                set_cookie('cookie_password', $dataAkun['password'], 3600 * 24 * 30);
            }

            $akun = [
                'akun_username' => $dataAkun['username'],
                'akun_nama_lengkap' => $dataAkun['nama_lengkap'],
                'akun_email' => $dataAkun['email'],
            ];
            session()->set($akun);
            if ($dataAkun['level'] == '1') {
                return redirect()->to('admin/article')->withCookies();

            }
            if ($dataAkun['level'] == '2') {
                echo 'hai';
            }
        }
        echo view('admin/login', $data);
    }

    function sukses()
    {
        return redirect()->to('admin/article');
        // $dataAkun = $this->m_admin->getData();
        // if ($dataAkun['level'] == 1) {
        //     return redirect()->to('admin/article');

        // } else {
        //     echo "ini user";
        // }
        // print_r(session()->get());
        // echo 'ISIAN COOKIE USERNAME ' . get_cookie('cookie_username') . 'DAN PASSWORD'
        //     . get_cookie('cookie_password');
    }

    function logout()
    {
        delete_cookie('cookie_username');
        delete_cookie('cookie_password');
        session()->destroy();
        if (session()->get('akun_username') != '') {
            session()->setFlashdata('success', 'Anda Berhasil Logout');

        }
        echo view('admin/v_login');
    }

    function lupapassword()
    {
        $err = [];
        if ($this->request->getMethod() == 'post') {
            $username = $this->request->getVar('username');
            if ($username == '') {
                $err[] = "Silahkan masukkan username atau email yang kamu punya";
            }
            if (empty($err)) {
                $data = $this->m_admin->getData($username);
                if (empty($data)) {
                    $err[] = "Akun yang kamu masukkan tidak terdata";
                }
            }
            if (empty($err)) {
                $email = $data["email"];
                $token = md5(date('ymdhis'));

                $link = site_url("admin/resetpassword/?email=$email&token=$token");
                $attachment = "";
                $to = "$email";
                $title = "Reset Password";
                $message = "Berikut ini adalah link untuk melakukan reset password anda";
                $message .= "Silahkan klik link berikut ini $link";

                kirim_email($attachment, $to, $title, $message);


                $dataUpdate = [
                    'email' => $email,
                    'token' => $token
                ];
                $this->m_admin->updateData($dataUpdate);
                session()->setFlashdata("success", "Email untuk recovery sudah dikirimkan ke email kamu");
            }
            if ($err) {
                session()->setFlashdata('username', $username);
                session()->setFlashdata('warning', $err);
            }
            return redirect()->to('admin/lupapassword');
        }
        echo view('admin/v_lupaPassword');
    }

    function resetpassword()
    {
        $err = [];
        $email = $this->request->getVar('email');
        $token = $this->request->getVar('token');
        if ($email != '' and $token != '') {
            $dataAkun = $this->m_admin->getData($email);
            if ($dataAkun['token'] != $token) {
                $err[] = "Token tidak valid";
            }
        } else {
            $err[] = "Parameter yang dikirimkan tidak valid";
        }

        if ($err) {
            session()->setFlashdata('warning', $err);
        }

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'password' => [
                    'rules' => 'required|min_length[5]',
                    'errors' => [
                        'required' => 'Password harus diisi',
                        'min_length' => 'Panjang karakter minimum untuk 
                        password adalah 5 karakter'
                    ]
                ],
                'konfirmasi_password' => [
                    'rules' => 'required|min_length[5]|matches[password]',
                    'errors' => [
                        'required' => 'Konfirmasi password harus diisi',
                        'min_length' => 'Panjang karakter minimum untuk 
                    konfirmasi password adalah 5 karakter',
                        'matches' => 'Konfirmasi password tidak sesuai 
                    dengan password yang diisikan'
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                session()->setFlashdata('warning', $this->validation->getErrors());
            } else {
                $dataUpdate = [
                    'email' => $email,
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                    'token' => null
                ];
                $this->m_admin->updateData($dataUpdate);
                session()->setFlashdata('success', 'Password berhasil direset, silahkan login');
                delete_cookie('cookie_username');
                delete_cookie('cookie_password');
                return redirect()->to('admin/login')->withCookies();
            }

        }
        echo view('admin/v_resetpassword');
    }


    public function dashboard()
    {
        $absensi = new Absensi();
        $bulanIni = date('Y-m');

        $absensiInfo = $absensi->where("DATE_FORMAT(waktu_absen,'%Y-%m')", $bulanIni)->select('nim_nis, nama_lengkap, nama_instansi')->distinct('nim_nis')->get()->getResult();
        $totalAbsensi = [];
        foreach ($absensiInfo as $nim_nis) {
            $nimUser = $nim_nis->nim_nis;
            $totalAbsensi[$nimUser]['masuk'] = $absensi->getTotalAbsensiByStatus($nimUser, 'Masuk');
            $totalAbsensi[$nimUser]['izin'] = $absensi->getTotalAbsensiByStatus($nimUser, 'Izin');
            $totalAbsensi[$nimUser]['sakit'] = $absensi->getTotalAbsensiByStatus($nimUser, 'Sakit');
        }
        $user = new MemberModel();

        $jumlahSekolah = $user->getJumlahInstansi('sekolah');
        $jumlahUniv = $user->getJumlahInstansi('universitas');
        $totalSiswa = $user->getTotalUser('Siswa');
        $totalMahasiswa = $user->getTotalUser('Mahasiswa');
        $aktif_dashboard = 'aktif';
        $halaman = 'Admin | Dashboard';
        $title = 'Dashboard';

        $data = [
            'dataAbsen' => $absensiInfo,
            'totalAbsensi' => $totalAbsensi,
            'totalSekolah' => $jumlahSekolah,
            'totalUniv' => $jumlahUniv,
            'totalMahasiswa' => $totalMahasiswa,
            'totalSiswa' => $totalSiswa,
            'aktif_dashboard' => $aktif_dashboard,
            'halaman' => $halaman,
            'title' => $title
        ];
        return view('admin/v_dashboard', $data);
    }

    public function data_absen()
    {
        $absensi = new Absensi();
        $jumlahBaris = 10;
        $currentPage = $this->request->getVar('page_absensi');
        $dataAbsen = $absensi->findAll();
        $nomor = nomor($currentPage, $jumlahBaris);
        $aktif_dataAbsen = 'aktif';
        $halaman = 'Admin | Data Absensi';
        $title = 'Data Absensi';

        $data = [
            'dataAbsen' => $dataAbsen,
            'nomor' => $nomor,
            'aktif_dataAbsen' => $aktif_dataAbsen,
            'halaman' => $halaman,
            'title' => $title
        ];
        return view('admin/v_dataAbsen', $data);
    }

    public function data_siswa()
    {
        $user = new MemberModel();
        $jumlahBaris = 10;
        $currentPage = $this->request->getVar('page_siswa');
        $dataSiswa = $user->where('jenis_user', 'Siswa')->findAll();
        $nomor = nomor($currentPage, $jumlahBaris);
        $aktif_dataUser = 'aktif';
        $halaman = 'Admin | Data Siswa';
        $title = 'Data Siswa';

        $data = [
            'dataSiswa' => $dataSiswa,
            'nomor' => $nomor,
            'aktif_dataUser' => $aktif_dataUser,
            'halaman' => $halaman,
            'title' => $title
        ];

        return view('admin/v_dataSiswa', $data);
    }
    public function data_mahasiswa()
    {
        $user = new MemberModel();
        $jumlahBaris = 10;
        $currentPage = $this->request->getVar('page_mahasiswa');
        $dataMahasiswa = $user->where('jenis_user', 'mahasiswa')->paginate($jumlahBaris, 'mahasiswa');

        $nomor = nomor($currentPage, $jumlahBaris);
        $aktif_dataUser = 'aktif';
        $halaman = 'Admin | Data Mahasiswa';
        $title = 'Data Mahasiswa';

        $data = [
            'dataMahasiswa' => $dataMahasiswa,
            'nomor' => $nomor,
            'aktif_dataUser' => $aktif_dataUser,
            'halaman' => $halaman,
            'title' => $title
        ];

        return view('admin/v_dataMahasiswa', $data);
    }

    function tambahUser()
    {
        $id = $this->request->getPost('id');

        $validasi = \Config\Services::validation();
        $aturan = [
            'nama_lengkap' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Lengkap wajib diisi',
                ]
            ],
            'nim_nis' => [
                'rules' => 'required|is_unique[member.nim_nis, member_id,' . $id . ']',
                'errors' => [
                    'required' => 'NIM/NIS wajib diisi',
                    'is_unique' => 'NIM/NIS sudah terdaftar'
                ]
            ],
            'username' => [
                'rules' => 'required|is_unique[member.username, member_id,' . $id . ']|regex_match[/^\S+$/]',
                'errors' => [
                    'required' => 'Username wajib diisi',
                    'is_unique' => 'Username sudah terdaftar',
                    'regex_match' => 'Username tidak boleh menggunakan spasi'
                ]
            ],
            'gender' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis Kelamin wajib diisi',
                ]
            ],
            'no_hp' => [
                'rules' => 'required|is_unique[member.no_hp, member_id,' . $id . ']',
                'errors' => [
                    'required' => 'Nomor Telepon wajib diisi',
                    'is_unique' => 'Nomor Telepon sudah terdaftar'
                ]
            ],
            'email' => [
                'rules' => 'required|is_unique[member.email, member_id,' . $id . ']',
                'errors' => [
                    'required' => 'Email wajib diisi',
                    'is_unique' => 'Email sudah terdaftar'
                ]
            ],
            'instansi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Instansi Pendidikan wajib diisi',
                ]
            ],
            'nama_instansi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Instansi wajib diisi',
                ]
            ],
        ];

        $validasi->setRules($aturan);
        if ($validasi->withRequest($this->request)->run()) {
            $id = $this->request->getPost('id');
            $nama_lengkap = $this->request->getPost('nama_lengkap');
            $nim_nis = $this->request->getPost('nim_nis');
            $username = $this->request->getPost('username');
            $gender = $this->request->getPost('gender');
            $no_hp = $this->request->getPost('no_hp');
            $email = $this->request->getPost('email');
            $instansi = $this->request->getPost('instansi');
            $nama_instansi = strtoupper($this->request->getPost('nama_instansi'));

            if ($instansi == 'Sekolah') {
                $jenis_user = 'Siswa';
            } else {
                $jenis_user = 'Mahasiswa';
            }
            $data = [
                'member_id' => $id,
                'nama_lengkap' => $nama_lengkap,
                'nim_nis' => $nim_nis,
                'username' => $username,
                'jenis_kelamin' => $gender,
                'email' => $email,
                'password' => '12345678',
                'no_hp' => $no_hp,
                'instansi_pendidikan' => $instansi,
                'nama_instansi' => $nama_instansi,
                'jenis_user' => $jenis_user,
            ];
            $user = new MemberModel();
            $user->save($data);


            notif_swal('success', 'Berhasil simpan data');

            $hasil['sukses'] = 'Berhasil simpan data';
            // $hasil['error'] = true;
        } else {
            // $hasil['sukses'] = false;
            $hasil = [
                // 'sukses' => false,
                'error' => [
                    'nama_lengkap' => $validasi->getError('nama_lengkap'),
                    'nim_nis' => $validasi->getError('nim_nis'),
                    'username' => $validasi->getError('username'),
                    'gender' => $validasi->getError('gender'),
                    'no_hp' => $validasi->getError('no_hp'),
                    'email' => $validasi->getError('email'),
                    'instansi' => $validasi->getError('instansi'),
                    'nama_instansi' => $validasi->getError('nama_instansi'),
                ],
            ];
        }

        echo json_encode($hasil);
    }

    // public function tambahUSer()
    // {
    //     if ($this->request->isAJAX()) {
    //         $msg = [
    //             'data' => view('admin/modal/modalTambah'),
    //         ];
    //     }
    //     echo json_encode($msg);
    // }

    public function editUser($id)
    {
        $user = new MemberModel();
        $data = $user->find($id);
        return json_encode($data);
    }

    public function hapus($id)
    {
        $user = new MemberModel();
        $user->delete($id);
        notif_swal('success', 'Terhapus');
        return redirect()->back();
    }
}
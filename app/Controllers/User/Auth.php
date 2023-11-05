<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\MemberModel;

;

class Auth extends BaseController
{
    protected $helpers = (['url', 'form']);
    protected $validation;
    protected $member;

    function __construct()
    {
        $this->validation = \Config\Services::validation();
        helper('global_fungsi_helper');
        helper('cookie');

    }

    public function login()
    {
        $data = [
            'validation' => null
        ];
        echo view('user/auth/login', $data);
    }

    function loginProcess()
    {
        $fieldType = filter_var($this->request->getVar('login_id'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $username = $this->request->getVar('login_id');
        $password = $this->request->getVar('password');

        if ($fieldType == 'username') {
            $rules = ($this->validate([
                'login_id' => [
                    'rules' => 'required|is_not_unique[member.username]',
                    'errors' => [
                        'required' => '',
                        'is_not_unique' => 'Username yang dimasukkan tidak terdaftar',
                    ]
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '',
                    ]
                ],

            ]));
        } else {
            $rules = ($this->validate([
                'login_id' => [
                    'rules' => 'required|is_not_unique[member.email]',
                    'errors' => [
                        'required' => '',
                        'is_not_unique' => 'Email yang dimasukkan tidak terdaftar',
                    ]
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '',
                    ]
                ],

            ]));
        }

        if (!$rules) {
            return view('user/auth/login', [
                'validation' => $this->validator->getErrors(),
            ]);

        } else {
            $member = new MemberModel();
            $memberInfo = $member->where($fieldType, $username)->first();
            $memberPassword = $memberInfo['password'];

            if (($password != $memberPassword)) {
                session()->setFlashdata('login_id', $username);
                $err = 'Password yang dimasukkan salah';
                return redirect()->back()->with('error', $err);
            }
            if (empty($err)) {
                if ($memberInfo['is_verifikasi'] == 'no') {
                    session()->set('member_email', $memberInfo['email']);
                    $err[] = 'Akun anda belum diverifikasi, silahkan dapatkan token untuk verifikasi';
                    session()->setFlashdata('warning', $err);
                    return redirect()->to('user/kirim_ulang');
                }
            }
            if (empty($err)) {
                $dataSesi = [
                    'logged_in' => true,
                    'member_id' => $memberInfo['member_id'],
                    'member_username' => $memberInfo['username'],
                    'member_password' => $memberInfo['password'],
                    'member_email' => $memberInfo['email'],
                    'member_nama_lengkap' => $memberInfo['nama_lengkap'],
                    'member_nim_nis' => $memberInfo['nim_nis'],
                    'member_jenis_kelamin' => $memberInfo['jenis_kelamin'],
                    'member_no_hp' => $memberInfo['no_hp'],
                    'member_instansi' => $memberInfo['instansi_pendidikan'],
                    'member_nama_instansi' => $memberInfo['nama_instansi'],
                    'member_foto' => $memberInfo['foto'],
                ];
                session()->set($dataSesi);
                if ($memberInfo['level'] == '1') {
                    notif_swal('success', 'Selamat Datang');
                    session()->set('redirected', 'superadmin');
                    return redirect()->to('admin/dashboard');
                } else if ($memberInfo['level'] == '2') {
                    notif_swal('success', 'Selamat Datang');
                    session()->set('redirected', 'admin');
                    return redirect()->to('admin/dashboard');
                } else if ($memberInfo['level'] == '3') {
                    notif_swal('success', 'Selamat Datang');
                    session()->set('redirected', 'user');
                    return redirect()->to('user/my-profile');
                }
            }

        }
    }

    function admin()
    {
        echo 'admin';
    }

    function logout()
    {
        session()->destroy();
        /** Untuk session login */
        if (session()->get('member_username') != '') {
            session()->setFlashdata('success', 'Anda Berhasil Logout');
        }
        /** Untuk session register */
        if (session()->get('akun_username') != '') {
            session()->setFlashdata('success', 'Anda Berhasil Logout');
        }
        return view('user/auth/login');
    }

    public function register()
    {
        $data = [
            'validation' => null
        ];
        return view('user/auth/register', $data);
    }

    public function registerProcess()
    {
        $member = new MemberModel();
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $rules = $this->validate([
            'username' => [
                'rules' => 'required|is_unique[member.username]|regex_match[/^\S+$/]',
                'errors' => [
                    'required' => '',
                    'is_unique' => 'Username sudah terdaftar',
                    'regex_match' => 'Username tidak boleh menggunakan spasi'
                ]
            ],
            'email' => [
                'rules' => 'required|is_unique[member.email]',
                'errors' => [
                    'required' => '',
                    'is_unique' => 'Email sudah terdaftar',
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[5]|alpha_numeric',
                'errors' => [
                    'required' => '',
                    'min_length' => 'Minimum karakter untuk password adalah 5',
                    'alpha_numeric' => 'Hanya angka, huruf, dan beberapa simbol saja yang diperbolehkan'
                ]
            ],
            'konfirmasi_password' => [
                'rules' => 'matches[password]',
                'errors' => [
                    'matches' => 'Konfirmasi Password harus sama dengan Password',
                ]
            ]
        ]);
        if (!$rules) {
            return view('user/auth/register', [
                'validation' => $this->validator->getErrors(),
            ]);
        } else {
            /**Membuat function kirim email verifikasi menggunakan helpers */
            $email = $this->request->getVar('email');
            $token = md5(date('ymdhis'));
            $link = site_url("user/verifikasi/?email=$email&token=$token");
            $attachment = "";
            $to = "$email";
            $title = "Verifikasi Akun";
            $message = "Berikut ini adalah link untuk melakukan verifikasi akun anda, ";
            $message .= "Silahkan klik link berikut ini $link";
            kirim_email($attachment, $to, $title, $message);

            /**Mendaftarkan akun ke database */
            $dataUpdate = [
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'token' => $token
            ];
            $member->insert($dataUpdate);

            /**Membuat session user*/
            $dataSesi = [
                'member_email' => $email,
                'member_password' => $password,
            ];
            session()->set($dataSesi);
            /**Pesan sukses */
            session()->setFlashdata("success", "Berhasil register, link verifikasi sudah dikirim ke Email anda");
            return redirect()->to('/register');
        }
    }

    function verifikasi()
    {
        $err = [];
        $email = $this->request->getVar('email');
        $token = $this->request->getVar('token');

        if ($email == '' and $token == '') {
            $err[] = 'Parameter yang dikirimkan tidak valid';

        }
        if (empty($err)) {
            $member = new MemberModel();
            $memberInfo = $member->where('email', $email)->first();
            if ($memberInfo['token'] != $token) {
                session()->set('member_email', $email);
                $err[] = 'Token tidak valid, Silahkan kirim ulang token';
            }

        }
        $verifikasi = $this->request->getVar('verifikasi');
        if ($verifikasi) {
            $dataUpdate = [
                'token' => null
            ];
            /**Mengupdate data ke DB */
            $member->where('email', $email)->set($dataUpdate)->update();
            /**Membuat session register */
            $dataSesi = [
                'akun_username' => $memberInfo['username'],
                'member_email' => $memberInfo['email'],
                'member_no_hp' => $memberInfo['no_hp']
            ];
            session()->set($dataSesi);

            notif_swal_dua('info', 'Lengkapi data berikut untuk melanjutkan proses verifikasi');
            return redirect()->to('user/index');
        }

        if ($err) {
            session()->setFlashdata('warning', $err);
            return redirect()->to('user/kirim_ulang');
        }

        $kirim_ulang = $this->request->getVar('kirim_ulang');
        if ($kirim_ulang) {
            return redirect()->to('user/kirim_ulang');
        }
        echo view('user/verifikasi');
    }

    function kirim_ulang_token()
    {
        /**Jalur Login */
        $kirim_ulang = $this->request->getVar('kirim_ulang');
        if ($kirim_ulang) {

            $member = new MemberModel();
            $email = session()->get('member_email');
            $memberInfo = $member->where('email', $email)->first();

            $token = md5(date('ymdhis'));


            $link = site_url("user/verifikasi/?email=$email&token=$token");
            $attachment = "";
            $to = "$email";
            $title = "Reset Password";
            $message = "Berikut ini adalah link untuk melakukan verifikasi akun anda, ";
            $message .= "Silahkan klik link berikut ini $link";

            kirim_email($attachment, $to, $title, $message);
            $updateToken = [
                "token" => $token,
            ];
            /*Mengupdate token user */
            $member->where('email', $email)->set($updateToken)->update();

            $success = 'Token berhasil dikirim, silahkan cek email anda';
            if ($success) {
                session()->setFlashdata('success', $success);
                return redirect()->to('user/kirim_ulang');
            }
        }
        $verifikasi = $this->request->getVar('verifikasi');
        if ($verifikasi) {
            return redirect()->to('user/verifikasi');
        }


        echo view('user/verifikasi');
    }

    function index()
    {
        $data = [
            'validation' => null,
            $this->request->getVar()
        ];

        echo view('user/lengkapi_data', $data);
    }

    public function indexHandler()
    {
        /**Merekam input dari user */
        $nama_lengkap = $this->request->getVar('nama_lengkap');
        $nim_nis = $this->request->getVar('nim_nis');
        $no_hp = $this->request->getVar('no_hp');
        $gender = $this->request->getVar('gender');
        $instansi = $this->request->getVar('instansi');
        $nama_instansi = strtoupper($this->request->getVar('nama_instansi'));
        $fileProfile = $this->request->getFile('profile');


        if ($fileProfile == '') {
            $namaFile = 'profile.png';
        } else {
            $namaFile = $fileProfile->getRandomName();
            $fileProfile->move(LOKASI_UPLOAD, $namaFile);
        }

        /**Mengambil session */
        $email = session()->get('member_email');

        $member = new MemberModel();
        $memberInfo = $member->where('email', $email)->first();
        $rules = $this->validate([
            'nama_lengkap' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Lengkap tidak boleh kosong',
                ]
            ],
            'nim_nis' => [
                'rules' => 'required|is_unique[member.nim_nis]',
                'errors' => [
                    'required' => 'NIS/NIM tidak boleh kosong',
                    'is_unique' => 'NIS/NIM sudah terdaftar'
                ]
            ],
            'gender' => [
                'rules' => 'required',
                'errors' => [
                    'required' => ''
                ]
            ],
            'instansi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => ''
                ]
            ],
            'nama_instansi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Instansi tidak boleh kosong',
                ]
            ],
            'no_hp' => [
                'rules' => 'required|is_unique[member.no_hp]|numeric',
                'errors' => [
                    'required' => 'Nomor Telepon tidak boleh kosong',
                    'numeric' => 'Nomor Telepon hanya boleh berisi angka',
                    'is_unique' => 'Nomor Telepon sudah terdaftar'
                ]
            ]
        ]);


        if (!$rules) {

            return view('user/lengkapi_data', [
                'validation' => $this->validator->getErrors()
            ]);

        } else {
            if ($instansi == 'Sekolah') {
                $jenis_user = 'Siswa';
            } else {
                $jenis_user = 'Mahasiswa';
            }
            $dataUpdate = [
                'nama_lengkap' => $nama_lengkap,
                'nim_nis' => $nim_nis,
                'jenis_kelamin' => $gender,
                'no_hp' => $no_hp,
                'foto' => $namaFile,
                'instansi_pendidikan' => $instansi,
                'nama_instansi' => $nama_instansi,
                'jenis_user' => $jenis_user,
                'is_verifikasi' => 'yes'
            ];
            $member->where('email', $email)->set($dataUpdate)->update();
            session()->remove('akun_username');
            $dataSesi = [
                'logged_in' => true,
                'redirected' => 'user',
                'member_username' => $memberInfo['username'],
                'member_email' => $memberInfo['email'],
                'member_nama_lengkap' => $nama_lengkap,
                'member_no_hp' => $no_hp,
                'member_foto' => $namaFile,
                'member_jenis_kelamin' => $gender,
                'member_nim_nis' => $nim_nis,
                'member_instansi' => $instansi,
                'member_nama_instansi' => $nama_instansi,
            ];
            session()->set($dataSesi);
            notif_swal('success', 'Berhasil Verifikasi Akun');
            return redirect()->to('user/my-profile');
        }

    }

    public function forgetPassword()
    {
        if ($this->request->getMethod() == 'post') {
            $fieldType = filter_var($this->request->getVar('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            $userInput = $this->request->getVar('email');

            if ($userInput == '') {
                $err = 'Masukkan Username atau Email untuk melakukan reset password';
            }

            if (empty($err)) {
                if ($fieldType == 'email') {
                    $member = new MemberModel();
                    $memberInfo = $member->where($fieldType, $userInput)->first();
                    if (!$memberInfo) {
                        $err = 'Email yang dimasukkan tidak terdaftar';
                    }
                }
            }

            if (empty($err)) {
                if ($fieldType == 'username') {
                    $member = new MemberModel();
                    $memberInfo = $member->where($fieldType, $userInput)->first();
                    if (!$memberInfo) {
                        $err = 'Username yang dimasukkan tidak terdaftar';
                    }
                }
            }

            if (empty($err)) {
                $email = $memberInfo['email'];
                $token = md5(date('ymdhis'));
                $link = site_url("resetpassword/?email=$email&token=$token");
                $attachment = "";
                $to = "$email";
                $title = "Reset Password";
                $message = "Berikut ini adalah link untuk melakukan reset password, ";
                $message .= "Silahkan klik link berikut ini $link";
                kirim_email($attachment, $to, $title, $message);

                $dataUpdate = [
                    'email' => $memberInfo['email'],
                    'token' => $token
                ];
                $member->where('email', $email)->set($dataUpdate)->update();

                session()->set('email', $email);
                session()->setFlashdata('success', 'Link reset password sudah dikirmkan ke email anda');
                return redirect()->back();
            }

            if ($err) {
                session()->setFlashdata('email', $userInput);
                session()->setFlashdata('invalid', 'is-invalid');
                session()->setFlashdata('error', $err);
                return redirect()->back();
            }
        }


        echo view('user/auth/forgetPassword');
    }

    function resetPassword()
    {
        $token = $this->request->getVar('token');
        $email = session()->get('email');
        $member = new MemberModel();
        $memberInfo = $member->where('email', $email)->first();
        $dataToken = $memberInfo['token'];

        if ($dataToken != $token) {
            $err = 'Token tidak valid, silahkan dapatkan link verifikasi kembali';
            session()->setFlashdata('error', $err);
            return redirect()->to('/forgetpassword');
        }


        $data = [
            'validation' => null
        ];
        echo view('user/auth/resetPassword', $data);
    }

    function resetPasswordProcess()
    {


        if (empty($err)) {
            $rules = $this->validate([
                'password' => [
                    'rules' => 'required|min_length[5]',
                    'errors' => [
                        'required' => '',
                        'min_length' => 'Minimum karakter untuk Password adalah 5 karakter'
                    ]
                ],
                'konfirmasi_password' => [
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        'required' => 'Konfirmasi ',
                        'matches' => 'Konfirmasi Password harus sama dengan Password'
                    ]
                ]
            ]);
            if (!$rules) {
                return view('user/auth/resetPassword', [
                    'validation' => $this->validator->getErrors()
                ]);
            } else {
                $member = new MemberModel();
                $email = session()->get('email');
                $password = $this->request->getVar('password');
                $dataUpdate = [
                    'password' => $password,
                    'token' => ''
                ];
                $member->where('email', $email)->set($dataUpdate)->update();
                session()->remove('email');
                session()->setFlashdata('success', 'Password berhasil direset, silahkan login');
                return redirect()->to('/login');
            }
        }

    }


}
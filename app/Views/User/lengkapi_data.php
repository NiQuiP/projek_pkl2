<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        User | Create Account
    </title>
    <link rel="stylesheet" href="<?= base_url('admin'); ?>/css/sidebar.css" />
    <link rel="stylesheet" href="<?= base_url('admin'); ?>/css/index.css">


    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <script src="https://kit.fontawesome.com/fb6ebd8b45.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto+Condensed&display=swap"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />


</head>

<body class="kontainer">
    <!-- Sidebar -->
    <nav class="navigasi">
        <div class="wrapperNav">
            <header>
                <div class="text">
                    <h1 class="nama-lengkap">
                        (Username)
                    </h1>
                    <h2 class="sekolah">
                        (Nama Instansi)
                    </h2>
                </div>
            </header>
        </div>
    </nav>
    <!-- Main Content -->
    <main class="kontainer-content">
        <?php $namaFile = session()->get('member_foto') ?>
        <div class="wrapper-icon">
            <i class="bx bx-menu"></i>
        </div>
        <header class="first">
            <div class="wrapper-name">
                <div class="user-text">
                    admin
                </div>
                <div class="user-profile">
                    <img src="<?= base_url(LOKASI_UPLOAD . '/' . 'profile.png') ?>" />
                </div>
            </div>
            <!-- <div class="dropdownMenu">
                <div class="wrapper-user">
                    <img src="<?= base_url(LOKASI_UPLOAD . '/' . 'profile.png') ?>" />
                    <div class="userText">
                        <?= session()->get('member_username') ?>
                    </div>
                </div>
                <div class="wrapper-a">
                    <a href="<?= site_url('member/my-profile'); ?>">Lihat Profile</a>
                </div>
                <div class="wrapper-logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <a href="<?= site_url('user/logout') ?>">Keluar</a>
                </div>
            </div> -->
        </header>
        <header class="second">
            <div class="text">
                Create Account
            </div>
        </header>
        <!-- Template Main Content -->
        <main class="wrapper-content-profile">
            <div class="kontainer-profile">
                <div class="wrapper-profile">
                    <div class="profile-body">
                        <div class="display_image">
                            <div class="tampil" id="display_image"></div>
                        </div>
                    </div>
                    <div class="text">
                        <label for="upload" class="uploud-image">Pilih Gambar</label>
                    </div>
                    <input name="profile" type="file" id="upload" accept=".png, .jpg, .jpeg"
                        style="visibility: hidden" />
                </div>
            </div>
            <div class="wrapper-identity-profile">
                <?php $validation = \Config\Services::validation() ?>
                <form action="<?= route_to('/index') ?>" method="post" enctype="multipart/form-data">
                    <div class="identitas-profile">
                        <label for="nama_lengkap">Nama Lengkap : </label>
                        <input type="text" name="nama_lengkap"
                            class="form-control <?= ($validation->hasError('nama_lengkap')) ? 'is-invalid' : ''; ?>"
                            id="" value="<?= set_value('nama_lengkap') ?>" />
                        <div class="invalid-feedbak">
                            <?= $validation->getError('nama_lengkap') ?>
                        </div>
                    </div>
                    <div class="identitas-profile">
                        <label for="nim/nis">NIM/NIS : </label>
                        <input type="number" name="nim_nis" id="nim_nis"
                            class="form-control <?= ($validation->hasError('nim_nis')) ? 'is-invalid' : ''; ?>"
                            value="<?= set_value('nim_nis') ?>" />
                        <div class="invalid-feedbak">
                            <?= $validation->getError('nim_nis') ?>
                        </div>
                    </div>
                    <div class="identitas-profile">
                        <label for="username">Username : </label>
                        <input type="text" name="username" id="" value="<?= session()->get('akun_username'); ?>"
                            readonly />
                    </div>
                    <div class="identitas-profile">
                        <label for="gender">Jenis Kelamin : </label>
                        <select name="gender" id="gender"
                            class="form-select <?= ($validation->hasError('gender')) ? 'is-invalid' : ''; ?>"
                            value="<?= set_value('selected_gender') ?>" onchange="updateValueG()">
                            <option value="" hidden></option>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                        <div class="invalid-feedbak">
                            <?= $validation->getError('gender') ?>
                        </div>
                    </div>
                    <div class="identitas-profile">
                        <label for="no_hp">No. Telepon :</label>
                        <input type="number" name="no_hp" id="" pattern="[0-9]{4}[0-9]{4}[0-9]{5}"
                            class="form-control <?= ($validation->hasError('no_hp')) ? 'is-invalid' : ''; ?>"
                            value="<?= set_value('no_hp') ?>" placeholder="08xxxxx" />
                        <div class="invalid-feedbak">
                            <?= $validation->getError('no_hp') ?>
                        </div>
                    </div>
                    <div class="identitas-profile">
                        <label for="email">Email :</label>
                        <input type="email" name="email" id="" value="<?= session()->get('member_email'); ?>"
                            readonly />
                    </div>
                    <div class="identitas-profileInstansi" id="instansi">
                        <div class="instansiAsal">
                            <label for="instansi">Instansi Pendidikan :</label>
                            <select name="instansi" id="instansi"
                                class="form-select <?= ($validation->hasError('instansi')) ? 'is-invalid' : ''; ?>"
                                value="<?= set_value('selected_instansi') ?>" onchange="updateValueI()">
                                <option value="" hidden></option>
                                <option value="Universitas">Universitas</option>
                                <option value="Sekolah">Sekolah</option>
                            </select>
                            <div class="invalid-feedbak">
                                <?= $validation->getError('instansi') ?>
                            </div>
                        </div>
                        <div class="instansiNama">
                            <label for="nama_instansi">Nama Instansi :</label>
                            <input type="text" name="nama_instansi" id=""
                                class="form-control <?= ($validation->hasError('nama_instansi')) ? 'is-invalid' : ''; ?>"
                                value="<?= set_value('nama_instansi') ?>" />
                            <div class="invalid-feedbak">
                                <?= $validation->getError('nama_instansi') ?>
                            </div>
                        </div>
                    </div>
                    <div class="wrapper-submit">
                        <button class="submit" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </main>
        <!-- End of Template Main Content -->
    </main>
    <!-- JS -->

    <script src="<?= base_url('admin'); ?>/js/script-index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    <?php if (session()->getFlashdata('swal_icon2')): ?>
    Swal.fire({
        icon: '<?= session()->getFlashdata('swal_icon2'); ?>',
        text: '<?= session()->getFlashdata('swal_text2'); ?>',
    })
    <?php endif; ?>
    </script>
</body>

</html>
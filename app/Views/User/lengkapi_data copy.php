<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User | Create Account</title>
  <link rel="stylesheet" href="<?= base_url('admin'); ?>/css/style.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&family=Roboto+Condensed&display=swap"
    rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
    crossorigin="anonymous"></script> -->
</head>

<body class="kontainer">
  <!-- Sidebar -->
  <nav>
    <header>
      <div class="text">
        <h1>(Username)</h1>
        <h2>(Sekolah)</h2>
      </div>
    </header>

  </nav>
  <!-- Main Content -->
  <main class="kontainer-content">
    <header class="first">
      <div class="wrapper-icon">
        <i class="bx bx-menu"></i>
      </div>
      <div class="wrapper-name">
        <div class="user-text">(Nama Lengkap)</div>
        <div class="user-profile"></div>
        <div class="display_image">
          <div class="tampil" id="display_image_h"></div>
          <img src="" alt="" />
        </div>
      </div>
    </header>
    <header class="second">
      <div class="text">Create Account</div>
    </header>
    <main class="wrapper-content">
      <div class="wrapper-identity">
        <?php $validation = \Config\Services::validation(); ?>
        <?php session()->get(); ?>
        <div class="wrapper-identity">
          <form action="<?= route_to('user.index.handler') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <!-- <input type="hidden" name="selected_gender" id="selected_gender" value="">
            <input type="hidden" name="selected_instansi" id="selected_instansi" value=""> -->
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
                <input name="profile" type="file" id="upload" accept=".png, .jpg, .jpeg" style="visibility: hidden" />
              </div>
            </div>
            <div class="wrapper-identitas">
              <div class="identitas">
                <label for="nama_lengkap">Nama Lengkap : </label>
                <input type="text" name="nama_lengkap"
                  class="form-control <?= ($validation->hasError('nama_lengkap')) ? 'is-invalid' : ''; ?>" id=""
                  value="<?= set_value('nama_lengkap') ?>" />
                <div class="invalid-feedback">
                  <?= $validation->getError('nama_lengkap') ?>
                </div>
              </div>
              <div class="identitas">
                <label for="nim/nis">NIM/NIS : </label>
                <input type="number" name="nim_nis" id="nim_nis"
                  class="form-control <?= ($validation->hasError('nim_nis')) ? 'is-invalid' : ''; ?>"
                  value="<?= set_value('nim_nis') ?>" />
                <div class="invalid-feedback">
                  <?= $validation->getError('nim_nis') ?>
                </div>
              </div>
              <div class="identitas">
                <label for="username">Username : </label>
                <input type="text" name="username" id="" value="<?= session()->get('akun_username'); ?>" readonly />
              </div>
              <div class="identitas">
                <label for="gender">Jenis Kelamin : </label>
                <select name="gender" id="gender"
                  class="form-select <?= ($validation->hasError('gender')) ? 'is-invalid' : ''; ?>"
                  value="<?= set_value('selected_gender') ?>" onchange="updateValueG()">
                  <option value="" hidden></option>
                  <option value="Pria">Pria</option>
                  <option value="Wanita">Wanita</option>
                </select>
                <div class="invalid-feedback">
                  <?= $validation->getError('gender') ?>
                </div>
              </div>
              <div class="identitas">
                <label for="no_hp">No. Telepon :</label>
                <input type="number" name="no_hp" id="" pattern="[0-9]{4}[0-9]{4}[0-9]{5}"
                  class="form-control <?= ($validation->hasError('no_hp')) ? 'is-invalid' : ''; ?>"
                  value="<?= set_value('no_hp') ?>" placeholder="08xxxxx" />
                <div class="invalid-feedback">
                  <?= $validation->getError('no_hp') ?>
                </div>
              </div>
              <div class="identitas">
                <label for="email">Email :</label>
                <input type="email" name="email" id="" value="<?= session()->get('member_email'); ?>" readonly />
              </div>
              <div class="identitasInstansi" id="">
                <div class="instansiAsal">
                  <label for="instansi">Instansi Pendidikan :</label>
                  <select name="instansi" id="instansi"
                    class="form-select <?= ($validation->hasError('instansi')) ? 'is-invalid' : ''; ?>"
                    value="<?= set_value('selected_instansi') ?>" onchange="updateValueI()">
                    <option value="" hidden></option>
                    <option value="Universitas">Universitas</option>
                    <option value="Sekolah">Sekolah</option>
                  </select>
                  <div class="invalid-feedback">
                    <?= $validation->getError('instansi') ?>
                  </div>
                </div>
                <div class="instansiNama">
                  <label for="nama_instansi">Nama Instansi :</label>
                  <input type="text" name="nama_instansi" id=""
                    class="form-control <?= ($validation->hasError('nama_instansi')) ? 'is-invalid' : ''; ?>"
                    value="<?= set_value('nama_instansi') ?>" />
                  <div class="invalid-feedback">
                    <?= $validation->getError('nama_instansi') ?>
                  </div>
                </div>
              </div>
              <div class="wrapper-submit">
                <button class="submit" type="submit">Submit</button>
              </div>
            </div>
          </form>
        </div>
    </main>
  </main>

  <script src="<?= base_url(); ?>/admin/js/script-index.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    <?php if (session()->getFlashdata('swal_icon')): ?>
      Swal.fire({
        icon: '<?= session()->getFlashdata('swal_icon'); ?>',
        text: '<?= session()->getFlashdata('swal_text'); ?>',
      })
    <?php endif; ?>
  </script>
</body>

</html>
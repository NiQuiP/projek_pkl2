<?= $this->extend('admin/layout/v_template'); ?>

<?= $this->section('content'); ?>
<!-- Begin Page Content -->

<div class="container-fluid">
    <div class="container-fluid d-flex mt-3">
        <div class="row row-cols-2">
            <div class="col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Sekolah
                                </div>
                                <div class="h3 mb-0 font-weight-bold text-gray-800" name="sekolah">
                                    <?= $totalSekolah ?>
                                </div>
                                <div class="font-weight-bold text-primary mt-1">
                                    <a href="">Info
                                        <i class="fa-regular fa-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-school fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Siswa
                                </div>
                                <div class="h3 mb-0 font-weight-bold text-gray-800" name="card-ssw">
                                    <?= $totalSiswa ?>
                                </div>
                                <div class="font-weight-bold text-primary mt-1">
                                    <a href="<?= site_url('admin/data-siswa'); ?>">Info
                                        <i class="fa-regular fa-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Active User
                                </div>
                                <div class="h3 mb-0 font-weight-bold text-gray-800" name="aktif">
                                    6 <span>Active</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Universitas
                                </div>
                                <div class="h3 mb-0 font-weight-bold text-gray-800" name="univ">
                                    <?= $totalUniv ?>
                                </div>
                                <div class="font-weight-bold text-primary mt-1">
                                    <a href="">Info
                                        <i class="fa-regular fa-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-school fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Mahasiswa
                                </div>
                                <div class="h3 mb-0 font-weight-bold text-gray-800" name="card-mhs">
                                    <?= $totalMahasiswa ?>
                                </div>
                                <div class="font-weight-bold text-primary mt-1">
                                    <a href="<?= site_url('admin/data-mahasiswa'); ?>">Info
                                        <i class="fa-regular fa-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="title text-dark px-1 rounded-top mt-2 pl-3">Update Absen Bulan Ini</div>
    <div class="card shadow mb-2">
        <div class="card-body border-bottom">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="">Data User</th>
                            <th class="" style="width: 100px;">Hadir</th>
                            <th class="" style="width: 100px;">Izin</th>
                            <th class="" style="width: 100px;">Sakit</th>
                            <th class="" style="width: 100px;">Tidak Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dataAbsen as $v) {
                            ?>
                            <tr>
                                <td class="dashboard"><img src="ikura.jpeg" alt="" />
                                    <div class="wrapper-tdSatu">
                                        <p class="dashboard nama" name="nama">
                                            <?= $v->nama_lengkap ?>
                                        </p>
                                        <p class="dashboard ssw" name="ssw">
                                            <?= $v->nama_instansi ?>
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <?= $totalAbsensi[$v->nim_nis]['masuk']; ?>
                                </td>
                                <td>
                                    <?= $totalAbsensi[$v->nim_nis]['izin']; ?>
                                </td>
                                <td>
                                    <?= $totalAbsensi[$v->nim_nis]['sakit']; ?>
                                </td>
                                <td>08.13</td>
                            </tr>
                            <?php
                        } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    <?php if (session()->getFlashdata('swal_icon')): ?>
        Swal.fire({
            icon: '<?= session()->getFlashdata('swal_icon'); ?>',
            title: '<?= session()->getFlashdata('swal_title'); ?>',
        })
    <?php endif; ?>
</script>
<?= $this->endSection(); ?>
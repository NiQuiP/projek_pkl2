<?= $this->extend('admin/layout/v_template'); ?>

<?= $this->section('content'); ?>
<!-- Begin Page Content -->

<div class="container-fluid">
    <h1 class="mt-3 text-dark font-weight-bold">Siswa</h1>
    <div class="wrapper-addUser text-dark bg-info d-flex w-25 p-2 my-3 rounded-lg shadow-sm">
        <button type="button" id="but" class="exampleModal" data-bs-toggle="modal" data-bs-target="#exampleModal"
            hidden></button>
        <label for="but"> <i class="fa-solid fa-circle-plus mr-2"></i> Tambah User Baru</label>
    </div>

    <!-- DataTales Example -->
    <div class="title text-dark px-1 rounded-top mt-5 pl-3">
        Data Tables Siswa
    </div>
    <div class="card shadow mb-2">
        <div class="card-body border-bottom">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" id="dataSiswa">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Asal Instansi</th>
                            <th>Username</th>
                            <th>Jenis Kelamin</th>
                            <th>Gambar</th>
                            <th>NIS</th>
                            <th>Tanggal Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dataSiswa as $v) {

                            ?>
                        <tr>
                            <td class="text-center">
                                <?= $nomor; ?>
                            </td>
                            <td>
                                <?= $v['nama_lengkap']; ?>
                            </td>
                            <td>
                                <?= $v['nama_instansi']; ?>
                            </td>
                            <td>
                                <?= $v['username']; ?>
                            </td>
                            <td>
                                <?= $v['jenis_kelamin']; ?>
                            </td>
                            <td>
                                <?= $v['foto']; ?>
                            </td>
                            <td>
                                <?= $v['nim_nis']; ?>
                            </td>
                            <td>
                                <?= tanggal_indo($v['tanggal_bergabung']) ?>
                            </td>
                            <td>
                                <a href="#" class="btn btn-danger btn-circle mb-1"
                                    onclick="hapus(<?= $v['member_id'] ?>)">
                                    <i class="fas fa-trash"></i>
                                </a>

                                <a class="btn btn-warning btn-circle mb-1" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" onclick="edit(<?= $v['member_id'] ?>)">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                            </td>
                        </tr>

                        <?php
                            $nomor++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
<?php if (session()->getFlashdata('swal_icon')): ?>
Swal.fire({
    icon: '<?= session()->getFlashdata('swal_icon'); ?>',
    title: '<?= session()->getFlashdata('swal_title'); ?>',
    showConfirmButton: false,
    timer: 2000
})
<?php endif; ?>
</script>
<?= $this->endSection(); ?>
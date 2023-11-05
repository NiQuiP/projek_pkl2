<?= $this->extend('admin/layout/v_template'); ?>

<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <h3 class="mt-3 text-dark font-weight-bold">Data Absensi</h3>
    <div class="card">
        <div class="card-body m-auto" style="width: 90%">
            <div class="row text-center">
                <div class="col-sm-4 col-md-4">
                    <div class="form-group basic mb-0 my-2">
                        <div class="input-wrapper">
                            <div class="input-group date">
                                <input type="text" class="form-control start_date" id="Fdatepicker" name="start_date"
                                    placeholder="Tanggal Awal" />
                                <span class="input-group-append">
                                    <span class="input-group-text bg-white">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 my-2">
                    <div class="form-group basic mb-0">
                        <div class="input-wrapper">
                            <div class="input-group date">
                                <input type="text" class="form-control end_date" id="Ldatepicker" name="end_date"
                                    placeholder="Tanggal Akhir" />
                                <span class="input-group-append">
                                    <span class="input-group-text bg-white">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 my-2 justify-content-center">
                    <button type="button" class="btn btn-warning col-6" data-toggle="modal"
                        data-target="#modal-print"><i class="fa-solid fa-print"></i> Cetak</button>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="title text-dark px-1 rounded-top mt-5 pl-3">Data Absensi</div>
    <div class="card shadow mb-2">
        <div class="card-body border-bottom">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No .</th>
                            <th>Tanggal</th>
                            <th>Nama Lengkap</th>
                            <th>SSW / MHS</th>
                            <th>Check-In</th>
                            <th>Status</th>
                            <th>Longitude / Latitude</th>
                            <th>Check-Out</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dataAbsen as $v) { ?>
                            <tr>
                                <td class="text-center">
                                    <?= $nomor; ?>
                                </td>
                                <td>
                                    <?= tanggal_indo($v['waktu_absen']); ?>
                                </td>
                                <td>
                                    <?= $v['nama_lengkap']; ?>
                                </td>
                                <td>
                                    <?= $v['jenis_user']; ?>
                                </td>
                                <td>
                                    <?= $v['checkin_time']; ?>
                                </td>
                                <td>
                                    <?= $v['status']; ?>
                                </td>
                                <td>

                                    <?= $v['lokasi']; ?>
                                </td>
                                <td>
                                    <?= $v['checkout_time']; ?>
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
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
<?= $this->endSection(); ?>
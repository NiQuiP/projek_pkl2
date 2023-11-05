<?= $this->extend('user/layout/v_template'); ?>

<?= $this->section('content'); ?>

<!-- Template Main Content -->
<main class="table">
    <div class="card body m-1">
        <div class="table__body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="col-1 text-center">No</th>
                        <th class="col-2 text-center">Status</th>
                        <th class="col-2 text-center">Nama</th>
                        <th class="col-3 text-center">Location</th>
                        <th class="col-1 text-center">Checkin</th>
                        <th class="col-1 text-center">Checkout</th>
                        <th class="col-2 text-center">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($dataAbsen as $value) {

                        ?>
                        <tr>
                            <td>
                                <?= $nomor; ?>
                            </td>
                            <td>

                                <?= $value['status']; ?>

                            </td>
                            <td>
                                <?= $value['nama_lengkap']; ?>
                            </td>
                            <td>
                                <?= $value['lokasi']; ?>
                            </td>
                            <td>
                                <?= $value['checkin_time']; ?>
                            </td>
                            <td>
                                <?= $value['checkout_time']; ?>
                            </td>
                            <td>
                                <?= tanggal_indo($value['waktu_absen']) ?>
                            </td>
                        </tr>
                        <?php
                        $nomor++;
                    } ?>
                </tbody>
            </table>
            <?= $pager->links('absensi', 'absensitable') ?>
        </div>
    </div>
    <script src="<?= base_url('admin') ?>/js/script-ha.js"></script>
</main>



<?= $this->endSection(); ?>
<div class="card-header">
    <i class="fas fa-table me-1"></i>
    Data Siswa
</div>
<div class="card-body">

    <?php
    $session = \Config\Services::session();
    if ($session->getFlashdata('warning')) {
        ?>
        <div class="alert alert-warning">
            <ul>
                <?php
                foreach ($session->getFlashdata('warning') as $val) {
                    ?>
                    <li>
                        <?php echo $val ?>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <?php
    }
    if ($session->getFlashdata('success')) {
        ?>
        <div class="alert alert-success">
            <?php echo
                $session->getFlashdata('success') ?>
        </div>
        <?php
    }
    ?>
    <form action="" method="post" enctype="multipart/form-data">

        <div class="mb-3">
            <label for="input_post_title" class="form-label">Nama</label>
            <input type="text" class="form-control" id="input_post_title" name="post_title"
                value="<?= (isset($post_title)) ? $post_title : '' ?>">
        </div>

        <div class="mb-3">
            <label for="input_nim" class="form-label">NIM</label>
            <input type="text" class="form-control" id="input_nim" name="nim" value="<?= (isset($nim)) ? $nim : '' ?> ">
        </div>

        <div class="mb-3">
            <label for="input_post_status" class="form-label">Jenis Kelamin</label>
            <select name="post_status" class="form-select">
                <option value="active" <?= (isset($post_status) && $post_status ==
                    'active') ? 'selected' : '' ?>>Pria
                </option>
                <option value="inactive" <?= (isset($post_status) && $post_status ==
                    'inactive') ? 'selected' : '' ?>>
                    Wanita
                </option>
            </select>
        </div>

        <?php
        if (isset($post_thumbnail)) {
            ?>
            <img src="<?= base_url(LOKASI_UPLOAD . '/' . $post_thumbnail) ?>" class="pb-2 mb-2 
            img-thumbnail w-50">
            <?php
        }
        ?>
        <div class="mb-3">
            <label for="input_post_thumbnail" class="form-label">Thumbnail</label>
            <input type="file" class="form-control" id="input_post_thumbnail" name="post_thumbnail" value="">
        </div>
        <div class="mb-3">
            <label for="input_email" class="form-label">Email</label>
            <input type="email" class="form-control" id="input_email" name="email"
                value="<?= (isset($email)) ? $email : '' ?>">
        </div>
        <div class="mb-3">
            <label for="input_alamat" class="form-label">Alamat Lengkap</label>
            <textarea name="alamat_lengkap" class="form-control" id="summernote"
                rows='10'><?= (isset($post_content) ? $post_content : '') ?></textarea>
        </div>
        <div>
            <input type="submit" name="submit" value="Simpan Data" class="btn btn-primary">
        </div>
    </form>
</div>
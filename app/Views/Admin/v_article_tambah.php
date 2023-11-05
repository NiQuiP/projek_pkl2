<div class="card-header">
    <i class="fas fa-table me-1"></i>
    DataTable Example
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
            <label for="input_post_title" class="form-label">Judul</label>
            <input type="text" class="form-control" id="input_post_title" name="post_title"
                value="<?= (isset($post_title)) ? $post_title : '' ?>">
        </div>
        <div class="mb-3">
            <label for="input_post_status" class="form-label">Status</label>
            <select name="post_status" class="form-select">
                <option value="active" <?= (isset($post_status) && $post_status ==
                    'active') ? 'selected' : '' ?>>Aktif
                </option>
                <option value="inactive" <?= (isset($post_status) && $post_status ==
                    'inactive') ? 'selected' : '' ?>>Tidak
                    Aktif
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
            <label for="input_post_description" class="form-label">Deskripsi</label>
            <textarea name="post_description" class="form-control" id="input_post_description"
                row='2'><?= (isset($post_description) ? $post_description : '') ?></textarea>
        </div>
        <div class="mb-3">
            <label for="input_post_content" class="form-label">Konten</label>
            <textarea name="post_content" class="form-control" id="summernote"
                rows='10'><?= (isset($post_content) ? $post_content : '') ?></textarea>
        </div>
        <div>
            <input type="submit" name="submit" value="Simpan Data" class="btn btn-primary">
        </div>
    </form>
</div>
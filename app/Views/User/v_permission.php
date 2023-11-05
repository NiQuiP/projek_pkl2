<?= $this->extend('user/layout/v_template'); ?>

<?= $this->section('content'); ?>

<!-- Template Main Content -->
<main class="wrapper-content">
    <div class="wrapper-body">
        <div class="body-satu">
            <div class="date">
                <div class="text">Waktu & Tanggal</div>
                <div class="date-time">
                    <h3 class="current-time" id="current-time"></h3>
                    <h3 class="date-today" id="date-today"></h3>
                </div>
            </div>
        </div>
        <div class="body-dua">
            <form id="myForm" action="<?= route_to('/permission') ?>" method="post" enctype="multipart/form-data">
                <div class="grid-satu">
                    <div class="wrapper-bukti">
                        <div class="wrapper-izin">
                            <select name="menu" id="menu" onchange="updateValue()">
                                <option value="" hidden></option>
                                <option value="Izin">Izin</option>
                                <option value="Sakit">Sakit</option>
                            </select>
                        </div>
                        <div class="wrapper-image">
                            <div class="profile-body">
                                <img id="preview" src="#" alt="File yang anda masukan bukan gambar" />
                            </div>
                            <div class="text">
                                <label for="upload" class="uploud-image">Pilih Gambar</label>
                            </div>
                            <input name="foto_absen" type="file" id="upload" accept=".png, .jpg, .jpeg"
                                style="display: none; visibility: hidden" value="<?= set_value('foto_absen'); ?>" />
                        </div>
                    </div>
                    <div class="wrapper-maps">
                        <div id="map"></div>
                    </div>
                </div>
                <div class="grid-dua">
                    <div class="wrapper">
                        <div class="textareaWrapper">
                            <h3>Keterangan :</h3>
                            <textarea name="keterangan" id="" cols="30" rows="10"
                                placeholder="Isi Disini..."></textarea>
                        </div>
                        <div class="kbWrapper">
                            <div class="kordinatWrapper">
                                <div class="lat">latitude <span>:</span>
                                    <input name="lat" type="text" id="latitude" readonly /> <br />
                                </div>
                                <div class="long">longitude <span>:</span>
                                    <input name="long" type="text" id="longitude" readonly />
                                </div>
                            </div>
                            <div class="buttonWrapper">
                                <input type="submit" data-type="checkin" name="checkin" value="Check-In">
                                <input type="submit" data-type="checkout" name="checkout" value="Check-Out">
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <script src="<?= base_url('admin') ?>/js/perms.js"></script>
</main>

<?= $this->endSection(); ?>
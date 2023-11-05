<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Verifikasi Email</title>
    <link href="<?php echo base_url('admin') ?>/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Verifikasi Email</h3>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="">
                                        <?php
                                        $session = \Config\Services::session();
                                        $session->get('cookie_username');
                                        $session->get('cookie_password');
                                        $session->get('cookie_no_hp');
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


                                        <div class="mb-3">
                                            <label class="form-label">
                                                Klik tombol di bawah untuk verifikasi email anda
                                            </label>

                                        </div>

                                        <div class=" align-items-center  mt-4 mb-0">
                                            <div class="d-grid">
                                                <input type="submit" name="verifikasi" class="btn btn-primary"
                                                    value="Verfikasi Email">
                                            </div>
                                        </div>
                                        <div class=" align-items-center  mt-4 mb-0">
                                            <div class="d-grid">
                                                <input type="submit" name="kirim_ulang" class="btn btn-primary"
                                                    value="Kirim Ulang Link Verifikasi">
                                            </div>
                                        </div>

                                        <!-- <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="<?= site_url('admin/lupapassword') ?>">Forgot
                                                Password?</a>
                                            <input type="submit" name="submit" class="btn btn-primary"
                                                value="Reset Password">
                                        </div> -->

                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <!-- <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a> -->
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="<?php echo base_url('admin') ?>/js/scripts.js"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Registrasi</title>
    <link href="<?= base_url('admin') ?>/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Registrasi Akun</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="<?= site_url('member/registerProccess'); ?>">
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

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputUsername" type="text"
                                                placeholder="Enter your first name" name="username" value="" />
                                            <label for="inputUsername">Username</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="email"
                                                placeholder="name@example.com" name="email" value="" />
                                            <label for="inputEmail">Email address</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" type="password"
                                                placeholder="Masukkan Password" name="password" />
                                            <label for="inputPassword">Password</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputKonfirmasiPassword" type="password"
                                                placeholder="Masukkan Konfirmasi Password" name="konfirmasi_password" />
                                            <label for="inputKonfirmasiPassword">Konfirmasi Password</label>
                                        </div>

                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <input class="btn btn-primary btn-block" type="submit" name="submit"
                                                    value="Registrasi Akun" />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="<?= base_url('/login') ?>">Sudah Punya Akun?
                                            Login</a></div>
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
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="<?= base_url('admin') ?>/js/scripts.js"></script>
</body>

</html>
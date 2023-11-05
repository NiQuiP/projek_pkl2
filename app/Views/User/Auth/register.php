<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('admin') ?>/css/register.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">

        <div class="title">
            <h2>Register</h2>
        </div>
        <?php $validation = \Config\Services::validation() ?>
        <form action="<?= route_to('/register') ?>" method="post">
            <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
            <?php endif ?>
            <div class="containerInput">
                <div class="wrapperInput form-floating">
                    <input id="inputUsername"
                        class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>" type="text"
                        name="username" placeholder="Masukkan Username" value="<?= set_value('username') ?>" />
                    <label class="form-label" for="inputUsername">Username</label>
                    <div class="invalid-feedback">
                        <?= $validation->getError('username') ?>
                    </div>
                </div>
                <div class="wrapperInput form-floating">
                    <input id="inputEmail"
                        class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : '' ?>" type="email"
                        name="email" placeholder="Masukkan Email" value="<?= set_value('email') ?>" />
                    <label for="inputEmail">Email</label>
                    <div class="invalid-feedback">
                        <?= $validation->getError('email') ?>
                    </div>
                </div>
                <div class="wrapperInput form-floating">
                    <input id="inputPassword"
                        class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>"
                        type="password" name="password" placeholder="Masukkan Password" />
                    <label for="inputPassword">Password</label>
                    <div class="invalid-feedback">
                        <?= $validation->getError('password') ?>
                    </div>
                </div>
                <div class="wrapperInput form-floating">
                    <input id="inputPassword"
                        class="form-control <?= ($validation->hasError('konfirmasi_password')) ? 'is-invalid' : '' ?>"
                        type="password" name="konfirmasi_password" placeholder="Masukkan Password" />
                    <label for="inputPassword">Konfirmasi Password</label>
                    <div class="invalid-feedback">
                        <?= $validation->getError('konfirmasi_password') ?>
                    </div>
                </div>

            </div>
            <div class="containerFooter">
                <input type="submit" name="submit" class="login" value="Register">
                <div class="wrapperText">
                    <h5>Sudah punya akun ?</h5>
                    <a href="<?= base_url('/login'); ?>">Login</a>
                </div>
                <div class="wrapperAtau">
                    <span></span>
                    <h5>Atau</h5>
                    <span></span>
                </div>
                <div class="login-google">
                    <img src="<?= base_url('admin') ?>/img/google 2.png" alt="" />
                    <label for="google">Login With Google</label>
                    <input id="google" type="submit" name="submit" hidden class="loginGoogle">
                </div>
            </div>
        </form>
    </div>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('admin') ?>/css/forgetPassword.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">

        <!-- <div class="containerTittle">

            <h2>Lupa Password</h2>

        </div> -->
        <div class="card-header">
            <h3 class="text-center font-weight-light my-4">Password Recovery</h3>
        </div>
        <?php $validation = \Config\Services::validation() ?>
        <form action="" method="post">
            <?php if (session()->getFlashdata("error")) { ?>
                <div class="alert alert-danger">
                    <?php echo session()->getFlashdata('error') ?>
                </div>
            <?php } ?>
            <?php if (session()->getFlashdata("success")) { ?>
                <div class="alert alert-success">
                    <?php echo session()->getFlashdata('success') ?>
                </div>
            <?php } ?>

            <div class="containerInput">
                <div class="wrapperJudul">
                    <label>Masukkan Email anda untuk melakukan reset password</label>
                </div>

                <div class="wrapperInput form-floating">
                    <input id="inputUsername" class="form-control <?= session()->getFlashdata('invalid');?>" type="text" name="email" placeholder="Username :" value="<?= session()->getFlashdata('email'); ?>"/>
                    <label for="inputUsername">Alamat Email</label>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between mt-4">
                <a class="small" href="<?= base_url('/login') ?>">Kembali Ke Login</a>
                <input type="submit" name="submit" class="button-reset" value="Reset Password">
            </div>
        </form>
    </div>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="<?= base_url('admin') ?>/css/login.css" />
</head>

<body>
    <div class="container">
        <form action="" method="post">
            <div class="containerTittle">
                <div class="wrapperImg">
                    <img src="sekolah.png" alt="" />
                    <h1>Absensi</h1>
                </div>
                <div class="wrapperTittle">
                    <h2>Siswa/Mahasiswa</h2>
                </div>
            </div>
            <div class="containerInput">
                <div class="wrapperInput">
                    <input type="text" name="username" placeholder="Username :" />
                    <input type="password" name="password" placeholder="Password :" />
                </div>
                <div class="forget">
                    <a href="">Lupa Akun?</a>
                </div>
            </div>
            <div class="containerFooter">
                <button type="submit" name="submit" class="login">Login</button>
                <div class="wrapperText">
                    <h5>Belum Punya Akun?</h5>
                    <a href="#">Bikin Akun</a>
                </div>
                <div class="wrapperAtau">
                    <span></span>
                    <h5>Atau</h5>
                    <span></span>
                </div>
                <div class="login-google">
                    <img src="google 2.png" alt="" />
                    <button class="loginGoogle">Login With Google</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
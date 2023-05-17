<!DOCTYPE html>
<html lang="en-us" class="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISKEUDES</title>
    <link rel="icon" type="image/png" sizes="56x56" href="<?= logoKab(); ?>">
    <?= css_asset('all.min.css', 'plugins/fontawesome-free/css/'); ?>
    <?= css_asset('adminlte.min.css', 'dist/css/'); ?>
    <?= css_asset('icheck-bootstrap.min.css', 'plugins/icheck-bootstrap/'); ?>
    <?= css_asset('sweetalert2.min.css', 'plugins/sweetalert/dist/'); ?>
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <style type="text/css">
        .bg-login {
            background: url('<?= base_url("assets/img/back_siskeudes.jpg") ?>') no-repeat center fixed;
            background-size: cover;
            height: 100%;
            overflow: hidden;
        }

        .logo-oneplan {
            /*float: left;*/
            width: 80px;

            padding: 10px;
            background: #ffffff;
            border-radius: 10px;

        }

        .login-box-bg {
            color: #ffffff;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .login-box,
        .register-box {
            margin-top: 5%;
            margin-left: 10%;
        }

        .running_text {
            margin-top: 3%;
            margin-left: 10%;
            margin-right: 10%;
        }

        @media (max-width: 1200px) {

            .login-box,
            .register-box {
                width: 360px;
                margin-top: 10%;
                margin-left: 6%
            }
        }

        @media (max-width: 960px) {

            .login-box,
            .register-box {
                width: 360px;
                margin-top: 10%;
                margin-left: 5%
            }
        }

        @media (max-width: 768px) {

            .login-box,
            .register-box {
                width: 360px;
                margin-top: 10%;
                margin-left: 5%
            }
        }

        @media (max-width: 360px) {

            .login-box,
            .register-box {
                width: 300px;
                margin-top: 10%;
                margin-left: 5%
            }
        }
    </style>
</head>

<body class="hold-transition bg-login mt-5">
<div class="login-box">
    <div class="card login-box-bg">
        <div class="card-header">
            <div class="login-logo">
                <img src="<?= logoKab() ?>" alt="logo" class="logo-oneplan">
                <h4 class="text-center text-bold">SISKEUDES</h4>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <span style="font-size: 11pt; text-align: center"
                          class="text-center">Sistem Informasi Keuangan Desa</span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?= form_open(site_url('login/validasi_login'), ['class' => 'form-login']) ?>
            <?= getCsrf(); ?>
            <div class="form-group has-feedback">
                <label>Username :</label>
                <input type="text" class="form-control" id="username" name="username" autofocus=""
                       placeholder="Username">
            </div>
            <div class="form-group has-feedback">
                <label>Password :</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <div class="row justify-content-end">
                <div class="col-12">
                    <button type="submit" class="btn btn-success btn-block btn-login">
                        <i class="fa fa-sign-in-alt"></i> Login
                    </button>
                </div>
            </div>
            <?= form_close() ?>
            <hr>
            <p class="text-center">
                <b>Hak Cipta Dilindungi Undang-Undang</b>
                <br>
                Copyright &copy; Pemkab. Tabalong <?= date('Y') == 2022 ? '2022' : '2022 -' . date('Y'); ?>
            </p>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?= js_asset('jquery.min.js', 'plugins/jquery/'); ?>
<?= js_asset('bootstrap.bundle.min.js', 'plugins/bootstrap/js/'); ?>
<?= js_asset('adminlte.min.js', 'dist/js/'); ?>
<?= js_asset('sweetalert2.min.js', 'plugins/sweetalert/dist/'); ?>
</body>

</html>
<script>
    $(".form-login").submit(function () {
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            cache: false,
            dataType: 'JSON',
            beforeSend: () => {
                $('.btn-login').html(`<i class="fa fa-spin fa-spinner"></i> Loading . . .`)
                $('.btn-login').prop('disabled', true)
            },
            complete: () => {
                $('.btn-login').html(`<i class="fa fa-sign-in"></i> Login`)
                $('.btn-login').prop('disabled', false)
            },
            success: function (result) {
                if (result.status == true) {
                    Swal({
                        type: 'success',
                        title: 'Berhasil masuk!',
                        html: 'Anda akan dihubungkan, mohon menunggu',
                        timer: 2500,
                        onBeforeOpen: () => {
                            Swal.showLoading();
                        }
                    }).then((result) => {
                        window.location.reload();
                    });
                } else {
                    Swal({
                        position: 'center',
                        type: 'info',
                        title: `Ada kesalahan pada sistem <br> ${result.error}`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            }
        });
        return false;
    })
</script>
$("#form-login").submit(function () {
    var username = $("#username").val();
    var password = $("#password").val();
    // misalnya kosong  
    if (!username || !password)
    {
        $(".has-feedback").toggleClass('has-feedback has-error');
        Swal({
            position: 'center',
            type: 'warning',
            title: 'Anda tidak memasukkan Username dan Password',
            showConfirmButton: false,
            timer: 1500,
            animation: false
        });
    } else {
        // kirim post
        $.ajax({
            type: "POST",
            url: "login/Login/validasi",
            data: {
                username: username,
                password: password
            },
            cache: false,
            success: function (result) {

                console.log(username);
                console.log(password);
                console.log(result);

                if (result == "true") {
                    Swal({
                        type: 'success',
                        title: 'Berhasil masuk!',
                        html: 'Anda akan dihubungkan, mohon menunggu',
                        timer: 2500,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        }
                    }).then((result) => {
                        window.location = "administrator.html";
                    })

                } else if (result == "nani") {

                    Swal({
                        position: 'center',
                        type: 'info',
                        title: 'Ada kesalahan pada sistem',
                        showConfirmButton: false,
                        timer: 1000
                    });

                } else {
                    Swal({
                        position: 'center',
                        type: 'error',
                        title: 'Username/Password tidak dikenali<br>Silahkan Coba lagi',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
        });
    }

    return false;
});
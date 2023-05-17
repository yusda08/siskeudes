<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <?= form_open(uri_string() . '/update-user'); ?>
                <?= getCsrf(); ?>
                <div class="card-header">Form Update Profile User</div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="staticUsername" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="staticUsername"
                                   value="<?= $log['username']; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticNama" class="col-sm-2 col-form-label">Nama User</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control-plaintext" id="staticNama"
                                   value="<?= $log['nama_user']; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Password Old</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control " name="password" id="inputPassword" required>
                            <div class="invalid-feedback">
                                Password Tidak sesuai.
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPasswordNew" class="col-sm-2 col-form-label">Password New</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password_new" id="inputPasswordNew" required>
                        </div>
                    </div>
                    <button disabled class="btn btn-success btn-save">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
<?= $this->include('backend/javasc'); ?>
<script>
    $(document).ready(function () {
        $('[name=password]').change(function () {
            $.ajax({
                type: 'POST',
                data: {password: $(this).val(), token: $('#token').val()},
                url: baseUrl('/profile/verification-password'),
                dataType: 'json',
                success: (response) => {
                    if (response.status === true) {
                        $('.btn-save').attr('disabled', false)
                        $(this).removeClass('is-invalid')
                        $(this).addClass('is-valid')
                    } else {
                        $(this).addClass('is-invalid')
                        $(this).removeClass('is-valid')
                        $('.btn-save').attr('disabled', true)
                    }
                }
            })
        })
    })
</script>

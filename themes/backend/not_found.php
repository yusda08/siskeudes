<div class="error-page">
    <h2 class="headline text-warning"> 404</h2>
    <div class="error-content">
        <h3><i class="fas fa-exclamation-triangle text-warning"></i> Halaman Tidak Tersedia</h3>
        <p>
            <?php
            if (!empty($pesan) && $pesan !== '(null)') :
                echo esc($pesan);
            endif
            ?>
        <hr>
        Mohon maaf Halaman yang anda minta belum ada,
        <br>
        Silakan kembali kehalaman sebelumnya 
        <a class="btn btn-danger" href="javascript:history.go(-1)">Kembali</a>
        </p>
    </div>
    <!-- /.error-content -->
</div>
<?= $this->include('backend/javasc');?>
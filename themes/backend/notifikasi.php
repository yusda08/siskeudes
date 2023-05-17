<?php
$msg = session()->getFlashdata('msg');
$tipe = session()->getFlashdata('tipe');
$lambang = 'fa-check';
$notify = 'Sukses!';
if ($tipe == 'alert-danger') {
    $lambang = 'fa-ban';
    $notify = 'Gagal!';
}
?>
<div class="row">
    <div class="col-md-8">
        <?php
        if ($msg) {
        ?>
            <div class="alert <?php echo $tipe; ?> alert-dismissable" id='notiv'>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa <?php echo $lambang; ?>"></i> <?php echo $notify; ?></h4>
                <?php echo $msg; ?>
            </div>
        <?php } ?>
    </div>
</div>
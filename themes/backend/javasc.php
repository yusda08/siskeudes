<!-- ./wrapper -->
<!--<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>-->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>v-->

<?= js_asset('jquery.min.js', 'plugins/jquery/'); ?>
<?= js_asset('jquery-ui.min.js', 'plugins/jquery-ui/'); ?>
<?= js_asset('bootstrap.bundle.min.js', 'plugins/bootstrap/js/'); ?>
<?= js_asset('moment.min.js', 'plugins/moment/'); ?>
<?= js_asset('tempusdominus-bootstrap-4.min.js', 'plugins/tempusdominus-bootstrap-4/js/'); ?>
<?= js_asset('jquery.inputmask.bundle.min.js', 'plugins/inputmask/min/'); ?>
<?= js_asset('summernote-bs4.min.js', 'plugins/summernote/'); ?>
<?= js_asset('jquery.overlayScrollbars.min.js', 'plugins/overlayScrollbars/js/'); ?>
<?= js_asset('adminlte.js', 'dist/js/'); ?>
<?= js_asset('daterangepicker.js', 'plugins/daterangepicker/'); ?>
<?= js_asset('moment.min.js', 'plugins/moment/'); ?>
<?= js_asset('jquery.overlayScrollbars.min.js', 'plugins/overlayScrollbars/js/'); ?>
<?= js_asset('select2.full.min.js', 'plugins/select2/js/'); ?>
<?= js_asset('sweetalert2.min.js', 'plugins/sweetalert/dist/'); ?>
<?= js_asset('toastr.min.js', 'plugins/toastr/'); ?>
<?= js_asset('croppie.min.js', 'plugins/crop/'); ?>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

<script>
    $('#datemask').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
    });
    $('[data-mask]').inputmask();

    const siteUrl = (dataUrl) => {
        return `<?=site_url();?>${dataUrl}`;
    };

    const baseUrl = (dataUrl) => {
        return `<?=base_url();?>${dataUrl}`;
    };

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }


    $.widget.bridge('uibutton', $.ui.button);
    $(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        $('.swalDefaultSuccess').click(function() {
            Toast.fire({
                type: 'success',
                title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
            })
        });

        //Initialize Select2 Elements
        $('.select2').select2();

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });


        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });

    })

    function callBackClassAfter(classParent, classAfter) {
        $(classParent).after(`<span class="${classAfter}"></span>`).css('margin-right', '10px');
        $(classParent).keyup(function() {
            $(this).css({
                'border': '1px solid #ccc',
                'background': 'none'
            });
        });
    }

    $(document).ready(function() {
        $('.datepicker').daterangepicker({
            "singleDatePicker": true,
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function(start, end, label) {});

        $.extend(true, $.fn.dataTable.defaults, {
            "searching": true
        });


        $(document).ready(function() {
            $('.tabel_3').DataTable({
                scrollY: '85vh',
                scrollX: true,
                scrollCollapse: true,
                paging: false,
                ordering: false
            });
            $('.tabel_2').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': false,
                'info': true,
                'autoWidth': true,
                'pageLength': 25
            });
        });
        /* END TABLETOOLS */
        setTimeout(function() {
            $('#notiv').fadeOut('slow');
        }, 4000);
    });


    const swalWithBootstrapButtons = Swal.mixin({
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    });
    function notifSmartAlert(status, ket) {
        if (status == true) {
            Swal({
                type: 'success',
                title: ket,
                timer: 2500,
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            }).then((result) => {
                window.location.reload();
            });
        } else {
            Swal({
                position: 'top',
                type: 'error',
                title: ket,
                showConfirmButton: false,
                timer: 2000
            });
        }
    }


    function notif_smartAlertSukses(ket) {
        Swal({
            type: 'success',
            title: ket,
            timer: 2500,
            onBeforeOpen: () => {
                Swal.showLoading()
            }
        }).then((result) => {
            window.location.reload();
        });
    }

    function notif_smartAlertGagal(ket) {
        Swal({
            position: 'top',
            type: 'error',
            title: ket,
            showConfirmButton: false,
            timer: 2000
        });
    }

    //    $(document).ready(function () {
    //        $('.overlay').hide();
    //
    //        // Format mata uang.
    ////        $('.uang').mask('0.000.000.000.000', {reverse: true});
    //        $('.duit').mask('0.000.000.000.000', {reverse: true});
    //
    //        // Format nomor HP.
    //        $('.no_hp').mask('0000−0000−0000');
    //
    //        // Format tahun pelajaran.
    //        $('.tapel').mask('0000/0000');
    //    });
</script>
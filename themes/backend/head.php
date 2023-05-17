<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>SISKEUDES</title>
<link rel="icon" type="image/png" sizes="56x56" href="<?= logoKab(); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Font Awesome -->
<?= css_asset('all.min.css', 'plugins/fontawesome-free/css/'); ?>
<?= css_asset('adminlte.min.css', 'dist/css/'); ?>
<?= css_asset('OverlayScrollbars.min.css', 'plugins/overlayScrollbars/css/'); ?>
<?= css_asset('daterangepicker.css', 'plugins/daterangepicker/'); ?>
<?= css_asset('summernote-bs4.css', 'plugins/summernote/'); ?>
<?= css_asset('select2-bootstrap4.min.css', 'plugins/select2-bootstrap4-theme/'); ?>
<?= css_asset('select2.min.css', 'plugins/select2/css/'); ?>
<?= css_asset('sweetalert2.min.css', 'plugins/sweetalert/dist/'); ?>
<?= css_asset('icheck-bootstrap.min.css', 'plugins/icheck-bootstrap/'); ?>
<?= css_asset('croppie.css', 'plugins/crop/'); ?>
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<style>
/*@import url(https://fonts.googleapis.com/css?family=Quicksand);*/
/*body.smart-style-3 #logo-group>span#logo:before{font-size:17px;color:#fff;font-weight:300;margin-top:1px;display:block}*/
html {
   -webkit-background-size: cover;
   -moz-background-size: cover;
   -o-background-size: cover;
   background-size: cover;
}

.form-check {
   width: 100%;
}

.table-borderless>tbody>tr>td,
.table-borderless>tbody>tr>th,
.table-borderless>tfoot>tr>td,
.table-borderless>tfoot>tr>th,
.table-borderless>thead>tr>td,
.table-borderless>thead>tr>th {
   border: none;
}

#main #content {
   height: 100%;
}

.hidden {
   display: none;
}

.logo-img {
   /*float: left;*/
   width: 100px;

   padding: 10px;
   background: #ff0000;
   border-radius: 10px;

}

.my-custom-scrollbar {
   position: relative;
   height: 560px;
   overflow: auto;
}

.table-wrapper-scroll-y {
   display: block;
}

/*.smart-style-3 .btn-header>:first-child>a{background:#1264ed;border:1px solid #fff;color:#fff!important;cursor:pointer!important}*/
select.select2 {
   position: static !important;
   outline: none !important;
}

#main {
   background-image: url('<?php echo base_url(); ?>assets/img/mybg.png') !important;
   background-size: auto;
   -webkit-background-size: 100% 100%;
   /*background-repeat : no-repeat;*/
   background-attachment: fixed;
   min-height: calc(100vh - 5em);
   overflow: auto;
   overflow-x: hidden;
   overflow-y: hidden;
}

.form-check {
   display: inline-block;
   position: relative;
   width: 40px;
   height: 20px;
}

.form-radio {
   display: inline-block;
   position: relative;
   width: 30px;
   height: 20px;
}

.ajax-loader {
   align-content: center;
   visibility: hidden;
   position: absolute;
   z-index: +100 !important;
   width: 100%;
   height: 100%;
}

.ajax-loader img {
   position: relative;
}

.ajax-loader-modal {
   align-content: center;
   visibility: hidden;
   position: absolute;
   z-index: +100 !important;
   width: 100%;
   height: 100%;
}

.ajax-loader-modal img {
   position: relative;
}

#notiv {
   width: 40%;
   position: absolute;
   z-index: 999;
}

#notivs {
   width: 100%;
   float: right;
   position: absolute;
   z-index: 1;
   top: 10px;
}

.inputHover {
   background-color: #ffffcc;
   border: solid 2px;
   border-color: #000;
}

.table thead tr th {
   text-align: center;
   vertical-align: top;
   background-color: #A6A4A4;
   color: #000;
   font-weight: bold;
}

note {
   font-size: 8pt;
}

.table tfoot tr th {
   vertical-align: top;
   background-color: #dedede;
   color: #000;
   font-weight: bold;
}

.table tbody tr td {
   vertical-align: top;
   color: #000;
   font-size: 10pt
}

#garis_1 {
   border-style: solid;
}

.modal-header {
   background-color: #999999
}

.modal-footer {
   background-color: #999999
}

.btn-success {
   background-color: #5a995a;
   color: #000;
   border: 1px solid
}

.numberCircle {
   border-radius: 50%;
   behavior: url(PIE.htc);
   /* remove if you don't care about IE8 */
   width: 20px;
   height: 20px;
   padding: 1px;
   background: #ededed;
   border: 2px solid #dedede;
   color: #000;
   text-align: center;
   font: 11pt Arial, sans-serif;
}

/*    td
    {
        font-size: 10pt;
    }*/
/*    .table{
            border: 1px solid;
        }*/
/*.active {background-color:#ededed};*/
.bag1 {
   background: #000;
   opacity: 0.4;
   filter: alpha(opacity=40);
}

.bag2 {
   background: rgba(0, 0, 0, 0.4);
}

.bg {
   background: #F0FFFF;
}

.bag {
   background-color: rgba(255, 255, 255, 0.8);
}

body {
   font-family: Arial;
   color: #000000;
}

.row-table {
   display: table;
   border-radius: 10px;
   border-radius: 10px;
   table-layout: fixed;
   width: 100%;
   height: 100%;
}

.panel-heading {
   background: #00a65a !important;
   background: -webkit-gradient(linear, left bottom, left top, color-stop(0, #00a65a), color-stop(1, #00ca6d)) !important;
   background: -ms-linear-gradient(bottom, #00a65a, #00ca6d) !important;
   background: -moz-linear-gradient(center bottom, #00a65a 0%, #00ca6d 100%) !important;
   background: -o-linear-gradient(#00ca6d, #00a65a) !important;
   filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00ca6d', endColorstr='#00a65a', GradientType=0) !important;
   color: #fff;
}

.group {
   display: block;
   margin-bottom: 1.5em
}

input {
   border: 2px solid #ddd;
   border-radius: 4px;
   font-family: 'Roboto', Arial, Sans-serif;
   font-size: 16px;
   outline: none;
   padding: .5em 1em;
}

.btn-default {
   border: solid 2px;
   border-color: #dedede;
}

.preloader {
   /*        background: url(https://2.bp.blogspot.com/-gwEckHVvyvM/VnbiQdPPZSI/AAAAAAAADcE/wwKnP62ARpc/s1600/loading.gif) no-repeat center;*/
   /*background: url(<?= base_url('assets/img/ajax-loader.gif'); ?>) no-repeat center;*/
   background-color: rgba(0, 0, 0, 0.36);
   width: 100%;
   height: 100%;
   position: fixed;
   left: 0;
   top: 0;
   z-index: 1000;
}

.preloader .loading {
   position: absolute;
   left: 50%;
   top: 50%;
   transform: translate(-50%, -50%);
   font: 14px arial;
}

input[data-readonly] {
   pointer-events: none;
}

td {
   padding: 5px;
   font-size: 11pt;
}

th {
   padding: 5px;
   font-size: 11pt;
}

table,
table .main {
   width: 100%;
   border-collapse: collapse;
   background: #fff;
}

table,
table .main tr th {
   font-size: 11pt;
}

.center {
   text-align: center;
}

.putus {
   border-bottom: 1px dotted #666;
   border-top: 1px dotted #666;
}

.bawah {
   border-bottom: 0px;
}

.atas {
   border-top: 0px;
}

.kanan {
   border-right: 0px;
}

.kiri {
   border-left: 0px;
}

.all {
   border: 1px solid #666;
}

.days,
.hours,
.minutes,
.seconds {
   display: inline-block;
   padding: 15px;
   max-width: 200px;
   max-height: 150px;
   border: 1px solid #ccc;
   border-radius: 10px;
   text-align: center;
   color: #000;
   /*font-weight: bold;*/
   /*text-shadow: 1px 1px 2px lightblue, 0 0 25px blue, 0 0 5px lightblue;*/
   background-color: rgba(255, 255, 255, 0.5);
   font-size: 40px;
   border-bottom: 1px solid #ccc;
}

.datepicker {
   z-index: 1151 !important;
}

.ui-autocomplete {
   position: absolute;
   z-index: 1000;
   cursor: default;
   padding: 3px;
   margin-top: 2px;
   list-style: none;
   background-color: #fff;
   border: 1px solid #000;
   -webkit-border-radius: 5px;
   -moz-border-radius: 5px;
   border-radius: 5px;
   -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
   -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
   box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
}

.ui-autocomplete:hover {
   background: #6693bc;
   color: #ffffff;
}

.ui-autocomplete>li {
   padding: 3px 10px;
}

.ui-autocomplete>li.ui-state-focus {
   background-color: #3399FF;
   color: #ffffff;
}

.ui-helper-hidden-accessible {
   display: none;
}


#myBtn {
   /*display: none;*/
   position: fixed;
   bottom: 20px;
   right: 30px;
   z-index: 99;
   font-size: 18px;
   border: none;
   outline: none;
   /*background-color: red;*/
   color: white;
   cursor: pointer;
   padding: 10px;
   border-radius: 4px;
}

#myBtn:hover {
   background-color: #555;
}

#myBtnTrn {
   /*display: none;*/
   position: fixed;
   bottom: 20px;
   right: 30px;
   z-index: 99;
   font-size: 18px;
   border: none;
   outline: none;
   color: white;
   cursor: pointer;
   padding: 10px;
   border-radius: 0px;
}

#myBtnTrn:hover {
   background-color: #555;
}
</style>
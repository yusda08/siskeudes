<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= css_asset('paper.min.css', 'css/paper-css/'); ?>
    <?= css_asset('dataTables.bootstrap4.min.css', 'css/'); ?>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'/>
    <title><?=$title ? $title : 'Document';?></title>
    <link rel="icon" type="image/x-icon" sizes="56x56" href="<?= logoKab(); ?>">
    <style type="text/css">
        @page { size: legal landscape }
        body {
            font-family: Tahoma,Verdana,Segoe,sans-serif;
            font-size: 12px
        }

        @media print {
            input.noPrint { display: none; }
        }

        td {
            padding: 3px 5px 3px 5px;
            font-size: 10pt;
            vertical-align: top;
        }


        table, table .main {
            border-collapse: collapse;
            background: #fff;
            vertical-align: top;
        }

        .form-check{
            display:inline-block;
            position:relative;
            width:50px;
            height:25px;
        }
        .padding-10{padding:10px}
        .padding-8{padding:8px}
        .padding-5{padding:5px}
        .text-center { text-align: center;}
        .text-right { text-align: right;}
        .border-putus { border-bottom: 1px dotted #666; border-top: 1px dotted #666; }
        .no-border-bottom { border-bottom: 0px ; }
        .no-border-top { border-top: 0px ; }
        .no-border-right { border-right: 0px ; }
        .no-border-left { border-left: 0px ; }
        .border-all { border: 1px solid #666; }
    </style>
</head>
<body class="legal">
<section class="sheet padding-10mm">
    <?= $content; ?>
</section>
</body>
</html>
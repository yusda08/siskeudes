<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Laporan</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="shrink-to-fit=no">
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
        <style type="text/css">
            body { 
                font-family: Tahoma,Verdana,Segoe,sans-serif; 
                font-size: 12px
            }

            #wrapper {
                max-width: 1200px;
                min-width: 1200px;
                margin:0 auto;
                margin-bottom:30px;
                margin-top: 20px;
            }

            @media print {
                input.noPrint { display: none; }
            }

            #wrapper2 {
                max-width: 760px;
                min-width: 760px;
                margin:0 auto;
                margin-bottom:50px;
                margin-top: 20px;
                border : 1px solid;
                padding:10px;
            }
            td {
                padding: 3px 5px 3px 5px;
                font-size: 10pt;
                vertical-align: top;
            }
            th {
                padding: 8px;
                font-size: 10pt;
            }

            table, table .main {
                border-collapse: collapse;
                background: #fff;
                vertical-align: top;
            }
            table, table .main tr th {
                font-size: 15pt;
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
    <body class="body" style="padding: 30px">
        <?php echo $content; ?>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>
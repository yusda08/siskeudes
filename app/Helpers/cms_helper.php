<?php

if (! function_exists('nomer'))
{
    function nomer($nomer)
    {
        return str_replace(',','',$nomer);
    }
}

if (! function_exists('more'))
{
    function more($body)
    {
        $i = strpos($body,'<!--more-->');
        if($i !== FALSE){
            $i += strlen('<!--more-->');
            return substr($body, 0, $i);
        }else{
            return $body;
        }
    }
}

function dateNow(){
    return date('Y-m-d H:i:s');
}


if ( ! function_exists('tanggal'))
{
    function tgl_indo($tgl)
    {
 		if($tgl != null){
 			$ubah = date("Y-m-d", strtotime($tgl));
 			$pecah = explode("-",$ubah);
 			$tanggal = $pecah[2];
 			$bulan = bulan_indo($pecah[1]);
 			$tahun = $pecah[0];
 			return $tanggal.' '.$bulan.' '.$tahun;
 		}
    }
}
    function tgl_indo_angka($tgl)
    {
        if($tgl != null){
            $ubah = date("Y-m-d", strtotime($tgl));
            $pecah = explode("-",$ubah);
            $tanggal = $pecah[2];
            $bulan = $pecah[1];
            $tahun = $pecah[0];
            return $tanggal.'-'.$bulan.'-'.$tahun;
        }
    }

    function day($tgl)
    {
        if($tgl != null){
            $ubah = date("Y-m-d", strtotime($tgl));
            $pecah = explode("-",$ubah);
            $tanggal = $pecah[2];
            $bulan = $pecah[1];
            $tahun = $pecah[0];
            return number_format($tanggal);
        }
    }

    function month($tgl)
    {
        if($tgl != null){
            $ubah = date("Y-m-d", strtotime($tgl));
            $pecah = explode("-",$ubah);
            $tanggal = $pecah[2];
            $bulan = $pecah[1];
            $tahun = $pecah[0];
            return number_format($bulan);
        }
}
    function year($tgl)
    {
        if($tgl != null){
            $ubah = date("Y-m-d", strtotime($tgl));
            $pecah = explode("-",$ubah);
            $tanggal = $pecah[2];
            $bulan = $pecah[1];
            $tahun = $pecah[0];
            return number_format($tahun);
    }
}

    function bulan_indo($bln)
    {
        switch ($bln)
        {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }
    function name_day($tanggal)
    {
        //$ubah = gmdate($tanggal, time()+60*60*8);
        $ubah = date("Y-m-d", strtotime($tanggal));
        $pecah = explode("-",$ubah);
        $tgl = $pecah[2];
        $bln = $pecah[1];
        $thn = $pecah[0];

        $nama = date("l", mktime(0,0,0,$bln,$tgl,$thn));
        $nama_hari = "";
        if($nama=="Sunday") {$nama_hari="Minggu";}
        else if($nama=="Monday") {$nama_hari="Senin";}
        else if($nama=="Tuesday") {$nama_hari="Selasa";}
        else if($nama=="Wednesday") {$nama_hari="Rabu";}
        else if($nama=="Thursday") {$nama_hari="Kamis";}
        else if($nama=="Friday") {$nama_hari="Jumat";}
        else if($nama=="Saturday") {$nama_hari="Sabtu";}
        return $nama_hari;
    }
    function count_down($wkt)
    {
        $waktu=array(	365*24*60*60	=> "tahun",
            30*24*60*60		=> "bulan",
            7*24*60*60		=> "minggu",
            24*60*60		=> "hari",
            60*60			=> "jam",
            60				=> "menit",
            1				=> "detik");

        $hitung = strtotime(gmdate ("Y-m-d H:i:s", time () +60 * 60 * 8))-$wkt;
        $hasil = array();
        if($hitung<5)
        {
            $hasil = 'kurang dari 5 detik yang lalu';
        }
        else
        {
            $stop = 0;
            foreach($waktu as $periode => $satuan)
            {
                if($stop>=6 || ($stop>0 && $periode<60)) break;
                $bagi = floor($hitung/$periode);
                if($bagi > 0)
                {
                    $hasil[] = $bagi.' '.$satuan;
                    $hitung -= $bagi*$periode;
                    $stop++;
                }
                else if($stop>0) $stop++;
            }
            $hasil=implode(' ',$hasil).' yang lalu';
        }
        return $hasil;
    }
    function age($tgl)
    {
        if($tgl != null){
            $tanggal['lahir'] = $tgl;
            $tanggal['sekarang'] = date('Y-m-d');
            $lahir = $tanggal['lahir'];
            $selisih = time()-strtotime($lahir);
            $tahun = floor($selisih / 31536000);
            $bulan = floor(($selisih % 31536000) / 2592000);
            return $tahun.' tahun, '.$bulan.' bulan';
        }
    }
    function terbilang($number)
    {
        $before_comma = trim(to_word($number));
        //$after_comma = trim(comma($number));
        //return ucwords($results = $before_comma.' koma '.$after_comma);
        return ucwords($results = $before_comma);
    }

    function to_word($number)
    {
        $words = "";
        $arr_number = array(
            "",
            "satu",
            "dua",
            "tiga",
            "empat",
            "lima",
            "enam",
            "tujuh",
            "delapan",
            "sembilan",
            "sepuluh",
            "sebelas");

        if($number<12)
        {
            $words = " ".$arr_number[$number];
        }
        else if($number<20)
        {
            $words = to_word($number-10)." belas";
        }
        else if($number<100)
        {
            $words = to_word($number/10)." puluh ".to_word($number%10);
        }
        else if($number<200)
        {
            $words = "seratus ".to_word($number-100);
        }
        else if($number<1000)
        {
            $words = to_word($number/100)." ratus ".to_word($number%100);
        }
        else if($number<2000)
        {
            $words = "seribu ".to_word($number-1000);
        }
        else if($number<1000000)
        {
            $words = to_word($number/1000)." ribu ".to_word($number%1000);
        }
        else if($number<1000000000)
        {
            $words = to_word($number/1000000)." juta ".to_word($number%1000000);
        }
        else if($number<1000000000000)
        {
            $words = to_word($number/1000000000)." miliyar ".to_word($number%1000000000);
        }
        else
        {
            $words = "undefined";
        }
        return $words;
    }

    function comma($number)
    {
        $after_comma = stristr($number,',');
        $arr_number = array(
            "nol",
            "satu",
            "dua",
            "tiga",
            "empat",
            "lima",
            "enam",
            "tujuh",
            "delapan",
            "sembilan");

        $results = "";
        $length = strlen($after_comma);
        $i = 1;
        while($i<$length)
        {
            $get = substr($after_comma,$i,1);
            $results .= " ".$arr_number[$get];
            $i++;
        }
        return $results;
    }
    function bln_romawi($bln)
    {
        switch ($bln)
        {
            case 1:
                return "I";
                break;
            case 2:
                return "II";
                break;
            case 3:
                return "III";
                break;
            case 4:
                return "IV";
                break;
            case 5:
                return "V";
                break;
            case 6:
                return "VI";
                break;
            case 7:
                return "VII";
                break;
            case 8:
                return "VIII";
                break;
            case 9:
                return "IX";
                break;
            case 10:
                return "X";
                break;
            case 11:
                return "XI";
                break;
            case 12:
                return "XII";
                break;
        }
    }
    function to_rupiah($value)
    {
        if($value < 0)
        {
            return '( Rp '.number_format(abs($value), 0, '', '.').' )';
        }
        else
        {
            return 'Rp '.number_format($value, 0, '', '.').'  ';
        }
    }
    function limit_word($word, $length)
    {
        if(strlen($word)<=$length)
        {
            echo $word;
        }
        else
        {
            $y=substr($word,0,$length) . '....';
            echo $y;
        }
    }

<table class='main' border='0' repeat_header="1" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th class="text-center" width="10%"><img style="width: 100%" src="<?= logoKab(); ?>" alt="Attachment Image"></th>
        <th class="text-center">
                            <span style="font-size: 16px"><?= $row_kop->pemda ?><br><?= $row_kop->skpd ?>
                                <br>
                                <span style="font-size: 11px">
                                    <?= $row_kop->alamat . ' Telp. ' . $row_kop->no_telp, ' Fax : ' . $row_kop->fax; ?>
                                    <br>
                                    <?= $row_kop->kota . ' Website. ' . $row_kop->website . ' email : ' . $row_kop->email; ?>
                                </span>
                            </span>
        </th>
        <th class="text-center" width="10%"><img style="width: 100%" src="<?=$qr_code;?>" alt="Attachment Image">
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="3"
            style="font-size: 12pt; text-align: center; font-weight: bold; border-top: 1px solid; border-bottom: 1px solid;">
            LEMBAR ALUR PROSES PENYELESAIAN DOKUMEN
        </td>
    </tr>
    </tbody>
</table>
<br>
<table class='main' border='0' repeat_header="1" cellspacing="0" width="100%">
    <tbody>
    <tr>
        <td style="width: 20%">Jenis Dokumen</td>
        <td style="width: 3%">:</td>
        <td><?= $row_nd['jenis_dok'] == 'ND' ? 'Nota Dinas' : 'Telaahan Staf'; ?></td>
    </tr>
    <tr>
        <td>Nomor</td>
        <td>:</td>
        <td><?= $row_nd['no_surat']; ?></td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td>:</td>
        <td><?= tgl_indo($row_nd['tgl_surat']); ?></td>
    </tr>
    <tr>
        <td>Perihal</td>
        <td>:</td>
        <td><?= $row_nd['perihal']; ?></td>
    </tr>
    <tr>
        <td colspan="3"><br></td>
    </tr>
    <tr>
        <td>Pembuat/Pengirim</td>
        <td>:</td>
        <td><?= $row_nd['pembuat']; ?></td>
    </tr>
    <tr>
        <td>Tanggal Masuk</td>
        <td>:</td>
        <td><?= tgl_indo($row_nd['tgl_masuk']); ?></td>
    </tr>
    <tr>
        <td>No. Reg</td>
        <td>:</td>
        <td><?= sprintfNumber($no_reg); ?></td>
    </tr>
    <tr>
        <td>Penerima</td>
        <td>:</td>
        <td><?= $row_nd['penerima']; ?></td>
    </tr>
    <?php
    foreach ($getListDisposisiNd as $dispo) {
        ?>
        <tr>
            <td colspan="3" style="border-bottom: 1px solid"></td>
        </tr>
        <tr>
            <td>Diserahkan Ke</td>
            <td>:</td>
            <td><?=$dispo['nama_jabatan'] ? $dispo['nama_jabatan'] : $dispo['jabatan'] ;?></td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td><?= tgl_indo($dispo['tgl_terima']);?></td>
        </tr>
        <tr>
            <td>Penerima</td>
            <td>:</td>
            <td><?= $dispo['penerima'];?></td>
        </tr>
        <tr>
            <td>Isi Disposisi</td>
            <td>:</td>
            <td style="padding-bottom: 30px">
                <?= $dispo['isi_disposisi'];?>
                <br>
                <span style="font-size: 10px"><?= $dispo['tgl_disposisi'] != '' ? 'Tgl : '. Tgl_indo_angka($dispo['tgl_disposisi']) .' At : '.$dispo['jam_disposisi'] : '';?></span>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="border-top: 1px solid"></td>
        </tr>
    <?php } ?>
    <tr>
        <td colspan="3" style="border-bottom: 1px solid"></td>
    </tr>
    <tr>
        <td>Diserahkan Ke</td>
        <td>:</td>
        <td>Bagian Umum</td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td>:</td>
        <td></td>
    </tr>
    <tr>
        <td>Penerima</td>
        <td>:</td>
        <td style="padding-bottom: 30px"></td>
    </tr>
    <tr>
        <td colspan="3" style="border-top: 1px solid"></td>
    </tr>
    <tr>
        <td colspan="3" style="border-bottom: 1px solid"></td>
    </tr>
    <tr>
        <td>Diserahkan Ke</td>
        <td>:</td>
        <td><?= $row_nd['pembuat']; ?></td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td>:</td>
        <td></td>
    </tr>
    <tr>
        <td>Penerima</td>
        <td>:</td>
        <td style="padding-bottom: 30px"></td>
    </tr>
    <tr>
        <td colspan="3" style="border-top: 1px solid"></td>
    </tr>
    </tbody>
</table>
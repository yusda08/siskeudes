<table class='main' border='0' repeat_header="1" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th class="text-center" width="10%"><img style="width: 100%" src="<?= logoKab(); ?>" alt="Attachment Image">
        </th>
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
        <th class="text-center" width="10%"><img style="width: 100%" src="<?= $qr_code; ?>" alt="Attachment Image">
    </tr>
    </thead>
</table>
<table class='main' border='1' repeat_header="1" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th colspan="2" class="text-center border border-dark">LEMBAR DISPOSISI</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="" width="50%">
            <table class='main' border='0' repeat_header="1" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <td width="30%">Surat Dari</td>
                    <td width="5%">:</td>
                    <td><?= $row_srt['pembuat']; ?>    </td>
                </tr>
                <tr>
                    <td width="30%">No. Surat</td>
                    <td width="5%">:</td>
                    <td><?= $row_srt['no_surat']; ?></td>
                </tr>
                <tr>
                    <td width="30%">Tgl Surat</td>
                    <td width="5%">:</td>
                    <td><?= Tgl_indo::indo($row_srt['tgl_surat']); ?></td>
                </tr>
                </thead>
            </table>
        </td>
        <td width="50%">
            <table class='main' border='0' repeat_header="1" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <td width="40%">Diterima Tanggal</td>
                    <td width="5%">:</td>
                    <td><?= Tgl_indo::indo($row_srt['tgl_masuk']); ?></td>
                </tr>
                <tr>
                    <td>No Agenda</td>
                    <td>:</td>
                    <td><?= sprintfNumber($row_srt['no_reg']); ?></td>
                </tr>
                <tr>
                    <td>Sifat</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <?php foreach ($getsifatSurat as $row_sft) { ?>
                    <tr>
                        <td colspan="3">
                            <input disabled <?= $row_srt['sifat_surat'] == $row_sft['nama'] ? ' checked ' : ''; ?>
                                   type="checkbox" value="">
                            <strong><?= $row_sft['nama']; ?></strong></td>
                    </tr>
                <?php } ?>
                </thead>
            </table>
        </td>
    </tr>
    <tr>
        <td class="padding-10" colspan="2">
            <div style="min-height: 50px">
                <strong>Perihal :</strong> <?= $row_srt['perihal']; ?>
            </div>
        </td>
    </tr>
    <tr>
        <td class="padding-10">
            <div style="min-height: 100px">
                <strong>Diteruskan Kepada :</strong>
                <hr>

            </div>
        </td>
        <td class="padding-10">
            <div style="min-height: 100px">
                <strong>Dengan Hormat Harap :</strong>

            </div>
        </td>
    </tr>
    <tr class="border-all">
        <td class="padding-10 no-border-right">
            <strong>Catatan :</strong>
            <br>

        </td>
        <td class="no-border-left text-center">
            Tanda Terima
            <br>
            <br>
            <br>___________
            <br>
            nama jelas
        </td>
    </tr>
    <tr class="border-all">
        <td style="font-size: 8px">Dicetak lewat : <?= base_url(); ?></td>
        <td style="text-align: right;font-size: 8px"></td>
    </tr>
    </tbody>
</table>

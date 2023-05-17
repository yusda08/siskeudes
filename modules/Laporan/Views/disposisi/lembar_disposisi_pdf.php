
<table class='main' border='0' repeat_header="1" cellspacing="0" width="100%" >
    <thead>
        <tr>
            <td class="text-center" width="10%"><img style="width: 10%" src="<?= logoKabPdf(); ?>" alt="Attachment Image"></th>
            <td class="text-center">
                <span style="font-size: 16px; font-weight: bold"><?= $row_kop->pemda ?><br><?= $row_kop->skpd ?>
                    <br>
                </span>
                <span style ="font-size: 11px">
                    <?= $row_kop->alamat . ' Telp. ' . $row_kop->no_telp, ' Fax : ' . $row_kop->fax; ?>
                    <br>
                    <?= $row_kop->kota . ' Website. ' . $row_kop->website . ' email : ' . $row_kop->email; ?>
                </span>
            </td>
            <td class="text-center" width="10%">
                <img style="width: 10%" src="<?= qrCodeImgPdf('disposisi', $row_srt->qr_code); ?>" alt="Qr-code">
            </td>
        </tr>
    </thead>  
</table>
<hr>
<table class='main ' border="1" repeat_header="1" cellspacing="0" width="100%" >
    <thead >
        <tr class="border-all">
            <th colspan="2" class="text-center border border-dark">LEMBAR DISPOSISI</th>
        </tr>
    </thead> 
    <tbody>
        <tr>
            <td width="50%" class="border-all">
                <table width="100%" >
                    <thead>
                        <tr>
                            <td width="30%">Surat Dari</td>
                            <td width="5%">:</td>
                            <td><?= $row_srt->surat_dari; ?>    </td>
                        </tr>
                        <tr>
                            <td width="30%">No. Surat</td>
                            <td width="5%">:</td>
                            <td><?= $row_srt->no_surat; ?></td>
                        </tr>
                        <tr>
                            <td width="30%">Tgl Surat</td>
                            <td width="5%">:</td>
                            <td><?= Tgl_indo::indo($row_srt->tgl_surat); ?></td>
                        </tr>
                    </thead>
                </table>
            </td>
            <td width="50%" class="border-all">
                <table width="100%" >
                    <thead>
                        <tr>
                            <td width="40%">Diterima Tanggal</td>
                            <td width="5%">:</td>
                            <td><?= Tgl_indo::indo($row_srt->tgl_terima); ?></td>
                        </tr>
                        <tr>
                            <td>No Agenda</td>
                            <td>:</td>
                            <td><?= sprintfNumber($row_srt->no_agenda); ?></td>
                        </tr>
                        <tr>
                            <td>Sifat</td>
                            <td>:</td>
                            <td></td>
                        </tr>
                        <?php foreach ($get_sifatSurat as $row_sft) { ?>
                            <tr>
                                <td colspan="3">
                                    <input class="form-check" <?= $row_srt->sifat_surat == $row_sft->nama ? ' checked="checked" ' : ''; ?> type="checkbox" value="">
                                    <strong><?= $row_sft->nama; ?></strong></td>
                            </tr>
                        <?php } ?>
                    </thead>
                </table>
            </td>
        </tr>
        <tr class="border-all">
            <td style="height:2cm" class="padding-10" colspan="2" >
                <strong>Perihal :</strong> <?= $row_srt->perihal_surat; ?>
            </td>
        </tr>
        <tr >
            <td class="padding-10 border-all">
                <div style="min-height: 100px">
                    <strong>Diteruskan Kepada :</strong> 
                    <br>
                    <table class='main' border='0' repeat_header="1" cellspacing="0" width="100%" >
                        <thead>
                            <?php
//                            $kd_penerima = explode(',', $row_srt->penerima);
                            foreach ($getPejabatan as $pejabat) {
                                $kd_petaPjbt = $pejabat['kd_peta'];
                                $check = '';
                                foreach ($getDataPenerima as $penerima) {
                                    if ($kd_petaPjbt == $penerima->kd_peta) {
                                        $check = 'checked="checked"';
                                        break;
                                    }
                                }
                                if ($pejabat['parent_jabatan'] != 0) {
                                    ?>
                                    <tr>
                                        <td>
                                            <input class="form-check" <?= $check; ?> type="checkbox" value="">
                                            <?= besarKecil($pejabat['nama_jabatan']); ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </thead>
                    </table>
                </div>
            </td>
            <td class="padding-10 border-all">
                <div style="min-height: 100px">
                    <strong>Dengan Hormat Harap :</strong>
                    <br>
                </div>
            </td>
        </tr>
        <tr class="border-all">
            <td class="padding-10 no-border-right" >
                <strong>Catatan :</strong> 
                <br>
                <table class='main' border='0' repeat_header="1" cellspacing="0" width="100%" >
                    <?php
                    foreach ($disposisi as $dis) {
                        $nama_pejabat = '';
                        foreach ($getPejabatan as $pejabat) {
                            if ($pejabat['kd_peta'] == $dis->kd_peta) {
                                $nama_pejabat = besarKecil($pejabat['nama_jabatan']);
                                break;
                            }
                        }
                        ?>
                        <tr>
                            <td style="padding-bottom: 0px"><?= $nama_pejabat; ?></td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 0px; padding-top: 0px"><textarea rows="4" disabled style="width: 400px"><?= $dis->isi_disposisi; ?></textarea></td>
                        </tr>
                        <tr style="padding-top: 0px">
                            <td colspan="2" style="font-size: 10px">Tanggal Disposisi : <?= Tgl_indo_angka($dis->tgl_disposisi) . ' At : ' . $dis->time_disposisi; ?></td>
                        </tr>
                    <?php } ?>
                </table>
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
            <td  style="font-size: 8px">Dicetak lewat : <?= base_url(); ?></td>
            <td style="text-align: right;font-size: 8px">QR-Code : <?= $row_srt->qr_code; ?></td>
        </tr>
    </tbody>
</table>

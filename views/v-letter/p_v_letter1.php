<?php ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 15px;font-size: 11px">
    <table>
        <tr>
            <td><small>Rujukan Kami</small></td>
            <td><small>&nbsp;&nbsp;: &nbsp;UMS/PEND2.2/500-6/2/5-UMS(PER)-<?= $permohonan->biodata->COOldID; ?></small></td>
        </tr>
        <tr>
            <td><small>Tarikh</small></td>
            <td><small>&nbsp;&nbsp;: &nbsp;<?= $permohonan->biodata->getTarikh(Yii::$app->formatter->asDate($permohonan->tarikh_notifikasi)); ?></small></td>  
        </tr>
    </table> 
</div>  
<div style="margin-bottom: 10px; ">
        <b>KEPADA YANG BERKENAAN</b>  <br/>
        Tuan/Puan,   
    </div> 

<div style="margin-bottom: 10px; text-align:justify">
    <b>PENGESAHAN KAKITANGAN UNIVERSITI MALAYSIA SABAH</b>
</div>

<div style="margin-bottom: 10px; text-align:justify"> 
    <table border="0" style="width:100%">
        <tr>
            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NAMA</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><b><?= strtoupper($permohonan->biodata->CONm); ?></b></small></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO. KAD PENGENALAN</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><small><?php
                        if ($permohonan->biodata->NatStatusCd == 1) {
                            echo $permohonan->ICNO;
                        } else {
                            echo$permohonan->biodata->latestPaspot;
                        }
                        ?></small></b></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO. PEKERJA</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><small><?= $permohonan->biodata->COOldID; ?></small></b></td>
        </tr> 
    </table>
</div>

<div style="margin-bottom: 15px; text-align:justify">
    Dengan segala hormatnya perkara di atas adalah dirujuk.
</div>

<div style="margin-bottom: 10px; text-align:justify"> 
    2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Adalah dimaklumkan bahawa penama di atas adalah kakitangan Universiti Malaysia Sabah dan maklumat lanjut adalah seperti butiran berikut:
</div>

<div style="margin-bottom: 10px; text-align:justify">
    <table border="0" style="width:100%">
        <tr>
            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a)&nbsp;Jawatan</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><b><?= strtoupper($permohonan->biodata->jawatan->nama); ?></b></small></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b)&nbsp;Gred Jawatan</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><b><?= strtoupper($permohonan->biodata->jawatan->gred); ?></b></small></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c)&nbsp;Tarikh Mula Sandang</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><b><?= strtoupper($permohonan->biodata->displayStartSandangan); ?></b></small></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;d)&nbsp;Taraf Jawatan</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><b><?= strtoupper($permohonan->biodata->statusLantikan->ApmtStatusNm ); ?></b></small></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;e)&nbsp;Jabatan/Fakulti/Pusat/<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Institut/Unit </td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><b><?= strtoupper($permohonan->biodata->department->fullname); ?></b></small></td>
        </tr>
    </table>
</div>
<?php
  if($permohonan->apply_type == 2){
  if($family){ $i = 1;
?>
<div style="margin-bottom: 10px; text-align:justify">
    3.	Sehubungan itu, Bahagian Sumber Manusia, Universiti Malaysia Sabah memohon kerjasama pihak tuan/ puan membenarkan kakitangan berserta keluarga untuk kembali ke Sabah. Maklumat bagi keluarga kakitangan adalah seperti berikut;
</div> 


<div style="margin-bottom: 10px; text-align:justify">
    <center><div class="table-responsive">
    <table style="width:100%" class="table table-striped table-sm jambo_table table-bordered">
        <tr>
            <th class="text-center" width="5%">BIL.</th>
            <th class="text-center" width="45%">NAMA</th>
            <th class="text-center" width="25%">NO. KP</th>
            <th class="text-center" width="25%">HUBUNGAN</th> 
        </tr>
        <?php foreach($family as $f) { ?>
        <tr>
            <td class="text-center" ><?= $i++; ?></td>
            <td><?= $f->FmyNm? ucwords(strtolower($f->FmyNm)):''; ?></td>
            <td class="text-center"><?= $f->FamilyId? $f->FamilyId:''; ?></td>
            <td class="text-center"><?= $f->hubunganKeluarga? $f->hubunganKeluarga->RelNm:''; ?></td>
        </tr> 
        <?php } ?>
    </table>
        </div>
    </center>
</div>
  <?php } }?>

<div style="margin-bottom: 10px; text-align:justify">
    Perhatian dan kerjasama pihak tuan dalam perkara ini amat dihargai dan didahului dengan ucapan terima kasih.<br/>
    <br/>
    Sekian.
</div>    

<div style="margin-bottom: 10px; text-align:justify">
    <b>"WAWASAN KEMAKMURAN BERSAMA 2030"</b><br/><br/>
    Saya Yang Menjalankan Amanah,
</div>  

<div style="margin-bottom: 10px; text-align:justify">
    <?php
    if ($permohonan->ICNO == $permohonan->isChiefBsm()) {
        $pn = $permohonan->Pendaftar();
        ?>
        <small><br/> <strong><?= $pn ? $pn->CONm : 'Tiada Maklumat'; ?></strong><br/> 
            Pendaftar<br/>

            No. Tel	: 088-320000 samb. <?= $pn ? $pn->COOffTelNoExtn : 'Tiada Maklumat'; ?><br/>
            No. Faks : 088-320243 / 320651<br/>
            Emel : <?= $pn ? $pn->COEmail : 'Tiada Maklumat'; ?><br/>
            <?php
        } else {
            $bsm = $permohonan->Bsm();
            ?>
            <small><br/> <strong><?= $bsm ? $bsm->CONm : 'Tiada Maklumat'; ?></strong><br/> 
                Ketua Bahagian Sumber Manusia<br/>
                B.p Pendaftar<br/> 

                No. Tel	: 088-320000 samb. <?= $bsm ? $bsm->COOffTelNoExtn : 'Tiada Maklumat'; ?><br/>
                No. Faks : 088-320243 / 320651<br/>
                Emel : <?= $bsm ? $bsm->COEmail : 'Tiada Maklumat'; ?><br/>
                <?php
            }
            ?>
            s.k: - Pendaftar<br/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Ketua Bahagian Sumber Manusia<br/> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Ketua Bahagian Keselamatan<br/> 
        </small>
</div>

<div style="margin-bottom: 5px; text-align:center">
    <b><small>CETAKAN SURAT INI TIDAK MEMERLUKAN TANDATANGAN</small></b> 
</div>   

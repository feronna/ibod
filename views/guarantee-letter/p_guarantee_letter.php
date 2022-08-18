<?php ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 15px;font-size: 11px">
    <table>
        <tr>
            <td><small>Rujukan</small></td>
            <td><small>&nbsp;&nbsp;: &nbsp;UMS/PEND2.2/500-6/2/5</small></td>
        </tr>
        <tr>
            <td><small>Tarikh</small></td>
            <td><small>&nbsp;&nbsp;: &nbsp;<?= $permohonan->biodata->getTarikh(Yii::$app->formatter->asDate($permohonan->tarikh_notifikasi)); ?></small></td>  
        </tr>
    </table></small>
</div> 

<div style="margin-bottom: 15px; ">
    <b> SURAT PENGESAHAN DIRI DAN PENGAKUAN PEGAWAI PENGARAH/PENGUASA<br/>
        PERUBATAN/PEGAWAI PERUBATAN YANG MENJAGA <?= $permohonan->hospital->nama; ?>,<br/>
        <?= $permohonan->hospital->daerah; ?><br/>
    </b>  
</div>

<div>
    <small>(u.p; Unit Hasil)</small>  
    <br/><br/>
</div>

<div>
    Tuan/Puan,  
    <br/> <br/>  
</div>



<div style="margin-bottom: 10px; text-align:justify">
    Sukacita dengan ini disahkan bahawa penama di bawah adalah kakitangan Universiti Malaysia Sabah. Butiran adalah seperti berikut: 
</div>

<div style="margin-bottom: 10px; text-align:justify"> 
    <table border="0" style="width:100%">
        <tr>
            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nama Pegawai</small></td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><small><?= strtoupper($permohonan->biodata->CONm); ?></small></b></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No. Kad Pengenalan</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><small><?php
                        if ($permohonan->biodata->NatCd == "MYS") {
                            echo $permohonan->ICNO;
                        } else {
                            echo$permohonan->biodata->latestPaspot;
                        }
                        ?></small></b></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Gred Gaji</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><small><?= strtoupper($permohonan->biodata->jawatan->gred); ?></small></b></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Gaji Pokok</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><small> <?= $permohonan->biodata->gajiBasic; ?></small></b></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jawatan</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><small><?= strtoupper($permohonan->biodata->jawatan->nama); ?></small></b></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kelayakan Kelas Wad</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><small><?= $permohonan->kelasWad->nama; ?></small></b></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Alamat Pejabat</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><small><?= strtoupper($permohonan->biodata->department->fullname) . ','; ?></small></b><br/>
                :<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <small><?php
                        if ($permohonan->biodata->campus_id == 1) {
                            echo "UNIVERSITI MALAYSIA SABAH,<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; JALAN UNIVERSITI MALAYSIA SABAH, <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;88400, KOTA KINABALU";
                        } else if ($permohonan->biodata->campus_id == 2) {
                            echo "UNIVERSITI MALAYSIA SABAH LABUAN INTERNATIONAL <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CAMPUS, JLN. SUNGAI PAGAR, 87000 LABUAN";
                        } else if ($permohonan->biodata->campus_id == 3) {
                            echo "UNIVERSITI MALAYSIA SABAH,<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LOCKED BAG NO. 3, 90509 SANDAKAN";
                        } else {
                            echo "Tiada Maklumat";
                        }
                        ?></b></small></td>
        </tr>
    </table>
</div>

<div style="margin-bottom: 15px; text-align:justify">
    2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pegawai berkenaan / Isteri / Suami / Ibu / Bapa / Anak** 
    pegawai berkenaan seperti butir-butir di bawah memerlukan rawatan. 
</div>

<div style="margin-bottom: 10px; text-align:justify"> 
    <table border="0" style="width:100%">
        <tr>
            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><b><?= strtoupper($permohonan->gl_nama); ?></small></b></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No. Kad Pengenalan</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><small><?php
                        if ($permohonan->biodata->NatCd == "MYS") {
                            echo $permohonan->gl_ICNO;
                        } else {
                            echo$permohonan->biodata->latestPaspot;
                        }
                        ?></b></small></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Perhubungan Pekerja</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><small><?= strtoupper($permohonan->gl_hubungan); ?></small></b></td>
        </tr> 
    </table>
</div>

<div style="margin-bottom: 10px; text-align:justify">
    3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jabatan ini bersetuju menjelaskan bil hospital untuk rawatan berkenaan. Sila kemukakan bil tuntutan rawatan berkenaan ke pejabat ini seperti alamat berikut:-   <br/> 
</div>

<div style="margin-bottom: 10px; text-align:center">
    <b> Bahagian Sumber Manusia, Jabatan Pendaftar, <br/>Aras 3, Blok Selatan, Bangunan Canselori, Universiti Malaysia Sabah,
        <br/>88400 Kota Kinabalu, Sabah.</b>
</div>    

<div style="margin-bottom: 10px; text-align:justify">
    Sekian, harap maklum.
</div>

<div style="margin-bottom: 10px; text-align:justify"> 
    <b>"WAWASAN KEMAKMURAN BERSAMA 2030"</b><br/><br/>
    <?php $peg = $permohonan->Pegawai(); ?>
    <small>Saya Yang Menjalankan Amanah,<br/><br/>
        <small><b><?= $peg->kakitangan ? $peg->kakitangan->CONm : 'Tiada Maklumat'; ?></b><br/>
            <?= $peg->kakitangan ? $peg->kakitangan->jawatan->nama : 'Tiada Maklumat'; ?><br/>
            Bahagian Sumber Manusia<br/>
            b.p Pendaftar<br/><br/>

            No. Tel	: 088-320000 samb. <?= $peg->kakitangan ? $peg->kakitangan->COOUCTelNo : 'Tiada Maklumat'; ?><br/>
            No. Faks : <?= $peg->kakitangan ? $peg->kakitangan->department->fax_no : 'Tiada Maklumat'; ?><br/>
            Emel : <?= $peg->kakitangan ? $peg->kakitangan->COEmail : 'Tiada Maklumat'; ?><br/>
            s.k: - Fail<br/></small>
</div>

<div style="margin-bottom: 5px; text-align:center">
    <small>Tempoh sah laku adalah 3 bulan dari tarikh surat dikeluarkan.</small><br/>
    <b><small>CETAKAN SURAT INI TIDAK MEMERLUKAN TANDATANGAN</small></b> 
</div>   


<style>
    table {
        font-family: arial, sans-serif;
        border: 1px solid black;
        width: 100%;
    }

    td, th {
        border: 1px solid black;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
    
</style>

<p>Salam Sejahtera,
    
    <br>Dr./Tuan/Puan,<br>
    
    Merujuk kepada perkara di atas.
<p>
    Adalah dimaklumkan bahawa mengikut rekod kami, Dr./Tuan/Puan <b style="color:red">BELUM</b> mengemukakan 
    Laporan Kemajuan Pengajian (LKP) / Progress Report bagi <b>
        
        <?php 
        $date = $lkk->effectivedt;
        $year = date('Y', strtotime($date));
        $month = date('F', strtotime($date));
        echo strtoupper($month. ' '. $year);
        
        ?></b>.
        
        
    Setiap kakitangan adalah DIWAJIBKAN untuk mengemukakan LKP setiap 
    ENAM (6) BULAN dari tarikh mula pengajian sehingga tamat cuti belajar.<br>
    <b> a. Tindakan Sekiranya Tidak Menghantar LKP (Kali Pertama dan Kedua)</b>
    <br>
    <div class="table-responsive">
                                <table style="border-collapse: collapse;table-layout:  fixed; border: 2px solid #dddddd; border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #f9f9f9;width:100%" cellpadding="0" cellspacing="0">
                <tr style="border: 2px solid #dddddd;">
                    <th class="col-md-3 col-sm-3 col-xs-12" style="border: 1px solid #dddddd;">TIDAK MENGHANTAR LKP SEBANYAK SATU (1) KALI:</th>
                    <td style="border: 2px solid #dddddd;"> 3 bulan pertama dari tarikh hantar - Emel peringatan kepada kakitangan sehingga kakitangan menghantar LKP tersebut.</td> 
                </tr>
                 <tr style="border: 2px solid #dddddd;">
                    <th class="col-md-3 col-sm-3 col-xs-12" style="border: 1px solid #dddddd;">TIDAK MENGHANTAR LKP SEBANYAK DUA (2) KALI/LEBIH:</th>
                    <td style="border: 2px solid #dddddd;"> Gaji bulanan akan ditahan dan pergerakan gaji tahunan tidak akan diberikan sehingga laporan diterima.</td> 
                </tr>
            </table></div>
    Sehubungan itu, mohon agar Dr./Tuan/Puan majukan LKP tersebut sebelum atau pada <b style="color:red"><?=$lkk->dt?> </b>
    bagi mengelakkan sebarang masalah berkenaan dengan KGT atau gaji Dr./Tuan/Puan.
    <br>
    Sila abaikan emel jika telah menghantar LKP terkini.
</p>
<p>
   Dr./Tuan/Puan hendaklah menghantar LKP secara atas talian iaitu:<br>

   1. <a href="https://registrar.ums.edu.my/staff/web">
    LOG MASUK HRv4</a>
    <br>
    
   2. Klik <a href="https://registrar.ums.edu.my/staff/web/cutibelajar/halaman-pemohon">
      Pengajian Lanjutan</a>
   <br>
   3. Klik <a href="https://registrar.ums.edu.my/staff/web/lkk/senarailkk">
      Laporan Pengajian Pengajian (LKP)</a> untuk tindakan selanjutnya. </p>

   Sekian, Terima Kasih.
<?php ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 
   <div class="col-md-12 col-sm-3 col-xs-12" style="margin-bottom: 15px; font-size:15px; margin-top: 50px">
       
                    <div class="profile_img text-center">
                        <div id="crop-avatar"> 
                     
                          <img src="/staff/web/images/logo-umsblack-text-png.png" width="200px" height="auto" alt="signature"/> <br><br>
                        </div>
                        <br>
                        <strong>BORANG PERAKUAN KETUA JABATAN<br>
                            (PENGESAHAN LAPOR DIRI TAMAT TEMPOH PENGAJIAN LANJUTAN)</strong><hr>
                    </div>
      </div>
 
<!--<div style="margin-bottom: 15px;font-size: 10px">
    <br>
</div>-->
  

<div style="margin-bottom: 30px;">
    <table  style="font-family: Arial;font-size: 11px;">
        <tr>
            <td>Kepada;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
                <strong>KETUA<br>
                    BAHAGIAN SUMBER MANUSIA</strong><br>
                Jabatan Pendaftar<br><br/>
        <u>Pegawai dihubungi:</u><br><br>
        </td>

        </tr>


        <tr>
            <td>No.Tel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 088-320000 ext 1058 (Puan Yanti Yusup)</td> 
        </tr>
        <tr>
            <td>No. Faks&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 088-320651</td> 
        </tr>
        <tr>
            <td>Alamat Emel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td style="color:blue">: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <u>yantiy@ums.edu.my</u></td> 
        </tr>


    </table>
</div>


<div  style="font-family: Arial;font-size: 12px;">
    Tuan,

</div> 
<div style="margin-bottom: 10px; text-align:justify; font-family: Arial;font-size: 12px;">
    <br>
    Dengan hormatnya perkara di atas adalah dirujuk.
</div>
<strong>PERAKUAN BAGI PENGESAHAN LAPOR DIRI
</strong><br><br>
<div style="margin-bottom: 15px; text-align:justify ;font-family: Arial;font-size: 12px;">
    Adalah dimaklumkan bahawa penama berikut merupakan kakitangan dibawah seliaan saya yang
    telah mengikuti pengajian lanjutan dan beliau telah melapor diri bertugas semula seperti berikut:

</div>


</div>
<div class="x_content">
    <div class="table-responsive">

        <table class="table table-sm table-bordered" style=" font-size: 10px;">
            <tr>
                <td colspan="10" style="text-align:center; background-color:#527e72" color="white" height="30px" ><strong>MAKLUMAT LAPOR DIRI</strong></td>
            </tr>


            <tr> 
                <th colspan="5" align="left">NAMA</th>
                <td colspan="5">
                    <?= strtoupper($model->kakitangan->CONm) ?></td>

            </tr>
            <tr> 
                <th colspan="5" align="left">UMSPER</th>
                <td colspan="5">
                    <?= strtoupper($model->kakitangan->department->fullname) ?></td>

            </tr>
              <tr> 
                <th colspan="5" align="left">FAKULTI</th>
                <td colspan="5">
                    <?= strtoupper($model->kakitangan->COOldID) ?></td>

            </tr>
              <tr> 
                <th colspan="5" align="left">PERINGKAT PENGAJIAN</th>
                <td colspan="5">
                    <?= strtoupper( $model->pengajian->tahapPendidikan) ?></td>

            </tr>
              
            <tr> 
                <th colspan="5" align="left">STATUS PENGAJIAN</th>
                <td colspan="5">
                    <?= strtoupper($model->study->status_pengajian) ?></td>

            </tr>
            <tr> 
                <th colspan="5" align="left">ULASAN</th>
                <td colspan="5">
                    <?= strtoupper($model->ulasan_jfpiu) ?></td>

            </tr>
             <tr> 
                 <th colspan="5" align="left">TARIKH LAPOR DIRI<br>
                     <small><i>**Diisi oleh Ketua Jabatan</i></small></th>
                <td colspan="5">
                    <?= strtoupper($model->dtlapor) ?></td>

            </tr>
        </table>
    </div>

</div>
<!--
<div style="margin-bottom: 15px; text-align:justify">
    <br>
    3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sukacita sekiranya pihak puan dapat membuat bayaran kepada penama yang
    berkenaan. Sehubungan itu, dilampirkan bersama-sama ini dokumen-dokumen yang berkaitan
    untuk rujukan pihak puan selanjutnya. 
</div>-->

<div style="margin-bottom: 8px; font-family: Arial;font-size: 11px;">
  
    Sekian, terima kasih.<br><br>
   
    <table style=" font-family: Arial;font-size: 11px;">
    


        <tr>
            <td style=" font-family: Arial;font-size: 10px;" >Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td style=" font-family: Arial;font-size: 10px;">: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $model->ketuajfpiu;?></td> 
        </tr>
        
        <tr>
            <td>Jawatan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php 
        if($model->jawatanketua)
        {
            echo $model->jawatanketua->adminpos->position_name;
        }
 else {
     echo 'DEKAN';
 }?>,  <?php echo $model->kakitangan->department->fullname;?></td> 
        </tr>
        <tr>
            <td>Tarikh Pengesahan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$model->dtkj?></td> 
        </tr>


    </table>
</div>
</div>


        



<!--<div style="margin-bottom:22px; font-size: 13px;">
    <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>
    <div align = "center"><strong> INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN </strong></div>

</div>-->





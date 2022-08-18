<html>
    <style>
        .div {
        font-family: Tahoma,serif;
        font-size:10pt;
        }
        </style>
    
    <body>
    <!--tick jenis_tuntutan, gigi-->   
        <div style="        
    position: absolute;
    width: 200px;
    top: 7.5%;
    left: 7%;
    text-align: center;
    text-transform: capitalize;">
        <?= ($model->jenis_tuntutan_id == 1) ? '<p style="font-family: arial;">&#10004;</p>' : '';?>
        </div>
    <!--tick jenis_tuntutan, kacamata-->   
        <div style="        
    position: absolute;
    width: 200px;
    top: 7.5%;
    left: 42.4%;
    text-align: center;
    text-transform: capitalize;">
        <?= ($model->jenis_tuntutan_id == 2) ? '<p style="font-family: arial;">&#10004;</p>' : '';?>
        </div>
    <!--tick sendiri-->   
        <div style="        
    position: absolute;
    width: 200px;
    top: 6.8%;
    left: 25.5%;
    text-align: center;
    text-transform: capitalize;">
        <?= ($model->used_by == $model->icno && $model->jenis_tuntutan_id == 1) ? '<p style="font-family: arial;">&#10004;</p>' : '';?>
        </div>
    <!--tick tanggungan-->   
        <div style="        
    position: absolute;
    width: 200px;
    top: 8.2%;
    left: 25.5%;
    text-align: center;
    text-transform: capitalize;">
        <?= ($model->icno !== $model->used_by) ? '<p style="font-family: arial;">&#10004;</p>' : '';?>
        </div>
    <!--tick kacamata,sendiri-->   
        <div style="        
    position: absolute;
    width: 200px;
    top: 7.7%;
    left: 59.6%;
    text-align: center;
    text-transform: capitalize;">
        <?= ($model->jenis_tuntutan_id == 2) ? '<p style="font-family: arial;">&#10004;</p>' : '';?>
        </div>
                
        <div style="        
    position: absolute;
    width: 333px;
    bottom: 85.5%;
    left: 15%;
    text-align: left;
    text-transform: uppercase;">
        <?php echo $model->kakitangan->CONm;?>
        </div>
    <div style="        
    position: absolute;
    width: 163px;
    bottom: 83%;
    right: 5%;
    text-align: center;">
        <?php echo $model->kakitangan->COOldID;?>
        </div>
    <!--jfpiu-->
    <div style="        
    position: absolute;
    width: 163px;
    bottom: 83%;
    left: 9.5%;
    text-align: center;">
        <?php echo $model->department->shortname;?>
        </div>
    <!--jenis tanggungan,suami-->
    <div style="        
    position: absolute;
    width: 163px;
    bottom: 83.5%;
    left: 22%;
    text-align: center;">
        <?= ($model->used_by !== $model->icno && $model->keluarga->RelCd == 02) ? '<p style="font-family: arial;">&#10004;</p>' : '';?>
        </div>
    <!--jenis tanggungan,isteri-->
    <div style="        
    position: absolute;
    width: 163px;
    bottom: 83.5%;
    left: 30%;
    text-align: center;">
        <?= ($model->used_by !== $model->icno && $model->keluarga->RelCd == 01) ? '<p style="font-family: arial;">&#10004;</p>' : '';?>
        </div>
    <!--jenis tanggungan,anak-->
    <div style="        
    position: absolute;
    width: 163px;
    bottom: 83.5%;
    left: 40%;
    text-align: center;">
        <?= ($model->used_by !== $model->icno && $model->keluarga->RelCd == 05) ? '<p style="font-family: arial;">&#10004;</p>' : '';?>
        </div>
    <!--jenis tanggungan,ibu-->
    <div style="        
    position: absolute;
    width: 163px;
    bottom: 83.5%;
    left: 48.7%;
    text-align: center;">
        <?= ($model->used_by !== $model->icno && $model->keluarga->RelCd == 03) ? '<p style="font-family: arial;">&#10004;</p>' : '';?>
        </div>
    <!--jenis tanggungan,bapa-->
    <div style="        
    position: absolute;
    width: 163px;
    bottom: 83.5%;
    left: 57.3%;
    text-align: center;">
        <?= ($model->used_by !== $model->icno && $model->keluarga->RelCd == 04) ? '<p style="font-family: arial;">&#10004;</p>' : '';?>
        </div>
    <!--nama tanggungan-->
    <div style="        
    position: absolute;
    width: 500px;
    bottom: 81%;
    left: 31%;
    text-align: left;">
        <?= ($model->used_by == $model->icno) ? '' : $model->hubungan->FmyNm ;?>
        </div>
    <!--nama klinik/kedai kacamata-->
    <div style="        
    position: absolute;
    width: 500px;
    bottom: 75.3%;
    left: 31%;
    text-align: left;">
        <?php if($model->jenis_tuntutan_id == 1){
            echo $model->klinik->klinik_nama;
        }else{
            echo $model->kacamata;
        } ?>
        </div>
    <div style="        
    position: absolute;
    width: 500px;
    bottom: 71%;
    left: 31%;
    text-align: left;">
        <?php if($model->jenis_tuntutan_id == 1){
            echo $model->klinik->klinik_alamat;
        }else{
            echo $model->kacamata;
        } ?>
        </div>
    <!--no.bil/resit-->
    <div style="        
    position: absolute;
    width: 500px;
    bottom: 68.5%;
    left: 31%;
    text-align: left;">
        <?php echo $model->catatan;?>
        </div>
    <!--jumlah_tuntutan-->
    <div style="        
    position: absolute;
    width: 500px;
    bottom: 68.5%;
    left: 89%;
    text-align: left;">
        <?php echo $model->jumlah_tuntutan;?>
        </div>
<!--    terima oleh-->
    <div style="        
    position: absolute;
    width: 500px;
    bottom: 53.3%;
    left: 20%;
    text-align: left;">
        <?php echo $model->kakitanganCheck->CONm;?>
        </div>
<!--    bayaran terakhir-->
    <div style="        
    position: absolute;
    width: 500px;
    bottom: 53.3%;
    left: 87%;
    text-align: left;">
        <?php echo 'RM'.$lastpayment->jumlah_tuntutan;?>
        </div>
<!--tick tolak-->
    <div style="        
    position: absolute;
    width: 500px;
    bottom: 48.2%;
    left: 21.2%;
    text-align: left;">
        <?= ($model->status == "DITOLAK") ? '<p style="font-family: arial;">&#10004;</p>' : '';?>
        </div>
<!--tick lulus sebahagian-->
    <div style="        
    position: absolute;
    width: 500px;
    bottom: 48.2%;
    left: 32.7%;
    text-align: left;">
        <?= ($model->jumlah_lulus !== $model->jumlah_tuntutan) ? '<p style="font-family: arial;">&#10004;</p>' : '';?>
        </div>
<!--tick lulus penuh-->
    <div style="        
    position: absolute;
    width: 500px;
    bottom: 48.2%;
    left: 56.3%;
    text-align: left;">
        <?= ($model->jumlah_lulus == $model->jumlah_tuntutan) ? '<p style="font-family: arial;">&#10004;</p>' : '';?>
        </div>
<!--jumlah bayar-->
    <div style="        
    position: absolute;
    width: 500px;
    bottom: 48.2%;
    left: 89%;
    text-align: left;">
        <?= $model->jumlah_lulus;?>
        </div>
<!--    bayaran_akhir
    <div style="        
    position: absolute;
    width: 500px;
    bottom: 53.3%;
    left: 90%;
    text-align: left;">
        
        </div>-->
    <!--masa print-->
    <div style="        
    position: absolute;
    width: 500px;
    bottom: 57.7%;
    left: 79%;
    text-align: left;">
        <?php echo date("d M Y");?>
        </div>
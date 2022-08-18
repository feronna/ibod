<html>
    <style>
        .div {
        font-family: Tahoma,serif;
        font-size:10pt;
        }
        </style>
    
    <body>
         <div style="        
    position: absolute;
    width: 400px;
    top: 10.6%;
    left: 19%;
    text-align: left;
    font-size: 11px;
    text-transform: uppercase;">
        <?php echo $model->kakitangan->CONm;?> 
        </div>
        <!--ums-per--> 
    <div style="        
    position: absolute;
    width: 163px;
    top: 10.2%;
    left: 64%;
    font-size: 11px;
    text-align: center;">
        <?php echo $model->kakitangan->COOldID;?>
        </div>
         <div style="        
    position: absolute;
    width: 400px;
    top: 13.2%;
    left: 19%;
    text-align: left;
    font-size: 11px;
    text-transform: uppercase;">
        <?php echo $model->kakitangan->jawatan->nama; ?>
        </div>
        
         <div style="        
    position: absolute;
    width: 163px;
    top: 13.2%;
    left: 64%;
    font-size: 11px;
    text-align: center;">
        <?php echo $model->kakitangan->ICNO;?>
        </div>
         <div style="        
    position: absolute;
    width: 400px;
    top: 16%;
    left: 4%;
    font-size: 11px;
    text-align: center;
    text-transform: uppercase;">
      <?php echo $model->kakitangan->department->fullname; ?>
        </div>
         <div style="        
    position: absolute;
    width: 163px;
    top: 16.2%;
    left: 67.7%;
    font-size: 11px;
    text-align: center;">
        <?php echo $model->kakitangan->COOffTelNoExtn.' / '.$model->kakitangan->COHPhoneNo;?>
        </div>
<!--   tick box sendiri 
-->        <div style="        
    position: absolute;
    width: 200px;
    top: 19.2%;
    left: 8.4%;
    text-align: center;
    text-transform: capitalize;">
        <?= ($model->jenis_belian == 'Kasut kulit biasa (RM 150.00)') ? '<p style="font-family: arial;">&#10004;</p>' : '';?>
        </div>
       <div style="        
    position: absolute;
    width: 200px;
    top: 19.1%;
    left: 45%;
    text-align: center;
    text-transform: capitalize;">
        <?= ($model->jenis_belian == 'Kasut kulit keselamatan (RM250.00)') ? '<p style="font-family: arial;">&#10004;</p>' : '';?>
        </div>
     <div style="        
    position: absolute;
    width: 200px;
    top: 25%;
    left: 44.5%;
    text-align: center;
    text-transform: capitalize;">
        <?php if($model->jenis_belian == 'Kasut kulit biasa (RM 150.00)'){
            echo $model->bil_belian;
        }
        ?>
        </div>
         <div style="        
    position: absolute;
    width: 200px;
    top: 25%;
    left: 78.5%;
    text-align: center;
    text-transform: capitalize;">
        <?php if($model->jenis_belian == 'Kasut kulit keselamatan (RM250.00)'){
            echo $model->bil_belian;
        }
        ?>
        </div>       
       <div style="        
    position: absolute;
    width: 400px;
    top: 35.5%;
    left: 18.5%;
    text-align: left;
    font-size: 13px;
    text-transform: uppercase;">
        <?php echo $model->kakitangan->CONm;?> 
        </div>
   <div style="        
    position: absolute;
    width: 400px;
    top: 39.2%;
    left: 23.5%;
    text-align: left;
    font-size: 11px;
    text-transform: uppercase;">
        <?php echo $model->entrydate;?> 
        </div>
    <div style="        
    position: absolute;
    width: 400px;
    top: 49.3%;
    left: 18.5%;
    text-align: left;
    font-size: 13px;
    text-transform: uppercase;">
        <?php echo $model->kakitangan->CONm;?> 
        </div>
    <div style="        
    position: absolute;
    width: 400px;
    top: 52.8%;
    left: 23.8%;
    text-align: left;
    font-size: 11px;
    text-transform: uppercase;">
        <?php echo $model->appdate;?> 
        </div>
<!--         
        <div style="        
    position: absolute;
    width: 163px;
    bottom: 83.8%;
    left: 79.5%;
    font-size: 11px;
    text-align: center;">
        <?php echo $model->kakitangan->ICNO;?>
        </div>
    jfpiu
    <div style="        
    position: absolute;
    width: 163px;
    bottom: 83%;
    left: 9.5%;
    text-align: center;"> 
        </div>
        <div style="        
    position: absolute;
    width: 333px;
    bottom: 81.7%;
    left: 17%;
    text-align: left;
    font-size: 11px;
    text-transform: uppercase;">
        <?php echo $model->kakitangan->department->fullname;?> 
        </div>
         status jawatan 
        <div style="        
    position: absolute;
    width: 333px;
    bottom: 81.8%;
    left: 65%;
    text-align: left;
    font-size: 11px;
    text-transform: uppercase;"> 
        <?= ( $model->kakitangan->statLantikan == 2) ? '<p style="font-family: arial;">&#10004;</p>' : '';?>
        </div>
        <div style="        
    position: absolute;
    width: 333px;
    bottom: 81.8%;
    left: 77.1%;
    text-align: left;
    font-size: 11px;
    text-transform: uppercase;"> 
        <?= ( $model->kakitangan->statLantikan == 1) ? '<p style="font-family: arial;">&#10004;</p>' : '';?>
        </div>
        <div style="        
    position: absolute;
    width: 333px;
    bottom: 81.8%;
    left: 85.3%;
    text-align: left;
    font-size: 11px;
    text-transform: uppercase;"> 
        <?= ( $model->kakitangan->statLantikan == 3) ? '<p style="font-family: arial;">&#10004;</p>' : '';?>
        </div>
        <div style="        
    position: absolute;
    width: 333px;
    bottom: 71.7%;
    left: 13%;
    text-align: left;
    font-size: 11px;
    text-transform: uppercase;">
        <?php echo $model->displayjenis->kemudahan?> 
        </div>
        <div style="        
    position: absolute;
    width: 333px;
    bottom: 71.7%;
    left: 49%;
    text-align: left;
    font-size: 11px;
    text-transform: uppercase;">
        <?php echo $model->used_dt?> 
        </div>
        <div style="        
    position: absolute;
    width: 333px;
    bottom: 71.7%;
    left: 59.8%;
    text-align: left;
    font-size: 11px;
    text-transform: uppercase;">
        <?php echo $model->resit?> 
        </div>
        <div style="        
    position: absolute;
    width: 333px;
    bottom: 71.7%;
    left: 71%;
    text-align: left;
    font-size: 11px;
    text-transform: uppercase;">
        RM <?php echo  $model->jumlah_tuntutan?> 
        </div>
        <div style="        
    position: absolute;
    width: 333px;
    bottom: 60.3%;
    left: 71%;
    text-align: left;
    font-size: 12px;
    text-transform: uppercase;">
         RM <?php echo  $model->jumlah_tuntutan?> 
        </div>
         tandatangan pegawai 
        <div style="        
    position: absolute;
    width: 333px;
    bottom: 49.8%;
    left: 28%;
    text-align: left;
    font-size: 12px;
    text-transform: uppercase;">
        <?php echo $model->kakitangan->CONm;?> 
        </div>
        <div style="        
    position: absolute;
    width: 333px;
    bottom: 49.8%;
    left: 78.7%;
    text-align: left;
    font-size: 12px;
    text-transform: uppercase;">
        <?php echo $model->entrydate;?> 
        </div>-->
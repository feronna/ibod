<html>
    <style>
        .div {
        font-family: Tahoma,serif;
        font-size:10pt;
        }
        </style>
    
    <body>
  <!-- tick box sendiri -->
        <div style="        
    position: absolute;
    width: 200px;
    top: 9.2%;
    left: 21.4%;
    text-align: center;
    text-transform: capitalize;">
        <?= ($model->jeniskemudahan == 8) ? '<p style="font-family: arial;">&#10004;</p>' : '';?>
        </div>
    <!-- nama kakitangan -->
                
        <div style="        
    position: absolute;
    width: 333px;
    bottom: 83.9%;
    left: 15%;
    text-align: left;
    font-size: 11px;
    text-transform: uppercase;">
        <?php echo $model->kakitangan->CONm;?> 
        </div>
        <!-- ums-per -->
    <div style="        
    position: absolute;
    width: 163px;
    bottom: 83.8%;
    left: 51.3%;
    font-size: 11px;
    text-align: center;">
        <?php echo $model->kakitangan->COOldID;?>
        </div>
        <div style="        
    position: absolute;
    width: 163px;
    bottom: 83.8%;
    left: 79.5%;
    font-size: 11px;
    text-align: center;">
        <?php echo $model->kakitangan->ICNO;?>
        </div>
    <!--jfpiu-->
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
        <!-- status jawatan -->
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
        RM <?php echo  $model->jumlah?> 
        </div>
        <div style="        
    position: absolute;
    width: 333px;
    bottom: 60.3%;
    left: 71%;
    text-align: left;
    font-size: 12px;
    text-transform: uppercase;">
         RM <?php echo  $model->jumlah?> 
        </div>
        <!-- tandatangan pegawai -->
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
        </div>
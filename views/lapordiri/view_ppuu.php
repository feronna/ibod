<html>
    <style>
        .div {
                
            font-family:    Arial, Helvetica, sans-serif;
        font-size:8pt;
        }
        </style>
    
    <body>
        
      
        <div style="      
    position: fixed;
    width: 500px;
    bottom: 49%;
    left: 20%;
/*    text-align: center;*/
    text-transform: uppercase;
    font-family: Arial;
    font-size: 12px;
    ">
            <?= strtoupper($model->kakitangan->CONm);?>
        </div>
    <div style="        
    position: fixed;

    width: 350px;
    bottom: 47%;
    left: 19%;
    text-align: center;
    text-transform: uppercase;
   font-family: Arial;
  font-size: 12px;
  
  ">
        <?php echo $model->kakitangan->COOldID;?>
        </div>
          
          <div style="        
    position: fixed;

    width: 350px;
    bottom: 44.5%;
    left: 31%;
    text-align: center;
    text-transform: uppercase;
   font-family: Arial;
  font-size: 12px;
  
  ">
        <?php echo $model->kakitangan->department->fullname;?>
        </div>
        
        
      
        <div style="        
    position: fixed;
    
    width: 350px;
    bottom: 41.8%;
    left: 22%;
/*    text-align: center;*/
font-family: Arial;
  font-size: 12px;
 ">
       <?php echo $model->pengajian->tahapPendidikan;?>
        </div>
        <div style="        
    position: fixed;
    width: 350px;
    bottom: 26%;
    left: 39%;
    text-align: left;
    text-transform: uppercase;
     text-transform: uppercase;
   font-family: Arial;
  font-size: 12px;">
        <?php echo $model->ulasan_jfpiu;?>
        </div>
        <div style="        
    position: fixed;
    width: 380px;
    bottom: 38.5%;
    left: 27.5%;
    text-align: center;
    text-transform: uppercase;
     text-transform: uppercase;
   font-family: Arial;
  font-size: 12px;">
     <?php echo $model->study->status_pengajian;?>
        </div>
        <div style="        
    position: fixed;
    width: 380px;
    bottom: 22%;
    left: 18.5%;
    text-align: center;
    text-transform: uppercase;
     text-transform: uppercase;
   font-family: Arial;
  font-size: 12px;">
        <?php echo $model->dtlapor;?>
        </div>
        
         <div style="        
    position: fixed;
    width: 350px;
    bottom: 12%;
    left: 20%;
    text-align: center;
     text-transform: uppercase;
   font-family: Arial;
  font-size: 12px;">
        <?php echo $model->ketuajfpiu;?>
        </div>
        <div style="        
    position: fixed;
    width: 350px;
    bottom: 9.8%;
    left: 27%;
    text-align: center;
     text-transform: uppercase;
   font-family: Arial;
  font-size: 12px;">
        <?php 
        if($model->jawatanketua)
        {
            echo $model->jawatanketua->adminpos->position_name;
        }
 else {
     echo 'DEKAN';
 }?>,  <?php echo $model->kakitangan->department->fullname;?>
        </div>
        
        
        
        <div style="        
    position: fixed;
    width: 350px;
    bottom: 7.5%;
    left: 13.8%;
    text-align: center;
    text-transform: uppercase;
     text-transform: uppercase;
   font-family: Arial;
  font-size: 12px;">
        <?php echo $model->dtkj;?>
        </div>

        
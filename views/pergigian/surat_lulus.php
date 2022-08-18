 

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 
<div style="margin-bottom: 200px;font-size: 11px">
    <br>
   
</div>           
         <div style="margin-bottom:14px; margin-left:-54px; font-size: 11px;">
             <strong><?php if($pergigian->jenis_tuntutan_id == 1){
                                echo 'TUNTUTAN RAWATAN PERGIGIAN';
                                }else{
                                echo 'TUNTUTAN PEMBELIAN KACAMATA';}
                               ?></strong>
        </div>
        <div style="margin-bottom: 0px;font-size: 10px">
    <br> 
</div> 
        <div style="margin-bottom:30px; margin-left:120px; font-size: 11px;">
             <strong> <?= $pergigian->kakitangan->CONm ?>  </strong>
        </div>
        <div style="margin-bottom: -24px;font-size: 10px">
     
</div> 
      
         <div style="margin-bottom:40px; margin-left:120px; font-size: 11px;">
             <strong> <?= $pergigian->icno ?>  </strong>
         </div>
        
        <div style="margin-bottom: -34px;font-size: 10px">
     
</div> 
      
         <div style="margin-bottom:40px; margin-left:120px; font-size: 11px;">
             <strong> (<?= $pergigian->kakitangan->jawatan->gred?>)&nbsp;<?= ucwords(strtolower($pergigian->kakitangan->jawatan->nama))?> </strong>
         </div>
        <div style="margin-bottom: -33px;font-size: 10px">
     
</div> 
      
         <div style="margin-bottom:40px; margin-left:120px; font-size: 11px;">
             <strong> <?= $pergigian->kakitangan->department->fullname ?></strong>
         </div>
        <div style="margin-bottom: -35px;font-size: 10px">
     
</div> 
      
         <div style="margin-bottom:42px; margin-left:120px; font-size: 11px;">
             <strong> <?= $pergigian->kakitangan->statusLantikan->ApmtStatusNm ?></strong>
         </div>
        <div style="margin-bottom: -35px;font-size: 10px">
     
</div> 
      
         <div style="margin-bottom:40px; margin-left:120px; font-size: 11px;">
             <strong><?= $pergigian->kakitangan->COEmail ?></strong>
         </div>
        
        <div style="margin-bottom: -32px;font-size: 10px">
     
</div> 
      
         <div style="margin-bottom:40px; margin-left:120px; font-size: 11px;">
             <strong><?= $pergigian->kakitangan->COOffTelNoExtn ?> </strong>
         </div>
        
         <div style="margin-bottom: -34px;font-size: 10px">
     
</div> 
      
         
         
         <div style="margin-bottom: 21px;font-size: 10px">
     
</div> 
         <div style="margin-bottom:65px; margin-left:11px; font-size: 10px;">
             <strong></strong>
         </div>
         
          <div style="margin-bottom: -15px;font-size: 10px">
     
</div> 
         <div style="margin-bottom:38px; margin-left:120px; font-size: 11px;">
             <strong><?php if($pergigian->jenis_tuntutan_id == 1){
                                if($pergigian->klinik_gigi_id == 174){
                                    echo $pergigian->lain;
                                }else{
                                     echo $pergigian->klinikname; 
                                }}else {echo $pergigian->kacamata;}
                               ?></strong>
         </div>



         <div style="margin-bottom: -34px;font-size: 10px">
     
</div> 
         <div style="margin-bottom:40px; margin-left:120px; font-size: 11px;">
             <strong><?= $pergigian->used_dt?></strong>
         </div>
         
           <div style="margin-bottom: -34px;font-size: 10px">
     
</div> 
         <div style="margin-bottom:40px; margin-left:120px; font-size: 11px;">
             <strong><?= $pergigian->jumlah_tuntutan?></strong>
         </div>
         <div style="margin-bottom: -34px;font-size: 10px">
     
</div> 
         <div style="margin-bottom:40px; margin-left:120px; font-size: 11px;">
             <strong><?= $pergigian->catatan?></strong>
         </div>
         
        <div style="margin-bottom:55px; margin-left:11px; font-size: 10px;">
             <strong></strong>
         </div>
     
         <div style="margin-bottom:45px; margin-left:120px; font-size: 10px;">
             <strong><?= $pergigian->statusS ?> </strong>
         </div>
         
         <div style="margin-bottom: -34px;font-size: 10px">
     
</div> 
         <div style="margin-bottom:40px; margin-left:120px; font-size: 11px;">
             <strong><?= $pergigian->check_dt?></strong>
         </div>
          <div style="margin-bottom:11px;font-size: 10px">
     
</div> 
         <div style="margin-bottom:40px; margin-left:120px; font-size: 10px;">
             <strong><?= $pergigian->statusL ?> </strong>
         </div>
         <div style="margin-bottom: -30px;font-size: 10px">
     
</div> 
         <div style="margin-bottom:40px; margin-left:120px; font-size: 11px;">
             <strong><?= $pergigian->app_dt?></strong>
         </div>
         
<div style="margin-bottom:9px;font-size: 10px"></div>
     
        
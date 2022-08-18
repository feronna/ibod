<?php
 
use kartik\tabs\TabsX;
use yii\helpers\Html;

error_reporting(0);
?>
 <div class="row">

<?php echo $this->render('/cutibelajar/_topmenu');?>

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><?php echo $title;?></strong></h2>
            <p align="right"><?= Html::a('Kembali', ['cbadmin/halaman-admin'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>
            
            <div class="clearfix"></div>
        </div>
        
          
      <div class="row">
            <div class="col-md-12 col-xs-12"> 

                <div class="x_panel" id="rcorners2">
                    <h5><i class="fa fa-clock-o"></i> SENARAI PEMAKLUMAN LAPOR DIRI</h5>

                    <hr>
                                 <?= $this->render('/lapordiri/_senarai_menunggu', ['bil' => 1,  'icno' => $icno, 
                                     'senarai' => $senarai, 'title' => $title, 'terima'=>$terima,'belum'=>$belum])?><br>
                </div></div>
        </div>
     
    </div> 
<!--            end of dropdownl link-->
  
    </div>
</div>
 


<?php
use yii\helpers\Html;
use kongoon\orgchart\OrgChart;
?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <?php echo $this->render('menu_info_tugas'); ?> 
</div>

<div class="col-md-3 col-sm-12 col-xs-12"> 
    <?php echo $this->render('menu_services'); ?>   
</div>
    <div class="col-md-9 col-sm-12 col-xs-12">

    <div class="x_panel">
                     <div class="x_content">
                      
            <div class="table-responsive">
            <div class="product_price">

        <center><h4> <span class="label label-success">CARTA ORGANISASI <?= strtoupper($test->department->fullname);?></span></h4></center>
            </div>
  
                
    
                
                <?php  
  
  

echo OrgChart::widget([
    
    
   // 'model' => $model,
    'data' => $model, 
    ]) ?>
                
       

</div>
                     </div></div>
 
            
</div>
</div>
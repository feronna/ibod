<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpraddress */

$this->title = 'Status Lantikan';

?> 

<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         <?= Html::a('Kembali', ['perkhidmatan/viewuser', 'id' => $ICNO], ['class' => 'btn btn-primary']) ?>
        
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>Status Lantikan</th>
                    <th>Tarikh Mula Lantikan </th>
                    <th>Tarikh Tamat Lantikan</th>
                  
                 
                </tr>
                </thead>
                <?php if($alamat) {
                    
                   foreach ($alamat as $alamatkakitangan) {
                    
                ?>
                  
                <tr>
                    <td><?= $alamatkakitangan->statusLantikan->ApmtStatusNm; ?></td>
                    <td><?= $alamatkakitangan->tarikhMulaLantikan; ?></td>
                    <td>
                        <?php  if (($alamatkakitangan->statusLantikan->ApmtStatusCd == 1) && ($alamatkakitangan->retire->RetireAgeCd != null)){
                     echo  $alamatkakitangan->retire->tarikhKuatkuasa;  
                  }else{
                      echo $alamatkakitangan->tarikhTamatLantikan; 
                 }
                ?>
                    
                    </td>
               
                   
                </tr>

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>
            </div>
        </div>
    </div>
</div>




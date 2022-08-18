<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm; 
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\number\NumberControl;
use kartik\grid\GridView;
error_reporting(0);
?>


<?php $this->title = 'Borang Online';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86,1183,1314], 'vars' => []]); ?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Kod Akaun Table fac_refakaun</strong></h2>
              
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
      <div class="table-responsive"> 
          
               <?php if ($akaun) { $bil=1; ?>
                    <?php foreach ($akaun as $lt) { ?> 
                     <?php } ?>
                 <?php } ?>
                         
          <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">BIL </th> 
                        <th class="text-center">Kod Akaun</th>   
                        <th class="text-center">TINDAKAN</th>    
                    </tr> 
                </thead>
                
               <?php if ($akaun) { $bil=1; ?>
                    
                        <tr>
                            <td class="text-center"  style="text-align:center"><?= $bil++; ?></td>  
                            <td class="text-justify"><?php echo $lt->kodAkaun; ?></td> 
                            <td class="text-center"> <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['dlte', 'akauncd' => $lt->akauncd]) ?></td>                    
                          
                          
                          <?php } ?>
                   
                        </tr> 
            </table>
           </div>
        <div class="ln_solid"></div>
 
    </div>
    </div>
</div>
 
 <?php ActiveForm::end(); ?>


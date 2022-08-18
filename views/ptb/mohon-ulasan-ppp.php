<?php

use yii\helpers\Html;
use kartik\checkbox\CheckboxX;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>

<div class="row">
<div class="col-md-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-pencil">&nbsp&nbsp </i>Mohon Ulasan Pegawai Penyelia Pertama (PPP)</strong></h2>
              
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
               
                          <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
         
                   
               <?php
               
               echo $form->field($ppp, 'ulasan_ppp')->widget(CheckboxX::classname(), [
       
                       'autoLabel' => true,
                       'labelSettings' => [
                      'label' => '  <h style="color: green">
                * Klik untuk mohon ulasan Pegawai Penyelia Pertama (PPP)
                </h>',
                        'position' => CheckboxX::LABEL_RIGHT
                          ]
                       ])->label(false);
               
               
               ?>
                 
                    <div class="ln_solid"></div>

            <div class="form-group">
                <div>
                 
                    <?= Html::submitButton('Hantar',['class' => 'btn btn-success']) ?>
              
                </div>
            </div>
                


            <?php ActiveForm::end(); ?>
            </div>
            </div>
        </div>
    </div>



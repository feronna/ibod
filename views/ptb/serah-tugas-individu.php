<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>


    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Nota Serah Tugas</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
             
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
       
        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
       
         <div class="form-group inline">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Ketua JFPIU<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12" style="display: inline-block">
                      
                        <?= Html::textInput('', $depart->chiefBiodata->CONm, ['class' => 'form-control inline', 'disabled' => true]) ?>
                    </div>
                </div>
   
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($tugas, 'catatan_individu')->textarea(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div>
        </div>

        <div class="ln_solid"></div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Hantar',['class' => 'btn btn-success', 'data'=>['confirm'=>'Nota Serah Tugas boleh dihantar sekali sahaja bagi setiap pertukaran tempat bertugas yang berjaya. Sila pastikan semua maklumat adalah betul. Teruskan?']]) ?>
            </div>
        </div>
            <?php ActiveForm::end();?>
    </div>
    </div>





<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;



?>

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2>Kemaskini Pergerakan Gaji</h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
              <div class="table-responsive">
            <p style="color: green">
                Petak dengan tanda * wajib diisi.
            </p>
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>


             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Bulan Pergerakan<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'SalMoveMth')->label(false)->widget(Select2::classname(), [
                        'data' => $bulanPergerakan,
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Pergerakan<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'SalMoveMthType')->label(false)->widget(Select2::classname(), [
                        'data' => $jenisPergerakan,
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>

        
            
                        
               <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mula<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
             
                             <?= $form->field($model, 'SalMoveMthStDt')->widget(DatePicker::className(),
                                  ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                                  ])->label(false);?>
                    </div>
                </div>

             
             
            
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar',['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <!--form-->
        </div>
    </div>
</div>
</div>




<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


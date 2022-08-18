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
            <h2>Fail Perkhidmatan</h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
              <div class="table-responsive">
            <p style="color: green">
                Petak dengan tanda * wajib diisi.
            </p>
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No Rujukan Fail Perkhidmatan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'COFileNo')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
           
             <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Kuatkuasa<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                            DatePicker::widget([
                                'model' => $model,
                                'attribute' => 'COFileNoEftvDt',
                                'template' => '{input}{addon}',
                                'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]);
                        ?>
                    </div>
                </div>
            
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= \yii\helpers\Html::a('Kembali', ['view-lantikan', 'id' => $model->ICNO], ['class' => 'btn btn-primary']) ?>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Tunggu..']]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
</div>




<?php


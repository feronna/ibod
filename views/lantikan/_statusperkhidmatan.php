<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\hronline\ServiceStatus;
use app\models\hronline\Servicestatusdetail;



?>

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2>Status Perkhidmatan</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
              <div class="table-responsive">
            <p style="color: green">
                Petak dengan tanda * wajib diisi.
            </p>
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Perkhidmatan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'ServStatusCd')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(ServiceStatus::find()->all(), 'ServStatusCd', 'ServStatusNm'),
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="jtooltip"><i class="fa fa-info-circle fa-md"></i>
                    <text>Status Perkhidmatan untuk lantikan pertama adalah "Aktif".</text>
                </div>

            </div>
            
               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Terperinci<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'ServStatusDtl')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Servicestatusdetail::find()->all(), 'id', 'name'),
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="jtooltip"><i class="fa fa-info-circle fa-md"></i>
                    <text>Status Terperinci untuk lantikan pertama adalah "Sedang aktif di UMS".</text>
                </div>
            </div>
             
             <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mula Sandangan<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                            DatePicker::widget([
                                'model' => $model,
                                'attribute' => 'ServStatusStDt',
                                'template' => '{input}{addon}',
                                'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]);
                        ?>
                    </div>
                    <div class="jtooltip"><i class="fa fa-info-circle fa-md"></i>
                    <text>Tarikh mula sandangan untuk lantikan pertama adalah "Tarikh Mula Lantikan".</text>
                </div>
            </div>
            
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= \yii\helpers\Html::a('Kembali', ['view-lantikan','id'=>$model->ICNO], ['class' => 'btn btn-primary']) ?>
                    <?= Html::submitButton('Hantar',['class' => 'btn btn-success','data'=>['disabled-text'=>'Tunggu..']]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
</div>






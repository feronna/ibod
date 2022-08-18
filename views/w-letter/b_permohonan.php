<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>  
<?= $this->render('menu') ?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 

    <div class="x_panel"> 
        <div class="x_title">
            <h2>Tujuan Permohonan</h2> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Pegawai: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12">   
                    <?=
                    $form->field($permohonan, 'ICNO')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => ''],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?>
                </div>
            </div> 
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh bertugas: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12">  
                    <?php
                    echo $form->field($permohonan, 'tarikh', [
                        'addon' => ['prepend' => ['content' => '<i class="fa fa-calendar"></i>']],
                        'options' => ['class' => 'drp-container'],
                        'showLabels' => false,
                    ])->widget(DateRangePicker::classname(), [
                        'useWithAddon' => true,
                        'startAttribute' => 'StartDate',
                        'endAttribute' => 'EndDate',
                        'convertFormat' => true,
                        'readonly' => true,
                        'pluginOptions' => [
                            'locale' => [
                                'format' => 'Y-m-d',
                                'separator' => ' to '
                            ],
                            'opens' => 'left',
                        ]
                    ]);
                    ?>  

                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Senarai Tugas: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                    <?=
                    $form->field($permohonan, 'tugas')->textarea(['rows' => 6])->label(false);
                    ?> 
                </div>
            </div>
            <div class="hide">  
                <?= $form->field($permohonan, 'tarikh_mohon')->hiddenInput(['value' => date("Y-m-d H:i:s")])->label(false); ?>
                <?= $form->field($permohonan, 'status_semasa')->hiddenInput(['value' => 3])->label(false); ?>
                <?= $form->field($permohonan, 'isActive')->hiddenInput(['value' => 1])->label(false); ?>
                <?= $form->field($permohonan, 'status_notifikasi')->hiddenInput(['value' => 1])->label(false); ?>
                <?= $form->field($permohonan, 'tarikh_notifikasi')->hiddenInput(['value' => date("Y-m-d H:i:s")])->label(false); ?>
                <?= $form->field($permohonan, 'approved_kj_at')->hiddenInput(['value' => date("Y-m-d H:i:s")])->label(false); ?>
                <?= $form->field($permohonan, 'approved_kj_ulasan')->hiddenInput(['value' => "AUTO-APPROVED"])->label(false); ?>
                <?= $form->field($permohonan, 'approved_kj_status')->hiddenInput(['value' => 1])->label(false); ?>
                <?= $form->field($permohonan, 'approved_bsm_at')->hiddenInput(['value' => date("Y-m-d H:i:s")])->label(false); ?>
                <?= $form->field($permohonan, 'approved_bsm_ulasan')->hiddenInput(['value' => "AUTO-APPROVED"])->label(false); ?>
                <?= $form->field($permohonan, 'approved_bsm_status')->hiddenInput(['value' => 1])->label(false); ?>
                <?= $form->field($permohonan, 'approved_bsm_by')->hiddenInput(['value' => "840813125655"])->label(false); ?>
                <?= $form->field($permohonan, 'auto')->hiddenInput(['value' => 1])->label(false); ?> 
            </div>
            <div class="form-group text-center">
                <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
                <?= Html::submitButton('Mohon', ['class' => 'btn btn-success']) ?>
            </div>

        </div>
    </div>   

    <?php ActiveForm::end(); ?> 

</div> 
</div>  


<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>
            
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        
        <div class="panel-body">
            <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mula Pengisian</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($model, 'lpp_trkh_hantar')->widget(DateTimePicker::classname(), [
                            'options' => ['placeholder' => 'Pilih tarikh'],
                            'pluginOptions' => [
                                    'autoclose' => true
                            ]
                        ])->label(false);
                    ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Tamat Pengisian</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($model, 'pengisian_PYD_tamat')->widget(DateTimePicker::classname(), [
                            'options' => ['placeholder' => 'Pilih tarikh'],
                            'pluginOptions' => [
                                    'autoclose' => true
                            ]
                        ])->label(false);
                    ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Tamat Penilaian PPP</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($model, 'penilaian_PPP_tamat')->widget(DateTimePicker::classname(), [
                            'options' => ['placeholder' => 'Pilih tarikh'],
                            'pluginOptions' => [
                                    'autoclose' => true
                            ]
                        ])->label(false);
                    ?>
                    </div>
                </div> 
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Tamat Penilaian PPK</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($model, 'penilaian_PPK_tamat')->widget(DateTimePicker::classname(), [
                            'options' => ['placeholder' => 'Pilih tarikh'],
                            'pluginOptions' => [
                                    'autoclose' => true
                            ]
                        ])->label(false);
                    ?>
                    </div>
                </div> 
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Tamat Penilaian PEER</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($model, 'penilaian_PEER_tamat')->widget(DateTimePicker::classname(), [
                            'options' => ['placeholder' => 'Pilih tarikh'],
                            'pluginOptions' => [
                                    'autoclose' => true
                            ]
                        ])->label(false);
                    ?>
                    </div>
                </div> 
                 
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                    <?=
                        $form->field($model, 'lpp_aktif')->label(false)->widget(Select2::classname(), [
                            'data' => ['Y' => "Aktif", 'N' => "Tidak Aktif",],
                            'hideSearch' => true,
                            'options' => ['placeholder' => 'Pilih Status', 
                                'class' => 'form-control col-md-7 col-xs-12',
                                //'id' => 'jenis_carian',
                                ],
                            'pluginOptions' => [
                                //'allowClear' => true
                            ],
                        ]);
                    ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                        <?= $model->isNewRecord ? Html::submitButton('Tambah', ['class' => 'btn btn-success']) : 
                        Html::submitButton('Kemaskini', ['class' => 'btn btn-success'])?>
                    </div>
                </div>
            
            <?php ActiveForm::end(); ?>
            <?php yii\widgets\Pjax::end() ?>
        </div>
    </div>
    </div>
</div>       
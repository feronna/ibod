<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use app\models\elnpt\GredJawatan;
use yii\helpers\ArrayHelper;
use app\models\elnpt\RefKumpGred;

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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">KATEGORI</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($model, 'ref_kump_gred_id')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(RefKumpGred::find()
                                    ->all(), 'id', 'kump_gred'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Carian ...', 
                                'id' => 'ppp'
                                //'class' => 'form-control col-md-7 col-xs-12',
                                //'id' => 'jenis_carian',
                                ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">GRED JAWATAN</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($model, 'gred_id')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(GredJawatan::find()
                                    ->leftJoin(['a' => 'hrm.elnpt_tbl_kump_gred'], 'a.gred_id = `hronline`.gredjawatan.id')
                                    ->where(['a.gred_id' => null])
                                    ->all(), 'id', 'fname'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Carian Gred Jawatan', 
                                'id' => 'ppk'
                                //'class' => 'form-control col-md-7 col-xs-12',
                                //'id' => 'jenis_carian',
                                ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            
            <?php ActiveForm::end(); ?>
            <?php yii\widgets\Pjax::end() ?>
        </div>
    </div>
    </div>
</div>       
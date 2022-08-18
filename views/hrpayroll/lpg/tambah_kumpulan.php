<?php

use yii\bootstrap\Alert;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\db\Expression;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\hronline_gaji\roc_reason;
use app\models\hronline_gaji\RocReason;
use app\models\hronline_gaji\Department;
use app\models\hronline_gaji\DepartmentMain;
use dosamigos\datepicker\DatePicker;


?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Tambah Kumpulan</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
                <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Sebab Perubahan</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?=
                        $form->field($model, 'srb_change_reason')->label(false)->widget(Select2::classname(), [
                            'data' => yii\helpers\ArrayHelper::map(RocReason::find()->where(['IN','RR_REASON_CODE',$lpg_ids])
                                ->all(), 'RR_REASON_CODE', 'RR_REASON_DESC'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Pilih ...',
                                'id' => 'lpg',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?= $form->field($model, 'srb_remarks')->textarea(['maxlength' => true])->label(false); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">JFPIU Proses</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?=
                        $form->field($model, 'srb_process_dept')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(DepartmentMain::find()
                                ->all(), 'dm_dept_code', 'dm_dept_desc'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Pilih ...',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Kuatkuasa</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?=
                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'srb_effective_date',
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


                <div class="form-group">
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Semula', ['class' => 'btn btn-primary']) ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
                <?php yii\widgets\Pjax::end() ?>
            </div>
        </div>
    </div>
</div>
</div>
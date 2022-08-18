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
use app\models\hronline_gaji\IncomeType;
use dosamigos\datepicker\DatePicker;

$page = $model->isNewRecord ? 'Tambah Elaun':'Kemaskini Elaun';

?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><?= $page ?></strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php yii\widgets\Pjax::begin(['id' => 'tambah-elaun']) ?>
                <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Elaun/Potongan</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?=
                        $form->field($model, 'SR_ROC_TYPE')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(IncomeType::find()
                                ->all(), 'it_income_code', 'it_income_desc'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Pilih ...',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],'disabled'=> $model->isNewRecord ? false: true,
                        ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Perubahan</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?=
                        $form->field($model, 'SR_CHANGE_REASON')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(RocReason::find()
                                ->all(), 'RR_REASON_CODE', 'RR_REASON_DESC'),
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?= $form->field($model, 'SR_NEW_VALUE')->textInput(['maxlength' => true,])->label(false); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah  Sebelum</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?= $form->field($model, 'SR_OLD_VALUE')->textInput(['maxlength' => true])->label(false); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Kiraan</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?=
                        $form->field($model, 'SR_CALC_TYPE')->label(false)->widget(Select2::classname(), [
                            'data' => ["1"=>"FIXED","2"=>"PRORATE"],
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Dari</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?=
                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'SR_DATE_FROM',
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Hinggah</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?=
                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'SR_DATE_TO',
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kod Projek</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?=
                        $form->field($model, 'SR_PROJECT_CODE')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Department::find()
                                ->all(), 'id', 'fullname'),
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pusat Kos</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?=
                        $form->field($model, 'sr_process_dept')->label(false)->widget(Select2::classname(), [
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?= $form->field($model, 'SR_REMARK')->textarea(['maxlength' => true])->label(false); ?>
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
</div>
<?php
/* @var $this yii\web\View */

use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

use app\models\hronline\Department;
use app\models\hronline\ServiceStatus;
use app\models\hronline\Kampus;

?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Carian Staff</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php $form = ActiveForm::begin(['action' => ['kew8'], 'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left']]); ?>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_pyd">UMSPER
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?=
                                $form->field($model, 'COOldID')->textInput(['id' => 'nama_pyd'])->label(false);
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama">Nama
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?=
                                $form->field($model, 'CONm')->textInput(['id' => 'nama'])->label(false);
                            ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">No KP
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?=
                                $form->field($model, 'ICNO')->textInput(['id' => 'icno'])->label(false);
                            ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="senarai">JFPIU</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?=
                                $form->field($model, 'DeptId')->label(false)->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(Department::find()->orderBy(['fullname' => SORT_ASC])->all(), 'id', 'fullname'),
                                    'options' => [
                                        'placeholder' => 'Pilih Jabatan', 
                                        'class' => 'form-control col-md-7 col-xs-12',
                                        //'selected'    => 2,
                                        //'id' => 'senarai',
                                        ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="senarai_status">Status Staf</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?=
                                $form->field($model, 'Status')->label(false)->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(ServiceStatus::find()->orderBy(['ServStatusNm' => SORT_ASC])->all(), 'ServStatusCd', 'ServStatusNm'),
                                    'hideSearch' => true,
                                    'options' => [
                                        'placeholder' => 'Pilih Status', 
                                        'class' => 'form-control col-md-7 col-xs-12',
                                        //'selected'    => 2,
                                        //'id' => 'senarai',
                                        ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                            ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lokasi">Lokasi</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?=
                                $form->field($model, 'campus_id')->label(false)->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(Kampus::find()->orderBy(['campus_name' => SORT_ASC])->all(), 'campus_id', 'campus_name'),
                                    'hideSearch' => true,
                                    'options' => [
                                        'placeholder' => 'Pilih Lokasi', 
                                        'class' => 'form-control col-md-7 col-xs-12',
                                        //'selected'    => 2,
                                        //'id' => 'senarai',
                                        ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <div class="form-group">
                        <div class="pull-right">
                            <?= Html::submitButton('Cari', ['class' => 'btn btn-success']) ?>
                            <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                    
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

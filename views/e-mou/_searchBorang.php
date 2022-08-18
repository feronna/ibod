<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use app\models\e_mou\RefMemorandumStatus;
use app\models\e_mou\RefMemorandumType;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\SwitchInput;
use yii\db\Expression;

use app\models\elnpt\Department;
use app\models\elnpt\TblLppTahun;
use app\models\hronline\Country;

?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian <?= $title ?></strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content collapse">
                <?php $form = ActiveForm::begin(['id' => 'search',  'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left']]); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">JAFPIB</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($model, 'id_dept')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Department::find()->orderBy(['fullname' => SORT_ASC,])->all(), 'id', 'fullname'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'JAFPIB',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Agensi Luar</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($model, 'external_parties')->textInput([
                            'placeholder' => 'Agensi',
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Negara</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($model, 'code_country')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Country::find()->all(), 'CountryCd', 'Country'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Negara',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Memorandum</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($model, 'id_memorandum_type')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(RefMemorandumType::find()->all(), 'memorandum_type_id', 'memorandum_type_desc'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Jenis',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($model, 'id_status')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(RefMemorandumStatus::find()->all(), 'status_id', 'status_desc'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Status',
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
                        <?= Html::submitButton('Cari', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
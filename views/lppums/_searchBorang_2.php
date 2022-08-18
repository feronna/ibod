<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\SwitchInput;
use yii\db\Expression;
use kartik\checkbox\CheckboxX;

use app\models\elnpt\Department;
use app\models\lppums\TblLppTahun;
use app\models\hronline\GredJawatan;
use app\models\hronline\Kumpulankhidmat;

?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian Borang</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(['id' => 'search',  'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left'], 'action' => $action]); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun Penilaian</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                        $form->field($model, 'tahun')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(TblLppTahun::find()->orderBy(['lpp_tahun' => SORT_DESC,])->all(), 'lpp_tahun', 'lpp_tahun'),
                            'hideSearch' => true,
                            'options' => [
                                'placeholder' => 'Pilih Tahun',
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($model, 'CONm')->textInput([
                            'placeholder' => 'Carian Nama',
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">J/F/P/I/U</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($model, 'jspiu')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Department::find()->orderBy(['fullname' => SORT_ASC,])->all(), 'id', 'fullname'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Cari JFPIU',
                                'multiple' => true
                                //'class' => 'form-control col-md-7 col-xs-12',
                                //'id' => 'jenis_carian',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'tags' => true,
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kumpulan</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($model, 'job_group')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Kumpulankhidmat::find()->orderBy(['id' => SORT_ASC,])->all(), 'id', 'name'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Cari Kumpulan',
                                'multiple' => true
                                //'class' => 'form-control col-md-7 col-xs-12',
                                //'id' => 'jenis_carian',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'tags' => true,
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Gred Skim</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($model, 'gred_skim')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(GredJawatan::find()->orderBy(['id' => SORT_ASC,])->where(['IS NOT', 'gred_skim', null])->distinct()->all(), 'gred_skim', 'gred_skim'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Cari Gred Skim',
                                'multiple' => true
                                //'class' => 'form-control col-md-7 col-xs-12',
                                //'id' => 'jenis_carian',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'tags' => true,
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Gred No</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($model, 'gred_no')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(GredJawatan::find()->orderBy(['id' => SORT_ASC,])->where(['IS NOT', 'gred_no', null])->distinct()->all(), 'gred_no', 'gred_no'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Cari Gred No',
                                'multiple' => true
                                //'class' => 'form-control col-md-7 col-xs-12',
                                //'id' => 'jenis_carian',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'tags' => true,
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">PYD mesti memenuhi syarat berikut</label>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        // $form->field($model, 'CONm')->textInput([
                        //     'placeholder' => 'Cari Nama',
                        //     ])->label(false);

                        $form->field($model, 'terima_apc')->widget(CheckboxX::classname(), [
                            'autoLabel' => true,
                            'labelSettings' => [
                                'label' => 'Tidak menerima APC dalam tempoh 1 tahun dari tahun penilaian',
                                'position' => CheckboxX::LABEL_RIGHT
                            ],
                            'pluginOptions' => ['threeState' => false]
                        ])->label((false));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        // $form->field($model, 'CONm')->textInput([
                        //     'placeholder' => 'Cari Nama',
                        //     ])->label(false);

                        $form->field($model, 'naik_pgkt')->widget(CheckboxX::classname(), [
                            'autoLabel' => true,
                            'labelSettings' => [
                                'label' => 'Tidak dinaikkan pangkat dalam tempoh 1 tahun dari tahun penilaian',
                                'position' => CheckboxX::LABEL_RIGHT
                            ],
                            'pluginOptions' => ['threeState' => false]
                        ])->label((false));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        // $form->field($model, 'CONm')->textInput([
                        //     'placeholder' => 'Cari Nama',
                        //     ])->label(false);

                        $form->field($model, 'khidmat')->widget(CheckboxX::classname(), [
                            'autoLabel' => true,
                            'labelSettings' => [
                                'label' => 'Telah berkhidmat bagi tempoh genap setahun pada hari terakhir tahun penilaian (Tarikh tamat peniliaan PPK)',
                                'position' => CheckboxX::LABEL_RIGHT
                            ],
                            'pluginOptions' => ['threeState' => false]
                        ])->label((false));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">APC</label>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        // $form->field($model, 'CONm')->textInput([
                        //     'placeholder' => 'Cari Nama',
                        //     ])->label(false);

                        $form->field($model, 'cadang_apc')->widget(CheckboxX::classname(), [
                            'autoLabel' => true,
                            'labelSettings' => [
                                'label' => 'Senarai yang telah dicadangkan sebagai penerima APC sahaja',
                                'position' => CheckboxX::LABEL_RIGHT
                            ],
                            'pluginOptions' => ['threeState' => false]
                        ])->label((false));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        // $form->field($model, 'CONm')->textInput([
                        //     'placeholder' => 'Cari Nama',
                        //     ])->label(false);

                        $form->field($model, 'panel_apc')->widget(CheckboxX::classname(), [
                            'autoLabel' => true,
                            'labelSettings' => [
                                'label' => 'Senarai yang telah diputuskan sebagai penerima APC oleh PPSM sahaja',
                                'position' => CheckboxX::LABEL_RIGHT
                            ],
                            'pluginOptions' => ['threeState' => false]
                        ])->label((false));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">APT</label>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        // $form->field($model, 'CONm')->textInput([
                        //     'placeholder' => 'Cari Nama',
                        //     ])->label(false);

                        $form->field($model, 'apt')->widget(CheckboxX::classname(), [
                            'autoLabel' => true,
                            'labelSettings' => [
                                'label' => 'Senarai Penerima APT sahaja',
                                'position' => CheckboxX::LABEL_RIGHT
                            ],
                            'pluginOptions' => ['threeState' => false]
                        ])->label((false));
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
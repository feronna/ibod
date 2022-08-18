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

use app\models\elnpt\Department;
use app\models\elnpt\TblLppTahun;

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
                <?php $form = ActiveForm::begin(['id' => 'search',  'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left'], 'action' => ['elnpt/bengkel-data']]); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Guru</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($model, 'CONm')->textInput([
                            'placeholder' => 'Cari Nama',
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">No. KP / Pasport Guru</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($model, 'PYD')->textInput([
                            'placeholder' => 'Cari No. KP / Pasport',
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">JAFPIB</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($model, 'jfpiu')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Department::find()->orderBy(['fullname' => SORT_ASC,])->all(), 'id', 'fullname'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Cari JAFPIB',
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                        $form->field($model, 'tahun')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(TblLppTahun::find()->orderBy(['lpp_tahun' => SORT_ASC,])->all(), 'lpp_tahun', 'lpp_tahun'),
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

                <div class="form-group nama">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_pyd">Nama PPP
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($model, 'PPP')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()
                                ->select(new Expression('`hronline`.`tblprcobiodata`.`ICNO` as ICNO, CONCAT(`hronline`.`tblprcobiodata`.`CONm` , \' - \' , `a`.`fname`) as CONm'))
                                ->leftJoin(['a' => '`hronline`.`gredjawatan`'], '`a`.`id` = `hronline`.`tblprcobiodata`.`gredJawatan`')
                                ->orderBy(['CONm' => SORT_ASC])->all(), 'ICNO', 'CONm'),
                            'options' => [
                                'placeholder' => 'Pilih Pegawai',
                                'class' => 'form-control col-md-7 col-xs-12',
                                //'selected'    => 2,
                                'id' => 'ppp',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group nama">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_pyd">Nama PPK
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($model, 'PPK')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()
                                ->select(new Expression('`hronline`.`tblprcobiodata`.`ICNO` as ICNO, CONCAT(`hronline`.`tblprcobiodata`.`CONm` , \' - \' , `a`.`fname`) as CONm'))
                                ->leftJoin(['a' => '`hronline`.`gredjawatan`'], '`a`.`id` = `hronline`.`tblprcobiodata`.`gredJawatan`')
                                ->orderBy(['CONm' => SORT_ASC])->all(), 'ICNO', 'CONm'),
                            'options' => [
                                'placeholder' => 'Pilih Pegawai',
                                'class' => 'form-control col-md-7 col-xs-12',
                                //'selected'    => 2,
                                'id' => 'ppk',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group nama">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_pyd">Nama PEER
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($model, 'PEER')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()
                                ->select(new Expression('`hronline`.`tblprcobiodata`.`ICNO` as ICNO, CONCAT(`hronline`.`tblprcobiodata`.`CONm` , \' - \' , `a`.`fname`) as CONm'))
                                ->leftJoin(['a' => '`hronline`.`gredjawatan`'], '`a`.`id` = `hronline`.`tblprcobiodata`.`gredJawatan`')
                                ->orderBy(['CONm' => SORT_ASC])->all(), 'ICNO', 'CONm'),
                            'options' => [
                                'placeholder' => 'Pilih Pegawai',
                                'class' => 'form-control col-md-7 col-xs-12',
                                //'selected'    => 2,
                                'id' => 'peer',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group nama">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kategori">Kategori Markah
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($model, 'kategori')->label(false)->widget(Select2::classname(), [
                            'data' => [
                                '-1' => 'TIADA MAKLUMAT / BELUM ISI [0]',
                                '1' => 'LEMAH [1 - 49]',
                                '50' => 'KURANG MEMUASKAN [50 - 59]',
                                '60' => 'SEDERHANA [60 - 79]',
                                '80' => 'BAIK [80 - 89]',
                                '90' => 'CEMERLANG [90 - ∞]',
                            ],
                            'options' => [
                                'placeholder' => 'Pilih Kategori',
                                'class' => 'form-control col-md-7 col-xs-12',
                                //'selected'    => 2,
                                'id' => 'kategori',
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
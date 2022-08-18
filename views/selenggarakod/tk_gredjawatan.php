<?php

use app\models\hronline\Kumpulankhidmat;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\myidp\VIdpKumpulan;

$this->title = 'Gred Jawatan';
?>
<div class="gelaran-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="gelaran-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

        <div class="x_panel">
            <div class="x_title">
                <h2><?= $this->title; ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'nama')->textInput(['Placeholder'=>'cth: Pegawai Teknologi Maklumat','maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Gred Skim: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'gred_skim')->textInput(['Placeholder'=>'cth: F','maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Gred No.: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'gred_no')->textInput(['Placeholder'=>'cth: 41','maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" >Nama Penuh: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'fname')->textInput(['Placeholder'=>'cth: (F41) Pegawai Teknilogi Maklumat','maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kategori Jawatan: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <?= $form->field($model, 'job_category')->label(false)->widget(Select2::classname(), [
                                'data' => ["1"=>"Akademik","2"=>"Pentadbiran"],
                                'options' => ['placeholder' => 'Pilih..', 'class' => 'form-control col-md-3 col-xs-3'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kumpulan Khidmat: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <?= $form->field($model, 'job_group')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Kumpulankhidmat::find()->orderBy(['id'=>SORT_ASC])->all(), 'id', 'name'),
                                'options' => ['placeholder' => 'Pilih..', 'class' => 'form-control col-md-3 col-xs-3'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); 
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kumpulan Khidmat: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <?= $form->field($model, 'cpd_group')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(VIdpKumpulan::find()->orderBy(['susunan'=>SORT_ASC])->all(), 'vckl_kod_kumpulan', 'vckl_nama_kumpulan'),
                                'options' => ['placeholder' => 'Pilih..', 'class' => 'form-control col-md-3 col-xs-3'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); 
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jawatan Khas: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <?= $form->field($model, 'isKhas')->label(false)->widget(Select2::classname(), [
                                'data' => ["1"=>"Ya","0"=>"Tidak"],
                                'options' => ['placeholder' => 'Pilih..', 'class' => 'form-control col-md-3 col-xs-3'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'isActive')->checkbox(['label' => 'Tandakan jika aktif', 'value' => 1, 'uncheck' => 0])->label(false) ?>
                    </div>
                </div>
            </div>
        </div>
    <div class="form-group text-center">
        <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>

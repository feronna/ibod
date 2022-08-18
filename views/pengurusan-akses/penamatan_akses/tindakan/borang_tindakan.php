<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\RefPapJenisAkses;

$this->title = 'Tambah Tindakan';
?>

<div class="tblpasport-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>


    <div class="x_panel">
        <div class="x_title">
            <h2><?= $this->title; ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Akses Ke: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($tindakan, 'jenis_akses')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(RefPapJenisAkses::find()->where(['pentadbir'=>Yii::$app->user->getId()])->all(), 'id','nama_akses'),
                        'options' => ['placeholder' => 'Pilih..', 'class' => 'form-control col-md-7 col-xs-12','disabled'=>$tindakan->isNewRecord ? false : true],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Penerangan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($tindakan, 'penerangan')->textarea(['maxlength' => true, 'rows' => '6'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false);
                    ?>
                </div>
            </div>

        </div>

        <div class="form-group text-center">
            <?= Html::a('Kembali', ['index'],  ['class' => 'btn btn-primary']) ?>
            <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please wait..']]) ?>
        </div>
    </div>




    <?php ActiveForm::end(); ?>

</div>
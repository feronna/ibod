<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\RefPapJenisAkses;
use yii\widgets\DetailView;

$this->title = 'Tindakan';
?>
<div class="x_panel">

<div class="x_title">
    <h4><?= "MAKLUMAT PENGGUNA" ?></h4>
    <div class="clearfix"></div>
</div>

<div class="row">

    <?= DetailView::widget([
        'options' => ['class' => 'table table-bordered detail-view fix-width'],
        'model' => $model,
        'attributes' => [
            [
                'label' => 'MAKLUMAT PENGGUNA',
                'attribute' => ' ',
                'captionOptions' => ['class'=>'text-center bg-primary','colspan' => '2'],
                'contentOptions' => ['style' => 'display: none;'],
            ],
            [
                'label' => 'IC / Passport No',
                'attribute' => 'icno',
            ],
            [
                'label' => 'NAMA',
                'attribute' =>  'nama',
            ],
            [
                'label' => 'STAF ID',
                'value' =>  $model->biodata ? $model->biodata->COOldID : '',
            ],
            [
                'label' => 'JFPIB',
                'attribute' =>  'jfpib',
            ],
            [
                'label' => 'JAWATAN',
                'value' =>  $model->biodata ? $model->biodata->jawatan->fname : '',
            ],
            [
                'label' => 'NO. HP.',
                'value' =>  $model->biodata ? $model->biodata->COHPhoneNo : '',
            ],
            [
                'label' => 'EMEL PERIBADI',
                'value' =>  $model->biodata ? $model->biodata->COEmail2 : '',
            ],
            [
                'label' => 'TARIKH MULA',
                'value' =>  $model->biodata ? Yii::$app->MP->Tarikh($model->biodata->startDateLantik) : '',
            ],
            [
                'label' => 'TARIKH AKHIR',
                'value' =>  $model->biodata ? Yii::$app->MP->Tarikh($model->biodata->endDateLantik) : '',
            ],
            [
                'label' => 'EMEL CADANGAN / AD',
                'value' =>  $model->biodata ? $model->biodata->COEmail : '',
            ],
            [
                'label' => 'SEBAB PERUBAHAN',
                'attribute' => 'sebab_perubahan',
            ],
        ],
    ]); ?>
</div>



</div>

<div class="tblpasport-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>


    <div class="x_panel">
        <div class="x_title">
            <h2><?= $this->title; ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Tindakan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($tindakan, 'jenis_akses')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(RefPapJenisAkses::find()->where(['id'=>4])->all(), 'id','nama_akses'),
                        'options' => ['placeholder' => 'Pilih..', 'class' => 'form-control col-md-7 col-xs-12','disabled'=>$tindakan->isNewRecord ? false : true],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($tindakan, 'status')->label(false)->widget(Select2::classname(), [
                        'data' => ['1'=>'Selesai','0'=>'Belum Selesai'],
                        'options' => ['placeholder' => 'Pilih..', 'class' => 'form-control col-md-7 col-xs-12'],
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
            <?= Html::a('Kembali', ['pengurusan-gmail'],  ['class' => 'btn btn-primary']) ?>
            <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please wait..']]) ?>
        </div>
    </div>




    <?php ActiveForm::end(); ?>

</div>
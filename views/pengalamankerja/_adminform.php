<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use app\models\hronline\SektorPekerjaan;
use app\models\hronline\JenisBadanMajikan;
use app\models\hronline\StatusJawatan;
use app\models\hronline\KategoriPekerjaan;

?>

<div class="tblpengalamankerja-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

    <div class="x_panel">
        <div class="x_title">
            <h2><?= $this->title; ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
     
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NamaMajikan">Nama Majikan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
             <?= $form->field($model, 'OrgNm')->textInput(['maxlength' => true])->label(false); ?>
        </div>
        </div>   
            
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="SektorPekerjaan">Sektor Pekerjaan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
             <?=
            $form->field($model, 'OccSectorCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(SektorPekerjaan::find()->all(), 'OccSectorCd', 'OccSector'),
                'options' => ['placeholder' => 'Pilih Sektor Pekerjaan', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
            
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="JenisMajikan">Jenis Majikan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
             <?=
            $form->field($model, 'CorpBodyTypeCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(JenisBadanMajikan::find()->all(), 'CorpBodyTypeCd', 'CorpBodyType'),
                'options' => ['placeholder' => 'Pilih Jenis Majikan', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
         <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="KeteranganTugas">Nama Jawatan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
             <?= $form->field($model, 'Position')->textInput(['maxlength' => true])->label(false) ;?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="JenisMajikan">Kategori Pekerjaan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-3 col-sm-3 col-xs-12">
             <?=
            $form->field($model, 'OccCategoryCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(KategoriPekerjaan::find()->all(), 'OccCatCd', 'OccCat'),
                'options' => ['placeholder' => 'Kategori Pekerjaan', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>   
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="JenisMajikan">Bawa Servis: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-2 col-sm-3 col-xs-12">
             <?=
            $form->field($model, 'WithServices')->label(false)->widget(Select2::classname(), [
                'data' => ["1"=>"Ya", "0"=>"Tidak"],
                'options' => ['placeholder' => 'Ya / Tidak', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="JenisMajikan">Kategori Pekerjaan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-2 col-sm-3 col-xs-12">
             <?=
            $form->field($model, 'PositionStatusCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(StatusJawatan::find()->all(), 'StatusCd', 'PosStatus'),
                'options' => ['placeholder' => 'Status Jawatan', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="KeteranganTugas">Keterangan Tugas: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
             <?= $form->field($model, 'PrevEmpRemarks')->textarea(['maxlength' => true])->label(false) ;?>
        </div>
        </div>    
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TarikhMula">Tarikh Mula: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <?=
            DatePicker::widget([
                'model' => $model,
                'attribute' => 'PrevEmpStartDt',
                'template' => '{input}{addon}',
                'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'required'=>'required'],
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
            ?>
        </div>
        </div>
        
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TarikhBerhenti">Tarikh Berhenti: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <?=
            DatePicker::widget([
                'model' => $model,
                'attribute' => 'PrevEmpEndDt',
                'template' => '{input}{addon}',
                'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'required'=>'required'],
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
            ?>
        </div>
        </div>
        </div>
    </div>
            
    <div class="form-group text-center">
        <?= Html::a('Kembali', ['adminview','icno'=>$model->ICNO],  ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success' , 'data'=>['disabled-text'=>'Please wait..']]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

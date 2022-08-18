<?php

use yii\helpers\Html;
use kartik\alert\Alert;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use app\models\hronline\JenisPenyakit;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblsejarahperubatan */
/* @var $form yii\widgets\ActiveForm */



?>

<div class="tblsejarahperubatan-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

    <div class="x_panel">
        <div class="x_title">
            <h2><?= $this->title; ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NamaPenyakit">Nama Penyakit: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
             <?=
            $form->field($model, 'IllnessCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(JenisPenyakit::find()->all(), 'IllnessCd', 'Illness'),
                'options' => ['placeholder' => 'Pilih Nama Penyakit', 'class' => 'form-control col-md-7 col-xs-12',],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="year">Tahun: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-2 col-sm-2 col-xs-12">
          <?= $form->field($model, 'Year')->textInput(['maxlength' => true])->label(false); ?>  
        </div>
        <span data-toggle="tooltip" ><i class="fa fa-info-circle fa-lg"></i></span>
        </div>

        
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Rawatan">Rawatan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <?= $form->field($model, 'MedTreatment')->textArea(['maxlength' => true])->label(false); ?>  
        </div>
        </div>
            
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TarikhMulaRawatan">Tarikh Mula Rawatan: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-3 col-sm-3 col-xs-12">
          <?=
            DatePicker::widget([
                'model' => $model,
                'attribute' => 'TreatmentStartDt',
                'template' => '{input}{addon}',
                'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12',],
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
            ?>  
        </div>
        </div>
            
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TarikhAkhirRawatan">Tarikh Akhir Rawatan: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-3 col-sm-3 col-xs-12">
            <?=
            DatePicker::widget([
                'model' => $model,
                'attribute' => 'TreatmentEndDt',
                'template' => '{input}{addon}',
                'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12',],
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip({
            placement: 'right',
            title : "<p>Tahun penyakit dikesan.</p>",
            html : true
        })
    });
</script>

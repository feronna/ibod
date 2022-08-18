<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use app\models\hronline\JenisKecacatan;
use app\models\hronline\PuncaKecacatan;


$this->title = 'Kecacatan Keluarga';

?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_content">
<div class="tblkecacatan-create">

    <div class="tblkecacatan-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

    <div class="x_panel">
        <div class="x_title">
            <h2><?= $this->title; ?></h2>
            <ul class="nav navbar-right panel_toolbox"></ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
         
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NoFailKebajikan">No. Fail Kebajikan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
             <?= $form->field($model, 'SocialWelfareNo')->textInput(['maxlength' => true])->label(false); ?>
        </div>
        </div> 
         
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NoLaporanDoktor">No. Laporan Doktor: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
             <?= $form->field($model, 'DrRptNo')->textInput(['maxlength' => true])->label(false); ?>
        </div>
        </div>
            
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="JenisKecacatan">Jenis Kecacatan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
 
            <?=
            $form->field($model, 'DisabilityTypeCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(JenisKecacatan::find()->all(), 'DisabilityTypeCd', 'DisabilityType'),
                'options' => ['placeholder' => 'Pilih Jenis Kecacatan', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
        
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Tarikhkad">Tarikh Kad Dikeluarkan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-3 col-sm-3 col-xs-12">
            <?=
            DatePicker::widget([
                'model' => $model,
                'attribute' => 'ConferredDt',
                'template' => '{input}{addon}',
                'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12','required'=>true],
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
            
            ?>
            
        </div>
        </div>
            
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Upload Kad Kebajikan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                    <?php
                    if (!empty($model->filename) && $model->filename != 'deleted') {
                        echo Html::a(Yii::$app->FileManager->NameFile($model->filename));
                        echo '&nbsp&nbsp&nbsp&nbsp';
                        if($model->id){
                            echo Html::a('Padam', ['admindeletegambar', 'id' => $model->id], ['class' => 'btn btn-danger']) . '<p>';
                        }
                        
                    }
                    else{
                       echo $form->field($model, 'file')->fileInput()->label(false);
                    }
                    ?>
                </div>
            </div>
            
        </div>
    </div>

    <div class="form-group text-center">
        <?= \yii\helpers\Html::a( 'Kembali', ['adminlihatkeluarga','id'=>$id], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>
       </div>
    </div>
</div>

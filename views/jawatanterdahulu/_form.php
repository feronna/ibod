<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tbljawatanterdahulu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbljawatanterdahulu-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

    <div class="x_panel">
        <div class="x_title">
            <h2><?= $this->title; ?></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
         
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NamaJawatan">Nama Jawatan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
             <?= $form->field($model, 'PrevPostNm')->textInput(['maxlength' => true])->label(false); ?>
        </div>
        </div> 
        
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="DeskripsiJawatan">Deskripsi Jawatan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
             <?= $form->field($model, 'PrevPostDesc')->textInput(['maxlength' => true])->label(false); ?>
        </div>
        </div>    
        
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TarikhMula">Tarikh Mula: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <?=
            DatePicker::widget([
                'model' => $model,
                'attribute' => 'PrevPostStartDt',
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
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TarikhAkhir">Tarikh Akhir: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <?=
            DatePicker::widget([
                'model' => $model,
                'attribute' => 'PrevPostEndDt',
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
        <?= Html::a('Kembali', Yii::$app->request->referrer,  ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

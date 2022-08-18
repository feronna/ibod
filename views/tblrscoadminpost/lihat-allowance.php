<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use app\models\hronline\Campus;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\ln\Ln */

//$this->title = $model->id;
//$this->params['breadcrumbs'][] = ['label' => 'Lns', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="row">
<div class="col-md-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <ol class="breadcrumb">
                <li><?php echo Html::a('<i class="fa fa-home"></i> Halaman Utama', ['admin-post-list']) ?></li>
                <li><?php echo Html::a('Rekod Lantikan', ['admin-view', 'id' => $model->ICNO]) ?></li>
                <li><?= Html::a('Senarai Rekod Allowance',['lihat-rekod-allowance', 'ICNO' => $model->ICNO])  ?></li>
                <li>Lihat Rekod Allowance</li>
            </ol>
            <h2><strong>Lihat Rekod Allowance</strong></h2>
        <div class="clearfix"></div>
        </div>
        
    <div class="tblrscoadminpost-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
    <div class="x_panel">
    <div class="x_content">
        
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">No IC</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <?=  $form->field($model, 'ICNO')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
            </div>
    </div>
        
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code">Kod</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <?=  $form->field($model, 'it_income_code')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
            </div>
    </div>  
        
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="allowance">Allowance</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <?=  $form->field($model->allowance, 'it_account_name')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
            </div>
    </div>  
 
<!--    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="renew">Status Pembaharuan:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <?php//echo  $form->field($model->renew0, 'renew_desc')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
            </div>
    </div> -->       

<!--    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="campus">Status Tugas:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <?php//echo  $form->field($model->tugasStatus0, 'tugasstatus_desc')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
            </div>
    </div>   -->
                
    <br>

    <?php ActiveForm::end(); ?>
 </div>
</div>
</div>
       
    </div>
</div>
</div>

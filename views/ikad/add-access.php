<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use app\models\hronline\Campus;
use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
?>
<div class="align-center text-center title bg-success" style="padding: 1px">
    <h4><i class="fa fa-user"></i>&nbsp;Tambah Akses / <i>Add Access</i></h4>
</div>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'enableAjaxValidation' => true]]); ?>
<?php //echo $form->errorSummary($model); 
?>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Name
        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan Kelulusan"></i>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <?=
            $form->field($model, 'ICNO')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Tblprcobiodata::find()->where(['Status' => '1'])->all(), 'ICNO', 'CONm'),
                'options' => ['placeholder' => 'Name', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
        ?> 
        </div>

</div>
<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Role
        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Status"></i>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">

    
           <?=
            $form->field($model, 'accesstype')->label(false)->widget(Select2::classname(), [
                'data' => ['0' => 'Pegawai Penyemak', '1' => 'Pegawai Peraku'] ,
                'options' => ['placeholder' => 'Choose Role', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
        ?> 
    </div>
</div>

<div class="ln_solid"></div>


<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Submit', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
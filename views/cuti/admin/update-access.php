<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use app\models\hronline\Campus;
use app\models\hronline\Department;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
?>
<div class="align-center text-center title bg-success" style="padding: 1px">
    <h4><i class="fa fa-user"></i>&nbsp;Update Access</h4>
</div>
<?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'slverifier.CONm',
            'jawatan',
            'department.fullname',

        ],
    ])
?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'enableAjaxValidation' => true]]); ?>
<?php //echo $form->errorSummary($model); 
?>


<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Role
        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Status"></i>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">

        <?php
        echo $form->field($model, 'akses_cuti_int')->dropDownList(
            ['2' => 'Penyelia JSPIU', '3' => 'Admin'],
            ['prompt' => 'Sila Pilih...']
        )->label(false);
        ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jspiu
        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan Kelulusan"></i>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <?=
            $form->field($model, 'akses_jspiu_id')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Department::find()->where(['isActive' => '1'])->all(), 'id', 'fullname'),
                'options' => ['placeholder' => 'Choose JSPIU', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
        ?> </div>

</div>
<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Campus
        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan Kelulusan"></i>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <?=
            $form->field($model, 'akses_kampus_id')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Campus::find()->all(), 'campus_id', 'campus_name'),
                'options' => ['placeholder' => 'Choose Campus', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
        ?> </div>

</div>

<div class="ln_solid"></div>


<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Submit', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use app\models\hronline\PendidikanTertinggi;
use app\models\hronline\ServiceStatus;
use app\models\hronline\StatusLantikan;
use app\models\hronline\ProgramPengajaran;
use app\models\hronline\Kampus;
?>

<div class="x_title">
    <h2>Carian</h2>
    <div class="clearfix"></div>
</div>
<?php $form = ActiveForm::begin([
    'action' => ['view-allowance'],
    'method' => 'get',
    'options' => ['class' => 'form-horizontal form-label-left']
]); ?>
<div class="form-group ">
    <div class="form-group align-center">
        <div class="col-md-4 col-sm-4 col-xs-12">
        <div class=" col-md-5 col-sm-5 col-xs-12">
            <?= $form->field($carian, 'sm_ic_no')->textInput(['placeholder' => 'Nama / Nombor IC / ID'])->label(false) ?>
        </div>
        <div class=" col-md-1 col-sm-1 col-xs-12">
            <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Cari', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
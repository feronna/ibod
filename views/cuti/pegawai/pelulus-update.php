<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\widgets\DetailView;
?>
<div class="align-center text-center title bg-success" style="padding: 1px"><h4><i class="fa fa-user"></i>&nbsp;MAKLUMAT PEMOHON</h4></div>
<?=
DetailView::widget([
    'model' => $model,
    'attributes' => [
        'kakitangan.CONm',
        'kakitangan.jawatan.fname',
        'kakitangan.department.fullname',
        'jenisCuti.fullname',
        'full_date',
        'remark',
        'tempoh',
        'jenis',
        [
            'attribute' => 'penyemak.CONm',
            'label' => 'Disemak oleh',
        ],
        'semakanLog',
        [
            'attribute' => 'viewDoc',
            'format' => 'raw',
        ],
    ],
])
?>
<div class="align-center text-center title bg-success" style="padding: 1px;"><h4><i class="fa fa-check-square"></i>&nbsp;MAKLUMAT SEMAKAN</h4></div>
<?=
DetailView::widget([
    'model' => $model,
    'attributes' => [
    
        [
            'attribute' => 'penyemak.CONm',
            'label' => 'Disemak oleh',
        ],
        'semakan_remark',
        'semakanLog',
    ],
])
?>
<div class="align-center text-center title bg-success" style="padding: 1px;"><h4><i class="fa fa-check-square"></i>&nbsp;MAKLUMAT PERAKUAN</h4></div>
<?=
DetailView::widget([
    'model' => $model,
    'attributes' => [
    
        [
            'attribute' => 'peraku.CONm',
            'label' => 'Perakuan oleh',
        ],
        'peraku_remark',
        'perakuLog',
    ],
])
?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'enableAjaxValidation' => true]]); ?>
<?php //echo $form->errorSummary($model); ?>


<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'status'); ?>
        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
           title="Status"></i>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">

        <?php
        echo $form->field($model, 'status')->dropDownList(
                ['APPROVED' => 'Diluluskan', 'REJECTED' => 'Ditolak'], ['prompt' => 'Sila Pilih...']
        )->label(false);
        ?>
    </div>
</div> 

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'peraku_remark'); ?>
        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
           title="Catatan Kelulusan"></i>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <?= $form->field($model, 'lulus_remark')->textarea(['rows' => 4])->label(false); ?>
    </div>

</div> 

<div class="ln_solid"></div>


<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Submit', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
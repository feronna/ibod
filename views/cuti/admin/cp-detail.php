<?php

use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\form\ActiveForm;
?>
<!--<h4><strong>Maklumat Teperinci</strong></h4>-->
<div class="table-responsive">
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Name',
                'attribute' => 'kakitangan.CONm',
            ],
            [
                'label' => 'Position',
                'attribute' => 'kakitangan.jawatan.fname',
            ],
            [
                'label' => 'Leave Date',
                'attribute' => 'full_date',
            ],

            [
                'attribute' => 'Applicant Remark',
                'value' => ((!$model->remark) ? "No Remark" : $model->remark),
            ],

            [
                'label' => 'Apply Date',
                'attribute' => 'mohon_dt',
            ],
            // 'mohon_dt:datetime',
            [
                'label' => '- -',
                'attribute' => 'remark',
                'value' => '- -',
                // 'type'=>'raw',
            ],


            [
                'label' => 'Head Of Department',
                'attribute' => 'penyemak.CONm',
            ],
            [
                'label' => 'Head Of Department Date of Approval',
                'attribute' => 'semakan_dt',
            ],
            [
                'label' => "Head Of Deparment's Remark",
                'attribute' => 'semakan_remark',

            ],
            [
                'label' => 'VC',
                'attribute' => 'peraku.CONm',
            ],
            [
                'label' => 'VC Date of Approval',
                'attribute' => 'peraku_dt',
            ],
            [
                'label' => "VC's Remark",
                'attribute' => 'peraku_remark',

            ],

        ],
    ]);
    ?>
   <?=
    DetailView::widget([
        'model' => $mod,
        'attributes' => [
            [
                'label' => 'Project',
                'attribute' => 'ProjectID',
                
            ],
            [
                'label' => 'Research Title',
                'attribute' => 'TajukPenyelidikan',
                
            ],
            [
                'label' => 'Research Summary',
                'attribute' => 'RingkasanPenyelidikan',
            ],
            [
                'label' => 'Addresss',
                'attribute' => 'TempatPenyelidikan',
            ],
            [
                'label' => 'Organizer',
                'attribute' => 'Penganjur',
            ],
            [
                'label' => 'Expected Result',
                'attribute' => 'JangkanHasil',
            ],
        ],
    ])
    
    ?>
</div>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'enableAjaxValidation' => true]]); ?>
<?php echo $form->errorSummary($res); ?>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'status'); ?>
        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Status"></i>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">

        <?php
        echo $form->field($res, 'bsm_status')->dropDownList(
            ['APPROVED' => 'APPROVED', 'REJECTED' => 'REJECTED'],
            ['prompt' => 'Sila Pilih...']
        )->label(false);
        ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'semakan_remark'); ?>
        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan penyemak"></i>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <?= $form->field($res, 'bsm_remark')->textarea(['rows' => 4])->label(false); ?>
    </div>

</div>

<div class="ln_solid"></div>


<div class="form-group">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>

        <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Submit', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
</div>
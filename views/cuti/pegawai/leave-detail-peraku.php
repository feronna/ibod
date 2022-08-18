
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\form\ActiveForm;?>
<!--<h4><strong>Maklumat Teperinci</strong></h4>-->
<div class="table-responsive">
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Nama / Name',
                'attribute' => 'kakitangan.CONm',
            ],
            [
                'label' => 'Jawatan / Position',
                'attribute' => 'kakitangan.jawatan.fname',
            ],
            [
                'label' => 'Tarikh Bercuti / Leave Date',
                'attribute' => 'full_date',
            ],
            [
                'attribute' => 'Catatan / Remark',
                'value' => ((!$model->remark) ? "No Remark" : $model->remark),
            ],
            [
                'attribute' => 'Baki Cuti / Balance',
                'value' =>  $bal,
            ],
            [
                'label' => 'Tarikh Mohon / Apply Date',
                'attribute' => 'mohon_dt',
            ],
            [
                'label' => 'Tempoh (Hari) / Duration (Days)',
                'attribute' => 'tempoh',
            ],
            // 'mohon_dt:datetime',
            [
                'label' => '- -',
                'attribute' => 'remark',
                'value' => '- -',
                // 'type'=>'raw',
            ],
            [
                "label" => "Catatan Penyemak / Supervisor's Remark",
                'attribute' => "statussupervisor",
                // 'value' => '- -',
                // 'type'=>'raw',
            ],
            [
                'label' => 'Pengganti / Substitute',
                'attribute' => 'pengganti.CONm',
            ],
            [
                'label' => 'Tarikh Bersetuju / Agreed Date',
                'attribute' => 'ganti_dt',
            ],
        ],
    ])
    ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'enableAjaxValidation' => true]]); ?>
<?php echo $form->errorSummary($model); ?>


<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'status'); ?>
        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
           title="Status"></i>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">

        <?php
        echo $form->field($model, 'status')->dropDownList(
                ['VERIFIED' => 'VERIFIED', 'REJECTED' => 'REJECTED'], ['prompt' => 'Sila Pilih...']
        )->label(false);
        ?>
    </div>
</div> 

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'peraku_remark'); ?>/ <i>Verifier Remark</i>
        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
           title="Catatan penyemak"></i>
    </label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <?= $form->field($model, 'peraku_remark')->textarea(['rows' => 4])->label(false); ?>
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
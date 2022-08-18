<?php

use app\models\cuti\TblRecords;
use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\form\ActiveForm;
use kartik\daterange\DateRangePicker;
use yii\bootstrap\Modal;

?>
<?php if($nc){ ?>
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
                'label' => 'Tempoh Bercuti / Leave Duration',
                'attribute' => 'tempoh',
            ],

            [
                'attribute' => 'Tujuan Bercuti / Remark',
                'value' => ((!$model->remark) ? "No Remark" : $model->remark),
            ],
            [
                'attribute' => 'Destinasi / Destination',
                'value' => ((!$model->destination) ? " " : $model->destination),
            ],
            [
                'label' => 'Tarikh Mohon / Apply Date',
                'format' => 'raw',
                'value' => function($data){
                    $model = TblRecords::getTarikh($data->mohon_dt);
                    return $model;
                },
            ],
            // 'mohon_dt:datetime',
          
            [
                'label' => "Catatan Semakan / Supervisor's Remark",
                'attribute' => 'statussupervisor',
                // 'value' => '- -',
                // 'type'=>'raw',
            ],
            [
                'label' => 'Tarikh Semakan / Check Date',
                'format' => 'raw',
                'value' => function($data){
                    $model = TblRecords::getTarikh($data->semakan_dt);
                    return $model;
                },
            ],
          
            [
                'label' => 'Pengganti / Substitute',
                'attribute' => 'pengganti.CONm',
            ],
            [
                'label' => 'Tarikh Bersetuju / Agreed Date',
                'format' => 'raw',
                'value' => function($data){
                    $model = TblRecords::getTarikh($data->ganti_dt);
                    return $model;
                },            ],
            [
                'label' => 'Peraku / Verifier',
                'attribute' => 'peraku.CONm',
                'value' => ((!$model->peraku_by) ? " Terus Kepada Pegawai Pelulus " : $model->peraku->CONm),

            ],
            [
                'label' => 'Tarikh Peraku / Verified Date',
                'value' => function($data){
                    $model = TblRecords::getTarikh($data->peraku_dt);
                    return $model;
                },   
            ],
            [
                'label' => "Catatan Peraku / Verifier's Remark",
                'attribute' => 'statusremark',
            ],
        ],
    ])
    ?>

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'enableAjaxValidation' => true]]); ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="form-group">
        <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>Ubah Tarikh Bercuti /<i>&nbsp;Change Leave Date (From - to)</i>

        </label>
        <!-- <div id="temp1" style="display:show" > -->

        <div class="col-md-4 col-sm-4 col-xs-10">
            <?php
            echo $form->field($model, 'full_date', [
                'addon' => ['prepend' => ['content' => '<i class="fa fa-calendar"></i>']],
                'options' => ['class' => 'drp-container'],
                'showLabels' => false,
            ])->widget(DateRangePicker::classname(), [
                'useWithAddon' => true,
                'startAttribute' => 'tempv2',
                'endAttribute' => 'tempv3',
                'convertFormat' => true,
                'readonly' => true,
                'pluginOptions' => [
                    'locale' => [
                        'format' => 'd/m/Y',
                        'separator' => ' to '
                    ],
                    'opens' => 'left',
                ]
            ]);
            ?>

            <!-- <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
                   title="Pengganti"></i> -->
        </div>

    </div>
    <!-- </div> -->

    <?php if ($model->jenis_cuti_id == 20 || $model->jenis_cuti_id == 21) { ?>
        

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"><strong>Sijil Sakit/<i>Medical Certificate</i> : </strong>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Status"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">

            <span class="badge" style="background-color :violet"><?= $model->displayLink; ?></span>
            </div>
        </div>
    <?php } ?>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'status'); ?>
            <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Status"></i>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">

            <?php
            echo $form->field($model, 'status')->dropDownList(
                ['APPROVED' => 'APPROVED', 'REJECTED' => 'REJECTED'],
                ['prompt' => 'Sila Pilih...']
            )->label(false);
            ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'lulus_remark'); ?>/<i>Approval Remark</i>
            <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan penyemak"></i>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'lulus_remark')->textarea(['rows' => 4])->label(false); ?>
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
<?php }else{ ?>
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
            // 'mohon_dt:datetime',
            [
                'label' => '- -',
                'attribute' => 'remark',
                'value' => '- -',
                // 'type'=>'raw',
            ],
            [
                'label' => "Catatan Penyemak / Supervisor's Remark",
                'attribute' => 'statussupervisor',
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
            [
                'label' => 'Peraku / Verifier',
                'attribute' => 'peraku.CONm',
            ],
            [
                'label' => 'Tarikh Peraku / Verified Date',
                'attribute' => 'peraku_dt',
            ],
            [
                'label' => "Catatan Peraku / Verifier's Remark",
                'attribute' => 'statusremark',
            ],
        ],
    ])
    ?>

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'enableAjaxValidation' => true]]); ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="form-group">
        <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>Ubah Tarikh Bercuti /<i>&nbsp;Change Leave Date (From - to)</i>

        </label>
        <!-- <div id="temp1" style="display:show" > -->

        <div class="col-md-4 col-sm-4 col-xs-10">
            <?php
            echo $form->field($model, 'full_date', [
                'addon' => ['prepend' => ['content' => '<i class="fa fa-calendar"></i>']],
                'options' => ['class' => 'drp-container'],
                'showLabels' => false,
            ])->widget(DateRangePicker::classname(), [
                'useWithAddon' => true,
                'startAttribute' => 'tempv2',
                'endAttribute' => 'tempv3',
                'convertFormat' => true,
                'readonly' => true,
                'pluginOptions' => [
                    'locale' => [
                        'format' => 'd/m/Y',
                        'separator' => ' to '
                    ],
                    'opens' => 'left',
                ]
            ]);
            ?>

            <!-- <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
                   title="Pengganti"></i> -->
        </div>

    </div>
    <!-- </div> -->

    <?php if ($model->jenis_cuti_id == 20 || $model->jenis_cuti_id == 21) { ?>
        

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"><strong>Sijil Sakit/<i>Medical Certificate</i> : </strong>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Status"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">

            <span class="badge" style="background-color :violet"><?= $model->displayLink; ?></span>
            </div>
        </div>
    <?php } ?>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'status'); ?>
            <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Status"></i>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">

            <?php
            echo $form->field($model, 'status')->dropDownList(
                ['APPROVED' => 'APPROVED', 'REJECTED' => 'REJECTED'],
                ['prompt' => 'Sila Pilih...']
            )->label(false);
            ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'lulus_remark'); ?>/<i>Approval Remark</i>
            <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan penyemak"></i>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'lulus_remark')->textarea(['rows' => 4])->label(false); ?>
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
<?php } ?>

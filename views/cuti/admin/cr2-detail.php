<?php

use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\form\ActiveForm;
?>
<!--<h4><strong>Maklumat Teperinci</strong></h4>-->
<?php if ($model->jenis_cuti_id == 28) { ?>

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
                    'attribute' => 'Catatan / remark',
                    'value' => ((!$model->remark) ? "No Remark" : $model->remark),
                ],
            
                [
                    'label' => 'Tarikh Mohon / Apply Date',
                    'attribute' => 'mohon_dt',
                ],
                [
                    'label' => 'Tempoh (Hari) / Duration (Days)',
                    'attribute' => 'tempoh',
                ],
                [
                    'label' => 'Baki / Maternity Leave Balance',
                    'value' => $bal,
                ],
                // 'mohon_dt:datetime',
                [
                    'label' => '- -',
                    'attribute' => 'remark',
                    'value' => '- -',
                    // 'type'=>'raw',
                ],
           
                // 'ganti_dt:datetime',
               
                [
                    'label' => 'Peraku / Verifier',
                    'attribute' => 'peraku.CONm',
                ],
                [
                    'label' => 'Pelulus / Approver',
                    'attribute' => 'verifier.CONm',
                ],

            ],
        ])
        ?>

<?php } else { ?>
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
                    'attribute' => 'Catatan / remark',
                    'value' => ((!$model->remark) ? "No Remark" : $model->remark),
                ],
                [
                    'label' => 'Destinasi / Destination',
                    'attribute' => 'destination',
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
                    'label' => 'Pengganti / Substitute',
                    'attribute' => 'pengganti.CONm',
                ],
                [
                    'label' => 'Tarikh Bersetuju / Agreed Date',
                    'attribute' => 'ganti_dt',
                ],
                // 'ganti_dt:datetime',
                [
                    'label' => 'Peraku / Verifier',
                    'attribute' => 'peraku.CONm',
                ],
                [
                    'label' => 'Pelulus / Approver',
                    'attribute' => 'verifier.CONm',
                ],

            ],
        ])
        ?>
    <?php } ?>


    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'enableAjaxValidation' => true]]); ?>
    <?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>Tarikh Bercuti /<i>&nbsp;Leave Date (From - to)</i>

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
                'startAttribute' => 'start_date',
                'endAttribute' => 'end_date',
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

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= Html::activeLabel($model, 'status'); ?>
            <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Status"></i>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">

            <?php
            echo $form->field($model, 'status')->dropDownList(
                ['BSMCHECK' => 'Waiting For BSM Aprroval', 'CHECKED' => 'DITERIMA', 'REJECTED' => 'DITOLAK'],
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
            <?= $form->field($model, 'semakan_remark')->textarea(['rows' => 4])->label(false); ?>
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
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\form\ActiveForm;
use kartik\daterange\DateRangePicker;
use yii\bootstrap\Modal;
error_reporting(0);
?>
 <div class="x_title">
                <h5><b> <i class="fa fa-check"></i> KEPUTUSAN MESYUARAT</b></h5><div  class="pull-right">
            </div>
            
        </div>
<!--<h4><strong>Maklumat Teperinci</strong></h4>-->
<div class="table-responsive">
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'NAMA',
                'attribute' => 'kakitangan.CONm',
            ],
            [
                'label' => 'JAWATAN',
                'attribute' => 'kakitangan.jawatan.fname',
            ],
            [
                'label' => 'TARIKH BERCUTI',
                'attribute' => 'full_date',
            ],

            [
                'label' => 'CATATAN PEMOHON',
                'value' => ((!$model->remark) ? "-" : $model->remark),
            ],
            [
                'label' => 'BAKI CUTI',
                'value' =>  $bal,
            ],
            [
                'label' => 'TARIKH MOHON',
                'attribute' => 'mohon_dt',
            ],
            // 'mohon_dt:datetime',
            [
                'label' => '- -',
                'attribute' => 'remark',
                'value' => '- -',
                // 'type'=>'raw',
            ],
//            [
//                'label' => "CATATAN / ",
//                'attribute' => 'statussupervisor',
//                // 'value' => '- -',
//                // 'type'=>'raw',
//            ],
            [
                'label' => 'PERAKUAN KETUA JABATAN ',
                'value' => $model->ketuajfpiu,
            ],
            [
                'label' => 'TARIKH DIPERAKU',
                'value' => ((!$model->semakan_dt) ? "-" : $model->semakan_dt),
            ],
            [
                'label' => 'PERAKU NC (JIKA CUTI PENYELIDIKAN LUAR NEGARA) ',
                'attribute' => 'peraku.CONm',
            ],
            [
                'label' => 'TARIKH DIPERAKU',
                'value' => ((!$model->peraku_dt) ? "-" : $model->peraku_dt),
            ],
            [
                'label' => "CATATAN PERAKU",
                'attribute' => 'statusremark',
            ],
        ],
    ])
    ?>

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'enableAjaxValidation' => true]]); ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="form-group">
        <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i> UBAH TARIKH BERCUTI /<i>&nbsp;Change Leave Date (From - to)</i>

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
  <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $edit; ?>"> 

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">STATUS MESYUARAT:
            <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Status"></i>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">

            <?php
            echo $form->field($model, 'status')->dropDownList(
                ['APPROVED' => 'DILULUSKAN', 'REJECTED' => 'TIDAK DILULUSKAN'],
                ['prompt' => 'Sila Pilih...']
            )->label(false);
            ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
            CATATAN MESYUARAT:
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
            </div>
  </div>
    
    <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $view; ?>"> 

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">STATUS MESYUARAT:
            <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Status"></i>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?php if($model->status == "APPROVED")
            {?>
            <?= $form->field($model, 'status')->textInput(['disabled' => true,'value'=>"DILULUSKAN"])->label(false); ?> <p>&nbsp;&nbsp;</p><?php }
            else
            {?>
                          <?= $form->field($model, 'status')->textInput(['disabled' => true,'value'=>"DILULUSKAN"])->label(false); ?> <p>&nbsp;&nbsp;</p>
  
        <?php    }
?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
            CATATAN MESYUARAT:
            <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan penyemak"></i>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <?= $form->field($model, 'lulus_remark')->textInput(['disabled' => true])->label(false); ?> <p>&nbsp;&nbsp;</p>
        </div>

    </div>
                
                <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">
            TARIKH SEMAKAN:
            <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Catatan penyemak"></i>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <?= $form->field($model, 'lulus_dt')->textInput(['disabled' => true])->label(false); ?> <p>&nbsp;&nbsp;</p>
        </div>

    </div>

    <div class="ln_solid"></div>


  
            </div>
  </div>
    <?php ActiveForm::end(); ?>
</div>
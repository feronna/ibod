<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\daterange\DateRangePicker;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\models\cuti\SetPegawai;
use yii\bootstrap\Modal;
use dosamigos\datepicker\DatePicker;

$this->title = $model->layak_icno;
?>
<div class="x_panel">

    <div class="x_content">
    <div class="x_title">
                <h2><strong> Tambah Kelayakan /<i>Set New Entitlement For </i> <?php echo $staff_list->CONm?></strong></h2>

                <div class="clearfix"></div>
            </div>
    <?php $form = ActiveForm::begin(['enableAjaxValidation' => true,'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>
        <?= $form->errorSummary($model); ?>

        <div class="form-group">
            <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Mula/<i>Start</i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tarikh Mula Kelayakan"></i>
            </label>

            <div class="col-md-4 col-sm-4 col-xs-10">

                <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'layak_mula',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                ?>

            </div>
          
        </div>
        <div class="form-group">
        <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Tamat/<i>End</i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
                title="Tarikh Tamat Kelayakan"></i>
            </label>

            <div class="col-md-4 col-sm-4 col-xs-10">

                <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'layak_tamat',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                ?>

            </div>
          
        </div>
        <div class="form-group">
        <label class="col-sm-3 control-label"><i class="fa fa-calendar"></i>&nbsp;Jumlah Kelayakan /<i>Entitlement Days</i>
                <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
                title="Jumlah Kelayakan"></i>
            </label>

            <div class="col-md-4 col-sm-4 col-xs-10">
            <?php if($admin){?>
    <?= $form->field($model, 'layak_cuti',[
           'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent','disabled'=>false]
     ])->textInput()->input('layak_cuti', ['placeholder' => "Kelayakan Cuti"])->input('layak_cuti', ['placeholder' => "Dikira automatik oleh sistem"])->label(false); ?>

    <?= $form->field($model, 'tempv2')->checkbox(array('label' => 'Tandakan jika Mahu Menambah Kelayakan Cuti Secara Manual')); ?>
    <?php }elseif($biodata->statLantikan == 7 || $biodata->statLantikan == 6){ ?>
        <?= $form->field($model, 'layak_cuti',[
           'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent','disabled'=>false]
     ])->textInput()->input('layak_cuti', ['placeholder' => "Kelayakan Cuti"])->input('layak_cuti', ['placeholder' => "Sila Masukkan Jumlah Kelayakan"])->label(false); ?>

<?php }else{ ?>
            <?= $form->field($model, 'layak_cuti',[
           'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control transparent','disabled'=>true]
     ])->textInput()->input('layak_cuti', ['placeholder' => "Kelayakan Cuti"])->input('layak_cuti', ['placeholder' => "Dikira automatik oleh sistem"])->label(false); ?>
            <?php }?>

            </div>
          
        </div>

        <div class="ln_solid"></div>


        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Back', ['cuti/supervisor/set-leave','id'=>Yii::$app->getRequest()->getQueryParam('id')], ['class' => 'btn btn-warning']) ?>
                <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Submit', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

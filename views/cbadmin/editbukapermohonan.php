<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
?>
<div class="row"> 
      <div class="x_content">
     <div class="col-xs-12 col-md-12 col-lg-12">
         <?= $this->render('/cutibelajar/_topmenu') ?>
  
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Tetapan Pembukaan Permohonan (SESI <?=$model->sesi?>)</strong></h2>
<!--            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>-->
            <div class="clearfix"></div>
        </div>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Tamat Pengajian
            </label>
            <div class="col-md-3 col-sm-6 col-xs-6">
                 <?=  DatePicker::widget([
                    'name' => 'starttamatkontrak',
                    'value' => $model->start_tamatkontrak,
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);?>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                 <?=  DatePicker::widget([
                    'name' => 'endtamatkontrak',
                    'value' => $model->end_tamatkontrak,
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Boleh Memohon
            </label>
            <div class="col-md-3 col-sm-6 col-xs-6">
                 <?=  DatePicker::widget([
                    'name' => 'startbolehmohon',
                    'value' => $model->start_bolehmohon,
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);?>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                 <?=  DatePicker::widget([
                    'name' => 'endbolehmohon',
                    'value' => $model->end_bolehmohon,
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun Sesi
            </label>
            <div class="col-md-3 col-sm-6 col-xs-6">
                 <?=  DatePicker::widget([
                    'name' => 'tahun',
                    'value' => $model->tahun,
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy',
                        'minViewMode'=> "years"
                    ]
                ]);?>
            </div>
        </div>
        <div class="ln_solid"></div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <?= Html::submitButton('Hantar', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

<?php ActiveForm::end(); ?>
    </div>
</div>
</div>
</div>
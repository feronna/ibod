<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
?>
<?php echo $this->render('/pengesahan/_menu'); ?>
<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Tetapan Pembukaan Permohonan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Lantikan
            </label>
            <div class="col-md-3 col-sm-6 col-xs-6">
                 <?=  DatePicker::widget([
                    'name' => 'startlantikan',
                    'value' => $model->getTarikh($model->start_lantikan),
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'dd M yyyy'
                    ]
                ]);?>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                 <?=  DatePicker::widget([
                    'name' => 'endlantikan',
                    'value' => $model->getTarikh($model->end_lantikan),
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'dd M yyyy'
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
                    'value' => $model->getTarikh($model->start_bolehmohon),
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'dd M yyyy'
                    ]
                ]);?>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6">
                 <?=  DatePicker::widget([
                    'name' => 'endbolehmohon',
                    'value' => $model->getTarikh($model->end_bolehmohon),
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'dd M yyyy'
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
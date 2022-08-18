<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>
            
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        
        <div class="panel-body">
            <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Projek / Aktiviti</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($model, "skt_projek")
                            ->textInput(['class' => 'form-control'])
                            ->label(false);
                    ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kuantiti</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($model, "skt_kuantiti")
                            ->textInput(['class' => 'form-control'])
                            ->label(false);
                    ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kualiti</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($model, "skt_kualiti")
                            ->textInput(['class' => 'form-control'])
                            ->label(false);
                    ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kos</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($model, "skt_kos")
                            ->textInput(['class' => 'form-control'])
                            ->label(false);
                    ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Masa</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($model, "skt_masa")
                            ->textInput(['class' => 'form-control'])
                            ->label(false);
                    ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Sasaran Kerja</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($model, "skt_sasar")
                            ->textInput(['class' => 'form-control'])
                            ->label(false);
                    ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pencapaian Sebenar</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($model, "skt_capai")
                            ->textInput(['class' => 'form-control'])
                            ->label(false);
                    ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($model, "skt_ulasan")
                            ->textInput(['class' => 'form-control'])
                            ->label(false);
                    ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <div class="col-md-3"></div>
                    <div class="col-md-8 col-xs-12">
                        <div class="pull-right">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                        <?= Html::submitButton('Tambah', ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
                </div>
            
            <?php ActiveForm::end(); ?>
            <?php yii\widgets\Pjax::end() ?>
        </div>
    </div>
    </div>
</div>       

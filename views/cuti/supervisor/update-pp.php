<?php

use app\models\cuti\SetPegawai;
use app\models\hronline\Tblprcobiodata;
use yii\helpers\Html;
use app\models\keselamatan\TblRekod;
use yii\helpers\Url;
use app\widgets\TopMenuWidget;
use yii\widgets\DetailView;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\daterange\DateRangePicker;
use yii\bootstrap\Modal;


?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Kemaskini Peraku dan Pelulus / <i>Update Approver and Verifier for </i> <?php echo $bio->CONm?></strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

               

            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"> Peraku / <i>Verifier</i>
                    <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Leave Type"></i>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($model, 'peraku_icno')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Tblprcobiodata::find()->where(['!=','Status','6'])->all(), 'ICNO', 'CONm'),
                            'options' => ['placeholder' => 'Choose Approver', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?>
                </div>

            </div>
           
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"> Pelulus / <i>Approver</i>
                    <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Leave Type"></i>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($model, 'pelulus_icno')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Tblprcobiodata::find()->where(['!=','Status','6'])->all(), 'ICNO', 'CONm'),
                            'options' => ['placeholder' => 'Choose Verifier', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?>
                </div>

            </div>
           
            <div class="ln_solid"></div>


            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                    <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Submit', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

    

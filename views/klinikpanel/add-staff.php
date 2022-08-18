<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;
use app\widgets\TopMenuWidget;
use app\models\keselamatan\RefUnit;
use app\models\hronline\Campus;
?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1162], 'vars' => []]); ?>

<div class="col-md-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Tambah Kelayakan Klinik Panel</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                        $form->field($newstaff, 'max_icno')->label(false)->widget(Select2::classname(), [
                            'data' => $allBiodata,
                            'options' => ['placeholder' => 'Sila pilih nama', 'default' => 0],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Kelayakan<span class="required">*</span>
                </label>

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                        $form->field($newstaff, 'max_tuntutan')->label(false)->widget(Select2::classname(), [
                            'data' => ['700.00' => 'RM700 - LANTIKAN KHAS','1000.00' => 'RM1000 - BUJANG', '1500.00' => 'RM1500 - BERKAHWIN (PASANGAN KAKITANGAN UMS)', '2000.00' => 'RM2000 - BERKAHWIN (PASANGAN BUKAN KAKITANGAN UMS)'],
                            'options' => ['placeholder' => '-- Pilih Kelayakan --', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?>

                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                </div>


            </div>
        </div>
    </div>



    <?php ActiveForm::end(); ?>
</div>
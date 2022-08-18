<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\RefWp;
use app\models\hronline\GredJawatan;
use kartik\grid\GridView;
use app\widgets\TopMenuWidget;
/* @var $this yii\web\View */
/* @var $model app\models\mohonjawatan\TblOpenpos */
//
//$this->title = 'Create Tbl Openpos';
//$this->params['breadcrumbs'][] = ['label' => 'Tbl Openpos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<?= TopMenuWidget::widget(['top_menu' => [18, 44, 45, 51], 'vars' => [
    ['label' => ''],
    //    ['label' => app\models\kontrak\Kontrak::totalPending(Yii::$app->user->getId())]
]]); ?>

<!--list permohonanan yang telah dibuka-->

<div class="col-md-12">
    <div class="x_panel">

        <div class="x_title">
            <h2>Pembukaan Permohonan CBTH dan GCR</h2>
            <ul class="nav navbar-right panel_toolbox">

            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date_start">Tarikh Mula <span class="required">*</span>
                </label>
                <div class="col-md-3 col-md-3 col-sm-6 col-xs-12">
                    <?=
                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'start_date',
                            'template' => '{input}{addon}',
                            'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'disabled' => false],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="end_date">Tarikh Akhir <span class="required">*</span>
                </label>
                <div class="col-md-3 col-md-3 col-sm-6 col-xs-12">
                    <?=
                        DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'end_date',
                            'template' => '{input}{addon}',
                            // 'disable' => true,
                            'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'disabled' => false],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                            ]
                        ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Remark<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'remark')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success', 'url' => ['index']]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div> <!-- end of xpanel-->
</div> <!-- end of md-->
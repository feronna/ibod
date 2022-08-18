<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\export\ExportMenu;
use app\models\elnpt\TblLppTahun;
use app\models\hronline\Department;
use kartik\daterange\DateRangePicker;
use kartik\date\DatePicker;

?>

<?= $this->render('_menuAdmin'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Jana LPG</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php $form = ActiveForm::begin(['id' => 'search',  'method' => 'post', 'options' => ['class' => 'form-horizontal form-label-left']]); ?>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Bulan</label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <?=
                            $form->field($model, 'month')->label(false)->widget(Select2::classname(), [
                                'data' => [
                                    '01' => 'Jan',
                                    '02' => 'Feb',
                                    '03' => 'Mac',
                                    '04' => 'Apr',
                                    '05' => 'Mei',
                                    '06' => 'Jun',
                                    '07' => 'Jul',
                                    '08' => 'Ogos',
                                    '09' => 'Sep',
                                    '10' => 'Okt',
                                    '11' => 'Nov',
                                    '12' => 'Dis',
                                ],
                                'hideSearch' => true,
                                'options' => [
                                    'placeholder' => 'Pilih Bulan', 
                                    //'class' => 'form-control col-md-7 col-xs-12',
                                    //'id' => 'jenis_carian',
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun</label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <?=
                            $form->field($model, 'year')->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => Yii::t('app', 'Tahun LPG')],
//                                'attribute2'=>'to_date',
//                                'type' => DatePicker::TYPE_RANGE,
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'startView'=>'year',
                                    'minViewMode'=>'years',
                                    'format' => 'yyyy'
                                ]
                            ])->label(false);
                        ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                        <?= Html::submitButton('Jana / Hantar', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    </div>
</div>
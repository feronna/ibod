<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use kartik\widgets\SwitchInput;
use yii\widgets\DetailView;
use kartik\checkbox\CheckboxX;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>
            
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        
        <div class="panel-body">
            <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>

            <?php
                echo DetailView::widget([
                    'model' => $main,
                    'attributes' => [
                        [                      
                            'label' => 'TAHUN',
                            'value' => $main->tahun,
                        ],
                        [                      
                            'label' => 'NAMA',
                            'value' => $main->pyd->CONm,
                        ],
                        [                      
                            'label' => 'UMSPER',
                            'value' => $main->pyd->COOldID,
                        ],
                        [                      
                            'label' => 'JAWATAN / GRED',
                            'value' => $main->gredJawatan->fname,
                        ],
                        [                      
                            'label' => 'JAFPIB',
                            'value' => $main->department->fullname,
                        ],
                    ],
                ]);
            ?>

            <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>

                <hr>

                <div class="form-group">
                    <?=
                            $form->field($model, 'cadang')->label(false)->widget(Select2::classname(), [
                                'data' => [
                                    '2' => 'Cadang PYD ini sebagai penerima APC bagi tahun penilaian '.$main->tahun,
                                    '3' =>  'Keputusan Panel PYD ini sebagai penerima APC bagi tahun penilaian '.$main->tahun,
                                ],
                                'hideSearch' => true,
                                'options' => [
                                    'placeholder' => 'Pilih cadangan APC', 
                                    //'class' => 'form-control col-md-7 col-xs-12',
                                    //'id' => 'jenis_carian',
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                </div>

                <hr>
            
                <div class="form-group">
                    <div class="pull-right">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            
            <?php ActiveForm::end(); ?>
            <?php yii\widgets\Pjax::end() ?>
        </div>
    </div>
    </div>
</div>       
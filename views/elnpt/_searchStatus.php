<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

use app\models\elnpt\Department;
use app\models\elnpt\TblLppTahun;

?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Carian Borang</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php $form = ActiveForm::begin(['id' => 'search',  'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left']]); ?>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">J/F/P/I/U</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                            $form->field($model, 'jfpiu')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Department::find()->orderBy(['fullname' => SORT_ASC,])->all(), 'id', 'fullname'),
                                'hideSearch' => false,
                                'options' => [
                                    'placeholder' => 'Cari JFPIU', 
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
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                            $form->field($model, 'tahun')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(TblLppTahun::find()->orderBy(['lpp_tahun' => SORT_ASC,])->all(), 'lpp_tahun', 'lpp_tahun'),
                                'hideSearch' => true,
                                'options' => [
                                    'placeholder' => 'Pilih Tahun', 
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
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                        <?= Html::submitButton('Cari', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    </div>
</div>


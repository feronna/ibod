<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use app\models\myidp\Kategori;

error_reporting(0);

?>
<div class="clearfix"></div> 
<div class="row">
    <div class="x_panel">
        <div class="x_title">
            <h3><span class="label label-danger" style="color: white">Tukar Kompetensi</span></h3>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
            <?php Pjax::begin(); ?>
            <div class="form-group">
                <label class="control-label col-md-2 col-sm-2 col-xs-4">Sila Pilih : </label>
                    <div class="col-md-8 col-sm-8 col-xs-10">
                    <?php 
                    
                    if ($model3->jawatan->job_category == '1'){
                    
                        echo Select2::widget([
                            'id' => 'a',
                            'name' => 'komp',
                            'data' => ArrayHelper::map(Kategori::find()->where(['academic' => '1'])->all(), 'kategori_id', 'kategori_nama'),
                            'options' => ['placeholder' => 'Sila pilih...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'multiple' => false,
                            ],
                        ]);
                    } elseif ($model3->jawatan->job_category == '2'){
                        
                        echo Select2::widget([
                            'id' => 'b',
                            'name' => 'komp',
                            'data' => ArrayHelper::map(Kategori::find()->where(['admin' => '1'])->all(), 'kategori_id', 'kategori_nama'),
                            'options' => ['placeholder' => 'Sila pilih...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'multiple' => false,
                            ],
                        ]);
                        
                    }
                    ?>
                    </div>
                    <p align="left">
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-info']) ?>
                    </p>
            
                </div>
                
            <?php Pjax::end(); ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
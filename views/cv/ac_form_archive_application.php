<?php

use yii\helpers\Html;
use kartik\form\ActiveForm; 
use kartik\select2\Select2; 
use yii\helpers\ArrayHelper;
?>

<div class="tblprcobiodata-search">
    <div class="x_panel">
        <div class="x_title"> 
            <p style="font-size:18px;font-weight: bold;">SEARCH</p> 
            <p align="right"><?= Html::a('Back', ['applications'], ['class' => 'btn btn-primary btn-sm']); ?></p>
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
            <?php
            $form = ActiveForm::begin([
                        'action' => ['archive-application-ac'],
                        'method' => 'get',
                        'options' => [
                            'data-pjax' => 1
                        ],
                        'fieldConfig' => ['autoPlaceholder' => true,
                        ],
            ]);
            ?> 
            
            <div class="col-md-3 col-sm-3 col-xs-3">
                <?=$form->field($permohonan, 'ICNO')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                    'options' => ['placeholder' => 'Name'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
            
            <div class="col-md-4 col-sm-4 col-xs-4">
                <?=$form->field($permohonan, 'ads_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\hronline\GredJawatan::find()->where(['IN','id',[10,13,11,205,220,257]])->all(), 'id', 'fname'),
                    'options' => ['placeholder' => 'Position'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
            
            <div class="col-md-3 col-sm-3 col-xs-3">
                <?=$form->field($permohonan, 'status_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\cv\RefStatus::find()
                                    ->where(['IN', 'id', [4,5]])
                                    ->all(), 'id', 'name'),
                    'options' => ['placeholder' => 'Status', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ])->label(false);
                ?>
            </div>
             
            <div class="col-md-2 col-sm-2 col-xs-2">
                <div class="form-group">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?> 
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php

use yii\helpers\Html;
use kartik\form\ActiveForm; 
use kartik\select2\Select2; 
use yii\helpers\ArrayHelper;
?>

<div class="tblprcobiodata-search">
    <div class="x_panel">
        <div class="x_title">
            <h2>Carian</h2> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
            <?php
            $form = ActiveForm::begin([
                        'action' => ['kakitangan-bertugas'],
                        'method' => 'get',
                        'options' => [
                            'data-pjax' => 1
                        ],
                        'fieldConfig' => ['autoPlaceholder' => true,
                        ],
            ]);
            ?>
  
            <div class="col-md-3 col-sm-3 col-xs-3 col-md-offset-8 col-sm-offset-8 col-xs-offset-8">
                <?=
                $form->field($search, 'ICNO')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm'),
                    'options' => ['placeholder' => 'Nama Staff'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false);
                ?>
            </div>

            <div class="col-md-1 col-sm-1 col-xs-1">
                <div class="form-group">
                    <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?> 
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

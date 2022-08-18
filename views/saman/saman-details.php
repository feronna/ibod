<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\grid\GridView;
use app\models\hronline\Department;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\GredJawatan;
use yii\helpers\Url;
use app\models\saman\SamanStatus;
use app\models\saman\SamanOld;
use kartik\widgets\DatePicker;
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian Saman</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                $form = ActiveForm::begin([
                            'action' => ['saman-details'],
                            'method' => 'get',
                            'options' => [
                                'data-pjax' => 1
                            ],
                ]);
                ?>
                <?=
                $form->field($searchModel, 'NOSAMAN')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(SamanOld::find()->all(), 'NOSAMAN', 'NOSAMAN'),
                    'options' => ['placeholder' => 'NO Saman', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                

                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-microchip"></i> Search', ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton('<i class="fa fa-repeat"></i> Reset', ['class' => 'btn btn-default']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Saman Individu</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="table-responsive">

                    <?=
                    GridView::widget([
                        'options' => [
                            'class' => 'table-responsive',
                        ],
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'NOSAMAN',
                            [
                                'label' => 'Tarikh Saman',
                                'format' => 'raw',
                                'value' => 'formattarikh'
                            ],
                            [
                                'label' => 'Status Bayaran',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $status = SamanStatus::find()->where(['NOSAMAN' => $data->NOSAMAN])->one();
                                    return $status->STATUS;
                              },
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
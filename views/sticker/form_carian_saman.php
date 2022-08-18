<?php

use yii\helpers\Html;
use kartik\select2\Select2; 
use yii\grid\GridView;
use kartik\form\ActiveForm;
?>
<?php echo $this->render('menu'); ?>  

<?php
$form = ActiveForm::begin([
            'action' => ['saman'],
            'method' => 'get',
            'options' => [
                'data-pjax' => 1,
                'class' => 'form-horizontal form-label-left disable-submit-buttons'
            ],
        ]);
?> 
<div class="x_panel" >
    <div class="x_title">
        <h2>Carian</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="form-group ">
            <div class="form-group"> 
                <div class=" col-md-3 col-sm-3 col-xs-12">
                    <?= $form->field($searchModel, 'ICNO')->textInput(['placeholder' => 'ICNO'])->label(false) ?> 
                </div>  
                <div class=" col-md-3 col-sm-3 col-xs-12">
                    <?= $form->field($searchModel, 'NO_KENDERAAN')->textInput(['placeholder' => 'NO KENDERAAN'])->label(false) ?> 
                </div>  
                <div class=" col-md-3 col-sm-3 col-xs-12"> 
                    <?=
                    $form->field($searchModel, 'STATUS_SAMAN')->widget(Select2::classname(), [
                        'data' => ['PENDING' => 'PENDING', 'PAID' => 'PAID'],
                        'options' => ['placeholder' => 'STATUS'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?>
                </div> 
                <div class=" col-md-2 col-sm-2 col-xs-12">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Sila Tunggu..']]) ?> 
                    <?= Html::a('Reset', ['saman'], ['class' => 'btn btn-danger']) ?>
                </div>
            </div>

        </div>
    </div>           
</div> 
<?php ActiveForm::end(); ?>   

<div class="x_panel">
    <div class="x_title">
        <h2>Rekod Saman</h2>
        <div class="clearfix"></div>
    </div> 
    <div class="x_content">

        <div class="table-responsive">

            <?=
            GridView::widget([ 
                'dataProvider' => $dataProvider,
                'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'ICNO',
                        'value' => 'ICNO'
                    ],
                    [
                        'attribute' => 'NO_KENDERAAN',
                        'value' => 'NO_KENDERAAN'
                    ],
                    [
                        'attribute' => 'LOKASI',
                        'value' => 'LOKASI'
                    ],
                    [
                        'attribute' => 'TRKHSAMAN',
                        'value' => 'TRKHSAMAN'
                    ],
                    [
                        'label' => 'Kesalahan',
                        'value' => 'NOTA1'
                    ],
                    [
                        'label' => 'STATUS',
                        'value' => function($model) {
                            if ($model->saman) {
                                if ($model->saman->STATUS == 'PENDING') {
                                    return '<span class="label label-danger">' . $model->saman->STATUS . '</span>';
                                } else {
                                    return '<span class="label label-success">' . $model->saman->STATUS . '</span>';
                                }
                            }
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Amaun Pending',
                        'value' => 'saman.AMOUNT_PENDING'
                    ],
                    [
                        'label' => 'Amaun Paid',
                        'value' => 'saman.AMOUNT_PAID'
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div> 

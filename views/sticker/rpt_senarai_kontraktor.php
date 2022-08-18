<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
?>

<?= $this->render('menu') ?> 
<div class="x_panel">
    <div class="x_title">
        <h2>Carian</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content"> 
        <?php
        $form = ActiveForm::begin([
                    'action' => ['status-syarikat'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                    'fieldConfig' => ['autoPlaceholder' => true,
                    ],
        ]);
        ?>

        <div class="col-md-6 col-sm-6 col-xs-6">
            <?=
            $form->field($searchModel, 'apsu_lname')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(app\models\esticker\TblKontraktor::find()->all(), 'apsu_lname', 'apsu_lname'),
                'options' => ['placeholder' => 'Nama Syarikat', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>     

        <div class="col-md-2 col-sm-2 col-xs-2">
            <div class="form-group">
<?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?> 
                <?= Html::a('Reset','status-syarikat', ['class' => 'btn btn-danger']) ?> 
            </div>
        </div>

<?php ActiveForm::end(); ?> 
    </div>
</div>

<div class="x_panel">
    <div class="table-responsive">     
        <?php Pjax::begin(); ?>
        <?php
        $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Kontraktor',
                'value' => function($model) {
                    return $model->apsu_lname ? $model->apsu_lname : '';
                },
            ],
                        [
                'label' => 'No. Tel',
                'value' => function($model) {
                    return $model->apsu_lname ? $model->apsu_phone : '';
                },
            ],
            [
                'label' => 'Alamat',
                'value' => function($model) {
                    return $model->apsu_address1 ? $model->apsu_address1 . $model->apsu_address2 . $model->apsu_address3 : '';
                },
            ],
            [
                'label' => 'Tarikh Perkhidmatan (MULA - TAMAT)',
                'value' => function($model) {
                    $end = date('Y-m-d',strtotime($model->tarikhtamatsah));
                    if($model->tarikhtamatsah){
                        if(date('Y-m-d',strtotime($model->tarikhtamatsah)) <= date('Y-m-d')){
                            $end = '<span style="color:red"><b>'.$end.'</b></span>';
                        }
                    }
                    
                    return date('Y-m-d',strtotime($model->tarikhmulasah)) . ' - ' . $end;
                },
                        'format' => 'raw',
            ],
        ];
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'beforeHeader' => [
                [
                    'columns' => [],
                    'options' => ['class' => 'skip-export'] // remove this row from export
                ]
            ],
            'toolbar' => [
                '{export}',
                '{toggleData}'
            ],
            'bordered' => true,
            'striped' => false,
            'condensed' => false,
            'responsive' => true,
            'hover' => true,
            'panel' => [
                'type' => GridView::TYPE_DEFAULT,
                'heading' => '<h2>Status Perkhidmatan Kontraktor</h2>',
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>


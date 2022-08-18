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
                    'action' => ['service-kontraktor'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                    'fieldConfig' => ['autoPlaceholder' => true,
                    ],
        ]);
        ?>

        <div class="col-md-5 col-sm-5 col-xs-5">
            <?=
            $form->field($searchModel, 'name')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(app\models\Kontraktor\SyarikatKontraktor::find()->all(), 'name', 'name'),
                'options' => ['placeholder' => 'Nama Syarikat', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>     
        <div class="col-md-5 col-sm-5 col-xs-5">
            <?=
            $form->field($searchModel, 'jenis_kontrak')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(app\models\Kontraktor\RefKontrakType::find()->all(), 'jenis_desc', 'jenis_desc'),
                'options' => ['placeholder' => 'Ketegori', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>     

        <div class="col-md-2 col-sm-2 col-xs-2">
            <div class="form-group">
<?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?> 
                <?= Html::a('Reset','service-kontraktor', ['class' => 'btn btn-danger']) ?> 
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
                    return $model->name ? $model->name : '';
                },
            ],
                        [
                'label' => 'No. Tel',
                'value' => function($model) {
                    return $model->kontraktor->apsu_phone ? $model->kontraktor->apsu_phone : '';
                },
            ],
            [
                'label' => 'Alamat',
                'value' => function($model) {
                    return $model->kontraktor->apsu_address1 ? $model->kontraktor->apsu_address1 . $model->kontraktor->apsu_address2 . $model->kontraktor->apsu_address3 : '';
                },
            ],
             
            [
                'label' => 'Tarikh Perkhidmatan (MULA - TAMAT)',
                'value' => function($model) {
                    $end = date('Y-m-d',strtotime($model->kontraktor->tarikhtamatsah));
                    if($model->kontraktor->tarikhtamatsah){
                        if(date('Y-m-d',strtotime($model->kontraktor->tarikhtamatsah)) <= date('Y-m-d')){
                            $end = '<span style="color:red"><b>'.$end.'</b></span>';
                        }
                    }
                    
                    return date('Y-m-d',strtotime($model->kontraktor->tarikhmulasah)) . ' - ' . $end;
                },
                        'format' => 'raw',
            ],

             [
                'label' => 'Perkhidmatan',
                'value' => 'syarikat',
                
            ],
           
            [
                'label' => '',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>function ($list){
                             
                        return  
                        Html::a('<i class="fa fa-eye">', ["kontraktor/perincian-kontraktor", 'apsu_suppid' => $list->apsu_suppid]);
                          
                           
                        
                      },
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
                'heading' => '<h2>Perkhidmatan Kontraktor Aktif</h2>',
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>


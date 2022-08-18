<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use kartik\form\ActiveForm;

error_reporting(0);
?> 
<?= $this->render('menu') ?> 

<div class="x_panel">
    <div class="x_title">
        <h2>Carian</h2> 
        <p align="right"><?= \yii\helpers\Html::a('Kembali', ['msiso/index-audit-report'], ['class' => 'btn btn-default btn-sm']) ?></p>  
        <div class="clearfix"></div>
    </div>
    <div class="x_content"> 
    <?php
        $form = ActiveForm::begin([
                    'action' => ['ncr-report'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                    'fieldConfig' => ['autoPlaceholder' => true,
                    ],
        ]);
        ?>

        <div class="col-md-3 col-sm-3 col-xs-5">
            <?=
            $form->field($searchModel, 'dept')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(app\models\msiso\TblNcr::find()->all(), 'dept', 'dept'),
                'options' => ['placeholder' => 'JAFPIB', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>    
        <div class="col-md-4 col-sm-4 col-xs-5">
            <?=
            $form->field($searchModel, 'clause')->label(false)->widget(Select2::classname(), [ 
                // 'data' => ArrayHelper::map(app\models\msiso\TblClause::find()->all(), 'clause_order', 'clauseName'),
                'data' => ArrayHelper::map(app\models\msiso\TblNcr::find()->all(), 'clause', 'clause'),
                'options' => ['placeholder' => 'Klausa', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>      
        <div class="col-md-5 col-sm-5 col-xs-5">
            <?=
            $form->field($searchModel, 'auditor')->label(false)->widget(Select2::classname(), [ 
                'data' => ArrayHelper::map(app\models\msiso\TblNcr::find()->all(), 'auditor', 'auditor'), 
                'options' => ['placeholder' => 'Auditor', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div> 
        <div class="col-md-3 col-sm-3 col-xs-5">
            <?=
            $form->field($searchModel, 'status_tindakan')->label(false)->widget(Select2::classname(), [ 
                'data' => [ '1' => 'SELESAI', '2' => 'MENUNGGU TINDAKAN', '3'=> 'KEMASKINI', '4' => 'TINDAKAN AUDITEE', '5'=> 'TINDAKAN AUDITOR', '6' => 'SEMMAKAN','7' => 'NOTIFIKASI'], 
                'options' => ['placeholder' => 'Status', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>  
    
        <div class="col-md-2 col-sm-2 col-xs-2">
            <div class="form-group">
            <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?> 
            <?= Html::a('Reset','ncr-report', ['class' => 'btn btn-danger']) ?> 
            </div>
        </div>

<?php ActiveForm::end(); ?> 
    </div>
</div>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
    <?php Pjax::begin(['id' => 'model']) ?> 
<div class="row"> 
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
        <h2><i class="fa fa-list"></i><strong> NCR AUDIT REPORT</strong></h2> 
        <div class="clearfix"></div>
        </div> 
     <div class="col-xs-12 col-md-12 col-lg-12"> 
        <!-- senarai ncr -->
             <?= GridView::widget([
                    'dataProvider' => $dataProvider,
//                    'filterModel' => true,
                    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                    'beforeHeader' => [
                        [
                            'columns' => [],
                            'options' => ['class' => 'skip-export'] // remove this row from export
                        ]
                    ],
                    'toolbar' => [
//                                '{export}',
//                                '{toggleData}'
                    ],
                    'bordered' => true,
                    'striped' => false,
                    'condensed' => false,
                    'responsive' => true,
                    'hover' => true,
                    'panel' => [
                        'type' => GridView::TYPE_DEFAULT,
                        'heading' => '<h2>NONCONFORMITY REPORT(NCR)</h2>',
                    ],
                    'columns' => [
                    ['class' => 'yii\grid\SerialColumn',
                                        'header' => '#',
                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                    ],  

                    [
                        'label' => 'JAFPIB',
                        'value' => 'dept',
                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                    ], 

                    [
                        'label' => 'Tarikh Audit',
                        'value' => 'tarikhAudit',
                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                    ], 
                    [
                        'label' => 'Auditor',
                        'value' => 'auditor',
                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                    ], 
                    [
                        'label' => 'Klausa',
                        'value' => 'clause',
                        // 'value' => function($senarai) { return $senarai->clause  . " " . $senarai->klausa->clause_title ;},
                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                    ], 
                    [
                        'label' => 'Status',
                        'value' => 'statusTindakan', 
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                    ], 
                    [
                        'label' => 'Tindakan',
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value'=>function ($list){ 
                                if($list->status_tindakan == '2' && $list->status_semasa == '2'){
                                    return Html::a('<i class="fa fa-eye"></i>', ["msiso/tindakan-bengkel-ncr", 'id' => $list->id], ['class' => 'btn btn-primary']); 
                                    
                                } 
                                elseif($list->status_tindakan == '2' ){
                                    return 
                                        Html::a('<i class="fa fa-pencil"></i>', ["msiso/tindakan-bengkel-ncr", 'id' => $list->id], ['class' => 'btn btn-success']);
                                }
                                elseif($list->status_tindakan == '1' || $list->status_tindakan == '3' || $list->status_tindakan == '4' || $list->status_tindakan == '7'){
                                    return 
                                        Html::a('<i class="fa fa-eye"></i>', ["msiso/paparan-ncr", 'id' => $list->id], ['class' => 'btn btn-primary']);
                                }elseif($list->status_tindakan == '5'){
                                    return Html::a('<i class="fa fa-eye"></i>', ["msiso/paparan-ncr", 'id' => $list->id], ['class' => 'btn btn-primary']); 
    
                                }elseif($list->status_tindakan == '6'){
                                    return Html::a('<i class="fa fa-pencil"></i>', ["msiso/tindakan-verify", 'id' => $list->id], ['class' => 'btn btn-success']); 
    
                                }   
                                },
                    ], 
                    [
                        'label' => 'Notifikasi',
                        'format' => 'raw',
                        'value'=>function ($list) {
                        if($list->status_tindakan  == '4'){
                            $checked = 'checked';
                        }
                        if($list->status_tindakan  == '7'){
                            $checked1 = 'checked';
                        }
                        
                        return Html::a('<input type="radio" name="'.$list->id.'" value="y'.$list->id.'" '.$checked.'><i class="fa fa-check"></i>').'  '.Html::a('<input type="radio" name="'.$list->id.'" value="n'.$list->id.'" '.$checked1.'><i class="fa fa-remove"></i>');
                      },
                              'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'checkboxOptions' => function ($list) { 
                        if(($list->status_tindakan  !='7'  )){
                        return ['disabled' => 'disabled'];
                        }
                        return ['value' => $list->id, 'checked'=> true];
                        },
                    ],
                ],
            ]); ?>
        <div class="form-group" align="right">
        <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar Notifikasi'), ['class' => 'btn btn-primary', 'name' => 'simpan', 'value' => 'submit_1']) ?>
       
        </div>
    </div>
     <?php Pjax::end() ?>
            <?php ActiveForm::end(); ?>

</div>
</div>
</div>

<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
 
/* @var $this yii\web\View */
/* @var $searchModel app\models\kontrak\KontrakSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
 error_reporting(0); 
?>

   <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
            <?php Pjax::begin(['id' => 'model']) ?>
            
            <div class="x_content">
                

                 <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'class' => 'table-responsive',
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'beforeHeader' => [
                    [
                        'columns' => [
                            ['content' => 'TAMBANG BELAS EHSAN', 'options' => ['colspan' => 9, 'class' => 'text-center ',
                                'style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                              
                            ],
                        ],
                    ]
                ],
                    'columns' => [
                        ['class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',

                            ],

                        [
                        'label' => 'Nama Pemohon',
                        'value' => 'kakitangan.CONm',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                     
                    [
                        'label' => 'Tarikh Mohon',
                        'value' => 'entrydate'
                    ],
                     
                    [
                        'header' => 'Status Ketua BSM',
                        'attribute' => 'statuskj',
                        'format' => 'raw',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                        [
                        'header' => 'Status bendahari',
                        'attribute' => 'statuss',
                        'format' => 'raw',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                         
                        [
                        'label' => 'Tindakan',
                        'format' => 'raw',
                        'value'=>function ($data) {
                        if($data->isActive2  == '1'){
                            $checked = 'checked';
                        }
                        if($data->isActive2  == '2'){
                            $checked1 = 'checked';
                        }
                        if($data->status_pt  == 'Diluluskan' || $data->status_pt  == 'Tidak Diluluskan'){
                            return $data->status_pt ;
                        }
                        return Html::a('<input type="radio" name="'.$data->id.'" value="y'.$data->id.'" '.$checked.'><i class="fa fa-check"></i>').'  '.Html::a('<input type="radio" name="'.$data->id.'" value="n'.$data->id.'" '.$checked1.'><i class="fa fa-remove"></i>');
                      },
                              'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                       
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'checkboxOptions' => function ($data) { 
                        if(($data->status_kj  =='Diluluskan' ||$data->status_kj  =='Tidak Diluluskan')){
                        return ['disabled' => 'disabled'];
                        }
                        return ['value' => $data->id, 'checked'=> true];
                        },
                    ],
                        ],
                ]);
                ?>
                <div class="form-group" align="right">
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary', 'name' => 'simpan', 'value' => 'submit_1']) ?>
                    
                </div>
                 
            </div>
            <?php Pjax::end() ?>
            <?php ActiveForm::end(); ?>
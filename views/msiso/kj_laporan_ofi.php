<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use kartik\form\ActiveForm;
use yii\data\Pagination;
use yii\widgets\LinkPager;
error_reporting(0);
?> 
<?= $this->render('menu') ?> 

<div class="x_panel">  
<div class="x_title">
        <h2><i class="fa fa-list"></i><strong> LAPORAN OFI</strong></h2> 
        <div class="clearfix"></div>
        </div>
         
          
                         <?=
                         $pdfHeader = [
                            'L'    => [
                                'content' => ' ',
                            ],
                            'C'    => [
                                'content'     => 'LAPORAN (OFI) AUDIT DALAM MS ISO 9001:2015',
                                'font-size'   => 10,
                                'font-style'  => 'B',
                                'font-family' => 'arial',
                                'color'       => '#333333',
                            ],
                            'R'    => [
                                'content' => ' ',
                            ],
                            'line' => true,
                        ]; 
                         
                         ?>
                        <?= 
                        GridView::widget([
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
                               '{export}',
                               '{toggleData}'
                    ],
                    'exportConfig' => [
                        kartik\grid\GridView::PDF => [
                            'filename' => 'Laporan OFI',
                            'config' => [
                              'methods' => [
                                'SetHeader' => [
                                  ['odd' => $pdfHeader, 'even' => $pdfHeader]
                                ],
                                'SetFooter' => [
                                  ['odd' => $pdfFooter, 'even' => $pdfFooter]
                                ],
                              ],
                              'options' => [
                                'title' => 'Laporan OFI',
                                'subject' => 'Laporan OFI',
                                // 'keywords' => 'pdf, preceptors, export, other, keywords, here'
                              ],
                            ]
                          ],
                    ],
                    
                    'bordered' => true,
                    'striped' => false,
                    'condensed' => false,
                    'responsive' => true,
                    'hover' => true,
                    'panel' => [
                        'type' => GridView::TYPE_DEFAULT,
                        'heading' => '<h2>OFI</h2>',
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
                        'label' => 'Klausa',
                        'value' => 'clause',
                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                    ], 
                    [
                        'label' => 'OFI', 
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['style'=>'white-space:pre-line;'], 
                        'value' => function($dataProvider) { 
                            if($dataProvider->penambahbaikan == NULL){
                                return "<strong>".$dataProvider->klausa-> clause_title. "</strong><br><br> " .$dataProvider->butiran;

                            }
                            elseif($dataProvider->penambahbaikan != NULL && $dataProvider->status_tindakan == '1'){
                                return "<strong>".$dataProvider->klausa-> clause_title. "</strong><br><br> " .$dataProvider->butiran.
                                "</strong><br><br><strong>Tindakan Penambahbaikan:</strong><br>"  .$dataProvider->penambahbaikan ;
                                
                            }
                        },
                    ], 
                        
                ],
            ]);
             ?>
                    </div>            
                </div>
            </div> 
</div>
</div>

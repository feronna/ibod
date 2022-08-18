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
        <h2><i class="fa fa-list"></i><strong> LAPORAN NCR</strong></h2>
        <p align="right"><?= \yii\helpers\Html::a('Kembali', ['msiso/index-audit-report'], ['class' => 'btn btn-default btn-sm']) ?></p> 
        <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
    <?php
        $form = ActiveForm::begin([
                    'action' => ['laporan-ncr'],
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
           
    
        <div class="col-md-2 col-sm-2 col-xs-2">
            <div class="form-group">
            <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?> 
            <?= Html::a('Reset','laporan-ncr', ['class' => 'btn btn-danger']) ?> 
            </div>
        </div>
        <?php ActiveForm::end(); ?> 
            <div class="table-responsive">
                <div class="col-md-12 col-sm-12 col-xs-12"> 
                         <?=
                         $pdfHeader = [
                            'L'    => [
                                'content' => ' ',
                            ],
                            'C'    => [
                                'content'     => 'LAPORAN (NCR) AUDIT DALAM MS ISO 9001:2015',
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
                        
                           $pdfFooter = [
                            'L'    => [
                                'content'     => '',
                                'font-size'   => 10,
                                'color'       => '#333333',
                                'font-family' => 'arial',
                            ],
                            'C'    => [
                                'content' => '',
                            ],
                            'R'    => [
                                'content'     => ' ',
                                'font-size'   => 10,
                                'color'       => '#333333',
                                'font-family' => 'arial',
                            ],
                            'line' => true,
                        ];
                         
                        ?>

                        <?=
                        GridView::widget([
                    'dataProvider' => $dataProvider,
//                    'filterModel' => true,
                    'containerOptions' => ['style' => 'overflow: auto',], // only set when $responsive = false
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
                            'filename' => 'Laporan NCR',
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
                                'title' => 'Laporan NCR',
                                'subject' => 'Laporan NCR',
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
                        'heading' => '<h2>NCR</h2>',
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
                        'label' => 'NCR', 
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['style'=>'white-space:pre-line;'],  
                        'value' => function($dataProvider) { 
                            if($dataProvider->status_tindakan == '4'){
                            return "<strong>Keperluan<br></strong>".$dataProvider->conformity_req. "<br><br><strong>Penemuan<br></strong>"
                             .$dataProvider->conformity_find."<br><br><strong>Bukti Penemuan<br></strong>".$dataProvider->conformity_proof ;

                            }
                            elseif($dataProvider->status_tindakan == '5' && $dataProvider->status_semasa == '1'){

                            return "<strong>Keperluan<br></strong>".$dataProvider->conformity_req. "<br><strong>Penemuan<br></strong>"
                            .$dataProvider->conformity_find."<br><strong>Bukti Penemuan<br></strong>".$dataProvider->conformity_proof.
                            "<br><br><strong>Keputusan hasil penyiasatan dan pengenalpastian punca:</strong><br> ".$dataProvider->invest_result.
                            "<br><br><strong> Pelan Tindakan Pembetulan termasuk tarikh pelaksanaan:</strong><br> ".$dataProvider->action_plan;
                            
                            }
                            elseif($dataProvider->status_tindakan == '6' && $dataProvider->status_semasa == '1'){

                            return "<strong>Keperluan<br></strong>".$dataProvider->conformity_req. "<br><strong>Penemuan<br></strong>"
                            .$dataProvider->conformity_find."<br><strong>Bukti Penemuan<br></strong>".$dataProvider->conformity_proof.
                            "<br><br><strong>Keputusan hasil penyiasatan dan pengenalpastian punca:</strong><br> ".$dataProvider->invest_result.
                            "<br><br><strong> Pelan Tindakan Pembetulan termasuk tarikh pelaksanaan:</strong><br> ".$dataProvider->action_plan.
                            "<br><br><strong> Verifikasi :</strong><br> ".$dataProvider->verifikasi; 
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

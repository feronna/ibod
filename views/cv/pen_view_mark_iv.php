<?php

use yii\helpers\Html;
use kartik\grid\GridView;
?> 

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <?php echo $this->render('menu'); ?>
        <div class="x_panel"> 
            <div class="x_title"> 
                <h2>MARKAH</h2>
                <p align ="right"> 
                    <?= Html::a('Back', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?>  
                </p>
            </div>
            <table class="table table-sm table-bordered jambo_table table-striped">  
                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12 text-right">Jawatan di mohon </th>
                    <td><?= $iv->jawatan->fname; ?></td>  
                </tr>
                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12 text-right">Maklumat Peribadi </th>
                    <td> <?= strtoupper($biodata->biodata->CONm) . '  (' . $biodata->ICNO . ')'; ?>
                    </td> 
                </tr>

                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12 text-right">Dokumen </th>
                    <td>  <?php
                     if($biodata->checkJd($biodata->ICNO)){
                                    $btn = 'btn-default';
                                }else{
                                    $btn = 'btn-danger';
                                }
                            
                                echo Html::a('CV', [
                                        'view-cv',
                                        'id' => sha1($biodata->ICNO),
                                        'title' => 'personal',
                                            ], [
                                        'class' => 'btn btn-default',
                                        'target' => '_blank',
                                    ]).Html::a('JD', [
                                        "jd", 
                                        'id' => $biodata->ICNO
                                            ],[
                                        'class' => 'btn '.$btn,
                                        'target' => '_blank',
                                    ]). Html::a('APPLICATION INFORMATION', [
                                        'download-cv', 
                                        'id' => sha1($biodata->ICNO), 
                                        'gred_id' => $iv->ads_id], 
                                        ['class' => 'btn btn-default btn-md', 
                                            'target' => '_blank']);
                    ?>
                    </td> 
                </tr>
            </table>
        </div>
        <div class="x_panel"> 

            <div class="table-responsive">   
                <?php
                $Columns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Panel',
                        'value' => function($model) {
                            return $model->biodata->CONm;
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Subject',
                        'value' => function($model) {
                            return $model->subjek->subj;
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Mark',
                        'value' => function($model) {
                            return $model->markah;
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Level',
                        'value' => function($model) {
                            if ($model->statusMarkah) {
                                return '<span class="label label-' . $model->statusMarkah->label . '">' . $model->statusMarkah->name . '</span>';
                            }
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Ulasan',
                        'value' => function($model) {
                            return $model->ulasan;
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Tarikh/Masa',
                        'value' => function($model) {
                            return $model->datetime;
                        },
                        'format' => 'raw'
                    ],
                ];


                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $Columns,
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                    'beforeHeader' => [
                        [
                            'options' => ['class' => 'skip-export'] // remove this row from export
                        ]
                    ],
                    'toolbar' => [
                    ],
                    'pjax' => true,
                    'bordered' => true,
                    'striped' => false,
                    'condensed' => false,
                    'responsive' => true,
                    'hover' => true,
                    'showPageSummary' => true,
                    'panel' => [
                        'type' => GridView::TYPE_DEFAULT,
                        'heading' => '<h2>List</h2>',
                    ],
                ]);
                ?> 
            </div>
        </div> 


    </div>
</div>
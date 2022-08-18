<?php

use yii\helpers\Html;
//use kartik\grid\GridView;
use yii\grid\GridView;
?> 

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <?php echo $this->render('menu'); ?>
        <div class="x_panel"> 
            <div class="x_title">
                <h2>List -  <?= $iv->jawatan->fname; ?></h2>
                <p align="right" >
                    <?php echo Html::a('Back', ['interview'], ['class' => 'btn btn-primary btn-sm']); ?>   
                </p>
                <div class="clearfix"></div>
            </div> 
            <div class="table-responsive">   
                <?php
                $Columns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Name',
                        'value' => function($model) { 
                                return $model->biodata->CONm; 
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Document',
                        'value' => function($model) use ($iv) { 
                                if($model->checkJd($model->ICNO)){
                                    $btn = 'btn-default';
                                }else{
                                    $btn = 'btn-danger';
                                }
                            
                                return Html::a('CV', [
                                        'view-cv',
                                        'id' => sha1($model->ICNO),
                                        'title' => 'personal',
                                            ], [
                                        'class' => 'btn btn-default',
                                        'target' => '_blank',
                                    ]).Html::a('JD', [
                                        "jd", 
                                        'id' => $model->ICNO
                                            ],[
                                        'class' => 'btn '.$btn,
                                        'target' => '_blank',
                                    ]). Html::a('APPLICATION INFORMATION', [
                                        'download-cv', 
                                        'id' => sha1($model->ICNO), 
                                        'gred_id' => $iv->ads_id], 
                                        ['class' => 'btn btn-default btn-md', 
                                            'target' => '_blank']);
                        },
                                'format' => 'raw'
                            ],
                            [
                                'label' => 'Action',
                                'value' => function($model) {
                                    return Html::a('<i class="fa fa-edit"></i>', ['mark-iv', 'id' => $model->id], ['class' => 'btn btn-default btn-sm']);
                                },
                                        'format' => 'raw'
                                    ],
//                                    [
//                                        'label' => 'Level/Mark',
//                                        'value' => function($model) {
//                                            $check = $model->MarkahIvBPanel($model->id);
//                                            if ($check) {
//                                                return '<span class="label label-' . $check->statusMarkah->label . '">' . $check->statusMarkah->name . '</span>';
//                                            }
//                                        },
//                                        'format' => 'raw'
//                                    ],
                                ];
 
                                    echo GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        'columns' => $Columns,
                                        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                                        'layout' => "{items}\n{pager}",
                                    ]); 
                                ?> 
            </div>
        </div> 
    </div>
</div>
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
?>  
<?= $this->render('menu') ?> 
<?php echo $this->render('ac_form_archive_application', ['permohonan' => $searchModel]) ?> 

<div class="x_panel">
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">ARCHIVE APPLICATION</p> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content"> 



        <div class="table-responsive">     
            <?php Pjax::begin(); ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                //'layout'=>"{items}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'UMSPER',
                        'value' => function($model) {
                            return $model->user->COOldID;
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Name',
                        'value' => function($model) {
                            return ucwords(strtolower($model->user->CONm));
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Previous Position',
                        'value' => function($model) {
                            return $model->oldJawatan->fname;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Current Position',
                        'value' => function($model) {
                            return $model->user->jawatan->fname;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Dean Validation',
                        'value' => function($model) {
                            return ($model->biodataChief ? $model->biodataChief->CONm : '') . '<br/>' . $model->kj_datetime;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'BSM Validation',
                        'value' => function($model) {
                            return ($model->biodataBsm ? $model->biodataBsm->CONm : '') . '<br/>' . $model->admin_datetime;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Status',
                        'value' => function($model) {
                            if ($model->status_id == 1) {
                                return '<span class="label label-warning">Waiting Dean approval</span>';
                            } else if ($model->status_id == 2) {
                                return '<span class="label label-info">Waiting BSM approval</span>';
                            } else if ($model->status_id == 3) {
                                return '<span class="label label-primary">Interview Offer</span>';
                            } else if ($model->status_id == 4) {
                                return '<span class="label label-success">Pass</span>';
                            } else if ($model->status_id == 5) {
                                return '<span class="label label-danger">Failed</span>';
                            }
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                        'headerOptions' => ['class' => 'text-center'],
                    ],
                ],
            ]);
            ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div> 


<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\cv\TblAccess;
?> 
<div class="col-md-12 col-sm-12 col-xs-12">
<?php echo $this->render('menu'); ?>   
<?php echo $this->render('menu_complain'); ?>  
<div class="x_panel">
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">COMPLAIN RECORD</p>
        <div class="clearfix"></div>
    </div>  

    <div class="x_content">
        <div class="table-responsive"> 
            <?php
            if (TblAccess::isAdminAcademic()) {
                $Columns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Name',
                        'value' => function($model) {
                            return Html::a('<u>'.$model->biodata->CONm.'</u>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'personal'], ['class' => 'btn btn-link btn-md', 'target' => '_blank']);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Gred',
                        'value' => function($model) {
                            return $model->biodata->jawatan->fname;
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Criteria',
                        'value' => function($model) {
                            return $model->kriteria->type;
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Justification',
                        'value' => function($model) {
                            return $model->justifikasi;
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Date Complain',
                        'value' => function($model) {
                            return $model->tarikh_mohon;
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Pass',
                        'value' => function($model) {
                            if ($model->assign_to) {
                                return ($model->assign_to ? $model->owner->CONm : ' ') . '<br/>' . ($model->assign_at ? $model->assign_at : ' ');
                            }
                            if ($model->status_id != 3) {
                                return Html::button(' ', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['assign-complain', 'id' => $model->id]), 'class' => 'fa fa-envelope mapBtn btn btn-primary btn-sm']);
                            }
                        },
                                'format' => 'raw',
                                'contentOptions' => ['style' => 'width: 10%;'],
                            ],
                            [
                                'label' => 'Action',
                                'value' => function($model) {
                                    return Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['complain-in-action', 'id' => $model->id], ['class' => 'btn btn-default btn-sm']);
                                },
                                        'format' => 'raw',
                                        'contentOptions' => ['style' => 'width: 10%;'],
                                    ],
                                ];
                            } else {
                                $Columns = [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    [
                                        'label' => 'Name',
                                        'value' => function($model) {
                                            return Html::a('<u>'.$model->biodata->CONm.'</u>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'personal'], ['class' => 'btn btn-link btn-md', 'target' => '_blank']);
                                        },
                                        'format' => 'raw'
                                    ],
                                    [
                                        'label' => 'Gred',
                                        'value' => function($model) {
                                            return $model->biodata->jawatan->fname;
                                        },
                                        'format' => 'raw'
                                    ],
                                    [
                                        'label' => 'Justification',
                                        'value' => function($model) {
                                            return $model->justifikasi;
                                        },
                                        'format' => 'raw'
                                    ],
                                    [
                                        'label' => 'Date Complain',
                                        'value' => function($model) {
                                            return $model->tarikh_mohon;
                                        },
                                        'format' => 'raw'
                                    ],
                                    [
                                        'label' => 'Action',
                                        'value' => function($model) {
                                            return Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['complain-in-action', 'id' => $model->id], ['class' => 'btn btn-default btn-sm']);
                                        },
                                                'format' => 'raw',
                                                'contentOptions' => ['style' => 'width: 10%;'],
                                            ],
                                        ];
                                    }

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
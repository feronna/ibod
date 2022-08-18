<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\cv\TblAccess;
?> 
<!--//<? echo $this->render('menu'); ?>  -->

<?php echo $this->render('menu_complain'); ?>    

<div class="x_panel">
    <div class="x_title">
        <h4><strong><i class="fa fa-pencil-square"></i> Rekod Aduan</strong></h4> 
        <div class="clearfix"></div>
    </div>  

    <div class="x_content">
        <div class="table-responsive"> 
            <?php
           
                                $Columns = [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    [
                                        'label' => 'Nama',
                                        'value' => function($model) {
                                            return $model->biodata->CONm;
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
                                        'label' => 'Justifikasi',
                                        'value' => function($model) {
                                            return $model->justifikasi;
                                        },
                                        'format' => 'raw'
                                    ],
                                    [
                                        'label' => 'Tarikh Aduan',
                                        'value' => function($model) {
                                            return $model->tarikh_mohon;
                                        },
                                        'format' => 'raw'
                                    ],
                                    [
                                        'label' => 'Tindakan',
                                        'value' => function($model) {
                                            return Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['complain-in-action', 'id' => $model->id], ['class' => 'btn btn-default btn-sm']);
                                        },
                                                'format' => 'raw',
                                                'contentOptions' => ['style' => 'width: 10%;'],
                                            ],
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

<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\cv\TblAccess;
?> 
<!--//<? echo $this->render('menu'); ?>  -->

<?php echo $this->render('/epos/menu'); ?>    

<div class="x_panel">
    <div class="x_title">
        <h4><strong><i class="fa fa-pencil-square"></i> Rekod Permohonan</strong></h4> 
        <div class="clearfix"></div>
    </div>  

    <div class="x_content">
        <div class="table-responsive"> 
            <?php
           
                                $Columns = [
                                    ['class' => 'yii\grid\SerialColumn'],
                                     [
                        //'attribute' => 'CONm',
                        'label' => 'NAMA PEMOHON',
                        'value' => function($model) {

                    return Html::a('<strong>' . $model->biodata->CONm . '</strong>') . '<br><small>' . $model->biodata->department->fullname . '</small>' .
                            '<br><small>' . $model->biodata->jawatan->nama . ' ' . $model->biodata->jawatan->gred;
                },
                        'format' => 'html',
                    ],
                [
                    'label' => 'TUJUAN MEL',
                    'attribute' => 'tujuan_mel',
                ],
                [
                    'label' => 'TARIKH MOHON',
                    'value' => function ($model) {
                        $date = DateTime::createFromFormat('Y-m-d H:i:s', $model->tarikh_mohon);
                        return Yii::$app->MP->Tarikh($date->format('Y-m-d'));
                    },
                ],
                                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'TINDAKAN',
                    'template' => '{lihat}',
                    'buttons' => [
                        'lihat' => function ($url,$model) {
                            return Html::a('<span class="fa fa-edit"></span>', ['mel-lihat-permohonan','id'=>$model->id], ['class' => 'text-center']);
                        },
                    ],
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['class' => 'text-center', 'style' => 'width:10%', 'bgcolor' => 'yellow'],
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

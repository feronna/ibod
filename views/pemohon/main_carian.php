<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
?> 
<div class="col-md-12 col-sm-12 col-xs-12">


    <?php echo $this->render('form_carian', ['iklan' => $searchModel]) ?> 

    <div class="x_panel">
        <div class="x_title">
            <h2>Jawatan Kosong</h2> 
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
                            'label' => 'Jawatan',
                            'value' => function($model) {
                                return '<b><u><a href=' . Url::to(['iklan', 'id' => $model->id]) . '> ' . $model->jawatan->fname . '</u></br>Kumpulan:</b> ' . $model->kumpulan->name . '</br>'
                                        . '<b>Klasifikasi:</b> ' . $model->klasifikasi->name . '</br><b>Tarikh tutup permohonan:</b> ' . $model->getTarikh($model->tarikh_tutup);
                            },
                                    'format' => 'raw',
                                ],
                                [
                                    'label' => 'Kampus',
                                    'value' => function($model) {
                                        return $model->penempatan->campus_name;
                                    },
                                ],
                                [
                                    'label' => 'Tarikh Pos',
                                    'value' => function($model) {
                                        return $model->getTarikh($model->tarikh_buka);
                                    },
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{mohon}',
                                    'buttons' => [
                                        'mohon' => function($url, $model, $key) {
                                            return Html::a('Mohon', ['pengakuan-pemohon', 'id' => $model->id], ['class' => 'btn btn-primary']);
                                        }
                                            ],
                                        ]
                                    ],
                                ]);
                                ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>  


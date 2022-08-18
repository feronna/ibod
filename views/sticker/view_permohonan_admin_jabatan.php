<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;  
?>
<?= $this->render('menu') ?> 
<div class="x_panel">
    <div class="x_title">
        <h2>Permohonan <?= $title; ?></h2> 
        <div class="clearfix"></div>
    </div> 
    <div class="x_content">
        <div class="table-responsive">   
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'Jabatan', 
                        'value' => 'kenderaan.department.shortname', 
                    ],
                    [
                        'attribute' => 'nama',
                        'value' => 'kenderaan.biodata.CONm'
                    ],
                    [
                        'attribute' => 'no_pendaftaran',
                        'value' => function($model) {
                            $words = str_replace(' ', '', strtolower($model->kenderaan->reg_number));
                            return strtoupper($words);
                        },
                    ],
                    [
                        'attribute' => 'apply_type',
                        'value' => function($model) {
                            return ucwords(strtoupper($model->apply_type));
                        },
                    ],
                    [
                        'attribute' => 'mohon_date',
                        'value' => 'mohon_date'
                    ],
                    [
                        'label' => '',
                        'value' => function($model) {
 

                                 if ($model->status_mohon == 'MENUNGGU KUTIPAN') {
                                    $title = 'Menunggu Kutipan';
                                    $btn = 'edit';
                                } elseif ($model->status_mohon == 'AKTIF') {
                                    $title = 'Selesai';
                                    $btn = 'eye';
                                } else {
                                    $title = 'Tiada Maklumat';
                                    $btn = 'eye';
                                }
                                return Html::a('<i class="fa fa-' . $btn . '"></i>', ['tindakan-jabatan', 'id' => $model->id, 'title' => $title], ['class' => 'btn btn-default btn-sm']);
                         
                        },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                        ],
                    ]);
                    ?> 
        </div>
    </div>
</div> 

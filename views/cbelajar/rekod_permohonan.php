<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;
?>

<div class="x_panel">
        <div class="x_title">
            <h4><strong>Rekod Permohonan Cuti Belajar</strong></h4> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
           
            <?php
            $dataProvider = new ActiveDataProvider([
                'query' => app\models\cbelajar\TblUrusMesyuarat::find()->where(['status' => 1]),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
            ?> 

            <div class="table-responsive">         
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'layout' => "{items}\n{pager}",
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                       
                                        [
                                            'label' => 'Nama Mesyuarat',
                                            'value' => function($model) {
                                               return 'Mesyuarat Jawatankuasa Pengajian Lanjutan Akademik Bil. ' ." ". $model->nama_mesyuarat." ".'(Kali Ke -' ." ". $model->kali_ke.")";
                                            },
                                        ],

                           

                                        [
                                            'label' => 'Tarikh Mesyuarat',
                                            'value' => function($model) {
                                               return $model->getTarikh($model->tarikh_mesyuarat);
                                            },
                                        ],
                                      
                                      
                                        
//                                             [
//                                                'class' => 'yii\grid\ActionColumn',
//                                                //'header' => 'PPK',
//                                                'headerOptions' => ['class'=>'text-center'],
//                                                'contentOptions' => ['class'=>'text-center'],
//                                                'template' => '{view}',
//                                                //'header' => 'TINDAKAN',
//                                                'buttons' => [
//                                                    'view' => function ($url, $model) {
//                                                        $url = Url::to(['dass21/result', 'id' => $model->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg"></i>', $url, [
//                                                            'title' => 'Keputusan Penilaian / Assessment Result',
//                                                        ]);
//                                                    },
//                                                ],
//                                            ],
                                        [
                                            'header' => 'Permohonan',
                                            'class' => 'yii\grid\ActionColumn',
                                            'template' => '{mohon}',
                                            'buttons' => [
                                                'mohon' => function($url, $model, $key) 
                                                {
                                                    if ($model->checkPermohonan($model->id)) {
                                                        $url = Url::to(['cutibelajar/lihat-permohonan', 'id' => $model->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                       return Html::a('<i class="fa fa-info-circle fa-lg" style="color: red"></i>', $url, [
                                                            'title' => 'Lihat Permohonan']);
                                                    } else {
                                                         $url = Url::to(['pengakuan-pemohon', 'id' => $model->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                       return Html::a('<i class="fa fa-info-circle fa-lg"></i>', $url, [
                                                            'title' => 'Mohon Cuti Belajar']);
                                                    }
                                                }
                                        ],
                                            'contentOptions' => ['class' => 'text-center'],
                                        ]
                                    ],
                                ]);
                                ?>
        </div>
        </div>
    </div>
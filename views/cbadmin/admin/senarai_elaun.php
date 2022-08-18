<?php



use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$title = $this->title = 'Muatnaik Dokumen';
?> 

<?php echo $this->render('/cutibelajar/_topmenu'); ?>

<p align="right">  <?= Html::a('Kembali', ['cutibelajar/halaman-pemohon'], 
                        ['class' => 'btn btn-primary btn-sm']) ?></p>
               
                               
           <div class="x_panel">

                     <div class="x_content"> 
                         <?php
                            $dataProvider = new ActiveDataProvider([
                                'query' => \app\models\cbelajar\RefBorang::find()->where(['status' => 3]),
                                'pagination' => [
                                    'pageSize' => 10,
                ],
            ]);
            ?> 
                   
                   
                    <div class="table-responsive ">
                        <h5><strong><i class="fa fa-file-o"></i> PROSES PEMBAYARAN ELAUN KAKITANGAN</strong></h5>

                        <?=
                            
                        GridView::widget([
                            'dataProvider' => $senarai_dokumen2,
                            'options' => ['style' => 'width:100%'],
                            'layout' => "{items}\n{pager}",
                            'columns' => [
                             
                                  ['class' => 'yii\grid\SerialColumn',
                                         'headerOptions' => ['class'=>'text-center'],
                                             'contentOptions' => ['class'=>'text-center'],
                                         'header' => 'Bil.'],

                                        [
                                            'label' => 'JENIS-JENIS ELAUN',
                                            'headerOptions' => ['class'=>'text-center'],
                                            'value' => function($model) {
                                               return  strtoupper($model->elaun);
                                            },
                                        ],

                                        [
                                            'header' => 'TINDAKAN',
                                             'headerOptions' => ['class'=>'text-center'],

                                            'class' => 'yii\grid\ActionColumn',
                                            'template' => '{mohon}',
                                            'buttons' => [
                                                'mohon' => function($url, $model, $key) 
                                                {
                                                 
                                                 
                                                      if ($model->id == "AKHIR")
                                                         {
                                                        $url = Url::to(['cblainlain/borang-permohonan']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                        return Html::a('LIHAT', ['tiketpenerbangan/borang-permohonan'], ['class' => 'btn btn-primary btn-xs']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg"></i>', $url, [
//                                                            'title' => 'Mohon Cuti Belajar']);
                                                    }
                                                    elseif ($model->id == "TESIS")
                                                         {
                                                        $url = Url::to(['cblainlain/borang-permohonan-tukar-tempat']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                        return Html::a('LIHAT', ['lapordiri/borang-hpg'], ['class' => 'btn btn-primary btn-xs']);
                                                    }
                                                     elseif ($model->id == "AMALI")
                                                         {
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                        return Html::a('LIHAT', ['senarai-keluarga'], ['class' => 'btn btn-primary btn-xs']);
                                                    }
                                                    elseif ($model->id == "KELUARGA")
                                                         {
                                                        return Html::a('LIHAT', ['senarai-keluarga'], ['class' => 'btn btn-primary btn-xs']);
                                                    }
                                                    elseif ($model->id == "PERKAKAS")
                                                         {
                                                        $url = Url::to(['cblainlain/borang-permohonan-tukar-tempat']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                        return Html::a('LIHAT', ['lapordiri/borang-hpg'], ['class' => 'btn btn-primary btn-xs']);
                                                    }
                                                     elseif ($model->id == "YURAN")
                                                         {
                                                        $url = Url::to(['cblainlain/borang-permohonan-tukar-tempat']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                        return Html::a('LIHAT', ['lapordiri/borang-hpg'], ['class' => 'btn btn-primary btn-xs']);
                                                    }
                                                     elseif ($model->id == "SEWA")
                                                         {
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                        return Html::a('LIHAT', ['lapordiri/borang-hpg'], ['class' => 'btn btn-primary btn-xs']);
                                                    }
                                                     elseif ($model->id == "SARA")
                                                         {
                                                        return Html::a('LIHAT', ['senarai-sara-hidup'], ['class' => 'btn btn-primary btn-xs']);
                                                    }
                                                     elseif ($model->id == "PENEMPATAN")
                                                         {
                                                        $url = Url::to(['cblainlain/borang-permohonan-tukar-tempat']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                        return Html::a('LIHAT', ['lapordiri/borang-hpg'], ['class' => 'btn btn-primary btn-xs']);
                                                    }
                                                     elseif ($model->id == "JALAN")
                                                         {
                                                        $url = Url::to(['cblainlain/borang-permohonan-tukar-tempat']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                        return Html::a('LIHAT', ['lapordiri/borang-hpg'], ['class' => 'btn btn-primary btn-xs']);
                                                    }
                                                     elseif ($model->id == "AMALI")
                                                         {
                                                        $url = Url::to(['cblainlain/borang-permohonan-tukar-tempat']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                        return Html::a('LIHAT', ['lapordiri/borang-hpg'], ['class' => 'btn btn-primary btn-xs']);
                                                    }
                                                     elseif ($model->id == "BUKU")
                                                         {
                                                        $url = Url::to(['cblainlain/borang-permohonan-tukar-tempat']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                        return Html::a('LIHAT', ['lapordiri/borang-hpg'], ['class' => 'btn btn-primary btn-xs']);
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



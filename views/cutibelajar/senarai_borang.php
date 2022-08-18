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
                        <h5><strong><i class="fa fa-file-o"></i>  BORANG PERMOHONAN</strong></h5>

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
                                            'label' => 'Nama Borang',
                                            'headerOptions' => ['class'=>'text-center'],
                                            'value' => function($model) {
                                               return  strtoupper($model->jenisBorang);
                                            },
                                        ],

                                        [
                                            'header' => 'Tindakan',
                                             'headerOptions' => ['class'=>'text-center'],

                                            'class' => 'yii\grid\ActionColumn',
                                            'template' => '{mohon}',
                                            'buttons' => [
                                                'mohon' => function($url, $model, $key) 
                                                {
                                                 
                                                 
                                                      if ($model->id == 4)
                                                         {
                                                        $url = Url::to(['cblainlain/borang-permohonan']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                        return Html::a('MOHON', ['tiketpenerbangan/borang-permohonan'], ['class' => 'btn btn-primary btn-xs']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg"></i>', $url, [
//                                                            'title' => 'Mohon Cuti Belajar']);
                                                    }
//                                                    elseif ($model->id == 30)
//                                                         {
//                                                        $url = Url::to(['cblainlain/borang-permohonan-tukar-tempat']);
////                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
//                                                        return Html::a('MOHON', ['lapordiri/borang-hpg'], ['class' => 'btn btn-primary btn-xs']);
//                                                    }
                                                     elseif ($model->id == 34)
                                                         {
//                                                        $url = Url::to(['cblainlain/borang-permohonan-tukar-tempat']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                        return Html::a('MOHON', ['tiketpenerbangan/borang-tuntutan'], ['class' => 'btn btn-primary btn-xs']);
                                                    }
                                                    elseif ($model->id == 30)
                                                         {
//                                                        $url = Url::to(['cblainlain/borang-permohonan-tukar-tempat']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                        return Html::a('MOHON', ['lapordiri/tuntut-hpg'], ['class' => 'btn btn-primary btn-xs']);
                                                    }
                                                     elseif ($model->id == 35)
                                                         {
//                                                        $url = Url::to(['cblainlain/borang-permohonan-tukar-tempat']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                        return Html::a('MOHON', ['lapordiri/tuntut-tesis'], ['class' => 'btn btn-primary btn-xs']);
                                                    }
                                                    elseif ($model->id == 37)
                                                         {
//                                                        $url = Url::to(['cblainlain/borang-permohonan-tukar-tempat']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                        return Html::a('MOHON', ['lapordiri/tuntut-akhir'], ['class' => 'btn btn-primary btn-xs']);
                                                    }
                                                     elseif ($model->id == 46)
                                                         {
//                                                        $url = Url::to(['cblainlain/borang-permohonan-tukar-tempat']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                        return Html::a('MOHON', ['tuntutan-yuran/tuntut'], ['class' => 'btn btn-primary btn-xs']);
                                                    }
                                                     elseif ($model->id == 50)
                                                         {
//                                                        $url = Url::to(['cblainlain/borang-permohonan-tukar-tempat']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                        return Html::a('MOHON', ['tuntutan-ielts/tuntut'], ['class' => 'btn btn-primary btn-xs']);
                                                    }
                                                      elseif ($model->id == 52)
                                                         {
//                                                        $url = Url::to(['cblainlain/borang-permohonan-tukar-tempat']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                        return Html::a('MOHON', ['tuntutan-visa/tuntut'], ['class' => 'btn btn-primary btn-xs']);
                                                    }
                                                      elseif ($model->id == 53)
                                                         {
//                                                        $url = Url::to(['cblainlain/borang-permohonan-tukar-tempat']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                        return Html::a('MOHON', ['tuntutan-insurans/tuntut'], ['class' => 'btn btn-primary btn-xs']);
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



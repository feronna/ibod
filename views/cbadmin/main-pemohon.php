<?php

use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;
?> 
<style>

    .html-marquee {
        height: auto;
        /*background-color:#ffff33;*/
        /*font-family:Cursive;*/
        font-size:14px;
        color:red;
        /*border-width:4;*/
        /*border-style:dotted;*/
        /*border-color:#ff0000;*/
    }
</style>
  <div class="col-md-12 col-sm-12 col-xs-12">
<?php echo $this->render('/cutibelajar/_topmenu'); ?>
      
<!--<marquee class="html-marquee" direction="left" behavior="scroll" scrollamount="6">
    <p>
        SILA KEMASKINI MAKLUMAT PERIBADI, MAKLUMAT AKADEMIK DAN MAKLUMAT KELUARGA ANDA SEBELUM MEMBUAT PERMOHONAN CUTI BELAJAR UNTUK MEMUDAHKAN PROSES PERMOHONAN ANDA. <br> 
    </p>
</marquee>-->

<div class="x_panel">
        <div class="x_title">
            <h4><strong><i class="fa fa-list"></i> Makluman Takwim Mesyuarat Jawatankuasa Pengajian Lanjutan</strong></h4> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
<!--            <h4><strong>Makluman Takwim Mesyuarat Jawatankuasa Pengajian Lanjutan</strong></h4> -->
            <?php
            $dataProvider = new ActiveDataProvider([
                'query' => app\models\cbelajar\TblUrusMesyuarat::find()->where(['status' => 1,'kategori_id'=>1]),
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
                        ['class' => 'yii\grid\SerialColumn',
                            'header' => 'BIL.'],
                       
                                        [
                                            'label' => 'NAMA MESYUARAT',
                                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            'value' => function($model) {
                                               return 'Mesyuarat Jawatankuasa Pengajian Lanjutan Akademik Bil. ' ." ". $model->nama_mesyuarat." ".'(Kali Ke -' ." ". $model->kali_ke.")";
                                            },
                                        ],

                                [
                                            'label' => 'KATEGORI',
                                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            'value' => function($model) {
                                                if ($model->kategori->id == 1) {
                                                    return 'PENTADBIRAN';
                                                } else {
                                                    return 'AKADEMIK';
                                                }
                                            },
                                        ],

                                        [
                                            'label' => 'TARIKH MESYUARAT',
                                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            'value' => function($model) {
                                               return $model->getTarikh($model->tarikh_mesyuarat);
                                            },
                                        ],
                                      
                                        [
                                            'label' => 'TARIKH PENGHANTARAN PERMOHONAN',
                                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            'value' => function($model) {
                                                return $model->getTarikh($model->tarikh_buka). ' - ' .$model->getTarikh($model->tarikh_tutup) ;
                                            },
                                        ],
//                                        [
//                                            'label' => 'Tarikh Tutup',
//                                            'value' => function($model) {
//                                                return $model->getTarikh($model->tarikh_tutup);
//                                            },
//                                        ],
                                        
                                  [
                                    'label' => 'TINDAKAN',
                                    'headerOptions' => ['class'=>'text-center'],
                                    'value' => function($model) { 
                                        return '<b><u><a href=' . Url::to(['cbadmin/senarai-borang', 'id' => $model->id]) . '>'.'Lihat'. '</span></b>';
                                    },
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center'],
                                ], 
//                                        [
//                                            'header' => 'Tindakan',
//                                            'class' => 'yii\grid\ActionColumn',
//                                            'template' => '{mohon}',
//                                            'buttons' => [
//                                                'mohon' => function($url, $model, $key) 
//                                                {
//                                                    if ($model->checkPermohonan($model->id))  {
//                                                        $url = Url::to(['cutibelajar/lihat-permohonan', 'id' => $model->id,]);
////                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
//                                                       return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
//                                                            'title' => 'Lihat Permohonan']);
//                                                    } 
//                                                    elseif($model->checkSimpan($model->id))
//                                                    {
//                                                        $url = Url::to(['cutibelajar/pengakuan-pemohon', 'id' => $model->id,]);
////                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
//                                                       return Html::a('<i class="fa fa-paper-plane" style="color: orange"></i>', $url, [
//                                                            'title' => 'Hantar Permohonan']);
//                                                    }
//                                                    else{
//                                                         $url = Url::to(['cbelajar/gambar', 'id' => $model->id,]);
////                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
//                                                       return Html::a('<i class="fa fa-info-circle fa-lg"></i>', $url, [
//                                                            'title' => 'Mohon Cuti Belajar']);
//                                                    }
//                                                }
//                                        ],
//                                            'contentOptions' => ['class' => 'text-center'],
//                                        ]
                                    ],
                                ]);
                                ?>
        </div>
        </div>
    </div>

    <div class="x_panel">
        <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
            <div class="clearfix"></div>
        </div>
       

 <div class="x_content"> 


            <div class="row">
                <div class="col-xs-12 col-md-3">
                    <?php
                    $resume = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'address-card',
                                        'header' => 'Rekod',
                                        'text' => 'Permohonan',
                                        'number' => '1',
                                    ]
                    );
                    echo Html::a($resume, ['cutibelajar/pemohonview?id='.$model->icno]);
        
                    ?>

                </div>


                 <div class="col-xs-12 col-md-3">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'align-right',
                                        'header' => 'LKK',
                                        'text' => 'Laporan Kemajuan Kursus',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($semakan, ['lkk/senarailkk']);
                    ?>
           </div>
                <div class="col-xs-12 col-md-3">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'edit',
                                        'header' => 'Lapor Diri',
                                        'text' => 'Tamat Pengajian Lanjutan',
                                        'number' => '4',
                                    ]
                    );
                    echo Html::a($semakan, ['#']);
                    ?>
           </div>
            
                
               
       </div>

                


        </div>
    </div>



    
  </div>


 


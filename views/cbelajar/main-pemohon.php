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
  
<?php echo $this->render('/cutibelajar/_topmenu'); ?>
       
 

<marquee class="html-marquee" direction="left" behavior="scroll" scrollamount="8">
    <p>
        SILA KEMASKINI MAKLUMAT PERIBADI, MAKLUMAT AKADEMIK DAN MAKLUMAT KELUARGA ANDA SEBELUM MEMBUAT PERMOHONAN CUTI BELAJAR UNTUK MEMUDAHKAN PROSES PERMOHONAN ANDA. <br> 
    </p>
</marquee>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Halaman Utama</h2> 
            <div class="clearfix"></div>
        </div>
       

 <div class="x_content"> 


            <div class="row">
                <div class="col-xs-12 col-md-3">
                    <?php
                    $resume = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'address-card',
                                        'header' => 'Permohonan',
                                        'text' => 'Maklumat Cuti Belajar',
                                        'number' => '1',
                                    ]
                    );
                    echo Html::a($resume, ['cbelajar/gambar']);
                    ?>

                </div>
                <div class="col-xs-12 col-md-3">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list-alt',
                                        'header' => 'Pengakuan',
                                        'text' => 'Perakuan Pemohon',
                                        'number' => '2',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['cbelajar/senarai-dokumen']);
                    ?>
                </div>

                 <div class="col-xs-12 col-md-3">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'info-circle',
                                        'header' => 'Semak',
                                        'text' => 'Permohonan',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($semakan, ['permohonan-semasa']);
                    ?>
           </div>
                <div class="col-xs-12 col-md-3">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'user',
                                        'header' => 'Dalam Pembangunan',
                                        'text' => 'Sistem Pengajian Lanjutan',
                                        'number' => '4',
                                    ]
                    );
                    echo Html::a($semakan, ['cbelajar/cv-pemohon']);
                    ?>
           </div>
            
                
               
       </div>

                


        </div>
    </div>



<div class="x_panel">
        <div class="x_title">
            <h2>Makluman Takwim Mesyuarat Jawatankuasa Pengajian Lanjutan</h2> 
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
                        ['class' => 'yii\grid\SerialColumn',
                         ],
                        
                       
                                        [
                                            'label' => 'Nama Mesyuarat',
                                            'value' => function($model) {
                                               return 'Mesyuarat Jawatankuasa Kali Ke -' ." ". $model->kali_ke;
                                            },
                                        ],

                                [
                                            'label' => 'Kategori',
                                            'value' => function($model) {
                                                if ($model->kategori->id == 1) {
                                                    return 'PENTADBIR';
                                                } else {
                                                    return 'AKADEMIK';
                                                }
                                            },
                                        ],

                                        [
                                            'label' => 'Tarikh Mesyuarat',
                                            'value' => function($model) {
                                               return $model->getTarikh($model->tarikh_mesyuarat);
                                            },
                                        ],
                                      
                                        [
                                            'label' => 'Tarikh Buka',
                                            'value' => function($model) {
                                                return $model->getTarikh($model->tarikh_buka);
                                            },
                                        ],
                                        [
                                            'label' => 'Tarikh Tutup',
                                            'value' => function($model) {
                                                return $model->getTarikh($model->tarikh_tutup);
                                            },
                                        ],
                                        [
                                            'header' => 'Tindakan',
                                            'class' => 'yii\grid\ActionColumn',
                                            'template' => '{mohon}',
                                            'buttons' => [
                                                'mohon' => function($url, $model, $key) 
                                                {
                                                    if ($model->checkPermohonan($model->id)) {
                                                       return '<i class="fa fa-check-circle fa-2x" aria-hidden="true" style="color: green"></i>';
                                                    } else {
                                                        return Html::a('<i class="fa fa-info-circle">', ["cutibelajar/pengakuan-pemohon", 'id' => $model->id]);
                                                       
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
</div>



  

 


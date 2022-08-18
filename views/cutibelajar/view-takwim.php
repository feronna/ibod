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

<!--<style> 
#rcorners1 {
  border-radius: 10px;
  background: white;
  padding: 10px; 
  width: 0px;
  height: 180px;  
}
  #rcorners2 {
  border-radius: 10px;
/*  border: 2px solid #293447;*/
  background: white;
  padding: 10px; 
  width: 1200px;
  height: 140px;  
}</style>-->
<?php error_reporting(0);?>
  
<?php echo $this->render('/cutibelajar/_topmenu'); ?>

    <p align="right"><?= Html::a('Kembali', ['cutibelajar/halaman-pemohon'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>
 

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

        <div class="x_panel"> 
    <div class="x_title">
        <h5>INFOGRAFIK</h5> 
        <div class="clearfix"></div>
    </div> 
    <div class="x_content"> 
        <ul class="list-unstyled timeline widget">
            <li>
                <div class="block">
                    <div class="block-content">
                        <h2 class="title"></h2>
                        <div class="excerpt">
                            <div id="w1" class="accordion" role="tablist" aria-multiselectable="true">

                                <a id="heading-w1-0" class="panel-heading" href="#w1-0" role="tab" data-toggle="collapse" data-parent="#w1" aria-expanded="true" aria-controls="w1-0">
                                    <h4 class="panel-title">TATACARA PERMOHONAN</h4>
                                </a>
                                <div id="w1-0" class="panel-collapse collapse out" aria-labelledby="heading-w1-0" role="tabpanel"><div class="panel-body">
                                        <div class="product_price"> 

               <center><?php echo Html::img('@web/images/pengajian_lanjutan.jpg',[ 'width' => '450px',
                   'height' => '450px']) ?></center></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </li>

            <li>
                <div class="block">
                    <div class="block-content">
                        <h2 class="title"></h2>
                        <div class="excerpt">
                            <div id="w2" class="accordion" role="tablist" aria-multiselectable="true">

                                <a id="heading-w2-0" class="panel-heading" href="#w2-0" role="tab" data-toggle="collapse" data-parent="#w2" aria-expanded="true" aria-controls="w2-0">
                                    <h4 class="panel-title">KEMUDAHAN PENGAJIAN LANJUTAN</h4>
                                </a>
                                <div id="w2-0" class="panel-collapse collapse out" aria-labelledby="heading-w2-0" role="tabpanel"><div class="panel-body">
                                        <table border="0" width="100%">
                                            <tr> 
                                                <td>
                                                    <a class="btn btn-success btn-xs">PROGRAM SANGKUTAN</a> 
                                                    <br/>
                                                    <div class="product_price"> 

               <center><?php echo Html::img('@web/images/sangkutan.png',[ 'width' => 'auto',
                   'height' => '500px']) ?></center></div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="block">
                    <div class="block-content">
                        <h2 class="title"></h2>
                        <div class="excerpt">
                            <div id="w3" class="accordion" role="tablist" aria-multiselectable="true">

                                <a id="heading-w3-0" class="panel-heading" href="#w3-0" role="tab" data-toggle="collapse" data-parent="#w3" aria-expanded="true" aria-controls="w3-0">
                                    <h4 class="panel-title">LAPORAN PENGAJIAN KEMAJUAN (LKP)</h4>
                                </a>
                                <div id="w3-0" class="panel-collapse collapse out" aria-labelledby="heading-w3-0" role="tabpanel"><div class="panel-body">
                                       <table border="0" width="100%">
                                            <tr> 
                                                <td>
                                                    <a class="btn btn-success btn-xs">TATACARA PENGHANTARAN LKP</a> 
                                                    <br/>
                                                    <div class="product_price"> 

               <center><?php echo Html::img('@web/files/Tatacara LKP.png',[ 'width' => 'auto',
                   'height' => '500px']) ?></center></div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="block">
                    <div class="block-content">
                        <h2 class="title"></h2>
                        <div class="excerpt">
                            <div id="w4" class="accordion" role="tablist" aria-multiselectable="true">

                                <a id="heading-w4-0" class="panel-heading" href="#w4-0" role="tab" data-toggle="collapse" data-parent="#w4" aria-expanded="true" aria-controls="w4-0">
                                    <h4 class="panel-title">TUNTUTAN</h4>
                                </a>
                                <div id="w4-0" class="panel-collapse collapse out" aria-labelledby="heading-w4-0" role="tabpanel"><div class="panel-body">
                                       <table border="0" width="100%">
                            <tr> 
                                <td>
                                    <p><i>SEDANG DIKEMASKINI</i></p> <br/><br/> 
                                </td>
                            </tr>
                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </li>
            
            <li>
                <div class="block">
                    <div class="block-content">
                        <h2 class="title"></h2>
                        <div class="excerpt">
                            <div id="w5" class="accordion" role="tablist" aria-multiselectable="true">

                                <a id="heading-w5-0" class="panel-heading" href="#w5-0" role="tab" data-toggle="collapse" data-parent="#w5" aria-expanded="true" aria-controls="w5-0">
                                    <h4 class="panel-title">LAPOR DIRI</h4>
                                </a>
                                <div id="w5-0" class="panel-collapse collapse out" aria-labelledby="heading-w5-0" role="tabpanel"><div class="panel-body">
                                       <table border="0" width="100%">
                            <tr> 
                                <td>
                                    <p><i>SEDANG DIKEMASKINI</i></p> <br/><br/> 
                                </td>
                            </tr>
                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </li>
            
            

        </ul>   

    </div>
</div>
                </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
        <div class="x_title">
            <h5><strong><i class="fa fa-calendar"></i> MAKLUMAN TAKWIM MESYUARAT JAWATANKUASA PENGAJIAN LANJUTAN</strong></h5> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
<!--            <h4><strong>Makluman Takwim Mesyuarat Jawatankuasa Pengajian Lanjutan</strong></h4> -->
        <?php if($model->kakitangan->jawatan->job_category == 1){?>    
    <?php
     
            $dataProvider = new ActiveDataProvider([
                'query' => app\models\cbelajar\TblUrusMesyuarat::find()->where([ 'kategori_id'=>2,'tahun'=>date("Y")]),
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
                                               return 'MESYUARAT JAWATANKUASA PENGAJIAN LANJUTAN AKADEMIK. ' ." ".strtoupper($model->nama_mesyuarat)." ".'(KALI KE -' ." ". strtoupper($model->kali_ke).")";
                                            },
                                        ],

                                [
                                            'label' => 'KATEGORI',
                                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            'value' => function($model) {
                                                if ($model->kategori->id == 1) {
                                                    return 'PENTADBIR';
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
                                               return strtoupper($model->getTarikh($model->tarikh_mesyuarat));
                                            },
                                        ],
                                      
                                        [
                                            'label' => 'TARIKH PENGHANTARAN PERMOHONAN',
                                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            'value' => function($model) {
                                                return strtoupper($model->getTarikh($model->tarikh_buka)). ' - '. strtoupper($model->getTarikh($model->tarikh_tutup)) ;
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
                                                if($model->status == 0)
                                                {
                                                return Html::button('TUTUP', ['class' => 'btn btn-primary btn-xs']);
                                                }
                                                else
                                                {
                                        return '<b><u><a href=' . Url::to(['cbelajar/senarai-borang', 'id' => $model->id]) . '><strong>'.'MOHON'. '</strong></span></b>';
                                                } },
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
            
                <?php }elseif($model->kakitangan->jawatan->job_category == 2){ ?>
                  <?php
     
            $dataProvider = new ActiveDataProvider([
                'query' => app\models\cbelajar\TblUrusMesyuarat::find()->where(['status' => 1, 'kategori_id'=>1]),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
            ?> 
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
                                               return 'MESYUARAT JAWATANKUASA PENGAJIAN LANJUTAN PENTABIRAN. ' ." ".strtoupper($model->nama_mesyuarat)." ".'(KALI KE -' ." ". strtoupper($model->kali_ke).")";
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
                                               return strtoupper($model->getTarikh($model->tarikh_mesyuarat));
                                            },
                                        ],
                                      
                                        [
                                            'label' => 'TARIKH PENGHANTARAN PERMOHONAN',
                                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            'value' => function($model) {
                                                return strtoupper($model->getTarikh($model->tarikh_buka)). ' - '. strtoupper($model->getTarikh($model->tarikh_tutup)) ;
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
                                        return '<b><u><a href=' . Url::to(['cbelajar/senarai-borang', 'id' => $model->id]) . '><strong>'.'MOHON'. '</strong></span></b>';
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
   <?php             }
?>
        </div>
        </div>
   
        
        
    </div>
       
                
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">

        <div class="x_content">  
            <div class="x_title">
            <h5><strong><i class="fa fa-info-circle"></i>  Untuk maklumat lanjut, sila hubungi:</strong></h5> 
            <div class="clearfix"></div>
        </div>
<!--            <table class="table" style="width:100%">
                <thead>
                    <tr>
                        <th colspan="6"><i class="fa fa-info-circle"></i><h5> MAKLUMAT LANJUT, SILA HUBUNGI:</h5></th> 
                    </tr>
                </thead>
            </table>-->
            <div class="col-md-12 col-sm-12 col-xs-12"> 

                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> 

                                  
                                        <tr>
                                            <th class="text-center" style="width:40%">PERKARA</th>
                                            <th class="text-center" style="width:50%">KAKITANGAN</th>
<!--                                            <th class="text-center">TARIKH PENGAJIAN</th>-->
<!--                                            <th class="text-center" style="width: 10%;">TEMPOH PENGAJIAN</th>-->
                                           

                                        </tr>
                                       
<!--                                        <tr>
                                                <td ><ul>
                                                        <li>Urusan Sistem Pengajian Lanjutan</li>
                                                       
                                                     </ul></td>
                                                     <td class="text-justify"><b> Cik Nor Fazleenawana Binti Awang Latiff</b>	 <br/>
                                                    Penolong Pegawai Teknologi Maklumat <br/>
                                                    <i class="fa fa-envelope"></i> norfazleenawana@ums.edu.my</td>
                                               
                                                
                                            </tr>-->

                                            <tr>
                                                <td ><ul>
                                                        <li>Urusan Cuti Belajar/Cuti Sabatikal/Pasca Kedoktoran/Sub-Kepakaran/Program Sangkutan Pentadbiran
                                                        /Latihan Industri (Jurutera Profesional)</li>
                                                      
                                                     </ul></td>
                                                     <td class="text-justify"><b> En Goraid J John</b>	 <br/>
                                                    Pembantu Tadbir (P/O) <br/>
                                                     <i class="fa fa-envelope"></i> goraidj.john@ums.edu.my</td>
                                               
                                                
                                            </tr>
                                            
                                              <tr>
                                                  <td><ul>
                                                      <li>Urusan Saraan Kakitangan Cuti Belajar dan Tajaan Hadiah Latihan KPT & Biasiswa UMS</li>
                                                      <li>Urusan Laporan Kemajuan Pengajian (LKP)</li></ul></td>
                                                      <td class="text-justify"><b> Puan Dayang Nooranizah Mohd Amin <br/>
                                               </b> Pembantu Tadbir (P/O) Kanan <br/>
                                                 <i class="fa fa-envelope"></i> anizah@ums.edu.my

                                                
                                            </tr>
                                            
                                            <tr>
                                                <td><ul><li>Urusan Hal Ehwal Untuk Tindakan Pihak Perundangan <br>
                                                        (Bon Perkhidmatan, Nominal Damages & Pecah Kontrak)</li>
                                                    </ul></td>
                                                    <td class="text-justify"><b>  En Goraid J John</b> <br/> 
                                            Pembantu Tadbir (P/O) <br/>
                                            <i class="fa fa-envelope"></i> goraidj.john@ums.edu.my
                                               
                                                
                                            </tr>

                                            
                       
                                            
                                </table>
         <div class="x_panel">
        <div class="x_content">  
            <strong>
                <table>
                    <tr>
                                                
<!--                        <td>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  

                           
                        </td>-->
                        <td>
                            
                            Ketua Bahagian Sumber Manusia<br/>
                            <strong>Cik Kamisah Husin</strong><br/>
                             <i class="fa fa-envelope"></i> anjangkh@ums.edu.my	<br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 

                        </td>
                        
                        <td>
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  

                           
                        </td>
                        
                         <td>
                            Seksyen Pengembangan Profesionalisme<br/>
                            <strong>Pn. Yanti Binti Yusup</strong><br/>
                            Penolong Pendaftar Kanan<br/>
                            <i class="fa fa-envelope"></i> yantiy@ums.edu.my
                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        </td>
                       
                    </tr>
                </table>
            </strong>  
        </div>
    </div>
    </div>
                           
                            </div>
                        </div>
                    </div>
            
             
        </div>
    </div> 
    

    </div>

 



 


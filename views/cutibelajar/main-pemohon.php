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
      
<!--<marquee class="html-marquee" direction="left" behavior="scroll" scrollamount="6">
    <p>
        SILA KEMASKINI MAKLUMAT PERIBADI, MAKLUMAT AKADEMIK DAN MAKLUMAT KELUARGA ANDA SEBELUM MEMBUAT PERMOHONAN CUTI BELAJAR UNTUK MEMUDAHKAN PROSES PERMOHONAN ANDA. <br> 
    </p>
</marquee>-->
<div class="col-md-12 col-sm-12 col-xs-12">

<div class="x_panel">
        <div class="x_title">
            <h5><strong><i class="fa fa-calendar"></i> Makluman Takwim Mesyuarat Jawatankuasa Pengajian Lanjutan</strong></h5> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
<!--            <h4><strong>Makluman Takwim Mesyuarat Jawatankuasa Pengajian Lanjutan</strong></h4> -->
            <?php
            $dataProvider = new ActiveDataProvider([
                'query' => app\models\cbelajar\TblUrusMesyuarat::find()->where(['status' => 1, 'kategori_id'=>2]),
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
                                        return '<b><u><a href=' . Url::to(['cbelajar/senarai-borang', 'id' => $model->id]) . '>'.'Lihat'. '</span></b>';
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

<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel" id="rcorners2">
<!--         <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
         </div>-->
         <div class="x_content">
             
<?php
  echo Html::a(Yii::t('app','<i class="fa fa-address-card"></i> <span class="label label-success">REKOD PENGAJIAN LANJUTAN</span>'), ['pemohonview?id='.$model->icno], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="glyphicon glyphicon-align-right"></i> <span class="label label-success">LAPORAN KEMAJUAN KURSUS</span>'), ['/lkk/senarailkk'], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-suitcase"></i> <span class="label label-success">LAPOR DIRI TAMAT PENGAJIAN</span>'), ['/lapordiri/borang'], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-check"></i> <span class="label label-success">SEMAKAN PERMOHONAN</span>'), ['/cbelajar/senarai'], ['class' => 'btn btn-default btn-lg']);

?>
         </div>
    </div>
</div>
</div>
  </div>
 <div class="col-md-6 col-sm-4 col-xs-12" >

<div class="x_panel" id="rcorners1">
    <div class="x_content" >
        <h4><i class="fa fa-user-circle"></i><strong> Maklumat Diri</strong>   <hr></h4>
                        Gred / Jawatan: <?=  ($biodata->jawatan->nama) ." ". ($biodata->jawatan->gred) ?><br/>
                        Emel: <?= $biodata->COEmail;?><br/>
                        Tempoh Berkhidmat Semasa:<?=  $biodata->tempohkhidmat ?><br/>
                        Status: <?= $biodata->Status ? $biodata->serviceStatus->ServStatusNm : 'Not Set' ?><br/>
                        
                        
                           
                        </tr>
        </div>
        
    </div>
    </div>
 

<div class="col-md-6 col-sm-4 col-xs-12">

<div class="x_panel" id="rcorners1">
    <div class="x_content">
        <h4><I class="fa fa-bookmark-o"></i><strong> Laporan Kemajuan Kursus (LKK)</strong>   <hr></h4>
                     
                        
                           
                    <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">SEMESTER </th>
<!--                        <th class="column-title text-center">TARIKH HANTAR LAPORAN</th>-->
                        <th class="column-title text-center">TINDAKAN</th>
<!--                        <th class="column-title text-center">STATUS</th>-->

                    </tr>
                </thead>
                <tbody>
                    <?php 
                    
                    
                     $sem = app\models\cbelajar\TblLkk::Semlkk($model->icno);
                    if($sem)
                    {
                    for ($i = 1; $i <= $sem; $i++)
                    {
                       ?>  <tr>
                            
                             <td style="width:30%;"> <?= $i;?>  </td>
                             <td> 
                                <?php echo Html::a('HANTAR LAPORAN', ['lkk/borang-permohonan'], ['class' => 'btn btn-success btn-xs', 'title' => 'Hantar']); ?>
                             </td>

            </tr><?php 
                    }
                    }
                       else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center">Tiada Rekod Pengajian</td>                     
                        </tr>
<?php }
?>
                </tbody>
            </table>
           
                    </div>
        </div>
        
    </div>
    </div>

  

<!--    <div class="x_panel">
        <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
            <div class="clearfix"></div>
        </div>
       

 <div class="x_content"> 


            <div class="row">
                <div class="col-xs-12 col-md-3">
                    <?php//
                    //$resume = \yiister\gentelella\widgets\StatsTile::widget(
//                                    [
//                                        'icon' => 'address-card',
//                                        'header' => 'Rekod',
//                                        'text' => 'Pengajian Lanjutan',
//                                        'number' => '1',
//                                    ]
//                    );
//                    echo Html::a($resume, ['pemohonview?id='.$model->icno]);
//         ?>

                </div>


                 <div class="col-xs-12 col-md-3">
                    <?php
//                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
//                                    [
//                                        'icon' => 'align-right',
//                                        'header' => 'LKK',
//                                        'text' => 'Laporan Kemajuan Kursus',
//                                        'number' => '2',
//                                    ]
//                    );
//                    echo Html::a($semakan, ['lkk/senarailkk']);
                    ?>
           </div>
                <div class="col-xs-12 col-md-3">
                    <?php
//                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
//                                    [
//                                        'icon' => 'edit',
//                                        'header' => 'Lapor Diri',
//                                        'text' => 'Tamat Pengajian Lanjutan',
//                                        'number' => '3',
//                                    ]
//                    );
//                    echo Html::a($semakan, ['#']);
                    ?>
           </div>
            
                
               
       </div>

                


        </div>
    </div>-->


  </div>

    
  </div>


 


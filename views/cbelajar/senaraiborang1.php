<?php



use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$title = $this->title = 'Muatnaik Dokumen';
?> 
<div class="col-md-12 col-sm-12 col-xs-12">
<?php echo $this->render('/cutibelajar/_topmenu'); ?>
        <div class="x_panel">
        <div class="x_title">
          <h4><strong>Jenis - Jenis Permohonan</strong></h4> 
            <div class="clearfix"></div>
        </div>

<div class="x_content"> 


            <div class="row">
                <div class="col-xs-12 col-md-3">
                    <?php
                    $resume = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list-alt',
                                        'header' => 'Akademik',
                                        'text' => 'Permohonan Baharu',
                                        'number' => '1',
                                    ]
                    );
//                    echo Html::a($resume, ['view-data-pemohon?ICNO='.$model->icno]);
                echo Html::a($resume, ['cbelajar/senarai-borang?id='.$iklan->id.'&page=permohonan-baharu']);
//                    'view-data-pemohon?ICNO='.$biodata->ICNO.'&page=cuti-sabatikal'

                    ?>

                </div>
                <div class="col-xs-12 col-md-3">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'clock-o',
                                        'header' => 'Pelanjutan',
                                        'text' => 'Tempoh Cuti Belajar',
                                        'number' => '2',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['cbelajar/borang-lanjutan?id='.$iklan->id.'&page=permohonan-lanjutan']);
                    ?>
                </div>
 <div class="col-xs-12 col-md-3">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'file',
                                        'header' => 'Lain - Lain',
                                        'text' => 'Permohonan',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($semakan, ['cbelajar/lain-lain-permohonan?id='.$iklan->id.'&page=lain-lain-permohonan']);
                    ?>
           </div>
                 <div class="col-xs-12 col-md-3">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'align-right',
                                        'header' => 'LKK',
                                        'text' => 'Laporan Kemajuan Kursus',
                                        'number' => '4',
                                    ]
                    );
                    echo Html::a($semakan, ['permohonan-semasa']);
                    ?>
           </div>
                
            
                
               
       </div>

                


        </div>
</div>


            <div class="x_panel">
<!--     <div class="row">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['cutibelajar/halaman-utama-pemohon']) ?></li>
        <li>Muat Naik Dokumen</li>
    </ol>
</div>-->
  
                
                   
                <div class="x_content"> 
                         <?php
                            $dataProvider = new ActiveDataProvider([
                                'query' => \app\models\cbelajar\RefBorang::find()->where(['status' => 1]),
                                'pagination' => [
                                    'pageSize' => 10,
                ],
            ]);
            ?> 
                   
                    <h4><strong>MESYUARAT JAWATANKUASA PENGAJIAN LANJUTAN KALI KE- BIL. <?= $iklan->nama_mesyuarat?></strong></h4>
                    <p align='right'><h2><span class="label label-danger">Tarikh Permohonan: <?= $iklan->tarikhbuka ?> - <?= $iklan->tarikhtutup ?> </span> </h2>
                    <div class="table-responsive ">
                        
                        <?=
                            
                        GridView::widget([
                            'dataProvider' => $senarai_dokumen,
                            'options' => ['style' => 'width:100%'],
                            'layout' => "{items}\n{pager}",
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                

                                        [
                                            'label' => 'Nama Borang',
                                            'value' => function($model) {
                                               return  $model->jenisBorang;
                                            },
                                        ],

                                        [
                                            'header' => 'Tindakan',
                                            'class' => 'yii\grid\ActionColumn',
                                            'template' => '{mohon}',
                                            'buttons' => [
                                                'mohon' => function($url, $model, $key) use ($iklan)
                                                {
                                                    if ($model->checkPermohonanLanjutan($iklan->id))  {
                                                        $url = Url::to(['lanjutancb/lihat-permohonan', 'id' => $iklan->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                       return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
                                                            'title' => 'Lihat Permohonan']);
                                                    } 
                                                  elseif($model->checkSimpanBorang($iklan->id))
                                                    {
                                                        $url = Url::to(['lanjutancb/borang-permohonan', 'id' => $iklan->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                       return Html::a('<i class="fa fa-paper-plane" style="color: orange"></i>', $url, [
                                                            'title' => 'Hantar Permohonan']);
                                                  }
                                                    else{
                                                         $url = Url::to(['lanjutancb/borang-permohonan', 'id' => $iklan->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                        return Html::a('MOHON', ['lanjutancb/borang-permohonan', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg"></i>', $url, [
//                                                            'title' => 'Mohon Cuti Belajar']);
                                                    }
                                                }
                                        ],
                                            'contentOptions' => ['class' => 'text-center'],
                                        ]
                                        

//                                         [
//                                            'header' => 'TINDAKAN',
//                                            'class' => 'yii\grid\ActionColumn',
//                                            'template' => '{muatnaik}',
//                                            'buttons' => [
//                                                'muatnaik' => function($url, $model, $key) use ( $iklan)
//                                                {
//                                                    if ($model->checkUpload($model->idBorang, $iklan->id)) {
//                                                        return '<i class="fa fa-check-circle fa-lg" aria-hidden="true" style="color: green"></i>';
//                                                    } else {
//                                                        return Html::a('Muatnaik', ['muat-naik-dokumen-cb', 'id' => $model->id,'iklan_id' => $iklan->id], ['class' => 'btn  btn-primary btn-xs']);
//                                                    }
//                                                }
//                                        ],
                                                
//                                        
//                                          'contentOptions' => ['class' => 'text-center'],
//                                        ],
//                                                    

                                        // [
                                        //     'label' => 'Status',
                                            
                                        // ],

                                            ],
                                        ]);

                                           
                                     
                                        ?>
                                    </div>
                           
</div>
               
<ul>
                <li><i class="fa fa-paper-plane fa-lg" style="color: orange"></i>: <span class="label label-primary">Simpan dan Hantar Permohonan</span></li>
                <li><i class="fa fa-check-square-o fa-lg" style="color: green"></i> : <span class="label label-success">Permohonan telah dihantar</span> </li> 
            </ul>
</div>
    
   <div class="x_panel">
        <div class="x_title">
            <h4><strong>Status Permohonan Pelanjutan Cuti Belajar</strong></h4>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center" >BIL </th>
                        <th class="column-title text-center">JENIS PERMOHONAN</th>
                        <th class="column-title text-center">TARIKH PERMOHONAN</th>
                        <th class="column-title text-center">TARIKH DIPERAKUKAN KETUA JABATAN</th>
                        <th class="column-title text-center">TARIKH DILULUSKAN BSM</th>
                        <th class="column-title text-center">STATUS</th>
                        <th class="column-title text-center">SALINAN SURAT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $bil=1;
                    if($status){
                    foreach ($status as $statuss) { 
                        ?>
                        <tr>
                            <td style="width:10%;"><?= $bil++; ?></td>
                            <td style="width:10%;"><?= $statuss->borang->alt; ?></td>
                            <td style="width:15%;"><?= $statuss->tarikh_mohon; ?></td>
                            <td style="width:15%;"><?= $statuss->app_date; ?></td>
                            <td style="width:15%;"><?= $statuss->ver_date;?></td>
                            <td style="width:20%;"><?= $statuss->statuss; ?></td>
                            <td style="width:40%;">
                                <?php if($statuss->status == 'LULUS'){?>
                                <div class="container" align="center">
                                    <button type="button" style="border:none; background-color: transparent;" data-toggle="collapse" data-target='#demo<?php echo $statuss->id?>'><i class="fa fa-chevron-up"></i></button>
                                <div id='demo<?php echo $statuss->id?>' class="collapse" style="text-align: left; padding-left: 10%;">
                                <?php if($statuss->dokumen->dokumen){ ?>
                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($statuss->dokumen->dokumen), true); ?>" target="_blank" ><i class="fa fa-download"></i> <?= ucwords(strtolower($statuss->dokumen->tajuk))?></a><br>
                                <?php }
                                
                                ?><br>
                                </div>
                              </div>
                                  </td>
                            <?php }?>
                           
                           
                          
                        </tr>
                    <?php }} ?>
                </tbody>
            </table>
            <ul>
                <li><span class="label label-info">Dalam Tindakan KJ</span> : Menunggu perakuan dari Dekan / Ketua Jabatan</li>
                <li><span class="label label-primary">Dalam Tindakan BSM</span> : Menunggu kelulusan dari BSM</li>
                <li><span class="label label-success">Berjaya</span> : Diluluskan</li> 
                <li><span class="label label-danger">Ditolak</span> : Tidak Diluluskan</li>
            </ul>
        </div>
        </div>
    </div>
</div>

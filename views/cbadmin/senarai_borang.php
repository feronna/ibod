<?php



use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$title = $this->title = 'Muatnaik Dokumen';
?> 

<?php echo $this->render('/cutibelajar/_topmenu'); ?>


    <div class="x_panel">
   <h5 align="center"><strong>MESYUARAT JAWATANKUASA PENGAJIAN LANJUTAN KALI KE- BIL. <?= $iklan->nama_mesyuarat?></strong></h5>
                    <p ><h5 align="center"><span class="label label-danger">Tarikh Permohonan: <?= $iklan->tarikhbuka ?> - <?= $iklan->tarikhtutup ?> </span> </h5>
</div>
               
                    <div class="x_panel">

                <div class="x_content"> 
                         <?php
                            $dataProvider = new ActiveDataProvider([
                                'query' => \app\models\cbelajar\RefBorang::find()->where(['status' => 1]),
                                'pagination' => [
                                    'pageSize' => 10,
                ],
            ]);
            ?> 
                    <div class="table-responsive ">
                       
                            <h5><strong><i class="fa fa-list"></i> Permohonan Baharu Pengajian Lanjutan</strong></h5>
                       
                        <?=
                            
                        GridView::widget([
                            'dataProvider' => $senarai_dokumen,
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
                                               return  $model->jenisBorang;
                                            },
                                                    
                                        ],

                                        [
                                            'header' => 'Tindakan',
    'headerOptions' => ['style' => 'width:20%'],
                                            
                                            'class' => 'yii\grid\ActionColumn',
                                            'template' => '{mohon}',
                                            'buttons' => [
                                                'mohon' => function($url, $model, $key) use ($iklan, $model2, $model3)
                                                {
//                                                    $id = $model3->id;
                                                 if ($model->kategori->id == 1) {
                                                   
                                                    if (($model->id == 28) &&($model->checkPermohonan($iklan->id, $model->id)))  {
                                                        $url = Url::to(['cutibelajar/lihat-permohonan', 'id'=>$model3->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                       return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
                                                            'title' => 'Lihat Permohonan', 'id' => $model->id]);
                                                    } 
                                                    elseif (($model->id == 29) &&($model->checkPermohonan($iklan->id, $model->id)))  {
                                                        $url = Url::to(['cutisabatikal/lihat-permohonan', 'id'=>$model2->id]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                       return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
                                                            'title' => 'Lihat Permohonan', 'id'=> $model->id]);
                                                    } 
//                                                     elseif (($model->id == 32) &&($model->checkPermohonan($iklan->id, $model->id)))  {
//                                                        $url = Url::to(['cbadmin/pemohon/lihat-permohonan', 'id'=>$model2->id]);
////                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
//                                                       return Html::a('<i class="fa fa-check-square-o fa-lg" style="color: green"></i>', $url, [
//                                                            'title' => 'Lihat Permohonan', 'id'=> $model->id]);
//                                                    } 
                                                    elseif(($model->id == 28) &&($model->checkSimpan($iklan->id, $model->id)))
                                                    {
                                                        $url = Url::to(['cutibelajar/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                       return Html::a('<i class="fa fa-paper-plane fa-lg" style="color: orange"></i>', $url, [
                                                            'title' => 'Hantar Permohonan']);
                                                    }
                                                    elseif(($model->id == 29) &&($model->checkSimpan($iklan->id, $model->id)))
                                                    {
                                                        $url = Url::to(['cutisabatikal/pengakuan-pemohon', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                       return Html::a('<i class="fa fa-paper-plane fa-lg" style="color: orange"></i>', $url, [
                                                            'title' => 'Hantar Permohonan']);
                                                    }
//                                                     elseif(($model->id == 32) &&($model->checkSimpan($iklan->id, $model->id)))
//                                                    {
//                                                        $url = Url::to(['cbadmin/pemohon/pengakuan-pemohon', 'id' => $iklan->id,]);
////                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
//                                                       return Html::a('<i class="fa fa-paper-plane fa-lg" style="color: orange"></i>', $url, [
//                                                            'title' => 'Hantar Permohonan']);
//                                                    }
                                                   
                                                    else{
                                                      if ($model->id == 28)
                                                         {
                                                        $url = Url::to(['cbelajar/gambar', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                        return Html::a('MOHON', ['cbadmin/pemohon/gambar', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg"></i>', $url, [
//                                                            'title' => 'Mohon Cuti Belajar']);
                                                    }
                                                    elseif ($model->id == 29)
                                                         {
                                                        $url = Url::to(['cutisabatikal/gambar', 'id' => $iklan->id,]);
//                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
                                                        return Html::a('MOHON', ['cutisabatikal/gambar', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
                                                    }
//                                                     elseif ($model->id == 32)
//                                                         {
//                                                        $url = Url::to(['cbadmin/pemohon/gambar', 'id' => $iklan->id,]);
////                                                        return Html::a('<i class="fa fa-info-circle fa-lg">', ["pengakuan-pemohon", 'id' => $model->id]);
//                                                        return Html::a('MOHON', ['cbadmin/pemohon/gambar', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-xs']);
//                                                    }
                                                }
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
               
  

                
               


<div class="x_panel">
    
    <ul>
                <li><i class="fa fa-save fa-lg" style="color: orange"></i>: <span class="label label-primary">Simpan dan Hantar Permohonan</span></li>
                <li><i class="fa fa-check-square-o fa-lg" style="color: green"></i> : <span class="label label-success">Permohonan telah dihantar</span> </li> 
            </ul>
</div>
                    </div>


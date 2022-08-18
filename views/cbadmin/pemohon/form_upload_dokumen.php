<?php



use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$title = $this->title = 'Muatnaik Dokumen';
?> 
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12"> 
<?php echo $this->render('/cutibelajar/_topmenu'); ?>
<div class="x_panel">
<div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | BAHAGIAN SUMBER MANUSIA<br/><u> 
     PERMOHONAN BAHARU PENGAJIAN LANJUTAN PENTADBIRAN
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div>
</div>
<?php echo $this->render('_menu', ['title' => $title, 'id'=>$iklan->id]) ?>
<!-- <div class="col-md-12">
    <?php echo $this->render('/cbelajar/menu'); ?>
</div> -->

<div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
       
  
                <div class="x_title">
                    <h2>Senarai Dokumen Yang Perlu Dimuat Naik</h2><p align="right"><?= Html::a('Lihat Dokumen Yang Telah Dimuatnaik', ['senarai-dokumen-dimuatnaik', 'id'=> $iklan->id], ['class' => 'btn btn-primary btn-sm']) ?></p> 
                    <div class="clearfix"></div>
                </div>
               
                
                   
                <div class="x_content"> 
                         <?php
                            $dataProvider = new ActiveDataProvider([
                                'query' => app\models\cbelajar\TblDokumen::find()->where(['status' => 1, 'kategori'=>2]),
                                'pagination' => [
                                    'pageSize' => 10,
                ],
            ]);
            ?> 
                    <h4><strong>DOKUMEN PERIBADI BAGI PERMOHONAN PENGAJIAN LANJUTAN</strong></h4>
                    <div class="table-responsive ">        
                        <?=
                        GridView::widget([
                            'dataProvider' => $senarai_dokumen,
                            'options' => ['style' => 'width:100%'],
                            'layout' => "{items}\n{pager}",
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn',  'header' => 'BIL.'],
                                

                                        [
                                            'label' => 'NAMA DOKUMEN',
                                            'value' => function($model) {
                                               return  $model->nama_dokumen;
                                            },
                                        ],

                                        

//                                         [
//                                            'header' => 'TINDAKAN',
//                                            'class' => 'yii\grid\ActionColumn',
//                                                'headerOptions' => ['style' => 'width:30%'],
//
//                                            'template' => '{muatnaik}',
//                                            'buttons' => [
//                                                'muatnaik' => function($url, $model, $key) use ( $iklan)
//                                                {
//                                                    if ($model->checkUpload($model->id, $iklan->id)) {
//                                                        return '<i class="fa fa-check-circle fa-lg" aria-hidden="true" style="color: green"></i>';
//                                                    } else {
//                                                        return Html::a('Muatnaik', ['muat-naik-dokumen-cb', 'id' => $model->id,'iklan_id' => $iklan->id], ['class' => 'btn  btn-primary btn-xs']);
//                                                    }
//                                                }
//                                        ],
//                                                
//                                        
//                                          'contentOptions' => ['class' => 'text-center'],
//                                        ],
                                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    //'attribute' => 'CONm',
                                    'header' => 'TINDAKAN',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'template' => '{update}',
                                    //'header' => 'TINDAKAN',
                                    'buttons' => [
                                        'update' => function ($url, $model) use ($iklan) {
                                            if ($model->checkUpload($model->id, $iklan->id)) {
                                                return
                                                        '<i class="fa fa-check-circle fa-lg" aria-hidden="true" style="color: green"></i>';
                                            } else {
                                                $url = Url::to(['muat-naik-dokumen-cb', 'id' => $model->id, 'iklan_id' => $iklan->id]);
                                                return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-primary btn-xs modalButton']);
                                            }
                                        },
                                            ],
                                        ],
                                        [
                                            'label' => 'MUAT TURUN',
                                            'format' => 'raw',
                                            'headerOptions' => ['class' => 'text-center'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'value' => function ($data) {

                                        if ($data->sokongan) {
                                            return Html::a('', (Yii::$app->FileManager->DisplayFile($data->sokongan->namafile)), ['class' => 'fa fa-download fa-lg', 'target' => '_blank']);
                                        } else {
                                            return '<b><small>TIADA BUKTI</small></b>';
                                        }
                                    },
                                        ],
                                                    

                                        // [
                                        //     'label' => 'Status',
                                            
                                        // ],

                                            ],
                                        ]);

                                           
                                     
                                        ?>
                                    </div>
                           
</div>
               

</div>
   
</div>
</div>
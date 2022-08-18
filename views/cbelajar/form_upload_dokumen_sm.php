<?php

$js=<<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$title = $this->title = 'Muat Naik Dokumen';
?> 
<div class="row">
<?php echo $this->render('_menusm', ['title' => $title, 'id'=>$iklan->id]) ?>
<!-- <div class="col-md-12">
    <?php echo $this->render('/cbelajar/menu'); ?>
</div> -->

<div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
     <div class="row">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['cutibelajar/halaman-pemohon']) ?></li>
        <li>Muat Naik Dokumen</li>
    </ol>
</div>
                
                <div class="x_title">
                    <h2>Senarai Dokumen Yang Perlu Dimuat Naik</h2><p align="right"><?= Html::a('Lihat Dokumen Yang Telah Dimuatnaik', ['senarai-dokumen-separuh-masa', 'id'=> $iklan->id], ['class' => 'btn btn-primary btn-sm']) ?></p> 
                    <div class="clearfix"></div>
                </div>
                <div class="table-responsive">

                    <table class="table table-sm jambo_table table-striped">
                        
                        <tr>
                              <th style="color: red;">Garis Panduan Menyediakan Kertas Cadangan Penyelidikan  </th>
                          <td style="color: green;"><a href="<?php echo Url::to('@web/'.'uploads-cutibelajar/cbelajar/dokumen/6. FORMAT CADANGAN PENYELIDIKAN DAN PELAN PENGAJIAN.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br> 
                                </td>
                        
                        </tr>
                    </table>
  </div>
                   
                <div class="x_content"> 
                         <?php
                            $dataProvider = new ActiveDataProvider([
                                'query' => app\models\cbelajar\TblDokumen::find()->where(['status' => 1]),
                                'pagination' => [
                                    'pageSize' => 10,
                ],
            ]);
            ?> 
                    <h4><strong>DOKUMEN SOKONGAN BAGI PERMOHONAN PENGAJIAN LANJUTAN (WAJIB)</strong></h4>
                    <div class="table-responsive ">        
                        <?=
                        GridView::widget([
                            'dataProvider' => $senarai_dokumen,
                            'options' => ['style' => 'width:100%'],
                            'layout' => "{items}\n{pager}",
                            
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn',
                            'headerOptions' => ['style' => 'width:5%'],
                            'header' => 'BIL.'],
                                

                                        [
                                            'label' => 'NAMA DOKUMEN',
                                            'value' => function($model) {
                                               return  $model->nama_dokumen;
                                            },
                                        ],

                                        

//                                         [
//                                            'header' => 'TINDAKAN',
//                                            'class' => 'yii\grid\ActionColumn',
//                                            'template' => '{muatnaik}',
//                                            'buttons' => [
//                                                'muatnaik' => function($url, $model, $key) use ( $iklan)
//                                                {
//                                                    if ($model->checkUpload($model->id, $iklan->id)) {
//                                                        return '<i class="fa fa-check-circle fa-lg" aria-hidden="true" style="color: green"></i>';
//                                                    } else {
//                                                          return Html::button(' <i class="fa fa-edit fa-xs" aria-hidden="true"></i>', 
//                                                    ['id' => 'modalButton',
//                                                    'value' => \yii\helpers\Url::to(['muat-naik-dokumen-sm?id=' . 'id' => $model->id,'iklan_id' => $iklan->id]),
//                                                    'class' => 'btn btn-primary btn-xs mapBtn']);      
////                                                        return Html::a('Muatnaik', ['muat-naik-dokumen-cb', 'id' => $model->id,'iklan_id' => $iklan->id], ['class' => 'btn  btn-primary btn-xs']);
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
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{update}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $model) use ($iklan){
                                                if ($model->checkUpload($model->id, $iklan->id)) {
                                                        return
                                                    '<i class="fa fa-check-circle fa-lg" aria-hidden="true" style="color: green"></i>';
                                                    } 
                                                    else{
                                    $url = Url::to(['muat-naik-dokumen-sm', 'id' => $model->id,'iklan_id' => $iklan->id]);
                                    return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-primary btn-xs modalButton']);
                                                    }
                                },
                            ],
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
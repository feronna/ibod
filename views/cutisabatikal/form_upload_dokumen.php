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
<div class="x_content">  
 <span class="required" style="color:#062f49;">
<center> <h2><strong><?= strtoupper('
CUTI SABATIKAL /LATIHAN INDUSTRI (JURUTERA PROFESIONAL) '); ?>
                        </strong></h2> </center>
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
                <div class="table-responsive">

                    <table class="table table-sm jambo_table table-striped"> 
                          <tr>
                              <th style="color: red;">Garis Panduan Menyediakan Kertas Cadangan Penyelidikan / Latihan / Sangkutan  </th>
                          <td style="color: green;"><a href="<?php echo Url::to('@web/'.'uploads-cutibelajar/cbelajar/dokumen/GARIS PANDUAN MENYEDIAKAN KERTAS CADANGAN CUTI SABATIKAL.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br> 
                                </td>
                        
                        </tr>
                    </table>
  </div>
                   
                <div class="x_content"> 
                         <?php
                            $dataProvider = new ActiveDataProvider([
                                'query' => app\models\cbelajar\TblDokumenSabatikal::find()->where(['status' => 1]),
                                'pagination' => [
                                    'pageSize' => 10,
                ],
            ]);
            ?> 
                    <h4><strong>DOKUMEN BAGI PERMOHONAN CUTI SABATIKAL / LATIHAN INDUSTRI</strong></h4>
                    <div class="table-responsive ">        
                        <?=
                        GridView::widget([
                            'dataProvider' => $senarai_dokumen,
                            'options' => ['style' => 'width:100%'],
                            'layout' => "{items}\n{pager}",
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                

                                        [
                                            'label' => 'NAMA DOKUMEN',
                                            'value' => function($model) {
                                               return  $model->nama_dokumen;
                                            },
                                        ],

                                        

                                         [
                                            'header' => 'TINDAKAN',
                                            'class' => 'yii\grid\ActionColumn',
                                            'template' => '{muatnaik}',
                                            'buttons' => [
                                                'muatnaik' => function($url, $model, $key) use ( $iklan)
                                                {
                                                    if ($model->checkUpload($model->id, $iklan->id)) {
                                                        return '<i class="fa fa-check-circle fa-lg" aria-hidden="true" style="color: green"></i>';
                                                    } else {
                                                        return Html::a('Muatnaik', ['muat-naik-dokumen', 'id' => $model->id,'iklan_id' => $iklan->id], ['class' => 'btn  btn-primary btn-xs']);
                                                    }
                                                }
                                        ],
                                                
                                        
                                          'contentOptions' => ['class' => 'text-center'],
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

<?php
//use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

?>
<?php echo $this->render('/cutibelajar/_topmenu'); ?>
 <div class="x_panel">
      
 <div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
        <h2><strong><i class="fa fa-list"></i> Senarai Permohonan Pengajian Lanjutan</strong></h2>
    <div class="clearfix"></div>
    </div> 
    <div class="row"> 
    <div class="x_content">
    <div class="table-responsive">
                    
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
                    'class' => 'table-responsive',
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => [
                        ['class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',

                            ],
 
                        [
                            'label' => 'Jenis Permohonan',
                            'value' => 'borang.alt'.'',
                            'format'=>'raw',
                            'hAlign' => 'center',
                        ],
                        [
                            'label' => 'Tarikh Mohon',
                            'value' => 'tarikh_m',
                            'format'=>'raw',
                            'hAlign' => 'center',
                        ],

                        [
                            'header' => 'Status',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'attribute' => function ($data){
                             if ($data->status_bsm == 'LULUS'|| $data->status_bsm == 'TIDAK LULUS' ) {
                                 return $data->statuss;
                             }else{
                                 return $data->statuss;
                             }
                            }
                        ],
                        [
                            'header' => 'Tindakan',
                            'format'=>'raw',
                            'hAlign' => 'center',
                            'value'=>function ($data) {
                            
                            if($data->status == "LULUS" && $data->terima1 == NULL){
    
                                    
                            return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['cbelajar/terima', 'id' => $data->id]),'style'=>'background-color: transparent; 
                            border: none;', 'class' => 'fa fa-eye fa-xs mapBtn' , 'data-toggle'=>'tooltip', 
                            'title'=>'Terima Tawaran']).$data->terima1;                                                    
}
//                            elseif ($data->terima== "Ya"){
//                            return Html::a('<i class="fa fa-check fa-lg">', ["/cbelajar/view-semakan-syarat", 'id' => $data->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
//                        }
                         
                           else{
//                                <?= Html::a('Kembali', ['cutibelajar/index'], ['class' => 'btn btn-primary btn-sm']) 
                            return Html::a('Mohon Tiket', ['tiketpenerbangan/borang-permohonan'],  ['class' => 'btn btn-primary btn-sm', 'target' => '_blank']);
//                                return "fg";                            }                              
                            }
                            } 
                        ],
                                 
                            [
                            'header' => 'Salinan Surat',
                            'format'=>'raw',
                            'hAlign' => 'center',
                            'attribute'=>function ($data) {
                            if($data->status == 'LULUS'){
                                return Html::a('',Url::to(Yii::$app->FileManager->DisplayFile($data->dokumen->dokumen), true), ['class'=>'fa fa-download', 'target' => '_blank']) ; 
                                }
                            }
                        ],
                                
                           

 
                        ],
                    ]);
                    ?>
                  
<!--                    <ul>
                        <li><span class="label label-warning">Baru</span> : Permohonan Baru</li>
                        <li><span class="label label-primary">Dalam Tindakan Pegawai BSM</span> : Menunggu perakuan dari BSM</li>
                        <li><span class="label label-info">Dalam Tindakan KJ BSM</span> : Menunggu kelulusan dari Ketua Jabatan</li>
                        <li><span class="label label-default">Arahan Bayaran Kepada Bendahari</span> : Menunggu tindakan dari Bendahari</li>
                        <li><span class="label label-success">BERJAYA / EFT</span> : Telah di EFT</li> 
                        <li><span class="label label-danger">Ditolak</span> : Tidak Diluluskan</li>
                    </ul>-->
                </div> 
    </div>
    </div>
            </div>
       
        </div> 
    </div>

<div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <p align="right">  <?= Html::a('Kembali', ['cutibelajar/index'], ['class' => 'btn btn-primary btn-sm']) ?></p>

            <div class="clearfix"></div>
        </div>
</div>


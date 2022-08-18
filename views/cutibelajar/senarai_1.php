<?php
//use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;

?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86], 'vars' => []]); ?>
 <div class="x_panel">
 <div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
        <h2><strong><i class="fa fa-list"></i> Senarai Permohonan Kemudahan</strong></h2>
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
                            'value' => 'displayjenis.kemudahan'.'',
                            'format'=>'raw',
                            'hAlign' => 'center',
                        ],
                        [
                            'label' => 'Tarikh Mohon',
                            'value' => 'entrydate',
                            'format'=>'raw',
                            'hAlign' => 'center',
                        ],

                        [
                            'header' => 'Status',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'attribute' => function ($data){
                             if ($data->stat_bendahari == 'EFT'|| $data->status_pp == 'MENUNGGU KELULUSAN' ) {
                                 return $data->statuss;
                             }else{
                                 return $data->stat_kj;
                             }
                            }
                        ],
                            [
                            'header' => 'Tindakan',
                            'format'=>'raw',
                            'hAlign' => 'center',
                            'attribute'=>function ($data) {
                            if($data->isActive2 == '1' && $data->jeniskemudahan == '3'){
                                return Html::a('', ['borang/skelulusan', 'id' => $data->id], ['class'=>'fa fa-download', 'target' => '_blank']) ; 
                                }
                            }
                        ],

 
                        ],
                    ]);
                    ?>
                  
                    <ul>
                        <li><span class="label label-warning">Baru</span> : Permohonan Baru</li>
                        <li><span class="label label-primary">Dalam Tindakan Pegawai BSM</span> : Menunggu perakuan dari BSM</li>
                        <li><span class="label label-info">Dalam Tindakan KJ BSM</span> : Menunggu kelulusan dari Ketua Jabatan</li>
                        <li><span class="label label-default">Arahan Bayaran Kepada Bendahari</span> : Menunggu tindakan dari Bendahari</li>
<!--                        <li><span class="label label-success">BERJAYA / EFT</span> : Telah di EFT</li> -->
                        <li><span class="label label-danger">Ditolak</span> : Tidak Diluluskan</li>
                    </ul>
                </div> 
    </div>
    </div>
            </div>
       
        </div> 
    </div>
</div>
</div>


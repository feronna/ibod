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
                             if ($data->status == 'LULUS'|| $data->status == 'TIDAK LULUS' ) {
                                 return $data->statuss;
                             }else{
                                 return $data->status_jfpiu;
                             }
                            }
                        ],
                            [
                            'header' => 'Tindakan',
                            'format'=>'raw',
                            'hAlign' => 'center',
                            'attribute'=>function ($data) {
                            if( $data->idBorang == '3'){
                                return Html::a('', ['borang/skelulusan', 'id' => $data->id], ['class'=>'fa fa-download', 'target' => '_blank']) ; 
                                }
                            }
                        ],

 
                        ],
                    ]);
                    ?>
                  
                    <ul>
                        <li><span class="label label-primary">Dalam Tindakan Pegawai BSM</span> : Menunggu perakuan dari BSM</li>
                        <li><span class="label label-info">Dalam Tindakan KJ BSM</span> : Menunggu kelulusan dari Ketua Jabatan</li>
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


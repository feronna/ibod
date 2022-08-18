<?php
  
use kartik\grid\GridView;

?>
 
<?= $this->render('menu') ?> 
<div class="x_panel">
<div class="row">
<div class="col-md-12 col-xs-12"> 
    
    <div class="x_panel">
    <div class="row"> 
    <div class="x_content">
    <div class="table-responsive">
                    
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                    'beforeHeader' => [
                        [
                            'columns' => [],
                            'options' => ['class' => 'skip-export'] // remove this row from export
                        ]
                    ],
                    'toolbar' => [
//                                '{export}',
//                                '{toggleData}'
                    ],
                    'bordered' => true,
                    'striped' => false,
                    'condensed' => false,
                    'responsive' => true,
                    'hover' => true,
                    'panel' => [
                        'type' => GridView::TYPE_DEFAULT,
                        'heading' => '<h2>Semakan Permohonan</h2>',
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                                            'header' => '#',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                                            ],
                        [
                            'label' => 'Nama Pemohon',
                            'value' => 'biodata.CONm',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ],
                        
                        [
                            'label' => 'Tarikh Mohon',
                            'value' => 'entrydt',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ],
                        [
                            'label' => 'Jenis Kad',
                            'value' => 'kadPekerja.card_type',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ],
                        [
                            'label' => 'Status Permohonan',
                            'format' => 'raw',
                            'value' => 'status',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ],
                        
                       
 

                    ],
                ]); ?>
                  
                         
                    </div> 
                  </div>
               </div>
            </div>
        <div class="x_content"> 
        <ul>
            <!--<li><span class="label label-warning">Pending Payment</span> : Status pembayaran belum lengkap.</li>-->
            <li><span class="label label-warning">Baru</span> : Permohonan Baru.</li>     
            <li><span class="label label-primary">Menunggu Bayaran Kaunter</span> : Pemohon boleh menjelaskan bayaran dan menuntut Kad Pekerja dikaunter Bahagian Keselamatan.</li>           
            <li><span class="label label-success">Menunggu Kutipan</span> : Permohonan berjaya dan sila kutip Kad Pekerja dikaunter keselamatan.</li>
            <li><span class="label label-success">Permohonan Selesai</span> : Permohonan selesai Kad Pekerja telah dikutip dikaunter Keselamtan.</li>
             
        </ul>
        </div>        
        </div> 
    </div>
</div>
</div>


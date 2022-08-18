<?php
use kartik\grid\GridView;
use yii\helpers\Html;

?>
<?php $this->title = 'Pinjaman Peribadi';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1306,1309,1312], 'vars' => []]); ?>


 <div class="x_panel">
 <div class="row">
 <div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_content">  
            <strong>
                Untuk maklumat lanjut, sila hubungi talian berikut:<br/><br/>
                <table>
                    <tr><td>
                            Pn Norjaidah Jaffar<br/>
                            Pembantu Tadbir (P/O) <br/>
                            Tel: 088320000 (samb. 1141)
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
                        </td>
                        <td>
                            Pn Jessieley Jefrry<br/>
                            Pembantu Tadbir (P/O) <br/>
                            Tel: 088320000 (samb. 1165)
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        </td>
                        <td>
                            En Mohd Afiz Mabni @ Matbee<br/>
                            Pembantu Tadbir (P/O) <br/>
                            Tel: 088320000 (samb. 1365)
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        </td> 
                        <td>
                            Pn Norni Lagung<br/>
                            Pembantu Tadbir (P/O) <br/>
                            Tel: 088320000 (samb. 1172)
                        </td>
                    </tr>
                </table>
            </strong>  
        </div>
    </div>
    
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
                        'heading' => '<h2>Status Permohonan Pinjaman Peribadi</h2>',
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                                            'header' => 'Bil',
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
                            'value' => 'tarikhm',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'],
                        ],
                        [
                            'header' => 'Status',
                            'format' => 'raw',
//                            'value' => 'statuspp',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'value' => function ($data){
                            if($data->stat_surat != 0){
                                 return $data->statsurat; //SEMAKAN LAYAK /DIPERAKUI
                             }elseif($data->stat_surat != 1){
                                 return $data->statuspp;
                             }
                            }
                        ],
                       
 

                    ],
                ]); ?>
                  
                        <ul>
                            <li><span class="label label-warning">Baru</span> : Permohonan Baru</li>
<!--                            <li><span class="label label-primary">Dalam Tindakan PT</span> : Menunggu tindakan dari Pembantu Tadbir BSM</li>-->
                            <li><span class="label label-info">Dalam Tindakan BSM</span> : Menunggu tindakan dari Pegawai BSM</li>
                            <li><span class="label label-success">Berjaya</span> : Diluluskan</li>
                            <li><span class="label label-success">Surat Sedia Diambil</span> : Surat Sedia untuk Diambil</li>
                            <li><span class="label label-danger">Ditolak</span> : Permohonan Ditolak</li>
                        </ul>
                    </div> 
                  </div>
               </div>
            </div>
          </div>       
        </div> 
    </div>
</div>
</div>


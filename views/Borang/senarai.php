
<?php
//use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;

?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86,1295,1297,1299,1314,1410,1470], 'vars' => []]); ?>
<div class="x_panel">
        <div class="x_content">  
            <strong>
                Untuk maklumat lanjut, sila hubungi talian berikut:<br/><br/>
                <table>
                    <tr>  
                        <td>
                            Pn. Sharifah Rofidah Binti Habib Hasan<br/>
                            Penolong Pendaftar Kanan (N44)<br/>
                            Tel: 088320000 ( No. UC: 100963 / 0198922449)
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        </td> 
                        
                        <td>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            En. Mohd Afiz Bin Mabni @ Matbee<br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            Pembantu Tadbir (P/O) Kanan <br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            Tel: 088320000 ( No. UC: 101862 / 01115360023)
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        </td> 
                         
                    </tr>
                </table>
            </strong>  
        </div>
    </div>
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
                             if ($data->stat_bendahari == 'EFT'|| $data->status_pp == 'MENUNGGU KELULUSAN') {
                                 return $data->statuss; 
                             }
//                             elseif($data->status_pp == 'TIDAK LENGKAP' || $data->status_pp == 'DILULUSKAN'){//erase this condition if have error display detail
//                                 return $data->stat_uniform;
//                             }
                             else{
                                 return $data->stat_kj;
                             }
                            }
                        ], 
                            [
                            'header' => 'Tindakan', //skelulusan - first timer letter, letter - repeated letter
                            'format'=>'raw',
                            'hAlign' => 'center',
                            'attribute'=>function ($data) {
                            if($data->jeniskemudahan == '7'&& $data->isActive == '1' && $data->letter_type == '1' ){   
                                 return Html::a('', ['borangwilayah/letter2', 'id' => $data->id], ['class'=>'fa fa-download', 'target' => '_blank']) ; 
   
                            } 
                            if($data->jeniskemudahan == '7'&& $data->isActive == '1' && $data->letter_type == '2' ){   
                               return Html::a('', ['borangwilayah/letter', 'id' => $data->id], ['class'=>'fa fa-download', 'target' => '_blank']) ; 
  
                            }
                            }
                        ],

 
                        ],
                    ]);
                    ?>
                  
                    <ul>
                        <li><span class="label label-warning">BARU</span> : Permohonan Baru</li>
                        <li><span class="label label-primary">DALAM TINDAKAN PEGAWAI</span> : Menunggu perakuan dari BSM</li>
                        <li><span class="label label-info">DALAM TINDAKAN KJ</span> : Menunggu kelulusan dari BSM</li>
                        <li><span class="label label-default">PEMBELIAN TIKET DALAM PROSES</span> : Proses Pembelian tiket</li>
                        <!--<li><span class="label label-success">PEMBELIAN TIKET SELESAI</span> : Tempahan tiket selesai</li>--> 
                        <li><span class="label label-danger">DITOLAK</span> : Tidak Diluluskan</li>
                    </ul>
                </div> 
    </div>
    </div>
            </div>
   
    
       
        </div> 
    </div>
</div>
</div>


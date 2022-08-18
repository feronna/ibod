<?php
//use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;

?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86,1295,1297,1314,1410,1470], 'vars' => []]); ?>
<!--<div class="x_panel">
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
    </div>-->
 <div class="x_panel">
 <div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
        <h2><strong><i class="fa fa-list"></i> Sejarah Permohonan</strong></h2>
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
//                        [
//                            'label' => 'Status Permohonan',
//                            'format'=>'raw',
//                            'hAlign' => 'center',
//                            'value' => function ($data) {
//                             return '<span class="label label-success">BERJAYA</span></li> ';
//                        },
//                        ],

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
</div>
</div>


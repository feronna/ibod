<?php

use kartik\grid\GridView;
use yii\helpers\Html;
?> 
<?= $this->render('menu') ?>
<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="x_panel">
        <div class="x_content">  
            <strong>
                Untuk maklumat lanjut, sila hubungi talian berikut:<br/><br/>
                <table> 
                    <tr>
                        <?php foreach($pegawai as $pegawai){ ?>
                        <td>
                            <?= $pegawai->kakitangan ? $pegawai->kakitangan->gelaran->Title : 'Tiada Maklumat'; ?> <?= $pegawai->kakitangan ? ucwords(strtolower($pegawai->kakitangan->CONm)) : 'Tiada Maklumat'; ?><br/>
                            <?= $pegawai->kakitangan ? $pegawai->kakitangan->jawatan->nama : 'Tiada Maklumat'; ?><br/>
                            Tel: 088320000 (samb. <?= $pegawai->kakitangan ? $pegawai->kakitangan->COOffTelNoExtn : 'Tiada Maklumat'; ?>)
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
                        </td>
                        <?php } ?>
                    </tr>
                </table>
            </strong>  
        </div>
    </div> 

    <div class="x_panel"> 
        <div class="x_content">   
            <div class="table-responsive">

                <?php
                $gridColumns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Butiran Permohonan',
                        'value' => function($model) {
                            if ($model->biodata->NatCd == "MYS") {
                                $icno = $model->ICNO;
                            } else {
                                $icno = $model->biodata->latestPaspot;
                            }
                            return 'Nama : ' . ucwords(strtolower($model->gl_nama)) . '<br/>No. K/P : ' . $icno . '<br/>Hubungan : ' . $model->gl_hubungan;
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Kelas Wad',
                        'value' => function($model) {
                            return ucwords(strtolower($model->kelasWad->nama));
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Tarikh/Masa Mohon',
                        'value' => function($model) {
                            return $model->tarikh_mohon;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Status Permohonan',
                        'value' => function() {
                            return '<span class="label label-success">Diterima </span>';
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Surat Jaminan',
                        'value' => function($model) {
                            if ($model->status_semasa == 2) {
                                return Html::a('<i class="fa fa-download" aria-hidden="true"></i>', [
                                            'surat-jaminan',
                                            'id' => $model->id,
                                                ], [
                                            'class' => 'btn btn-default',
                                            'target' => '_blank',
                                ]);
                            } else {
                                return '';
                            }
                        },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                        ];



                        echo GridView::widget([
                            'dataProvider' => $permohonan,
                            'columns' => $gridColumns,
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
                                'heading' => '<h2>Status Permohonan Surat Jaminan (eGL)</h2>',
                            ],
                        ]);
                        ?>
                    </div>

                    <div>
                        *   Rujukan:  Pekeliling Perkhidmatan Bil. 4/2010 <br/>                
                        *   Tempoh laku surat ini ialah tiga (3) bulan daripada tarikh di atas.<br/>   
                    </div>
                </div>
            </div>  

</div>  


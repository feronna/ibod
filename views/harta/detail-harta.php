<?php
use yii\widgets\DetailView;
$options = [
        1 => 'Sendiri', 2 => 'Pasangan' , 3 => 'Anak', 4 => 'Bersama'

];
?>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-money"></i> Maklumat Aset</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                
                
<div class="table-responsive">
    <?= DetailView::widget([
        'model' => $detail,
        'attributes' => [
          
            ['label'=> 'HTA / HA ',
             'value' =>  strtoupper($detail->hta->jenis_harta),
             'contentOptions' => ['style'=>'width:auto'],
             'captionOptions' => ['style'=>'width:26%'],],
            ['label'=> 'Jenis Harta',
             'value' => strtoupper($detail->jenisHarta->keterangan)],
             ['label'=> 'Spesifikasi Harta',
             'value' =>  strtoupper($detail->spesifikasiHarta->keterangan)],
             ['label'=> 'Pemilikan',
             'value' =>  strtoupper($options[$detail->pemilikan])],
             ['label'=> 'No. Sijil Aset',
             'value' =>  $detail->AlAssetCertNo ],
             ['label'=> 'Nilai Pembelian Aset (RM)',
             'value' => $detail->AlPurchasedValue],
             ['label'=> 'Nilai Semasa Aset(RM)',
             'value' => $detail->AlCurVal],
             ['label'=> 'Kuantiti Aset',
             'value' => strtoupper($detail->AlQuantity) ],
            ['label'=> 'Alamat Aset I',
             'value' => strtoupper($detail->AlAddr1) ],
            ['label'=> 'Alamat Aset II',
             'value' => strtoupper($detail->AlAddr2) ],
            ['label'=> 'Alamat Aset III',
             'value' => strtoupper($detail->AlAddr3) ],
               ['label'=> 'Poskod Aset',
             'value' => strtoupper($detail->AlPostcode) ],
              ['label'=> 'Negara',
             'value' => strtoupper($detail->negara->Country)  ],
              ['label'=> 'Negeri',
             'value' => strtoupper($detail->negeri->State) ],
              ['label'=> 'Daerah',
             'value' => strtoupper($detail->bandar->City) ],
            ['label'=> 'Tarikh Pemilikan',
             'value' => strtoupper($detail->tarikhPemilikan) ],
            ['label'=> 'Cara dan dari Siapa Harta Diperolehi(dipusakai,
                 dibeli, dihadiahkan, dll)',
             'value' => strtoupper($detail->caraDiperolehi2)],
            ['label'=> 'Jenis Sumber Kewangan',
             'value' =>  strtoupper($detail->sumberKewangan2)],
            ['label'=> 'Punca Dana,Jumlahnya, Maklumat Pembiaya & 
                 Keterangan Lain (jika perlu)',
             'value' => strtoupper($detail->AlDesc)  ],
              ['label'=> 'Jumlah Keseluruhan Sumber Kewangan (RM)',
             'value' => $detail->FinclSrcTotalAmt ],
              ['label'=> 'Tempoh bayaran balik Sumber Kewangan',
             'value' => $detail->FinclSrcRepaymtPeriod  ],
              ['label'=> 'Ansuran Bulanan Sumber Kewangan (RM)',
             'value' => $detail->FinclSrcMthlyInstalmt  ],
             ['label'=> 'Tarikh Mula Bayar Ansuran Bulanan',
             'value' => strtoupper ($detail->tarikhMulaBayar) ],
             ['label'=> 'Tarikh Akhir Bayar Ansuran Bulanan',
             'value' => strtoupper ($detail->tarikhAkhirBayar) ],
            
         
        ],
    ]) ?>
               </div>
          
               
            </div>
        </div>
    </div>
</div>

<?php
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 15px; font-size: 11px ">
      Ruj. Kami  : UMS/PEND2.2/500-6/2/4<br>
      Tarikh     : <?= $pinjaman->tarikhm ?>
     
 
</div>

        <div style="margin-bottom: 20px; ">
            <b>  
       <!--Alamat-->

            <br>

        </div>

        <div>
           Tuan/Puan,

        </div>

        <div style="margin-bottom: 8px;font-size: 14px;">
            <br>  <b>SURAT KEBENARAN JABATAN DAN PENGESAHAN GAJI KAKITANGAN<br>

        </div>

         <div style="margin-bottom: 0px; text-align:justify; font-size: 13px;">
             <b>NAMA <?php  echo str_repeat("&nbsp;", 40);  ?> : <?= $pinjaman->biodata->CONm ?> </b>
        </div>


        <div style="margin-bottom: 10px; text-align:justify; font-size: 13px;">
             <b>NO. KAD PENGENALAN <?php  echo str_repeat("&nbsp;", 10);  ?>: <?= $pinjaman->biodata->ICNO ?> </b>
        </div>



        <div style="margin-bottom: 10px; text-align:justify; font-size: 13px;">
        Dengan segala hormatnya perkara di atas adalah dirujuk.
        </div>

        <div style="margin-bottom: 10px; text-align:justify; font-size: 13px;">
            2.<?php  echo str_repeat("&nbsp;", 5);  ?>  Adalah dimaklumkan bahawa penama di atas adalah kakitangan di <?= $pinjaman->biodata->department->fullname ?>,
            Universiti Malaysia Sabah dan maklumat lanjut adalah seperti butiran berikut:
                       
        </div>
        <div style="margin-bottom: 10px; margin-left: 60px; text-align:justify; font-size: 13px;">
            i. <?php  echo str_repeat("&nbsp;", 2); ?> Jawatan <?php  echo str_repeat("&nbsp;", 35);  ?>:<?php  echo str_repeat("&nbsp;", 1); ?><?= $pinjaman->biodata->jawatan->nama ?><br>
            ii.<?php  echo str_repeat("&nbsp;", 2); ?> Gred Jawatan <?php  echo str_repeat("&nbsp;", 26);  ?>:<?php  echo str_repeat("&nbsp;", 1); ?><?= $pinjaman->biodata->jawatan->gred ?><br>
            iii.&nbsp; Tarikh Mula Berkhidmat <?php  echo str_repeat("&nbsp;", 9);  ?>&nbsp; :<?php  echo str_repeat("&nbsp;", 1); ?><?= $pinjaman->biodata->displayStartSandangan  ?><br>
            iv.&nbsp; Taraf Jawatan <?php  echo str_repeat("&nbsp;", 26);  ?>:<?php  echo str_repeat("&nbsp;", 1); ?><?= $pinjaman->biodata->statusLantikan->ApmtStatusNm  ?> dan <?= $pinjaman->statPencen->statusPencen->PsnStatusNm?><br>
            v.<?php  echo str_repeat("&nbsp;", 2); ?> Umur Opsyen Persaraan <?php  echo str_repeat("&nbsp;", 9); ?>: 
            <?php if($pension) {
                    
                   foreach ($pension as $retireage) {
                    
                ?>

                   <?= $retireage->umurBersara->RetireAgeCd  ?> Tahun <?php } 
                   
                } else{ echo '';
                }
                    ?><br> 
                

            vi.<?php  echo str_repeat("&nbsp;", 1); ?> Tarikh Disahkan Jawatan<?php  echo str_repeat("&nbsp;", 9); ?> :<?php  echo str_repeat("&nbsp;", 1); ?><?=  $gaji->tarikhpengesahan  ?>  <br>
            vii.<?php  echo str_repeat("&nbsp;", 1); ?> Gaji Pokok<?php  echo str_repeat("&nbsp;", 32);  ?>:<?php  echo str_repeat("&nbsp;", 1); ?><?= $gaji->gajiBasic ?>  <br>
            viii.&nbsp;Elaun Tetap<?php  echo str_repeat("&nbsp;", 30); ?>:<?php  echo str_repeat("&nbsp;", 1); ?>RM <?= $sum ?> <br> 
            ix.<?php  echo str_repeat("&nbsp;", 1); ?> Gaji Kasar<?php  echo str_repeat("&nbsp;", 33);  ?>:<?php  echo str_repeat("&nbsp;", 1); ?>RM <?= $pinjaman->payroll->MPH_TOTAL_ALLOWANCE  ?><br> 
            x.<?php  echo str_repeat("&nbsp;", 2); ?> Jumlah Potongan<?php  echo str_repeat("&nbsp;", 21);  ?> :<?php  echo str_repeat("&nbsp;", 1); ?>RM <?= $pinjaman->payroll->MPH_TOTAL_DEDUCTION ?><br> 
            xi.<?php  echo str_repeat("&nbsp;", 1); ?> Gaji Bersih<?php  echo str_repeat("&nbsp;", 32);?>&nbsp;:<?php  echo str_repeat("&nbsp;", 1); ?>RM <?= ($pinjaman->payroll->MPH_TOTAL_ALLOWANCE)-($pinjaman->payroll->MPH_TOTAL_DEDUCTION) ?><br> 

            
            
        </div> 
        </div>
        
        <div class="row">
    <div class="table-responsive">
        
        <?=
            GridView::widget([
                'options' => ['id' => 'saraan'],
                'emptyText' => 'Tiada Rekod',
                'summary' => '',
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'BIL',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        //                                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'PENDAPATAN',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return ($model->elaunnn) ? $model->elaunnn->it_account_name . ' (' . $model->elaunnn->it_income_code . ')' : null;
                        },
                    ],
                    [
                        //                                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'TARIKH MULA',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return $model->SR_DATE_FROM ? Yii::$app->formatter->asDate($model->SR_DATE_FROM, 'dd-MM-yyyy') : null;
                        },
                        'format' => 'html'
                    ],
                   
                    [
                        'header' => 'JUMLAH',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return $model->SR_NEW_VALUE;
                        },
                    ],
                   [
                        'header' => 'ELAUN/POTONGAN',
                        'headerOptions' => ['class' => 'text-center col-md-1'],
                        'contentOptions' => ['class' => 'text-center'],
                        'value' => function ($model) {
                            return ($model->elaunnn) ? $model->elaunnn->it_trans_type : null;
                        },
                    ],
                     
                ],
            ]);
        ?>
    </div>
</div>

        <div style="margin-bottom: 10px; text-align:justify; font-size: 13px;">
            3.<?php  echo str_repeat("&nbsp;", 5);  ?> Pihak yang diberi kuasa oleh bahagian gaji tiada
            halangan dan memberi kebenaran potongan gaji dibuat melalui unit kewangan/bahagian gaji untuk 
            membayar balik pembiayaan, mohon tuan/puan pastikan potongan dalam slip gaji hendaklah tidak melebihi 60%
            daripada gaji kasar.
                       
        </div>

         <div style="margin-bottom: 15px; text-align:justify; font-size: 13px;">
             4.<?php  echo str_repeat("&nbsp;", 5);?> Pihak kami juga mengesahkan bahawa:<br>
             <?php  echo str_repeat("&nbsp;", 11); ?>a) Tiada sebarang tindakan tatatertib telah diambil terhadap penama jawatannya akan 
            digantung/dibuang  <?php  echo str_repeat("&nbsp;", 16);  ?> kerja.<br>
             <?php  echo str_repeat("&nbsp;", 11);  ?>b)&nbsp; Penama tidak terlibat dalam Skim Pelepasan Sukarela (VSS).<br>
             <?php  echo str_repeat("&nbsp;", 11);  ?>c)&nbsp; Penama tiada memohon untuk bercuti tanpa gaji.
                       
        </div>
        <br>
        <div style="margin-bottom: 6px; font-size: 13px;">
            Sekian, Terima Kasih.<br>
            Yang ikhlas,<br><br><br><br>

           <b>SHARIFAH ROFIDAH HABIB HASAN</b><br>
           Penolong Pendaftar<br>
           Seksyen Perkhidmatan<br> 
           Bahagian Sumber Manusia<br>
           b.p Pendaftar

        </div> 

        <div style=""> 
          <div style="margin-bottom:22px; font-size: 11px;">

          <br>
          <br>
          <br>mam/srhh 

        </div>
        </div>
        
         
        
        
        
         
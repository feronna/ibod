<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$this->title = 'Permohonan Cuti Belajar';
error_reporting(0);
?> 
<style>
    fieldset.scheduler-border {
        border: 1px groove #062f49 !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow: 0px 0px 0px 0px #000;
        box-shadow: 0px 0px 0px 0px #000;
    }

    legend.scheduler-border {
        width: inherit;
        /* Or auto */
        padding: 0 10px;
        /* To give a bit of padding on the left and right */
        border-bottom: none;
    }
</style>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

<div class="x_content">  
    <div class="row">
        <ol class="breadcrumb">
            <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['cutibelajar/halaman-pemohon']) ?></li>
            <li>Borang Permohonan</li>
        </ol>
    </div>
</div>


<p align="right">  <?= Html::a('Kembali', ['cutibelajar/permohonan-semasa'], ['class' => 'btn btn-primary btn-sm']) ?></p>


<div class="x_panel">
    <div class="x_content"> 

        <span class="required" style="color:#062f49;">
            <strong>
                <center>


                    <?= strtoupper('
     SEKSYEN PEMBANGUNAN PROFESIONALISME | SEKTOR PENGURUSAN BAKAT<br/><u> PERMOHONAN LATIHAN PENSIJILAN PROFESIONAL 

        '); ?>




            </strong> </center>
        </span> 
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">

            <fieldset class="scheduler-border">
                <legend class="scheduler-border">  
                    <h5><i class='fa fa-check-square'></i>
                        SEMAKAN SYARAT LATIHAN PENSIJILAN PROFESIONAL</h5></legend> 

                <div class="form-group" align="text-center">


                    <div class="x_content" >
                        <div class="table-responsive">
                            <table class="table table-striped table-sm jambo_table table-bordered">
                                <thead style="background-color:lightseagreen;color:white">
                                    <tr class="headings">
                                        <th class="text-center" rowspan="2">BIL</th>
                                        <th class="text-center" rowspan="2">PERKARA</th>

                                    </tr>

                                </thead>
                                <?php
                                if ($semak) {
                                    $no = 0;
                                    ?>

                                    <?php
                                    foreach ($semak as $dok) {
                                        $no++;
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no; ?></td>
                                            <td class="text-justify"><?php echo $dok->syarat; ?></td>

                                        </tr>

                                        <?php
                                    }

//                             }
                                }
                                ?>

                            </table>

                        </div>

                    </div>

                </div>
        </div>
    </div>

</div>
<div class="x_panel">

    <div class="x_content"> 
        <?php
        $dataProvider = new ActiveDataProvider([
            'query' => app\models\cbelajar\TblDokumen::find()->where(['status' => 1]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        ?> 
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">  
                <h5><i class='fa fa-file-pdf-o'></i>
                    SENARAI SEMAK DOKUMEN YANG PERLU DIKEMUKAKAN/DIMUATNAIK</h5></legend> 


            <div class="table-responsive ">        
                <?=
                GridView::widget([
                    'dataProvider' => $senarai_dokumen,
                    'options' => ['style' => 'width:100%'],
                    'layout' => "{items}\n{pager}",
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                            'headerOptions' => ['style' => 'width:5%'],
                            'header' => 'BIL.'],
                        [
                            'label' => 'NAMA DOKUMEN',
                            'headerOptions' => ['style' => 'width:60%'],
                            'format' => 'raw',
                            'value' => function($model) {
                        return $model->nama_dokumen;
                    },
                        ],
                        [
                            'label' => 'MUAT TURUN',
                            'format' => 'raw',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                            'value' => function ($data) {

                        if ((!empty($data->nama_dokumen)) && (!empty($data->sokongan->namafile))) {
                            return Html::a('', (Yii::$app->FileManager->DisplayFile($data->sokongan->namafile)), ['class' => 'fa fa-download fa-lg', 'target' => '_blank']);
                        } else {
                            return '<b><small>TIADA BUKTI</small></b>';
                        }
                    },
                        ],
//                                                    [
//                                            'header' => 'STATUS DOKUMEN',
//                                            'class' => 'yii\grid\ActionColumn',                            
//                                             'headerOptions' => ['style' => 'width:5%'],
//
//                                            'template' => '{muatnaik}',
//                                            'buttons' => [
//                                                'muatnaik' => function($url, $model, $key) use ( $iklan)
//                                                {
//                                                    if ($model->checkUpload($model->id, $iklan->id)) {
//                                                        return '<i class="fa fa-check-circle fa-lg" aria-hidden="true" style="color: green"></i>';
//                                                    } else {
//                                                        return '<i class="fa fa-times fa-lg" aria-hidden="true" style="color: red"></i>';
//                                                    }
//                                                }
//                                        ],
//                                                
//                                                
//                                          'headerOptions' => ['class' => 'text-center'],
//                                          'contentOptions' => ['class' => 'text-center'],
//                                        ],
//                                                [
//                        'label'=>'MUAT TURUN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                       'value'=>function ($data) use ($biodata)  {
////                                $icno =Yii::$app->user->getId();
//                            
//                             if($data->sokongan->sokongan->namafile)
//                             {
//                         return  Html::a('', 
//                            (Yii::$app->FileManager->DisplayFile($data->sokongan->sokongan->namafile)), 
//                            ['class'=>'fa fa-download fa-lg' , 'target' => '_blank']);
//                             }
// else {
//     return '<b><small>TIADA BUKTI</small></b>';
//     
// }
//                      },
//             ],
                    // [
                    //     'label' => 'Status',
                    // ],
                    ],
                ]);
                ?>
            </div>

    </div></div>
<div class="x_panel">
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">  
            <h5><i class='fa fa-check-square'></i>
                MAKLUMAT PERIBADI</h5></legend>       
        <div class="col-md-3 col-sm-3  profile_left"> 


            <div class="profile_img">
                <div id="crop-avatar"> <br/><br/>
                    <center> <?php
                        if ($img) {
                            echo Html::img($gambar->getImageUrl() . $gambar->filename, [
                                'class' => 'img-thumbnail',
                                'width' => '150',
                                'width' => '150',
                            ]);
                        }
                        ?>  </center>
                </div>
            </div> 
            <br/> 
        </div>
        <div class="col-md-9 col-sm-9 col-xs-9">

            <div class="col-md-12 col-sm-12 col-xs-12">   
                <br/>
    <!--            <h4 colspan="2" style="background-color:lightseagreen;color:white"><center>MAKLUMAT PERIBADI</center></h4>-->

                <table class="table" style="width:100%">

                    <thead>
                        <tr>
                            <th colspan="4" class="text-center">
                    <h5><?= strtoupper($biodata->CONm); ?> |
                        <?= date("Y") - date("Y", strtotime($biodata->COBirthDt)) . " " . "TAHUN" ?></h5>
                    </th>
                    </tr>  
                    <tr>
                        <th colspan="4" class="text-center"> 
                            <?= strtoupper($biodata->jawatan->fname); ?> | 
                            <?= strtoupper($biodata->department->fullname); ?>
                        </th> 
                    </tr>
                    </thead>
                    <tbody>

                        <tr> 
                            <th style="width:20%">ICNO</th>
                            <td style="width:20%"><?= $biodata->ICNO; ?></td> 
                            <th>UMSPER</th>
                            <td><?= $biodata->COOldID; ?></td> 


                        </tr>
                        <tr> 


                            <th style="width:20%">TARIKH LANTIKAN</th>
                            <td style="width:20%"><?= strtoupper($biodata->displayStartLantik); ?></td>
                            <th width="20%">TARAF PERKAHWINAN: </th>
                            <td><?= strtoupper($biodata->displayTarafPerkahwinan) ?></td> 

                        </tr>
                        <tr> 

                            <th style="width:20%">TARIKH DISAHKAN DALAM PERKHIDMATAN</th>
                            <td style="width:20%">  <?php
                                if ($biodata->confirmDt) {
                                    echo strtoupper($biodata->confirmDt->tarikhMula);
                                } else {
                                    echo 'Tiada Maklumat';
                                }
                                ?></td>
                            <th style="width:20%">TEMPOH BERKHIDMAT SEMASA</th>
                            <td style="width:20%"><?= strtoupper($biodata->servPeriodPermanent); ?></td>


                        </tr>

                        <tr> 

                            <th>EMEL</th>
                            <td><?= $biodata->COEmail; ?></td> 
                            <th style="width:20%">NO. TELEFON</th>
                            <td style="width:20%"><?= $biodata->COHPhoneNo; ?></td>
                        </tr>



                    </tbody>
                </table> 
            </div> 
            <br/>

        </div>
</div> 

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">

        <div class="x_panel">
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">   <h5><i class='fa fa-book'></i> MAKLUMAT AKADEMIK</h5>
                </legend>
                <?php
                $akademik = $biodata->akademik;
                if ($akademik) {
                    ?>

                    <div>
                        <form id="w0" class="form-horizontal form-label-left" action="">

                            <table class="table table-bordered jambo_table">
                                <thead style="background-color:lightseagreen;color:white">

                                    <tr class="headings">
                                        <th class="column-title text-center">BIL</th>
                                        <th class="column-title text-center">TAHAP PENDIDIKAN </th>
                                        <th class="column-title text-center">BIDANG</th>
                                        <th class="column-title text-center">UNIVERSITI/INSTITUSI</th>
                                        <th class="column-title text-center">KELAS/CGPA</th>
                                        <th class="column-title text-center">TARIKH DIANUGERAHKAN</th>
                                        <th class="column-title text-center">TAJAAN</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $bil = 1;
                                    foreach ($akademik as $akademik) {
                                        ?>

                                        <tr>

                                            <td><?= $bil++ ?></td>
                                            <td><?php
                                                if ($akademik->tahapPendidikan) {
                                                    echo strtoupper($akademik->tahapPendidikan);
                                                } else {
                                                    echo '-';
                                                }
                                                ?></td>
                                            <td><?= strtoupper($akademik->namaMajor); ?></td>
                                            <td><?= strtoupper($akademik->namainstitut); ?></td>
                                            <td><?= strtoupper($akademik->OverallGrade); ?></td>
                                            <td class="text-center"><?= strtoupper($akademik->confermentDt); ?></td> 
                                            <td ><?= strtoupper($akademik->namapenaja); ?></td>

                                        </tr>
                                    <?php } ?>
                                </tbody>


                            </table>

                    </div>
                <?php } ?>
        </div>
    </div>

</div>

<div class="row"> 
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">

            <fieldset class="scheduler-border">
                <legend class="scheduler-border">   <h5><i class='fa fa-graduation-cap'></i> MAKLUMAT LATIHAN PENSIJILAN PROFESIONAL</h5>
                </legend>    

                <?php
                if ($pengajian) {
                    foreach ($pengajian as $pengajian) {
                        ?>  


                        <div class="x_content ">

                            <div class="table-responsive">

                                <table class="table table-striped table-sm  table-bordered">
                                    <thead>

                                        <tr class="headings">
                                            <th colspan="2" style="background-color:lightseagreen;color:white"><center>

                                        <?php
                                        if ($pengajian->tahapPendidikan) {
                                            echo strtoupper($pengajian->tahapPendidikan);
                                        } else {
                                            echo '';
                                        }
                                        ?></center></th>
                                    </tr>
                                    <tr> 
                                        <th style="width:10%" align="right">JAWATAN SEMASA CUTI BELAJAR</th>
                                        <td style="width:20%">
                                            <?= strtoupper($biodata->jawatan->fname) ?></td>

                                    </tr>
                                    <tr>
                                        <th style="width:10%" align="right">KATEGORI LATIHAN</th>
                                        <td style="width:20%">

                                            <?php
                                            if ($pengajian->cat_latihan == "1") {
                                                echo '<span class="label label-success">SIJIL KEMAHIRAN PROFESIONAL</span>';
                                            } else {
                                                echo '<span class="label label-warning">KURSUS MENGANGGOTAI BADAN PROFESIONAL</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr> 

                                        <th style="width:10%" align="right">NAMA AGENSI/ORGANISASI</th>
                                        <td style="width:20%">
                                            <?php echo strtoupper($pengajian->badanprof->namaBadan); ?></td><?php } ?></tr>



                                <tr> 

                                    <th style="width:10%" align="right">NAMA PENSIJILAN</th>
                                    <td style="width:20%">
                                        <?php echo strtoupper($pengajian->bodyCert->namasijil); ?></td></tr>





                                <th style="width:10%" align="right">BIDANG</th>
                                <td style="width:20%"><?php
                                        if (($pengajian->MajorCd == NULL) && ($pengajian->MajorMinor != NULL)) {
                                            echo strtoupper($pengajian->MajorMinor);
                                        } elseif (($pengajian->MajorCd != NULL) && ($pengajian->MajorMinor != NULL)) {
                                            echo strtoupper($pengajian->MajorMinor);
                                        } else {
                                            echo strtoupper($pengajian->major->MajorMinor);
                                        }
                                        ?></td>










                                <tr> 

                                    <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                                    <td style="width:40%">
                                        <?= strtoupper($pengajian->tarikhmula) ?> <b>HINGGA</b> 
                                        <?= strtoupper($pengajian->tarikhtamat) ?> (<?= strtoupper($pengajian->tempohtajaan); ?>)</td>
                                </tr>
                            <?php } else {
                                ?>
                                <tr>
                                    <td colspan="8" class="text-center"><b>Tiada Rekod Maklumat Pengajian yang dipohon</b></td>                     
                                </tr>
                            <?php }
                            ?> 






                            </thead>




                        </table>

                    </div> 

                </div></div>
    </div>

</div>
<!--  -->






<!-- Dokumen Yang telah dimuatnaik-->


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">

        <div class="x_panel">
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">   <h5><i class='fa fa-money'></i> MAKLUMAT PENAJAAN</h5>
                </legend> 
                <?php if ($biasiswa) { ?>
                    <div>
                        <form id="w0" class="form-horizontal form-label-left" action="">

                            <table class="table table-bordered jambo_table">
                                <thead style="background-color:lightseagreen;color:white">

                                    <tr class="headings">


                                        <th class="column-title text-center">NAMA AGENSI/TAJAAN </th>
                                        <th class="column-title text-center">JENIS TAJAAN</th>
                                        <th class="column-title text-center">JUMLAH AMAUN (RM)</th>

                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
                                    $bil = 1;
                                    foreach ($biasiswa as $biasiswa) {
                                        ?>

                                        <tr>

                                            <td class="text-center"><?= $biasiswa->nama_tajaan; ?></td>
                                            <td class="text-center"><?= $biasiswa->bantuan->bentukBantuan; ?></td>
                                            <td class="text-center"><?= $biasiswa->amaunBantuan; ?></td>



                                        </tr>
                                    <?php } ?>

                                </tbody>

                            </table></form>




                    </div>   
                    <?php
                } else {
                    ?>
                    <tr>
                        <td colspan="8" class="text-center"><b>Tiada Rekod Maklumat Pembiayaan / Pinjaman yang dipohon</b></td>                     
                    </tr>
                <?php }
                ?> 

                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <thead style="background-color:lightseagreen;color:white">
                            <tr class="headings">
                                <th class="text-center">NAMA TAJAAN</th>
                                <th class="text-center">PERINCIAN TAJAAN</th>

                            </tr>
                        </thead>



                        <tr>

                            <td class="text-center">
                                <b> BIASISWA PENGURUSAN UMS</b></td>

                            <td class="text-left"> 
                                <small> <b>
                                        KELAYAKAN KEWANGAN</b><br>
                                    a. Yuran Kursus<br>
                                    b. Bayaran Peperiksaan<br>
                                    c. Elaun Berkursus (Berdasarkan Pekeliling Bendahari yang sedang berkuatkuasa</small><br>

                                <small style="color:red"> <b>NOTA:
                                    </b><br>
                                    Yuran Pendaftaran dan Yuran Pembaharuan Sijil Tahunan adalah  mengguna pakai
                                    kemudahan Garis Panduan Bagi Pembayaran Yuran Keahlian Badan Profesional/Ikhtisas UMS<br>
                                    </td>


                                    </table>

                                    </div>

                                    </div>
                                    </div>

                                    </div>





                                    <!--  -->




                                    <!-- -->
                                    <!-- --> 



                                    <div class="row"> 
                                        <div class="col-xs-12 col-md-12 col-lg-12">

                                            <div class="x_panel">   
                                                <fieldset class="scheduler-border">
                                                    <legend class="scheduler-border">   <h5><i class='fa fa-check-square'></i> PERAKUAN KAKITANGAN</h5>
                                                    </legend> 
                                                    <div>
                                                        <form id="w0" class="form-horizontal form-label-left" action="">

                                                            <table class="table table-bordered jambo_table">
                                                                <tr>
                                            <!--                    <thead style="background-color:lightseagreen;color:white">
                                                                <th scope="col" colspan=12">
                                                                <center>PERAKUAN KAKITANGAN</center></th>
                                                            </thead>-->

                                                                <tr class="headings">






                                                                    <td class="col-sm-2 text-center">
                                                                        <div >

                                                                            <p class="text-justify"><h5><br> 
                                                                                <strong>Saya mengaku  semua keterangan di atas adalah benar dan jika saya didapati memberi 
                                                                                    maklumat palsu, saya bersetuju permohonan ini (jika telah diluluskan) 
                                                                                    akan terbatal dengan sendirinya dan boleh diambil tindakan perundangan.</strong>

                                                                            </h5> 
                                                                            <center><p style="color:black;">Tarikh Mohon: <?php echo $model3->tarikh_m; ?></p></center><br/>

                                                                        </div>
                                                                    </td>


                                                            </table>
                                                    </div> </div></div>
                                    </div> 
                                    <div class="x_panel">    
                                        <div class="col-xs-12 col-md-12 col-lg-12"> 

                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">   <h5><i class='fa fa-check-square'></i> STATUS PERAKUAN KETUA JABATAN (DEKAN/PENGARAH)</h5>
                                                </legend>  
                                                <div class="x_content" >
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-bordered jambo_table table-striped"> 


                                                            <tr class="headings">
                                                                <th class="col-md-3 col-sm-3 col-xs-12">DIPERAKUKAN OLEH:</th>
                                                                <td> <?= $models->ketuajfpiu; ?>  </td>


                                                            </tr>



                                                            <tr class="headings">
                                                                <th class="col-md-3 col-sm-3 col-xs-12">STATUS KETUA JABATAN (DEKAN/PENGARAH):</th>
                                                                <td> 
                                                                    <?= strtoupper($models->statusjfpiu) . '  [ ' . $models->app_date . ' ] ';
                                                                    ?>
                                                                </td>


                                                            </tr>

                                                            <tr class="headings">
                                                                <th class="col-md-3 col-sm-3 col-xs-12">ULASAN JFPIU:</th>
                                                                <td><?php
                                                                    if ($models->status_jfpiu == "DALAM TINDAKAN KETUA JABATAN") {

                                                                        echo "-";
                                                                    } else {
                                                                        echo strtoupper($models->ulasan_jfpiu);
                                                                    }
                                                                    ?>   </td>


                                                            </tr>

                                                            <tr class="headings">
                                                                <th class="col-md-3 col-sm-3 col-xs-12">TARIKH MOHON:</th>
                                                                <td> <?= $models->tarikh_m; ?>  </td>


                                                            </tr>
                                                            <tr class="headings">
                                                                <th class="col-md-3 col-sm-3 col-xs-12">STATUS PERMOHONAN:</th>
                                                                <td> <?= ucwords(strtoupper($models->status)); ?>  </td>


                                                            </tr>

                                                        </table>
                                                    </div>  

                                                </div>
                                        </div>
                                    </div>
                                    <?php ActiveForm::end(); ?>
   





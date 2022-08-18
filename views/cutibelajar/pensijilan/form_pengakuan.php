<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;

error_reporting(0);
$this->title = 'Permohonan Cuti Belajar'; 
?>
<?php
$umum = app\models\cbelajar\RefSemakan::find()->where(['id'=>[107,108,109,114,117]])->all();
$akademik = app\models\hronline\Tblpendidikan::find()->where([ 'HighestEduLevelCd'=> 8])->one();
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
<p align="right">
 <?= Html::a('Kembali', ['cbelajar/senarai-borang','id'=>$iklan->id], ['class' => 'btn btn-primary btn-sm']) ?></p>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<div class="row">
                
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['cutibelajar/halaman-pemohon']) ?></li>
        <li>Pengakuan Pemohon</li>
    </ol>
</div>
    <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">

<div class="x_panel">

        <div class="x_title">
            <h5><strong><i class='fa fa-clipboard'></i> SEKSYEN PENGEMBANGAN PROFESIONALISME | SEKTOR PENGURUSAN BAKAT</strong></h5>
            <div class="clearfix"></div>     
        </div>

</div></div>
</div>
<div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                 <h5><strong>
                  <i class='fa fa-arrow-right'></i> <?= strtoupper('
       
      PERMOHONAN LATIHAN PENSIJILAN PROFESIONAL
 '); ?>
                    </strong> </h5>
            </span> 
        </div>
    </div>
<div class="x_panel ">
 
<div class="col-xs-12 col-md-12 col-lg-12"> 
     <fieldset class="scheduler-border">

        <legend class="scheduler-border">  
                <h5><i class='fa fa-book'></i>
              RUJUKAN SYARAT UMUM</h5></legend>  
<div class="table-responsive">

                <div class="col-md-6 col-sm-6 col-xs-6">
                    <center> 
                        <table class="table table-sm table-bordered jambo_table table-striped" style="width:80%"> 
                            <tr>   
                                <th colspan="3" class="text-center" style="background-color:lightseagreen; color:white;">RUJUKAN</th>   
                            </tr>
                                 <tr>   
                                <th>TEMPOH PERKHIDMATAN</th>  
                                <td colspan="2"><small><?= strtoupper($biodata->servPeriodPermanent);   ?></small></td> 
                            </tr>  
                            <tr>   
                                <th style="width:40%">PENGESAHAN PERKHIDMATAN</th>  
                                <td colspan="2">
                                    <?php
                                    $pengesahan_status = '';

                                    if ($biodata->confirmDt) {
                                        echo $biodata->confirmDt->tarikhMula;
                                        $pengesahan_status = "YA";
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td> 
                            </tr> 
                            
                            <tr>   
                                <th>BERJAWATAN TETAP</th>  
                                <td colspan="2"><small><?= strtoupper($biodata->statusLantikan->ApmtStatusNm); ?></small></td> 
                            </tr>
                            
                            
                           
                            
<!--                            <tr>   
                                <th>TEMPAT PENGAJIAN</th>  
                                <td colspan="2"> 
                                <small><?= $pengajian->InstNm; 
                             ?></small>
                                </td> 
                            </tr> -->
<!--                            <tr>   
                                <th>LOKASI PENGAJIAN</th>  
                                <td colspan="2"> 
                                <small><?//php if($pengajian->statusp == "DN")
                                {
                                    echo 'DALAM NEGARA';
                                }
                                else
                                {
                                    echo 'LUAR NEGARA';
                                }
                             ?></small>
                                </td> 
                            </tr> -->
                             
                             <tr>   
                                    <th rowspan="4">LNPT <br/>
                                        (Pemberat 3 Tahun = 20%, 35%, 45%)<br/>
                                        (Pemberat 2 Tahun = 40% , 60%)
                                    </th>  
                                    <td colspan="2"><?= '<b>' . $biodata->markahlnptCV(1, 'Tahun') . ' :</b> ' . $biodata->markahlnptCV(1, 'Markah'); ?></td> 
                                </tr>
                                <tr>   
                                    <td colspan="2"><?= '<b>' . $biodata->markahlnptCV(2, 'Tahun') . ' :</b> ' . $biodata->markahlnptCV(2, 'Markah'); ?></td>  
                                </tr>
                                <tr>
                                    <td colspan="2"><?= '<b>' . $biodata->markahlnptCV(3, 'Tahun') . ' :</b> ' . $biodata->markahlnptCV(3, 'Markah'); ?></td> 
                                </tr> 
                                <tr>
                                    <td colspan="2">   
                                        <?php if (!empty($biodata->markahlnptCVpen(3, 'Tahun'))) { ?>
                                            Avg (3 Tahun) : 
                                            <?php
                                            $lnpt = number_format(($biodata->markahlnptCV(3, 'Markah') * 0.2) + ($biodata->markahlnptCV(2, 'Markah') * 0.35) + ($biodata->markahlnptCV(1, 'Markah') * 0.45), 2, '.', '');
                                            echo $lnpt;
                                        } else {
                                            ?> 
                                            Avg (2 Tahun) : 
                                            <?php
                                            $lnpt = number_format(($biodata->markahlnptCV(2, 'Markah') * 0.6) + ($biodata->markahlnptCV(1, 'Markah') * 0.4), 2, '.', '');
                                            echo $lnpt;
                                        }
                                        ?>
                                    </td> 
                                </tr>
                                
                            
<!--                            <tr>   
                                <th>SARJANA MUDA?</th>  
                                <td colspan="2"> 
                                <small><?//php 
                                if($akad->HighestEduLevelCd == 7 &&)
                                {
                                    echo 'YA';
                                }else
                                {
                                    echo '-';
                                    }?></small>
                                </td> 
                            </tr> -->
                        </table>
                    </center>
                </div>
     <div class="col-md-6 col-sm-6 col-xs-6">
                    <center>
                        <table class="table table-sm table-bordered jambo_table table-striped" style="width:80%"> 
                            <tr>   
                                <th colspan="3" class="text-center" style="background-color:lightseagreen; color:white;">KRITERIA</th>   
                            </tr>
                            <?php
                            $totalUmum = 0;
                            foreach ($umum as $p) {
                                ?>
                                <tr>      
                                    <th colspan="2"><small><?= strtoupper($p->syarat); ?></small></th>   
                                    <?php  if ($p->id == 107) {
                                            if ($biodata->statLantikan == $p->ans_no) {
                                                $s = 1;
                                                $totalUmum++;
                                            } else {
                                                $s = 0;
                                            }
                                        }
                                        elseif ($p->id == 108) {
                                        if ($model->kakitangan->servPeriodPermanent >= $p->ans_no) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                        }
                                       
                                       
                                        else if ($p->id == 109) {
                                            if ($lnpt >= $p->ans_no) {
                                                $s = 1;
                                                $totalUmum++;
                                            } else {
                                                $s = 0;
                                            }
                                        }
                                         
                                        else if ($p->id == 117) {
                                            if ($biodata->harta) {
                                                $s = 1;
                                                $totalUmum++;
                                            } else {
                                                $s = 0;
                                            }
                                        }
                                        else if ($p->id == 114) {
                                            if ($biodata->tatatertib == $p->ans_char) {
                                                $s = 2;
                                                $totalUmum++;
                                            }
                                            elseif(!$biodata->tatatertib)
                                            {
                                                $s = 2;
                                            }
                                           else {
                                                $s = 0;
                                            }
                                        }
                           
                                   
                                   


                            
                                       
                                    if ($s == 1) {
                                            $color = "#20c997";
                                            $button = "<i class='fa fa-check-circle fa-lg'></i>";
                                        } else if ($s == 0) {
                                            $color = "red";
                                            $button = "<i class='fa fa-times-circle fa-lg'></i>";
                                        } 
                                        else if ($s == 2) {
                                            $color = "#20c997";
                                            $button = "<i class='fa fa-check-circle fa-lg'></i>";
                                        }else {
                                            $color = "white";
                                            $button = "HOLD";
                                        } 

//                                    if ($s == 1) {
//                                        $color = "white";
//                                        $button = "<i class='fa fa-check-circle fa-lg'></i>";
//                                    } else if ($s == 0) {
//                                        if ($p->id == 2) {
//                                            $color = "white";
//                                        } else {
//                                            $color = "white";
//                                        }
//                                        $button = "<i class='fa fa-times-circle fa-lg'></i>";
//                                    } else {
//                                        $color = "#1E90FF";
//                                        $button = "HOLD";
//                                    }
                                    ?>
                                    <td colspan="2" style="background-color:<?= $color; ?>" class="text-center">  
                                        <?= Html::a($button, ['pengakuan-pemohon','id'=>$iklan->id], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                           
                        </table>
                    </center>
                </div>
</div>
</div></div>
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12"> 
<div class="x_panel">
    
                <fieldset class="scheduler-border">
            <legend class="scheduler-border">  
                <h5><i class='fa fa-check-square'></i>
                SEMAKAN SYARAT LATIHAN PENSIJILAN</h5></legend> 
                
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
                            if ($semak) 
                            { $no=0;?>
                            
                                <?php foreach ($semak as $dok) { $no++; 
                                   
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $dok->syarat; ?></td>
                         
                                </tr>
                                
                                <?php }
                               
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
<!--<h5> <strong><i class="fa fa-paperclip"></i>SENARAI SEMAK DOKUMEN YANG PERLU DIKEMUKAKAN</strong> </h5>-->

    <?= Html::a('Muat Naik', ['senarai-dokumen?id='.$iklan->id], ['class' => 'btn btn-primary btn-sm', 'target'=>'_blank']) ?> </h5>
  <div class="table-responsive">

<!--            <table class="table table-sm jambo_table table-striped">

                <tr>
                    <th style="color: red;">Garis Panduan Menyediakan Kertas Cadangan Penyelidikan  </th>
                    <td style="color: green;"><a href="<?php echo Url::to('@web/' . 'uploads-cutibelajar/cbelajar/dokumen/6. FORMAT CADANGAN PENYELIDIKAN DAN PELAN PENGAJIAN.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br> 
                    </td>

                </tr>
            </table>-->
        </div>
                     <div class="x_title">

    <h5> <strong><i class="fa fa-paperclip"></i> DOKUMEN WAJIB</strong> </h5>
                  
                     
<div class="clearfix"></div>     </div> 
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
                                            'format'=>raw,
                                            'value' => function($model) {
                                               return  $model->nama_dokumen;
                                            },
                                        ],
                                                    [
                                            'header' => 'STATUS DOKUMEN',
                                            'class' => 'yii\grid\ActionColumn',                            
                                             'headerOptions' => ['style' => 'width:5%'],

                                            'template' => '{muatnaik}',
                                            'buttons' => [
                                                'muatnaik' => function($url, $model, $key) use ( $iklan)
                                                {
                                                    if ($model->checkUpload($model->id, $iklan->id)) {
                                                        return '<i class="fa fa-check-circle fa-lg" aria-hidden="true" style="color: green"></i>';
                                                    } else {
                                                        return '<i class="fa fa-times fa-lg" aria-hidden="true" style="color: red"></i>';
                                                    }
                                                }
                                        ],
                                                
                                                
                                          'headerOptions' => ['class' => 'text-center'],
                                          'contentOptions' => ['class' => 'text-center'],
                                        ],
[
                                            'label' => 'MUAT TURUN',
                                            'format' => 'raw',
                                            'headerOptions' => ['class' => 'text-center'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'value' => function ($data) {

                                        if((!empty($data->nama_dokumen))&& (!empty($data->sokongan->namafile))) {
                                            return Html::a('', (Yii::$app->FileManager->DisplayFile($data->sokongan->namafile)), ['class' => 'fa fa-download fa-lg', 'target' => '_blank']). ' | '.
                                                 Html::a('<i class="fa fa-trash fa-lg" aria-hidden="true"></i>',['delete-dokumen?id='.$data->sokongan->id.'&i='.$data->sokongan->iklan_id], [
                                        'data' => [
                                        'confirm' => 'Anda ingin membuang rekod ini?',
                                        'method' => 'post',
                                        ],
                                    ]);
                                        } 
                                        else {
                                            return '<b><small>TIADA BUKTI</small></b>';
                                        }
                                    },
                                        ],
                                        

                                         

                                            ],
                                        ]);

                                           
                                     
                                        ?>
                                    </div>
  
 
</div>
</div>
<div class="x_panel">
    <fieldset class="scheduler-border">
            <legend class="scheduler-border">   <h5><i class='fa fa-user'></i> MAKLUMAT PERIBADI</h5></legend>      
    <div class="col-md-3 col-sm-3  profile_left"> 
        

        <div class="profile_img">
            <div id="crop-avatar"> <br/><br/>
                <center> <?php
                       
                        if ($gambar) {
                            echo Html::img($gambar->getImageUrl().$gambar->filename, [
                                'class' => 'img-thumbnail',
                                'width' => '150',
                                'width' => '150',
                            ]);
                        }
//                                                 echo Html::a('<i class="fa fa-upload"></i>', ['gambar', 'id'=> $iklan->id], ['class' => 'btn btn-success btn-sm', 'target'=>'_blank']);
                echo Html::button('<i class="fa fa-upload"></i> Gambar', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['upgambar?id='.$iklan->id,
                  ]),'class' => 'btn btn-primary btn-sm mapBtn']) ?>
                          </center>
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
                <h5><?=  strtoupper($biodata->CONm); ?> |
                <?=date("Y") - date("Y", strtotime($biodata->COBirthDt))." ". "TAHUN"?></h5>
                                                                <?php echo Html::a('Kemaskini ', ['biodata/lihatbiodata'], ['class' => 'btn btn-primary btn-sm', 'target'=>'_blank']); ?>

                </th>
                </tr>  
                <tr>
                    <th colspan="4" class="text-center"> 
                        <?= strtoupper($biodata->jawatan->fname);?> | 
                        <?= strtoupper($biodata->department->fullname);?>
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
                        <td style="width:20%"><?= strtoupper($biodata->servPeriodPermanent);  ?></td>


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
 <div class="x_panel">
       
             <fieldset class="scheduler-border">
            <legend class="scheduler-border">   <h5><i class='fa fa-book'></i> MAKLUMAT AKADEMIK</h5>
            </legend> 
             <?= Html::a('Kemaskini', ['pendidikan/view'], ['class' => 'btn btn-primary btn-sm', 'target'=>'_blank']) ?> </h5>
            <?php
                    $akademik = $biodata->akademik;
              if($akademik){ ?>
            
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

                    <?php $bil=1; foreach ($akademik as $akademik) { ?>

                        <tr>

                            <td><?= $bil++ ?></td>
                            <td><?= strtoupper($akademik->tahapPendidikan); ?></td>
                            <td><?= strtoupper($akademik->namaMajor);?></td>
                            <td><?= strtoupper($akademik->namainstitut);?></td>
                            <td><?= strtoupper($akademik->OverallGrade);?></td>
                            <td class="text-center"><?= strtoupper($akademik->confermentDt);?></td> 
                            <td ><?= strtoupper($akademik->namapenaja);?></td>

                        </tr>
                    <?php } ?>
                    </tbody>
              
                
                </table>

             </div>
              <?php }
              else{?>
                  <tr>
                  <p style="color:red"><b> SILA ISI MAKLUMAT AKADEMIK ANDA</b></p>
                      <td class="text-center"><b> TIADA MAKLUMAT</b></td>
                               

                        </tr>
   <?php           }
?>
  
</div>
<div class="x_panel">
      <fieldset class="scheduler-border">
            <legend class="scheduler-border">   <h5><i class='fa fa-graduation-cap'></i> MAKLUMAT PERMOHONAN</h5>
            </legend>
            <p align="left">
              
            
                <?php
                if (!$pengajian){
                
                //if ($model->status !=0 ) {
//                echo Html::a('Tambah Rekod', ['tambah-pengajian', 'id' => $iklan->id],
//                ['class' => 'btn btn-primary btn-sm']);
                 echo Html::a('Tambah Rekod', ['tambah-pengajian?id='.$iklan->id], ['class' => 'btn btn-primary btn-sm']);
                 ?>
          
                
                </p>
<!--                  Html::a('Kembali', ['tambah-pengajian?id='.$iklan->id], ['class' => 'btn btn-primary btn-sm']) ?></p>-->

            
       
                <?php }
 else {
  ' ';
 }
?>
        <div class="x_content">
       
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead style="background-color:lightseagreen;color:white">
                <tr class="headings">
                    <th class="text-center">BIL</th>
                    <th class="text-center">KATEGORI LATIHAN</th>
                    <th class="text-center">NEGARA</th>
                    <th class="text-center">BIDANG</th>
                    <th class="text-center">TARIKH PENGAJIAN</th>
                    <th class="text-center">TINDAKAN</th>    
                </tr>
                </thead>
               
               <?php
                    if ($pengajian) {
                        $counter = 0;
                        foreach ($pengajian as $eduhighest) {
                            $counter = $counter + 1;
                            ?>

                            <tr>
                                <td class="text-center"><?= $counter; ?></td> 
                                <td class="text-center"><?php
                                if($eduhighest->cat_latihan == "1")
                                {
                                    echo 'SIJIL KEMAHIRAN PROFESIONAL';
                                }
                                else
                                {
                                    echo 'KURSUS MENGANGGOTAI BADAN PROFESIONAL';
                                }
                                        ?></td>
                                <td class="text-center"><?= strtoupper($eduhighest->negara->Country)?></td>
                                <td class="text-center">
                                        <?php if($eduhighest->MajorCd == 9999 )
                                        {
                                                echo strtoupper($eduhighest->MajorMinor);
                                        }
                                        else
                                        {
                                             echo strtoupper($eduhighest->major->MajorMinor); 
                                        }?></td>
                                <td class="text-center">
                                             <?php if($eduhighest->tarikh_mula && $eduhighest->tarikh_tamat)
                                            {  ?><?= strtoupper($eduhighest->tarikhmula) ?> HINGGA 
                                            <?= strtoupper($eduhighest->tarikhtamat); ?>
                                            (<?= $eduhighest->tempohtajaan; ?>)<br><?php }
                                            else{
                                                echo '<p style="color:red">Tarikh Pengajian Tidak Diisi Lengkap'.
                                                    '</p>';
                                                     
                                            }
?> 
                                    </td>
                                <td class="text-center">
                 <?=    Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update?id='.$eduhighest->id], ['class' => 'btn btn-default']);?>

<!--//<?   Html::button('<i class="fa fa-pencil" aria-hidden="true"></i>', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['update?id='.$eduhighest->id,
//                  ]),'class' => 'btn btn-default mapBtn']); -->

                                  <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete?id='.$eduhighest->id.'&i='.$eduhighest->iklan_id], ['class' => 'btn btn-default',
                                        'data' => [
                                        'confirm' => 'Anda ingin membuang rekod ini?',
                                        'method' => 'post',
                                        ],
                                    ])
                                  ?>
                                    
                                  </td>  
                            </tr>
                            

                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center">Tiada Rekod</td>                     
                        </tr>
<?php }
?>
                </table>
                
            </div>
         
             
   </div>
   </div>
    




   <div class="x_panel">
    <div class="x_content">

                                  <fieldset class="scheduler-border">
            <legend class="scheduler-border">   <h5><i class='fa fa-money'></i> 
                    MAKLUMAT PEMBIAYAAN/PENAJAAN</h5>
            </legend>
                          

  <?= Html::a('Tambah Rekod', ['tambah-biasiswa', 'id' => $iklan->id], ['class' => 'btn btn-primary btn-sm', 'target'=>'_blank']) ?> </p>
                                  <p style="color:red"> * Jika ada tajaan luar, sila isi maklumat Penaja Luar . Namun jika tidak ingin memilih tanpa tajaan sila pilih Tanpa Tajaan.
         Maklumat biasiswa boleh dinyatakan lebih daripada satu:</p>

   
   

         
       
 <div class="x_content"> 
     <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped">
                <thead style="background-color:lightseagreen;color:white">
                        <tr class="headings">
                            <th class="text-center">BIL</th>
                            <th class="text-center">NAMA TAJAAN</th>
                            <th class="text-center">BENTUK TAJAAN</th>
                            <th class="text-center">AMAUN BANTUAN (RM)</th>
                            <th class="text-center">TINDAKAN</th>  
                        </tr>
                    </thead>
                   
                  <?php  if ($biasiswa) {
                        $counter = 0;
                        foreach ($biasiswa as $sponsor) {
                            $counter = $counter + 1;
                            ?>

                            <tr>
                                <td class="text-center"><?= $counter; ?></td>                        
                                <td class="text-center">
                             <?php  if ($sponsor->jenisCd == '1')
                                    {
                                      echo strtoupper($sponsor->nama_tajaan);
                                    }elseif ($sponsor->jenisCd == '2')
                                    {
                                      echo strtoupper($sponsor->nama_tajaan);
                                    }
                                    elseif ($sponsor->jenisCd == '3')
                                    {
                                      echo strtoupper($sponsor->nama_tajaan);
                                    }
                                     elseif ($sponsor->jenisCd == '4')
                                    {
                                      echo strtoupper($sponsor->nama_tajaan);
                                    }
                                     elseif ($sponsor->jenisCd == '5')
                                    {
                                      echo strtoupper($sponsor->tajaan->nama_tajaan);
                                    }
                                ?></td>
                                <td class="text-center">
                                 
                                <?php  
                                    if ($sponsor->BantuanCd == '4')
                                    {
                                      echo strtoupper($sponsor->bantuan->bentukBantuan);
                                    }
                                    elseif ($sponsor->BantuanCd == '6')
                                    {
                                      echo strtoupper($sponsor->bantuan->bentukBantuan);
                                    }
                                    else
                                    {
                                      echo strtoupper($sponsor->bantuan->bentukBantuan);
                                    }
                                    
                                ?>
                                    
                                </td>
                                <td class="text-center"> 
                                    <?php  
                                    if($sponsor->amaunBantuan == NULL)
                                    {
                                         echo "-";
                                    }
                                     else
                                     {
                                      echo strtoupper($sponsor->amaunBantuan);
                                     }
                                    
                                ?>
                                    </td>
                               
                                <td class="text-center">

<?=    Html::button('<i class="fa fa-pencil" aria-hidden="true"></i>', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['update-sponsor?id='.$sponsor->id,
                  ]),'class' => 'btn btn-default mapBtn']); ?>
                                 

                                  <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete-biasiswa?id='.$sponsor->id.'&i='.$sponsor->iklan_id], ['class' => 'btn btn-default',
                                        'data' => [
                                        'confirm' => 'Anda ingin membuang rekod ini?',
                                        'method' => 'post',
                                        ],
                                    ])
                                  ?>
                                    
                                  </td>  

                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center">Tiada Rekod</td>                     
                        </tr>
<?php }
?>
                </table>
                
            </div>

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
                                            c. Elaun Berkursus (Berdasarkan Pekeliling Bendahari yang sedang berkuatkuasa)</small><br>
                                            
                                       <small style="color:red"> <b>NOTA:
                                            </b><br>
                                            Yuran Pendaftaran dan Yuran Pembaharuan Sijil Tahunan adalah  mengguna pakai
                                            kemudahan Garis Panduan Bagi Pembayaran Yuran Keahlian Badan Profesional/Ikhtisas UMS<br>
                                    </td>
                               

                </table>
                
            </div>
     
     
   </div>
      

                              </div></div>

    

    
    
    
    
<!-- Dokumen Yang telah dimuatnaik-->
<div class="x_panel">
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $view;?>"> 
 <div class="form-group">
      <div class="x_title">
            <h5><strong><i class="fa fa-check-square"></i> PERAKUAN PEMOHON</strong></h5>
           
            <div class="clearfix"></div>
        </div>
  <div class="col-sm-12 text-center">
    
    <table>
        <tr>
            <td class="col-sm-3 text-right">
                <?php $model->agree = 1; ?>
                <br><?= $form->field($model, 'agree')->checkbox(['disabled' => true])->label(false); ?> <p>&nbsp;&nbsp;</p>
            </td>

            <td> 
                <div style="width: 800px; height: 90px;border:2px solid red">
             <h5 style="color:light grey;" >Saya mengaku  semua keterangan di atas adalah benar dan jika saya didapati memberi <br/>
                    maklumat palsu, saya bersetuju permohonan ini (jika telah diluluskan) 
                    akan terbatal dengan sendirinya dan boleh diambil tindakan perundangan. </h5>
                    <p style="color:light grey;">Tarikh Mohon: <?php echo $model->tarikhmohon;?></p><br/>
                      
            </div>
            </td>
        </tr>
    </table>
     <br/>
     <div class="col-sm-12 text-center">
          
        <div class="col-md-12 col-sm-12 col-xs-12" align="center"> 
         
         
        
             <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary ', 'name' => 'hantar1', 'value' => 'submit_2']) ?>

                
           
            <?= Html::a('Keluar', ['cutibelajar/halaman-pemohon'], ['class' => 'btn btn-danger ']);?>
     
        </div>
    </div>
 </div>
</div>
</div>     
</div>
</div>
        <div class="x_panel">
            <div class="x_content">
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $edit;?>"> 
         <div class="x_title">
             <h5 ><center><strong><i class="fa fa-check-square"></i> PERAKUAN PEMOHON</strong></center></h5>
           
            <div class="clearfix"></div>
        </div>
        <div class="form-group">
 <div class="col-sm-12 text-center">
    
    <table>
        <tr>
            <td class="col-sm-3 text-right">
                <?php // $model->agree = 1; ?>
                                <br><input type="checkbox"  id="checkbox1" class="default-input sale-text-req" onclick="checkTerms();"/>

<!--                <br>//<?= $form->field($model, 'agree')->checkbox()->label(false); ?> <p>&nbsp;&nbsp;</p>-->
            </td>

            <td> 
                <div style="width: 800px; height: 90px;border:2px solid red">
             <h5 style="color:black;" >Saya mengaku  semua keterangan di atas adalah benar dan jika saya didapati memberi <br/>
                    maklumat palsu, saya bersetuju permohonan ini (jika telah diluluskan) 
                    akan terbatal dengan sendirinya dan boleh diambil tindakan perundangan. </h5>
                    <p style="color:black;">Tarikh Mohon: <?php echo $model->tarikhmohon;?></p><br/>
                      
            </div>
            </td>
        </tr>
    </table>
     <br/>
     <div>
          
        <div class="col-md-12 col-sm-12 col-xs-12" align="center"> 
            <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1']) ?>
            <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['id'=> 'submitb', 'disabled'=> true, 'class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2']) ?>
            <?= Html::a('Keluar', ['cutibelajar/halaman-pemohon'], ['class' => 'btn btn-danger ']);?>
     
        </div>
    </div>
 </div>
</div>
    </div>
            </div></div>
        <?= $form->field($model, 'icno')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?>
        <?= $form->field($model, 'iklan_id')->hiddenInput(['value' => $iklan->id])->label(false); ?>
        <?= $form->field($model, 'kali_ke')->hiddenInput(['value' => $iklan->kali_ke])->label(false); ?> 
        <?= $form->field($model, 'tarikh_mesyuarat')->hiddenInput(['value' => $iklan->tarikh_mesyuarat])->label(false); ?>  
    
     <?php ActiveForm::end(); ?>
<script>
                function checkTerms() {
                  // Get the checkbox
                  var checkBox = document.getElementById("checkbox1");

                  // If the checkbox is checked, display the output text
                  if (checkBox.checked === true){
                    document.getElementById("submitb").disabled = false;
                  } else {
                    document.getElementById("submitb").disabled = true;
                  }
                }
</script>


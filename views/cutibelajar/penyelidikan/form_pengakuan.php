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
$umum = app\models\cbelajar\RefSemakan::find()->where(['id'=>[97,98,102]])->all();
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
       
      PERMOHONAN LATIHAN PENYELIDIKAN
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
                                    <?php 
                                           if ($p->id == 97) {
                                        if ($model->kakitangan->servPeriodPermanent >= $p->ans_no) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    }
                                          else if ($p->id == 102) {
                                            if ($lnpt >= $p->ans_no) {
                                                $s = 1;
                                                $totalUmum++;
                                            } else {
                                                $s = 0;
                                            }
                                          }
                                                                                    else if ($p->id == 98) {

                                            if ($biodata->statLantikan == $p->ans_no) {
                                                $s = 1;
                                                $totalUmum++;
                                            } else {
                                                $s = 0;
                                            }
                                        }
                                        
                                        
                                       
                                       
                           
                           
                                         
                                   
                                   


                            
                                       
                                    if ($s == 1) {
                                            $color = "#20c997";
                                            $button = "<i class='fa fa-check-circle fa-lg'></i>";
                                        } else if ($s == 0) {
                                            $color = "red";
                                            $button = "<i class='fa fa-times-circle fa-lg'></i>";
                                        } else {
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
                                        <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
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
                SEMAKAN SYARAT LATIHAN PENYELIDIKAN</h5></legend> 
                
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
                       
                        if ($img) {
                            echo Html::img($img->getImageUrl().$img->filename, [
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
            <legend class="scheduler-border">   <h5><i class='fa fa-book'></i> MAKLUMAT LATIHAN PENYELIDIKAN</h5>
            </legend> 
                 <ul class="nav navbar-right panel_toolbox">
                    <i>[FROM SMP-PPI]</i>
                </ul>
            <?php
                    $cp = $biodata->research2;
              if($cp){ ?>
            
            <div>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead style="background-color:lightseagreen;color:white">
                      
                    <tr class="headings">
                        <th class="column-title text-center">BIL</th>
                        <th class="column-title text-center">ID PROJEK </th>
                        <th class="column-title text-center">TAJUK PENYELIDIKAN</th>
                        <th class="column-title text-center">RINGKASAN PENYELIDIKAN</th>
                        <th class="column-title text-center">STATUS</th>
                        <th class="column-title text-center">TARIKH PENYELIDIKAN</th>
                        
                    </tr>
 </thead>
                    <tbody>

                    <?php $bil=1; foreach ($cp as $akademik) { ?>

                        <tr>

                            <td><?= $bil++ ?></td>
                            <td><?= strtoupper($akademik->ProjectID); ?></td>
                            <td><?= strtoupper($akademik->Title);?></td>
<td class="text-center">
<?=    Html::button('<i class="fa fa-info" aria-hidden="true"></i>', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['/cuti-penyelidikan/ringkasan?id='.$akademik->ProjectID,
                  ]),'class' => 'btn btn-primary btn-md mapBtn']); ?>

                                
                                    
                                  </td>
                            <td class="text-center"><?= strtoupper($akademik->ResearchStatus);?></td>
                             <td class="text-center"><?= strtoupper($akademik->StartDate);?> Hingga <?= strtoupper($akademik->EndDate);?>  </td> 

                        </tr>
                    <?php } ?>
                    </tbody>
              
                
                </table>

             </div>
              <?php }
              else{?>
                  <tr>
                      <td class="text-center"><b> TIADA MAKLUMAT</b></td>
                               

                        </tr>
   <?php           }
?>
  
</div>
    
<div class="x_panel">
      <fieldset class="scheduler-border">
            <legend class="scheduler-border">   <h5><i class='fa fa-graduation-cap'></i> MAKLUMAT LATIHAN PENYELIDIKAN YANG DIPOHON</h5>
            </legend>
            <p align="left">
              
            
                <?php
                if (!$pengajian){
                
                //if ($model->status !=0 ) {
//                echo Html::a('Tambah Rekod', ['tambah-pengajian', 'id' => $iklan->id],
//                ['class' => 'btn btn-primary btn-sm']);
                  echo Html::button('<i class="fa fa-plus"></i> Tambah Rekod', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tambah-pengajian?id='.$iklan->id,
                  ]),'class' => 'btn btn-primary btn-sm mapBtn']); ?>
          
                
                </p>
            
       
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
                    <th class="text-center">NO. GERAN</th>
                    <th class="text-center">TAJUK PENYELIDIKAN</th>
                    <th class="text-center">TEMPAT PENYELIDIKAN</th>
                    <th class="text-center">TARIKH PENYELIDIKAN</th>
                    <th class="text-center">JUSTIFIKASI PERMOHONAN</th>
                    <th class="text-center">PENETAPAN KPI SEPANJANG CUTI</th>

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
                                <td class="text-center"><?= strtoupper($rs_d->ProjectID)?></td>
                                <td class="text-center"><?= strtoupper($rs_d->Title)?></td>
                                
                              <td class="text-center"><?= strtoupper($rs_d->ResearchStatus)?></td>

                                <td class="text-center">
                                             <?php if($eduhighest->tarikh_mula && $eduhighest->tarikh_tamat)
                                            {  ?><?= strtoupper($eduhighest->full_dt) ?> 
                                          <br><?php }
                                            else{
                                                echo '<p style="color:red">Tarikh Penyelidikan Tidak Diisi Lengkap'.
                                                    '</p>';
                                                     
                                            }
?> 
                                    </td>
                                    <td class="text-center"><?= strtoupper($eduhighest->catatan)?></td>
                                    <td class="text-center"><?= strtoupper($eduhighest->summary)?></td>

                                <td class="text-center">
<?=    Html::button('<i class="fa fa-info" aria-hidden="true"></i>', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['/cuti-penyelidikan/ringkasan?id='.$eduhighest->research_id,
                  ]),'class' => 'btn btn-default mapBtn']); ?>
<?=    Html::button('<i class="fa fa-pencil" aria-hidden="true"></i>', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['update?id='.$eduhighest->id,
                  ]),'class' => 'btn btn-default mapBtn']); ?>

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


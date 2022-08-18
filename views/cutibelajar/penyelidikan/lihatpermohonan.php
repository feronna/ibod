<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$this->title = 'Permohonan Cuti Belajar'; 
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
     SEKSYEN PEMBANGUNAN PROFESIONALISME | SEKTOR PENGURUSAN BAKAT<br/><u> PERMOHONAN 
     LATIHAN PENYELIDIKAN
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
                                'query' => app\models\cbelajar\TblDokumen::find()->where(['kategori'=>10]),
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
                                            return Html::a('', (Yii::$app->FileManager->DisplayFile($data->sokongan->namafile)), ['class' => 'fa fa-download fa-lg', 'target' => '_blank']);
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
            <legend class="scheduler-border">  
                <h5><i class='fa fa-user'></i>
                MAKLUMAT PERIBADI</h5></legend>     
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
                <h5><?=  strtoupper($biodata->CONm); ?> |
                <?=date("Y") - date("Y", strtotime($biodata->COBirthDt))." ". "TAHUN"?></h5>
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

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
       
        <div class="x_panel">
              <fieldset class="scheduler-border">
            <legend class="scheduler-border">   <h5><i class='fa fa-book'></i> MAKLUMAT AKADEMIK</h5>
            </legend>
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
              <?php }?>
    </div>
</div>

</div>

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
       
        <div class="x_panel">

<fieldset class="scheduler-border">
            <legend class="scheduler-border">   <h5><i class='fa fa-graduation-cap'></i> MAKLUMAT PENGAJIAN/PENEMPATAN YANG DIPOHON</h5>
            </legend>      


                    <div class="x_content ">

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

        </div></div>
  </div>
</div>

<!--  -->






<!-- Dokumen Yang telah dimuatnaik-->






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

     <?php ActiveForm::end(); ?>
   





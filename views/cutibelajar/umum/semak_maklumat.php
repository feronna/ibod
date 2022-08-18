<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 
use kartik\select2\Select2;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;


error_reporting(0);
/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$this->title = 'Permohonan Cuti Belajar'; 
?> 
<!--  <?php echo $this->render('/cbelajar/menu'); ?> -->
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
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

     <div class="row">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['cutibelajar/index']) ?></li>
        <li>Maklumat Pemohon</li>
    </ol>
</div>
             
<p align="right">  <?= Html::a('Kembali', ['cutisabatikal/senaraitindakan'], ['class' => 'btn btn-primary btn-sm']) ?></p>

<div class="x_panel">
        <div class="x_content"> 
              
            <span class="required" style="color:#062f49;">
                <strong>
                    <center>
        
      
        <?= strtoupper('
     SEKSYEN PEMBANGUNAN PROFESIONALISME | SEKTOR PENGURUSAN BAKAT<br/><u> PERMOHONAN SARJANA / SARJANA KEPAKARAN / PHD <b>(SEPENUH MASA)</b>
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
                    SEMAKAN SYARAT SARJANA / SARJANA KEPAKARAN / PHD <b>(SEPENUH MASA)</b></h5></legend> 
                
                 <div class="form-group" align="text-center">
                   
             
                <div class="x_content" >
                    <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead style="background-color:lightseagreen;color:white">
                          
                                <tr class="headings">
                    <th scope="col" colspan=12"  style="background-color:white;color:black;">SYARAT UMUM KELAYAKAN PERMOHONAN:</th>
                    
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
                                
                                <tr class="headings">
                    <th scope="col" colspan=12"  style="background-color:white;color:black;">SYARAT KHUSUS PERMOHONAN DALAM NEGARA:</th>
                    
                </tr>
                            <?php
                            if ($khusus) 
                            { $no=4;?>
                            
                                <?php foreach ($khusus as $dok) { $no++; 
                                   
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $dok->syarat; ?></td>
                         
                                </tr>
                                
                                <?php }
                               
//                             }
                    }
                            ?>
                                
                                <tr class="headings">
                    <th scope="col" colspan=12"  style="background-color:white;color:black;">SYARAT KHUSUS PERMOHONAN LUAR NEGARA:</th>
                    
                </tr>
                            <?php
                            if ($khusus_ln) 
                            { $no=14;?>
                            
                                <?php foreach ($khusus_ln as $dok) { $no++; 
                                   
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
                <h5><i class='fa fa-check-square'></i>
                SEMAKAN DOKUMEN YANG DIKEMUKAKAN</h5></legend>               <div class="table-responsive ">        
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
                                            'label' => 'MUAT TURUN',
                                            'format' => 'raw',
                                            'headerOptions' => ['class' => 'text-center'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'value' => function ($data) use ($ICNO) {
                                            

                                        if((!empty($data->nama_dokumen))&& (!empty($data->sokonganby($ICNO)->namafile))) {
                                            return Html::a('', (Yii::$app->FileManager->DisplayFile($data->sokonganby($ICNO)->namafile)), ['class' => 'fa fa-download fa-lg', 'target' => '_blank']);
                                        } 
                                        else {
                                            return '<b><small>TIADA BUKTI</small></b>';
                                        }
                                    },
                                        ],
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
                    <div class="col-md-12 col-sm-12 col-xs-12"> 

       <?php
                            $dataProvider = new ActiveDataProvider([
                                'query' => app\models\cbelajar\TblDokumenKpm::find()->where(['status' => 1, 'kategori'=>1]),
                                'pagination' => [
                                    'pageSize' => 10,
                ],
            ]);
            ?> 
<div class="x_title">

    <h5> <strong><i class="fa fa-paperclip"></i> DOKUMEN BAGI PERMOHONAN KPM</strong>
</h5>
    <i style="color:red">Borang KPT yang telah ditandatangan dan disahkan hendaklah dihantar kepada Puan Dayang di Bahagian Sumber Manusia.</i>
             
                     
<div class="clearfix"></div>     </div>                       <div class="table-responsive ">        
                        <?=
                        GridView::widget([
                            'dataProvider' => $senarai_dokumenkpm,
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
                                            'label' => 'MUAT TURUN',
                                            'format' => 'raw',
                                            'headerOptions' => ['class' => 'text-center'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'value' => function ($data) use ($ICNO) {
                                            

                                        if((!empty($data->nama_dokumen))&& (!empty($data->sokonganby($ICNO)->namafile))) {
                                            return Html::a('', (Yii::$app->FileManager->DisplayFile($data->sokonganby($ICNO)->namafile)), ['class' => 'fa fa-download fa-lg', 'target' => '_blank']);
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
                           
</div></div>
<div class="x_panel">
  <fieldset class="scheduler-border">
            <legend class="scheduler-border">  
                <h5><i class='fa fa-user-circle'></i>
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
                                        echo '<i>Tiada Maklumat</i>';
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
                    $akademik = $biodata->akademikWarta;
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
<div class="x_panel">
       
             <fieldset class="scheduler-border">
            <legend class="scheduler-border">   <h5><i class='fa fa-users'></i> MAKLUMAT KELUARGA</h5>
            </legend> 
<div class="table-responsive">
    <p style="color:red"> 
Hanya maklumat pasangan dan anak-anak sahaja yang akan tertera:</p>
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead style="background-color:lightseagreen;color:white">
                <tr class="headings">
                    <th>NO. KAD PENGENALAN</th>
                    <th>NAMA</th>
                    <th>HUBUNGAN</th>
                    <th>UMUR</th>
                </tr>
                </thead>
                <?php if($keluarga) {
                    
                   foreach ($keluarga as $keluargakakitangan) {
                    if( $keluargakakitangan->hubunganKeluarga->RelNm == "Suami" || $keluargakakitangan->hubunganKeluarga->RelNm == "Isteri" || $keluargakakitangan->hubunganKeluarga->RelNm == "Anak Kandung"){?>
         
                   
                <tr>
                    <td><?= $keluargakakitangan->FamilyId; ?></td>
                    <td><?= $keluargakakitangan->FmyNm; ?></td>
                    <td><?= $keluargakakitangan->hubkeluarga; ?></td>
                   <td class="text-center"><?=date("Y") - date("Y", strtotime($keluargakakitangan->FmyBirthDt))." " ."TAHUN";?></td>

                </tr>

                   <?php } 
                   
                   } } else{
                    ?>
                    <tr>
                        <td colspan="4" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>
            </div>
</div>
<div class="row">

<div class="col-xs-12 col-md-12 col-lg-12">
<div class="x_panel">

<fieldset class="scheduler-border">
            <legend class="scheduler-border">   <h5><i class='fa fa-graduation-cap'></i> MAKLUMAT PENGAJIAN YANG DIPOHON</h5>
            </legend>    

     <?php if($pengajian){
        foreach ($pengajian as $pengajian) {
                
                ?>  
            

                    <div class="x_content ">

                 <div class="table-responsive">
                     
                        <table class="table table-striped table-sm  table-bordered">
                            <thead>
                                
                                
                                <tr> 
                        <th style="width:10%" align="right">JAWATAN SEMASA CUTI BELAJAR</th>
                        <td style="width:20%">
                        <?=strtoupper($biodata->jawatan->fname) ?></td>
                       
                    </tr>
                     <tr> 
                                
                        <th style="width:10%" align="right">PERINGKAT PENGAJIAN</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($pengajian->tahapPendidikan); ?></td></tr>
                        
                    <tr> 
                                
                        <th style="width:10%" align="right">UNIVERSITI/INSTITUSI</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($pengajian->InstNm); ?></td><?php }?></tr>
                        
                        
                   
                     
                       
                 
                        <th style="width:10%" align="right">BIDANG</th>
                        <td style="width:20%"><?php
                        
                        if(($pengajian->MajorCd == NULL) && ($pengajian->MajorMinor != NULL))
                        {
                                echo  strtoupper($pengajian->MajorMinor);
                        }
                        elseif (($pengajian->MajorCd != NULL) && ($pengajian->MajorMinor != NULL))  {
                            echo   strtoupper($pengajian->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($pengajian->major->MajorMinor);
                        }
?></td>
                          <?php }?> 
                    
                     
                     
                      
                    
                  
                 
                    
                        <tr> 
                     
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td style="width:40%">
                        <?= strtoupper($pengajian->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($pengajian->tarikhtamat)?> (<?= strtoupper($pengajian->tempohtajaan);?>)</td>
                        </tr>
                          
                     
                    
                  
                        
                
                    <tr> 
                                
                        <th style="width:10%" align="right">NAMA PENYELIA</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($pengajian->nama_penyelia); ?></td></tr> 
                        
                  
                    
                     
                                
<!--                                <tr class="headings">
                                    <th class="column-title text-center">Telah Dimuatnaik</th>
                                    <th class="column-title text-center">Belum Dimuatnaik</th>
                                </tr>-->
                            </thead>
                        
                                     
<!--                                   // <td class="text-center">
                                        <?//php
                                   if (!$k->namafile)
                                       {
                                     echo '&#10008;'; }?></td>
                                 
                                </tr>-->
                                
                      
                        </table>
                    </div> 

        </div></div>
  </div>
</div>

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
           <fieldset class="scheduler-border">
            <legend class="scheduler-border">   <h5><i class='fa fa-money'></i> MAKLUMAT PEMBIAYAAN YANG DIPOHON</h5>
            </legend>  
              <?php 
                  
              if($biasiswa){ ?>
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

                    <?php $bil=1; foreach ($biasiswa as $biasiswa) { ?>

                        <tr>

                            <td class="text-center"><?= $biasiswa->nama_tajaan; ?></td>
                            <td class="text-center"><?=  $biasiswa->bantuan->bentukBantuan;?></td>
                            <td class="text-center"><?=  $biasiswa->amaunBantuan;?></td>
                            
                           
                        
                        </tr>
                    <?php } ?>
                        
                </tbody>

</table></form>
             


          
        </div>   
     <?php }
      else{
                    ?>
                    <tr>
                        <td colspan="8" class="text-center"><b>Tiada Rekod</b></td>                     
                    </tr>
                  <?php  
                } ?> 

      

    </div>
</div>
  
</div>
 
 


    
<div class="row" > 
    <div class="col-xs-12 col-md-12 col-lg-12"> 

    <div class="x_panel">
       <fieldset class="scheduler-border">
            <legend class="scheduler-border">   <h5><i class='fa fa-check-square'></i> PERAKUAN PEMOHON</h5>
            </legend>  
        <div class="x_content">
             <h4 style="color:grey;" ><small>Saya mengaku  semua keterangan di atas adalah benar dan jika saya didapati memberi
                    maklumat palsu, saya bersetuju permohonan ini (jika telah diluluskan) 
                    akan terbatal dengan sendirinya dan boleh diambil tindakan perundangan.</small> </h4>
            <h6 style="color:grey;"><small>Tarikh Hantar: <?php echo $model->tarikhmohon;?></small></h6><br/>
        </div>
    </div>
</div>
    
</div>

   


 <!-- Perakuan Ketua Jabatan -->
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $view;?>"> 
    <div class="x_panel">
        <div class="x_title">
            <h5><strong><i class="fa fa-check-square"></i> STATUS PERAKUAN KETUA JABATAN/DEKAN</strong></h5>
<!--            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>-->
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            

            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">STATUS PERAKUAN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->status_jfpiu;?>" disabled="disabled">
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">ULASAN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ulasan_jfpiu')->textArea(['maxlength' => true, 'rows' => 4, 'disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">TARIKH DIPERAKUKAN:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->tarikhkj;?>" disabled="disabled">
                </div>
            </div>    
        </div>
    </div>
</div>     
</div>
 <div class="row">
  <!-- Perakuan Ketua Jabatan -->
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $edit;?>"> 
    <div class="x_panel">
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">   <h5><i class='fa fa-check-square'></i> PERAKUAN KETUA JABATAN/DEKAN</h5>
            </legend>  
        <br>
        <div class="form-group">
           
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">STATUS PERAKUAN:<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($model, 'status_jfpiu')->label(false)->widget(Select2::classname(), [
                        'data' => ['Diperakukan' => 'PERMOHOHAN DIPERAKUKAN', 'Tidak Diperakukan' => 'PERMOHONAN DITOLAK'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "Diperakukan"){
                        $("#ulasan").show();$("#ulasan1").show();
                        }
                        else if($(this).val() == "Tidak Diperakukan"){
                        $("#ulasan1").show();$("#ulasan").hide();}
                        
                        else{$("#ulasan").hide();$("#ulasan1").hide()
                        }'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        
                       
                    ]);
                    ?>
                </div>
        </div><br><br>
        <div class="form-group" id="ulasan" style="display: none" align="center">
        <div style="width: 580px; height: 130px;border:2px solid red">
            <br><p align="left">&nbsp;Saya mengesahkan bahawa semua kenyataan yang diberikan oleh pemohon adalah benar.<br>
               &nbsp;1. Tarikh dan tempoh latihan pra-warta sesuai.<br>
               &nbsp;2. Fungsi JFPIU tidak akan terjejas sepanjang ketidakberadaan kakitangan.<br>
               &nbsp;3. Saya bersetuju untuk memberi pelepasan kepada beliau tanpa staf gantian.<br>
            </p>            </div>
        </div>        
        <div class="form-group" id="ulasan1" style="display: none" align="center">
            <h5 style="font-size:120%;" class="text-justify"> 
                </h5>
                <label class="control-label col-md-3 col-sm-3 col-xs-12">ULASAN: <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ulasan_jfpiu')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
        </div>
        
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                    <button class="btn btn-primary" type="reset">Reset</button>

                </div>
            </div>
    </div>
</div>
        

    </div>

   <?php ActiveForm::end(); ?>





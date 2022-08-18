<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;

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
<div class="col-md-12">
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>
</div>
                        <p align="right">  <?= Html::a('Kembali', ['cbadmin/senaraitindakan1'], ['class' => 'btn btn-primary btn-sm']) ?></p>
<div class="x_panel">
        <div class="x_content"> 
              
            <span class="required" style="color:#062f49;">
                <strong>
                    <center>
        
      
        <?= strtoupper('
     SEKSYEN PEMBANGUNAN PROFESIONALISME | SEKTOR PENGURUSAN BAKAT<br/><u> PERMOHONAN PENGAJIAN LANJUTAN
     
        '); ?>
        
      

                        
                </strong> </center>
            </span> 
        </div>
    </div>
<div class="x_panel">
     <div class="col-md-12 col-sm-12 col-xs-12">

   
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
                <h5><?=  strtoupper($biodata->CONm); ?></h5>
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
                        <td style="width:20%"><?= $biodata->displayStartLantik; ?></td>
                       <th width="20%">TARAF PERKAHWINAN: </th>
                       <td><?= strtoupper($biodata->displayTarafPerkahwinan) ?></td> 

                    </tr>
                    <tr> 

                        <th style="width:20%">TARIKH DISAHKAN DALAM PERKHIDMATAN</th>
                        <td style="width:20%">  <?php
                                    if ($biodata->confirmDt) {
                                        echo $biodata->confirmDt->tarikhMula;
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
 </div>
<div class="x_panel">
      <div class="col-md-12 col-sm-12 col-xs-12"> 

<fieldset class="scheduler-border">
            <legend class="scheduler-border">  
                <h5><i class='fa fa-graduation-cap'></i>
                MAKLUMAT PENGAJIAN YANG DIPOHON</h5></legend>        

     <?php if($pengajian){
        foreach ($pengajian as $pengajian) {
                
                ?>  
            

                    <div class="x_content ">

                 <div class="table-responsive">
                     
                        <table class="table table-striped table-sm  table-bordered">
                            <thead>
                                
                                <tr class="headings">
                                    <th colspan="2" style="background-color:lightseagreen;color:white"><center>
            
                                <?php if($pengajian->tahapPendidikan)
                                {
                                 echo strtoupper($pengajian->tahapPendidikan);
                                         
                                }
                                
                              
?></center></th>
                                </tr>
                                <tr> 
                        <th style="width:10%" align="right">JAWATAN SEMASA CUTI BELAJAR</th>
                        <td style="width:20%">
                        <?=strtoupper($biodata->jawatan->fname) ?></td>
                       
                    </tr>
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
                                
                        <th style="width:10%" align="right">MOD PENGAJIAN</th>
                        <td style="width:20%">
                            
                                  <?php if($pengajian->modeID)
                                  {echo strtoupper($pengajian->mod->studyMode);}
                                  
                                  else{
                                      echo "Tiada Maklumat";
                                  }
?></td></tr>
                     
                      <tr> 
                                
                        <th style="width:10%" align="right">TAJUK PENYELIDIKAN</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($pengajian->tajuk_tesis); ?></td></tr>
                        <tr> 
                                
                        <th style="width:10%" align="right">NAMA PENYELIA</th>
                        <td style="width:20%">
                                  <?php echo strtoupper($pengajian->nama_penyelia); ?></td></tr>
                          <tr> 
                                
                        <th style="width:10%" align="right">EMEL PENYELIA</th>
                        <td style="width:20%">
                                  <?php echo ($pengajian->emel_penyelia); ?></td></tr>
                    
                  
                 
                    
                        <tr> 
                     
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td style="width:40%">
                        <?= strtoupper($pengajian->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($pengajian->tarikhtamat)?> (<?= strtoupper($pengajian->tempohpengajian);?>)</td>
                        </tr>
                        
                         <tr> 
                     
                        <th style="width:10%" align="right">STATUS KETUA JABATAN/DEKAN</th>
                        <td style="width:40%">
                        <?= strtoupper($kontrak->statusjfpiu)?> </td>
                        </tr>
                          
                     
                    
                  
                
                    
                        
                  
                    
                     
                                
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
<div class="x_panel">
          <div class="col-md-12 col-sm-12 col-xs-12"> 

       <fieldset class="scheduler-border">
            <legend class="scheduler-border">  
                <h5><i class='fa fa-user'></i>
                MAKLUMAT LAPORAN NILAIAN PRESTASI TAHUNAN (LNPT)</h5></legend>  
        
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
               <thead>
                <tr class="headings" style="background-color:lightseagreen; color:white;">
                    <th class="text-center">Tahun</th>
                    <th class="text-center">Markah Purata</th>
                </tr>
               </thead>
                        <tr>
                            <td class="text-center"><?= date('Y')-1; ?></td>
                            <td class="text-center"><?= $kontrak->markahlnpt(date('Y')-1); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?php echo date('Y')-2; ?></td>
                            <td class="text-center"><?= $kontrak->markahlnpt(date('Y')-2); ?></td>
                        </tr>
                        <tr>
                            <td class="text-center"><?php echo date('Y')-3; ?></td>
                            <td class="text-center"><?= $kontrak->markahlnpt(date('Y')-3); ?></td>
                        </tr>
            </table>
            </div>
        </div>
    </div>
</div>

<div class="x_panel">
    
          <fieldset class="scheduler-border">
            <legend class="scheduler-border">  
                 <?php if(($pengajian->HighestEduLevelCd == 1) || ($pengajian->HighestEduLevelCd == 102) ||
                ($pengajian->HighestEduLevelCd == 202)|| ($pengajian->HighestEduLevelCd == 20) || ($pengajian->modeStudy == "SEPENUH MASA")){?>
                <h5><i class='fa fa-check-square'></i>
                SEMAKAN SYARAT PENGAJIAN LANJUTAN  </h5></legend> 
                <div class="x_content ">
                 <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead style="background-color:lightseagreen;color:white">
                                <tr class="headings">
                                    <th class="text-center" rowspan="2">No.</th>
                                    <th class="text-center" rowspan="2">Perkara</th>
                                    <th class="text-center" colspan="2">Tindakan</th>
                                  
                                  
                                </tr>
                                <tr class="headings">
                                    <th class="column-title text-center">Ya</th>
                                    <th class="column-title text-center">Tidak</th>
                                </tr>
                                <tr class="headings">
                    <th scope="col" colspan=12"  style="background-color:white;color:black;">SYARAT UMUM KELAYAKAN PERMOHONAN:</th>
                    
                </tr>
                            </thead>
                         <?php
                            if ($semak) 
                            { $no=0;?>
                            
                                <?php foreach ($semak as $kpi) { $no++; 
                                $mod = \app\models\cbelajar\TblNilaiSyarat::find()->where(['syarat_id' => $kpi->syarat_id, 'icno' => $icno, 'iklan_id'=>$kontrak->iklan_id, 'parent_id'=>$kontrak->id])->one();
                                     
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $kpi->syarat; ?></td>
                                    <td class="text-center"><?php if($mod->semak_phd === 'y') {echo '&#10004;';} ?></td>
                                    <td class="text-center"><?php if($mod->semak_phd === 'n') {echo '&#10008;';} ?></td>
                                 
                                </tr>
                                
                                <?php }
                               
//                             }
              }
                            ?>
                                
                           <tr class="headings">
                    <th scope="col" colspan=12"  style="background-color:white;color:black;">SYARAT - SYARAT KHUSUS PERMOHONAN DALAM NEGARA:</th>
                    
                </tr>
                         <?php
                            if ($khusus) 
                            { $no=4;?>
                            
                                <?php foreach ($khusus as $kpi) { $no++; 
                                $mod = \app\models\cbelajar\TblNilaiSyarat::find()->where(['syarat_id' => $kpi->syarat_id, 'icno' => $icno, 'iklan_id'=>$kontrak->iklan_id, 'parent_id'=>$kontrak->id])->one();
                                     
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $kpi->syarat; ?></td>
                                    <td class="text-center"><?php if($mod->semak_phd === 'y') {echo '&#10004;';} ?></td>
                                    <td class="text-center"><?php if($mod->semak_phd === 'n') {echo '&#10008;';} ?></td>
                                 
                                </tr>
                                
                                <?php }
                               
//                             }
              }
                            ?>
                                
                        <tr class="headings">
                    <th scope="col" colspan=12"  style="background-color:white;color:black;">SYARAT - SYARAT KHUSUS PERMOHONAN LUAR NEGARA:</th>
                    
                </tr>
                         <?php
                            if ($khusus_ln) 
                            { $no=14;?>
                            
                                <?php foreach ($khusus_ln as $kpi) { $no++; 
                                $mod = \app\models\cbelajar\TblNilaiSyarat::find()->where(['syarat_id' => $kpi->syarat_id, 'icno' => $icno, 'iklan_id'=>$kontrak->iklan_id, 'parent_id'=>$kontrak->id])->one();
                                     
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $kpi->syarat; ?></td>
                                    <td class="text-center"><?php if($mod->semak_phd === 'y') {echo '&#10004;';} ?></td>
                                    <td class="text-center"><?php if($mod->semak_phd === 'n') {echo '&#10008;';} ?></td>
                                 
                                </tr>
                                
                                <?php }
                               
//                             }
              }
                            ?>
                        </table>

                    </div>       <div class="pull-right">
                        <?php 
                 echo Html::a('<i class="fa far fa-hand-point-up"></i> Kemaskini Semakan', ['update-semakan-syarat', 'id' =>$kontrak->id, 'ICNO'=>$kontrak->icno, 'takwim_id'=>$kontrak->iklan_id], [
                    'class'=>'btn btn-success btn-sm', 
                    'target'=>'_self', 
                    //'data-toggle'=>'tooltip', 
                    //'title'=>'Will open the generated PDF file in a new window'
                ]);?>
                <?php 
                echo Html::a('<i class="fa far fa-hand-point-up"></i> Cetak Semakan', ['/sepenuh-masa/generate-semakan-syarat', 'id' =>$kontrak->id, 'ICNO'=>$kontrak->icno, 'takwim_id'=>$kontrak->iklan_id], [
                    'class'=>'btn btn-primary btn-sm', 
                    'target'=>'_self', 
                    //'data-toggle'=>'tooltip', 
                    //'title'=>'Will open the generated PDF file in a new window'
                ]);
                ?>
                
            </div> </div>
              </div>
                <?php }?>
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
<div class="x_content">
       <?php
                            $dataProvider = new ActiveDataProvider([
                                'query' => app\models\cbelajar\TblDokumenLn::find()->where(['status' => 1, 'kategori'=>1]),
                                'pagination' => [
                                    'pageSize' => 10,
                ],
            ]);
            ?> 
<div class="x_title">

    <h5> <strong><i class="fa fa-paperclip"></i> DOKUMEN BAGI PERMOHONAN LUAR NEGARA</strong> </h5>
                  
                     
<div class="clearfix"></div>     </div>     
    <div class="table-responsive ">        
                        <?=
                        GridView::widget([
                            'dataProvider' => $senarai_dokumenln,
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
                              
    </div></div>
                            </div>
                        
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
 
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $view;?>"> 
    <div class="x_panel">
        
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Hasil Semakan</strong></h2>
<!--            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>-->
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

       

            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Semakan:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $kontrak->status_semakan;?>" disabled="disabled">
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($kontrak, 'ulasan_bsm')->textArea(['maxlength' => true, 'rows' => 6, 'disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            
                  <p align="center"> <?= Html::button('<i class="fa fa-pencil" aria-hidden="true"></i> KEMASKINI ULASAN', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['kemaskini-ulasan?id='.$id.'&ICNO='.$ICNO]),
                        'class' => 'btn btn-success btn-sm mapBtn']) ?></p> 
        </div>
    </div>
</div>     
</div>

 <div class="row">
  <!-- Semakan Admin BSM -->
<div class="col-xs-12 col-md-12 col-lg-12" style="display: <?php echo $edit;?>"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list-alt"></i> Hasil Semakan</strong></h2>
            <div class="clearfix"></div>
        </div>
        <br>
        <div class="form-group">
           
                <label class="control-label col-md-3 col-sm-3 col-xs-3">Semakan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($kontrak,'status_semakan')->label(false)->widget(Select2::classname(), [
                        'data' => ['Layak Dipertimbangkan' => 'LAYAK DIPERTIMBANGKAN', 'Tidak Layak Dipertimbangkan' => 'TIDAK LAYAK DIPERTIMBANGKAN', 'Dokumen Tidak Lengkap' => 'DOKUMEN TIDAK LENGKAP'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "Dimajukan untuk pertimbangan JK Pengajian Lanjutan Akademik"){
                        $("#ulasan").show();$("#ulasan1").show();
                        }
                        else if($(this).val() == "Dokumen Tidak Lengkap"){
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
        </div>
          
        <div class="form-group" align="center">
            <h5 style="font-size:120%;" class="text-justify"> 
                </h5>
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan: <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($kontrak, 'ulasan_bsm')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
        </div>
        
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
    </div>
</div>
 </div>
<?php ActiveForm::end(); ?>

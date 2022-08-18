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
<?php
$umum = app\models\cbelajar\RefPhd::find()->where(['id'=>[1,2,4,10,11,12,13]])->all();
$akademik = app\models\hronline\Tblpendidikan::find()->where([ 'HighestEduLevelCd'=> 8])->one();
?>

<?php echo $this->render('/cutibelajar/_topmenu');?>
                        <p align="right">  <?= Html::a('Kembali', ['cbadmin/senaraitindakan1'], ['class' => 'btn btn-primary btn-sm']) ?></p>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
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
                <h5><?=  strtoupper($biodata->CONm); ?>
                |
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
 <p align ="left"><?php // Html::a('KEMASKINI <i class="fa fa-pencil" aria-hidden="true"></i>', ['', 'id' => $eduhighest->id],
//  ['class' => 'btn btn-default'])
           echo Html::button('KEMASKINI <i class="fa fa-pencil" aria-hidden="true"></i>', 
                    ['id' => 'modalButton', 
                    'value' => \yii\helpers\Url::to(['update-study?id='.$studi->id.'&idb='.$biasiswa->id.'&ICNO='.$ICNO.'&takwim_id='.$iklan->id]),
                     'class' => 'btn btn-primary btn-sm mapBtn'])                               
                   ;?> </p>
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
                                  <?php echo $pengajian->emel_penyelia; ?></td></tr>
                    
                  
                 
                    
                        <tr> 
                     
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN LANJUTAN</th>
                        <td style="width:40%">
                        <?= strtoupper($pengajian->tarikhmula)?> <b>HINGGA</b> 
                        <?= strtoupper($pengajian->tarikhtamat)?> (<?= strtoupper($pengajian->tempohtajaan);?>)</td>
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
                <h5><i class='fa fa-bar-chart'></i>
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
                            <td class="text-center"><?php echo date('Y')-1; ?></td>
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
                                            'header' => 'STATUS DOKUMEN',
                                            'class' => 'yii\grid\ActionColumn',
                                            'template' => '{muatnaik}',
                                            'buttons' => [
                                                'muatnaik' => function($url, $model, $key) use ($biodata, $iklan)
                                                {
                                                     if ($model->checkUploada($biodata->ICNO,$model->id, $iklan->id)) {
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
                                            'header' => 'STATUS DOKUMEN',
                                            'class' => 'yii\grid\ActionColumn',
                                            'template' => '{muatnaik}',
                                            'buttons' => [
                                                'muatnaik' => function($url, $model, $key) use ($biodata, $iklan)
                                                {
                                                     if ($model->checkUploada($biodata->ICNO,$model->id, $iklan->id)) {
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
                  
                     
<div class="clearfix"></div>     </div>                       <div class="table-responsive ">        
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
                                            'header' => 'STATUS DOKUMEN',
                                            'class' => 'yii\grid\ActionColumn',
                                            'template' => '{muatnaik}',
                                            'buttons' => [
                                                'muatnaik' => function($url, $model, $key) use ($biodata, $iklan)
                                                {
                                                   if ($model->checkUploada($biodata->ICNO,$model->id, $iklan->id)) {
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
                        
    
    
                         
    
    
                            
   
                        <div class="row">
<div class="col-xs-12 col-md-12 col-lg-12"> 
<div class="x_panel">
     <div class="x_title">
                <h5>RUJUKAN SYARAT UMUM</h5>  
                <div class="clearfix"></div>
            </div> <br/>
<div class="table-responsive">

                <div class="col-md-6 col-sm-6 col-xs-6">
                    <center> 
                        <table class="table table-sm table-bordered jambo_table table-striped" style="width:80%"> 
                            <tr>   
                                <th colspan="3" class="text-center" style="background-color:lightseagreen; color:white;">RUJUKAN</th>   
                            </tr>
                                  <tr>   
                                <th style="width:40%">UMUR</th>  
                                <td colspan="2">
                                    <small> <?=date("Y") - date("Y", strtotime($biodata->COBirthDt))." ". "TAHUN"?></small>
                                </td> 
                            </tr> <tr>   
                                <th style="width:40%">WARGANEGARA MALAYSIA</th>  
                                <td colspan="2">
                                    <?php

                                    if ($biodata->warganegara->CountryCd == "MYS") {
                                        echo '<small>YA</small>';
                                    } else {
                                        echo 'TIDAK';
                                    }
                                    ?>
                                </td> 
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
                            <tr>   
                                <th>BEBAS TINDAKAN TATATERTIB</th>  
                                <td colspan="2"><?= $biodata->usercv ? $biodata->usercv->statusTatatertib() : '-'; ?></td> 
                            </tr>
                            <tr>   
                                <th>TEMPOH PERKHIDMATAN</th>  
                                <td colspan="2"><small><?= strtoupper($biodata->servPeriodPermanent);   ?></small></td> 
                            </tr>
                            <tr>   
                                <th>PERINGKAT PENGAJIAN - SARJANA MUDA</th>  
                                <td colspan="2"> 
                                <small><?php if($akad->HighestEduLevelCd == 7){?>
                                    <?= $akad->OverallGrade; ?>
                                <?php }?>
                             </small>
                                </td> 
                            </tr> 
                            <tr>   
                                <th>TEMPAT PENGAJIAN</th>  
                                <td colspan="2"> 
                                <small><?= $pengajian->InstNm; 
                             ?></small>
                                </td> 
                            </tr> 
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
                                <th>PERAKUAN KETUA JABATAN</th>  
                                <td colspan="2"> <small><?= strtoupper($kontrak->statusjfpiu)?></small></td> 
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
                                    <?php if ($p->id == 1) {
                                        if ($biodata->warganegara->CountryCd == "MYS") {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    
                                    } 
                             elseif ($p->id == 2) {
                                        if ($pengesahan_status == $p->ans_char) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    } else if ($p->id == 4) {
                                       if($kontrak->status_jfpiu == "Diperakukan")
                                       {
                                           $s =1;
                                           $totalUmum++;
                                       }
                                       else
                                       {
                                           $s=0;
                                       }
                                    }
                                     else if ($p->id == 11) {
                                       if($pengajian->HighestEduLevelCd == 1 && $biodata->umur <= 43)
                                       {
                                           $s =1;
                                           $totalUmum++;
                                       }
                                       else
                                       {
                                           $s=0;
                                       }
                                    }
                                     else if ($p->id == 10) {
                                       if($pengajian->HighestEduLevelCd == 20 && $biodata->umur <= 45)
                                       {
                                           $s =1;
                                           $totalUmum++;
                                       }
                                       else
                                       {
                                           $s=0;
                                       }
                                     }
                                       elseif($p->id == 13)
                                       {
                                           if($akad->HighestEduLevelCd == 7 && $akad->OverallGrade >= 3.0)
                                           {
                                               $s = 1;
                                               $totalUmum++;
                                               
                                           }
                                           else
                                           {
                                               $s=0;
                                           }
                                       }
//                                       elseif ($p->id == 15) {
//                                        if (($biodata->usercv ? $biodata->usercv->tatatertib_status : '') == $p->ans_no) {
//                                            $s = 1;
//                                            $totalUmum++;
//                                        } else {
//                                            $s = 0;
//                                        }
                                        
                                        
                                    //}
//                                     elseif($p->id == 8)
//                                       {
//                                           if($pengajian->statusp == "DN")
//                                           {
//                                               $s = 1;
//                                               $totalUmum++;
//                                               
//                                           }
//                                           else
//                                           {
//                                               $s=0;
//                                           }
//                                       }
//                                       elseif($p->id == 9)
//                                       {
//                                           if($pengajian->statusp == "LN")
//                                           {
//                                               $s = 1;
//                                               $totalUmum++;
//                                               
//                                           }
//                                           else
//                                           {
//                                               $s=0;
//                                           }
//                                       }

                            
                                       
                                    

                                    if ($s == 1) {
                                        $color = "white";
                                        $button = "<i class='fa fa-check-circle fa-lg'></i>";
                                    } else if ($s == 0) {
                                        if ($p->id == 2) {
                                            $color = "white";
                                        } else {
                                            $color = "white";
                                        }
                                        $button = "<i class='fa fa-times-circle fa-lg'></i>";
                                    } else {
                                        $color = "#1E90FF";
                                        $button = "HOLD";
                                    }
                                    ?>
                                    <td colspan="2" style="background-color:<?= $color; ?>" class="text-center">  
                                        <?= Html::a($button, [''], ['class' => 'btn btn-info btn-md', 'disabled' => true]); ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                           
                        </table>
                    </center>
                </div>
</div>
</div></div></div>
 

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
<div class="x_panel">
                
    
    <fieldset class="scheduler-border">
            <legend class="scheduler-border">  
                 <?php if(($pengajian->HighestEduLevelCd == 1) || ($pengajian->HighestEduLevelCd == 102) ||
                ($pengajian->HighestEduLevelCd == 202)|| ($pengajian->HighestEduLevelCd == 20) || ($pengajian->modeStudy == "SEPENUH MASA")){?>
                <h5><i class='fa fa-check-square'></i>
                SEMAKAN SYARAT PENGAJIAN LANJUTAN  </h5></legend> 
                
                 <div class="form-group" align="text-center">
                   
             
                <div class="x_content">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead style="background-color:lightseagreen;color:white">
                                <tr class="headings">
                                    <th class="text-center" rowspan="2">Bil</th>
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
                            if ($kriteriakpi) 
                            { $no=0;
//                            echo app\models\cbelajar\TblPermohonan::find()->where(['icno'=>$icno])->one()->status_jfpiu;

//                           echo app\models\hronline\Tblrscoconfirmstatus::find()->where(['ICNO'=>$icno])->orderBy(['ConfirmStatusStDt'=>SORT_DESC])->one()->ConfirmStatusCd;

                                foreach ($kriteriakpi as $kpi) { $no++; 
                                $mod = \app\models\cbelajar\TblNilaiSyarat::find()->where(['syarat_id' => $kpi->syarat_id, 'icno' => $icno, 'iklan_id'=>$kontrak->iklan_id, 'parent_id'=>$kontrak->id])->all();
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $kpi->syarat; ?></td>
                                    <td class="text-center"><input type="radio" name="<?=$kpi->syarat_id.'semak_phd'?>" value="y" 
                                        <?php if(eval('return '.$kpi->checking. ';')== 1){echo "checked";}?>></td>
                                    
                                    <td class="text-center"><input type="radio" name="<?=$kpi->syarat_id.'semak_phd'?>" value="n"<?php if(eval('return '.$kpi->checking. ';')=== false){echo "checked";}?>></td>
                                   
                                </tr>
                                
                                <?php }
                               
//                             }
                            }
                            ?>
                                 <tr class="headings">
                    <th scope="col" colspan=12"  style="background-color:white;color:black;">SYARAT 
                        - SYARAT KHUSUS PERMOHONAN DALAM NEGARA:</th>
                    
                </tr>
<?php
                            if ($khusus) 
                            { $no=4;
//                            echo app\models\cbelajar\TblPermohonan::find()->where(['icno'=>$icno])->one()->status_jfpiu;

//                           echo app\models\hronline\Tblrscoconfirmstatus::find()->where(['ICNO'=>$icno])->orderBy(['ConfirmStatusStDt'=>SORT_DESC])->one()->ConfirmStatusCd;

                                foreach ($khusus as $kpi) { $no++; 
                                $mod = \app\models\cbelajar\TblNilaiSyarat::find()->where(['syarat_id' => $kpi->syarat_id, 'icno' => $icno, 'iklan_id'=>$kontrak->iklan_id, 'parent_id'=>$kontrak->id])->all();
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $kpi->syarat; ?></td>
                                    <td class="text-center"><input type="radio" name="<?=$kpi->syarat_id.'semak_phd'?>" value="y" 
                                        <?php if(eval('return '.$kpi->checking. ';')== 1){echo "checked";}?>></td>
                                    
                                    <td class="text-center"><input type="radio" name="<?=$kpi->syarat_id.'semak_phd'?>" value="n"<?php if(eval('return '.$kpi->checking. ';')=== false){echo "checked";}?>></td>
                                   
                                </tr>
                                
                                <?php }
                               
//                             }
                            }
                            ?>
                                <tr class="headings">
                    <th scope="col" colspan=12"  style="background-color:white;color:black;">SYARAT 
                        - SYARAT KHUSUS PERMOHONAN LUAR NEGARA:</th>
                    
                </tr>
<?php
                            if ($khusus_ln) 
                            { $no=14;
//                            echo app\models\cbelajar\TblPermohonan::find()->where(['icno'=>$icno])->one()->status_jfpiu;

//                           echo app\models\hronline\Tblrscoconfirmstatus::find()->where(['ICNO'=>$icno])->orderBy(['ConfirmStatusStDt'=>SORT_DESC])->one()->ConfirmStatusCd;

                                foreach ($khusus_ln as $kpi) { $no++; 
                                $mod = \app\models\cbelajar\TblNilaiSyarat::find()->where(['syarat_id' => $kpi->syarat_id, 'icno' => $icno, 'iklan_id'=>$kontrak->iklan_id, 'parent_id'=>$kontrak->id])->all();
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $kpi->syarat; ?></td>
                                    <td class="text-center"><input type="radio" name="<?=$kpi->syarat_id.'semak_phd'?>" value="y" 
                                        <?php if(eval('return '.$kpi->checking. ';')== 1){echo "checked";}?>></td>
                                    
                                    <td class="text-center"><input type="radio" name="<?=$kpi->syarat_id.'semak_phd'?>" value="n"<?php if(eval('return '.$kpi->checking. ';')=== false){echo "checked";}?>></td>
                                   
                                </tr>
                                
                                <?php }
                               
//                             }
                            }
                            ?>
                        </table>
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <center><?= Html::submitButton('<i class="fa fa-save"></i>&nbsp;Hantar Semakan' ,['class' => 'btn btn-primary btn-sm', 'name' => 'hantar']) ?>
                            <a style="color: green; font-weight: bold"><?php echo $message;?></a>


        
                    </div>
                </div>
                    </div>
            
            </div>
           
            </div>
        </div>
    
</div>
                <?php }?>
                        






<?php ActiveForm::end(); ?>

  




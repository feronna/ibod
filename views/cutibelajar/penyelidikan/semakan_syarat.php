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
$umum = app\models\cbelajar\RefSemakan::find()->where(['id'=>[97,98,102]])->all();
$akademik = app\models\hronline\Tblpendidikan::find()->where([ 'HighestEduLevelCd'=> 8])->one();
?>

<?php echo $this->render('/cutibelajar/_topmenu');?>
                        <p align="right">  <?= Html::a('Kembali', ['cbadmin/senaraitindakan1'], ['class' => 'btn btn-primary btn-sm']) ?></p>
<div class="x_panel">
        <div class="x_content"> 
              
            <span class="required" style="color:#062f49;">
                <strong>
                    <center>
        
      
        <?= strtoupper('
     SEKSYEN PEMBANGUNAN PROFESIONALISME | SEKTOR PENGURUSAN BAKAT<br/><u> PERMOHONAN LATIHAN PENYELIDIKAN
        '); ?>
        
      

                        
                </strong> </center>
            </span> 
        </div>
    </div>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

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
                  echo Html::button('<i class="fa fa-plus"></i> Tambah Rekod', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tambah-pengajian2?id='.$id.'&ICNO='.$ICNO.'&takwim_id='.$takwim_id,
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
</div></div>
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
                    

                                    </div>
                           
</div></div>
   
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12"> 
<div class="x_panel">
    
                  <fieldset class="scheduler-border">
            <legend class="scheduler-border">  
                <h5><i class='fa fa-check-square'></i>
                SEMAKAN SYARAT LATIHAN PENYELIDIKAN </h5></legend> 
                
                 <div class="form-group" align="text-center">
                   
             
                <div class="x_content" >
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
                                    
                            </thead>
                            <?php
                            if ($doktoral) 
                            { $no=0;?>
                            
                                <?php foreach ($doktoral as $dok) { $no++; 
                                $mod = \app\models\cbelajar\TblNilaiSyarat::find()->where(['syarat_id' => $dok->syarat_id, 'icno' => $icno, 'iklan_id'=> $kontrak->iklan_id, 'parent_id'=>$kontrak->id])->one();
                                   
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $dok->syarat; ?></td>
                                    <td class="text-center"><input type="radio" name="<?=$dok->syarat_id.'semak_phd'?>" value="y" <?php if($mod->semak_phd){if($mod->semak_phd === 'y'){echo "checked";}}?>></td>
                                    <td class="text-center"><input type="radio" name="<?=$dok->syarat_id.'semak_phd'?>" value="n" <?php if($mod->semak_phd){if($mod->semak_phd === 'n'){echo "checked";}}?>></td>
                                   
                                    
                                </tr>
                                
                                <?php }
                               
//                             }
                    }
                            ?>

                        </table>
                        <div class="form-group">
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
    
</div> 


            
                        






<?php ActiveForm::end(); ?>

  




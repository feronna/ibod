<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
$this->title = 'Permohonan Cuti Belajar'; 
error_reporting(0);
?>
<div class="col-md-12">
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>
</div>
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">  
     <div class="x_panel">
          <div class="x_title">
                   
                    <h5> <strong><center>MAKLUMAT KAKITANGAN</center></strong> </h5>
                     
                    <div class="clearfix"></div>
                </div>
    <table class="table table-sm table-bordered">

                   <tr>
                    <td width="15%"><strong>Nama Pegawai</strong></td>
                    <td><?= $kontrak->kakitangan->CONm; ?></td>
                </tr>
                <tr>
                    <td><strong>No. KP / Pasport</strong></td>
                    <td><?= $kontrak->kakitangan->ICNO; ?></td>
                </tr>

                  <tr>
                    <td><strong>JFPIU</strong></td>
                    <td><?= strtoupper($kontrak->kakitangan->department->fullname); ?></td>
                </tr>
                <tr>
                    <td><strong>Jawatan / Gred</strong></td>
                    <td><?= strtoupper($kontrak->kakitangan->jawatan->nama); ?> / <?= strtoupper($kontrak->kakitangan->jawatan->gred); ?></td>
                </tr>
                 <tr>
             <td><strong>Peringkat Pengajian Yang Dipohon</strong></td>
             <td><?= strtoupper($kontrak->s->pendidikanTertinggi->HighestEduLevel); ?></td>
    </tr>
                
                <tr>
                    <td><strong>Status Perakuan Ketua Jabatan</strong></td>
                    <td><?= strtoupper($kontrak->status_jfpiu); ?></td>
                </tr>
                
                 <tr>
                    <td><strong>Tempoh Pengajian</strong></td>
                    <td><?= strtoupper($kontrak->s->tempohtajaan); ?></td>
                </tr>
                
            </table
            
</div>
  </div>
  </div>
</div>
<div class="x_panel">

          <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <h5> <strong><center>SEMAKAN SYARAT CUTI BELAJAR - CUTI SABATIKAL | UNIT PENGAJIAN LANJUTAN (UPL)</center></strong> </h5>
                     
                    <div class="clearfix"></div>
                </div>    <div class="x_content collapse">
                 <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center" rowspan="2">No.</th>
                                    <th class="text-center" rowspan="2">Perkara</th>
                                    <th class="text-center" colspan="2">Tindakan</th>
                                  
                                  
                                </tr>
                                <tr class="headings">
                                    <th class="column-title text-center">Ya</th>
                                    <th class="column-title text-center">Tidak</th>
                                </tr>
                            </thead>
                         <?php
                            if ($sabatikal) 
                            { $no=0;?>
                            
                                <?php foreach ($sabatikal as $dok) { $no++; 
                                $mod = \app\models\cbelajar\TblSemakSyarat::find()->where(['syarat_id' => $dok->syarat_id, 'icno' => $icno, 'iklan_id'=>$kontrak->iklan_id])->one();
                                     
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $dok->syarat; ?></td>
                                    <td class="text-center"><?php if($mod->semak_sabatikal === 'y') {echo '&#10004;';} ?></td>
                                    <td class="text-center"><?php if($mod->semak_sabatikal === 'n') {echo '&#10008;';} ?></td>
                                 
                                </tr>
                                
                                <?php }
                               
//                             }
                            }
                            ?>
                        </table>
                    </div>   <div class="pull-right">
                <?php 
                echo Html::a('<i class="fa far fa-hand-point-up"></i> Cetak Semakan', ['/cutibelajar/generate-semakan-syarat-sabatikal', 'id' =>$kontrak->id, 'ICNO'=>$kontrak->icno, 'takwim_id'=>$kontrak->iklan_id], [
                    'class'=>'btn btn-primary btn-sm', 
                    'target'=>'_self', 
                    //'data-toggle'=>'tooltip', 
                    //'title'=>'Will open the generated PDF file in a new window'
                ]);
                ?>
            </div>     </div></div>
<div class="x_panel">
    
          <div class="x_title">
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <h5> <strong><center>SEMAKAN SYARAT CUTI BELAJAR - LATIHAN INDUSTRI | UNIT PENGAJIAN LANJUTAN (UPL)</center></strong> </h5>
                     
                    <div class="clearfix"></div>
                </div>
                <div class="x_content collapse">
                 <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center" rowspan="2">No.</th>
                                    <th class="text-center" rowspan="2">Perkara</th>
                                    <th class="text-center" colspan="2">Tindakan</th>
                                  
                                  
                                </tr>
                                <tr class="headings">
                                    <th class="column-title text-center">Ya</th>
                                    <th class="column-title text-center">Tidak</th>
                                </tr>
                            </thead>
                         <?php
                            if ($latihan) 
                            { $no=0;?>
                            
                                <?php foreach ($latihan as $kpi) { $no++; 
                                $mod = \app\models\cbelajar\TblSemakSyarat::find()->where(['syarat_id' => $kpi->syarat_id, 'icno' => $icno, 'iklan_id'=>$kontrak->iklan_id])->one();
                                     
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-justify"><?php echo $kpi->syarat; ?></td>
                                    <td class="text-center"><?php if($mod->semak_latihan === 'y') {echo '&#10004;';} ?></td>
                                    <td class="text-center"><?php if($mod->semak_latihan === 'n') {echo '&#10008;';} ?></td>
                                 
                                </tr>
                                
                                <?php }
                               
//                             }
                            }
                            ?>
                        </table>
                    </div>       <div class="pull-right">
                <?php 
                echo Html::a('<i class="fa far fa-hand-point-up"></i> Cetak Semakan', ['/cutibelajar/generate-semakan-syarat-latihan', 'id' =>$kontrak->id, 'ICNO'=>$kontrak->icno, 'takwim_id'=>$kontrak->iklan_id], [
                    'class'=>'btn btn-primary btn-sm', 
                    'target'=>'_self', 
                    //'data-toggle'=>'tooltip', 
                    //'title'=>'Will open the generated PDF file in a new window'
                ]);
                ?>
            </div> </div>
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
                    <?= $form->field($kontrak, 'ulasan_bsm')->textArea(['maxlength' => true, 'rows' => 4, 'disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            
              
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
                        'data' => ['Layak Dipertimbangkan' => 'LAYAK DIPERTIMBANGKAN', 'Dokumen Tidak Lengkap' => 'DOKUMEN TIDAK LENGKAP'],
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

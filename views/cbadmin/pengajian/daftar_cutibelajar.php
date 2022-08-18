<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use yii\widgets\ActiveForm;
 

$title = $this->title = 'Takwim Mesyuarat Pengajian Lanjutan';
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
       <?php echo $this->render('/cutibelajar/_topmenu'); ?>
  <p align="right"><?= Html::a('Kembali', ['cbadmin/page-semak'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>
        <div class="x_panel">

<div class="iklan-form"> 
    <div class="col-md-12 col-sm-12 col-xs-12">
          
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">  
                <h5><i class='fa fa-plus'></i>
                    TAMBAH PERMOHONAN MANUAL PENGAJIAN LANJUTAN YANG DILULUSKAN</h5></legend> 
                
            <div class="x_content">

                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                
             
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">NAMA KAKITANGAN: <span class="required" style="color:red;">*</span>
                    </label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
              <?=
                $form->field($pengajian, 'icno')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => 'Nama Kakitangan'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                ?>
            
            </div>
                </div> 
                 <div class="clearfix"></div>
                 <div class="x_title">
                <h5><strong>MAKLUMAT PENGAJIAN</strong></h5> 
                <div class="clearfix"></div>
            </div>
                
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Nama Universiti: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($pengajian, 'InstNm')->textInput()->label(false); ?> 
                    </div>
                </div> 
                 <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Lokasi: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($pengajian, 'lokasi')->textInput()->label(false); ?> 
                    </div>
                </div> 
                 <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Negara: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                         <?= $form->field($pengajian, 'Country')->widget(Select2::classname(), 
                        ['data' => ArrayHelper::map(app\models\hronline\Negara::find()->orderBy(['CountryCd' => SORT_ASC,])->all(), 'CountryCd', 'Country'),
                        'options' => [
                            'placeholder' => 'Pilih Negara'],
                    ])->label(false); ?>
                    </div>
                </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Peringkat Pengajian: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                         <?=
                    $form->field($pengajian, 'HighestEduLevelCd')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\app\models\cbelajar\Edulevel::find()->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
                    'options' => ['placeholder' => 'Pilih Peringkat Pengajian', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'disabled'=> false,
                    ],
                ]);?>
                        
                    </div>
                  </div>
                 <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Major">Bidang: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          
            
             <?=$form->field($pengajian, 'MajorCd')->label(false)->widget(Select2::classname(), [
                 'data' => ArrayHelper::map(\app\models\hronline\MajorMinor::find()->all(),  'MajorMinorCd', 'MajorMinor'),
                 'options' => ['placeholder' => 'Pilih Major', 'class' => 'form-control col-md-7 col-xs-12',
                 'onchange' => 'javascript:if ($(this).val() == "9999"){
                   $("#lain").show();
                                         }
                                    else{
                                    $("#lain").hide();
                                    }'],
                        
                                    'pluginOptions' => [
                                    'allowClear' => true
                                    ],
                                ]);


                                ?> 
                               
                              <div id="lain" style="display: none">
                                        <?= $form->field($pengajian, 'MajorMinor')->textInput()->label(false); ?>
                              </div>
                                
        </div>
                 </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tarikh_mula">Tarikh Mula Pengajian: <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    DatePicker::widget([
                        'model' => $pengajian,
                        'attribute' => 'tarikh_mula',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
          
            </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tarikh_tamat">Tarikh Tamat Pengajian: <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    DatePicker::widget([
                        'model' => $pengajian,
                        'attribute' => 'tarikh_tamat',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd',
                        ]
                    ]);
                    ?>
                </div>
            </div>
                
               
                
                                <div class="form-group">
                                    &nbsp;&nbsp;<label class="control-label col-md-3 col-sm-3 col-xs-12" for="modeID">Mod Pengajian: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        
                       <?=
                    $form->field($pengajian, 'modeID')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\cbelajar\Modpengajian::find()->all(), 'modeID', 'studyMode'),
                    'options' => ['placeholder' => 'Pilih Mod Pengajian', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
?>
                    </div>
                                </div>
           
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tajuk_tesis">Tajuk Tesis Disertasi (Sarjana) dan Tajuk Penyelidikan PhD/Post Doktoral (Sila Lampirkan):<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                          <?= $form->field($pengajian, 'tajuk_tesis')->textArea()->label(false); ?> 
                    </div>
                </div>

                 <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_penyelia">Nama Penyelia (Cadangan):<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                          <?= $form->field($pengajian, 'nama_penyelia')->textInput()->label(false); ?> 
                    </div>
                </div>
                 
                 <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="catatan">Catatan:<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                          <?= $form->field($pengajian, 'catatan')->textarea()->label(false); ?> 
                    </div>
                </div>
                
                <div class="x_title">
                <h5><strong>MAKLUMAT PEMBIAYAAN/PINJAMAN</strong></h5> 
                <div class="clearfix"></div>
            </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenisCd">Nama Agensi/Tajaan:<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
          
            
             <?php
            echo $form->field($biasiswa,'jenisCd')->
            dropDownList(['3' => 'KEMENTERIAN PENGAJIAN TINGGI',
                          '2' => 'UNIVERSITI MALAYSIA SABAH', 
                          '1'=>'TAJAAN LUAR',
//                          'TIKET'=> 'TIKET PENERBANGAN',
                        
                        ],['prompt'=>'Pilih Nama Agensi/Tajaan'])->label(false);
?>
                               
<!--                              <div id="test" style="display: none">
                                        <?= $form->field($biasiswa, 'jenisCd')->textInput()->label(false); ?>
                              </div>-->
                                
        </div>
                </div>
                <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Tajaan :<span class="required"></span>
                </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">

                         <?php
            echo $form->field($biasiswa,'nama_tajaan')->
            dropDownList(['SLAB' => 'SLAB',
                          'SLAI' => 'SLAI', 
                          'YURAN PENGAJIAN'=>' UMS - YURAN PENGAJIAN',
                          'SARA HIDUP' =>'UMS - SARA HIDUP',
                          'TIKET'=> 'UMS - TIKET PENERBANGAN',
                          'HUMS' => 'HOSPITAL UNIVERSITI MALAYSIA SABAH (HUMS)',
                          'TAJAAN LUAR' => 'TAJAAN LUAR',
                        
                        ],['prompt'=>'Pilih Jenis Tajaan'])->label(false);
?>
                    </div>
</div>
                

                 
                 
                
                    
                     
                <div class="form-group">
                    <div class="col-sm-3"></div> 
                    <div class="col-sm-9">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']); ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

             

            </div>
        </div>
    </div>
     
       <?php ActiveForm::end(); ?>
</div>

<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use yii\widgets\ActiveForm;
 

$title = $this->title = 'Takwim Mesyuarat Pengajian Lanjutan';

?>

<div class="iklan-form"> 
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>TAMBAH PERMOHONAN PENGAJIAN LANJUTAN</strong></h2> 
              
           
            <p align="right"><?= Html::a('Kembali', ['cbadmin/page-semak'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>
            
            <div class="clearfix"></div>

          
            </div>
            <div class="x_content">

                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_mesyuarat">Mesyuarat: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        Mesyuarat Pengajian Lanjutan Bil. Ke
                        <?= $form->field($permohonan, 'iklan_id')->widget(Select2::classname(), 
                        ['data' => ArrayHelper::map(\app\models\cbelajar\TblUrusMesyuarat::find()->orderBy(['id' => SORT_ASC,])->all(), 'id', 'nama_mesyuarat'),
                        'options' => [
                            'placeholder' => 'Pilih Mesyuarat'],
                    ])->label(false); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Kad Pengenalan: <span class="required" style="color:red;">*</span>
                    </label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($permohonan, 'icno')->textInput()->label(false); ?> 
            
            </div>
                </div> 
                 <div class="clearfix"></div>
                 <div class="x_title">
                <h2><strong>MAKLUMAT PENGAJIAN</strong></h2> 
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Negara: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                         <?= $form->field($pengajian, 'CountryCd')->widget(Select2::classname(), 
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
                        <?php
            echo $form->field($pengajian,'HighestEduLevelCd')->
            dropDownList(['1' => 'Doktor Falsafah (Phd) ',
                          '200' => 'Post Doktoral', 
                          '102'=>'Sub Kepakaran',
                          '20'=> 'Sarjana',
                        ],['prompt'=>'Pilih Peringkat Pengajian'])->label(false);
?>
                    </div>
                  </div>
                 <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Major">Major: <span class="required" style="color:red;">*</span>
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
                
                <div class="x_title">
                <h2><strong>MAKLUMAT PEMBIAYAAN/PINJAMAN</strong></h2> 
                <div class="clearfix"></div>
            </div>
                
                <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Tajaan :<span class="required"></span>
                </label>

                 <div class="col-md-6 col-sm-6 col-xs-12">

                        <?=
                        $form->field($biasiswa, 'jenisCd')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(\app\models\cbelajar\TblTajaan::find()->all(), 'jenisCd', 'jenisTajaan'),
                            'options' => 
                                        ['placeholder' => 'Pilih Tajaan', 'class' => 'form-control col-md-7 col-xs-12',
                                         'onchange' =>
                                                     'javascript:if ($(this).val() == "1"){ 
                                                        $("#tajaan").show();$("#ums").hide();$("#tanpatajaan").hide();$("kpm").hide();
                                                    }
                                                    else if($(this).val() == "2"){
                                                        $("#tajaan").hide(); $("#ums").show();$("#kpm").hide();$("#tanpatajaan").hide();
                                                    }
                                                    else if($(this).val() == "3"){
                                                        $("#kpm").show(); $("#tajaan").hide();$("#ums").hide();$("#tanpatajaan").hide();
                                                    }
                                                    else if($(this).val() == "4"){
                                                         $("#tanpatajaan").show(); $("#tajaan").hide(); $("#ums").hide(); $("#kpm").hide();
                                                    }
                                                   else{$("#tajaan").hide();$("#ums").hide();$("#kpm").hide();$("#tanpatajaan").hide(); }',

                                        ],
                                        'pluginOptions' => [
                                        'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
</div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_tajaan">Nama Agensi/Tajaan:<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                          <?= $form->field($biasiswa, 'nama_tajaan')->textArea()->label(false); ?> 
                    </div>
                </div>
                 <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bentukBantuan">Bentuk Tajaan: <span class="required">*</span>
                </label>
                <div class="col-md-3 col-md-3 col-sm-6 col-xs-12">
                   <?=$form->field($biasiswa, 'BantuanCd')->label(false)->widget(Select2::classname(), [
                 'data' => ArrayHelper::map(\app\models\cbelajar\RefBantuan::find()->all(),  'id', 'bentukBantuan_ums'),
                 'options' => ['placeholder' => 'Pilih Bantuan', 'class' => 'form-control col-md-7 col-xs-12',
                 'onchange' => 'javascript:if ($(this).val() == "4"){
                   $("#lain2").show();
                                         }
                                    else{
                                    $("#lain2").hide();
                                    }'],
                        
                                    'pluginOptions' => [
                                    'allowClear' => true
                                    ],
                                ]);


                                ?> 
                    <div id="lain2" style="display: none">
                                        <?= $form->field($biasiswa, 'bentukBantuan')->textInput()->label(false); ?>
                              </div>
                </div>
            </div>
                
                    <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amaunBantuan">Amaun Bantuan:<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                          <?= $form->field($biasiswa, 'amaunBantuan')->textInput()->label(false); ?> 
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

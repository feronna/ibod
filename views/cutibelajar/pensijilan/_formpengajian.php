<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\hronline\Negara;
use app\models\hronline\MajorMinor; 
use dosamigos\datepicker\DatePicker;
use app\models\cbelajar\RefPensijilan;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

error_reporting(0);

?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>

<div class="x_panel">
    
 


    
<div class="table-responsive">
    <table class="table table-bordered jambo_table">
                <thead>
                        <th scope="col" colspan=12">
                        <center>MAKLUMAT PERMOHONAN</center></th>
                </thead>
        <tr>
        <td><strong>JENIS PERMOHONAN:</strong></td>
            <td colspan="5"><?=$form->field($model, 'cat_latihan')->label(false)->widget(Select2::classname(), [
                 'data' => ArrayHelper::map(RefPensijilan::find()->all(),  'id', 'kategori'),
                 'options' => ['placeholder' => 'Pilih Jenis Permohonan', 'class' => 'form-control col-md-7 col-xs-12',
                  'onchange' => 
                'javascript:if ($(this).val() == "1")
                                           {
                                                $("#mod").show();$("#b").hide();
                                         }
                                        
                                          else if(($(this).val() == "2")
                                          )
                                         {
                                           $("#b").show();$("#mod").hide();
                                           }
                                          
                                         
                                         

                                    else{
                                    $("#b").hide();$("#mod").hide();
                                    }'],
                 
                        
                                    'pluginOptions' => [
                                    'allowClear' => true
                                    ],
                                ]);


                                ?> 
</td>
    </tr>
    <tr>
        <th class="col-md-3 col-sm-3 col-xs-12">NAMA AGENSI/ORGANISASI:</th>

                      <td colspan="5">
                      
                      <?= $form->field($model, 'nama_badan')->widget(Select2::classname(), 
                        ['data' => ArrayHelper::map(app\models\hronline\BadanProfesional::find()->where(['isBSM'=>1])->all(), 'ProfBodyCd', 'ProfBody'),
                        'options' => [
                            'placeholder' => 'Pilih Agensi/Organisasi'],
                    ])->label(false); ?>
                        </td>
                        
                </tr>
    <tr id="mod" style="display: none">
        
                         <th>NAMA SIJIL:<i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
                                           title="Sijil Kemahiran Profesional Mengikut Skim Perkhidmatan"
                                           ></i><Br>
                         <a href="<?php echo Url::to('@web/'.'uploads-cutibelajar/cbelajar/dokumen/Senarai Kursus Sijil Kemahiran Profesional Mengikut Skim Perkhidmatan.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Rujukan Sijil Kemahiran Profesional</a></th>
                        <td colspan="10">  
                                <?=
                            $form->field($model, 'nama_sijil')->widget(DepDrop::classname(), [
                                'type' => DepDrop::TYPE_SELECT2,
                                'data' => ArrayHelper::map(\app\models\hronline\profesionalcert::find()->all(), 'ProfCertCd', 'ProfCertNm'),
                                'options' => [
                                    'multiple' => false
                                ],
                                'pluginOptions' => [
                                    'placeholder' => 'Pilih Sijil Kemahiran',
                                    'depends' => [Html::getInputId($model, 'nama_badan')],
                                    'initialize' => true,
                                    'url' => Url::to(['/latihan-pensijilan/badan-list'])
                                ]
                            ])->label(false)
                        ?>
<!-- $form->field($model, 'nama_sijil')->widget(Select2::classname(), 
                        ['data' => ArrayHelper::map(\app\models\hronline\profesionalcert::find()->all(), 'ProfCertCd', 'ProfCertNm'),
                        'options' => [
                            'placeholder' => 'Pilih Sijil Kemahiran'],
                    ])->label(false); ?>-->
                        </td> 
                </tr>
                
                
   
            <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">LOKASI PENGAJIAN:</th>
                        <td colspan="5">   <?= $form->field($model, 'lokasi')->textInput(['maxlength' => true]) ->label(false);?> 
                        </td> 
                        
                </tr>
                
               
                    
                
               
                <tr>                        <th class="col-md-3 col-sm-3 col-xs-12">NEGARA:</th>

                      <td colspan="5">
                         <?= $form->field($model, 'Country')->widget(Select2::classname(), 
                        ['data' => ArrayHelper::map(Negara::find()->all(), 'CountryCd', 'Country'),
                        'options' => [
                            'placeholder' => 'Pilih Negara'],
                    ])->label(false); ?>
                        </td>
                </tr>
                
                 <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">BIDANG PENGAJIAN:</th>
                        <td colspan="5">
                      
                      <?=$form->field($model, 'MajorCd')->label(false)->widget(Select2::classname(), [
                     'data' => ArrayHelper::map(MajorMinor::find()->all(),  'MajorMinorCd', 'MajorMinor'),
                     'options' => ['placeholder' => 'Pilih Bidang Pengajian', 'class' => 'form-control col-md-7 col-xs-12',
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
                        </td>
                        <td id="lain" style="display: none">
                                        <?= $form->field($model, 'MajorMinor')->textInput()->label(false); ?>
                         </td>
                        
                 </tr>
                 
                  
                
                 <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">TARIKH MULA LATIHAN :</th>
                        <td colspan="2">
            <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'tarikh_mula',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>

     
</td> <th class="col-md-3 col-sm-3 col-xs-12">TARIKH TAMAT LATIHAN :</th>
                        <td colspan="2">
            <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'tarikh_tamat',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>

     
</td> 
                    </tr>
                    
                   
                    
                    
                </table>
          

          
          
         

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                     <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                    <button class="btn btn-primary" type="reset">Reset</button>
                    
                   
                </div>
            </div>
                 <?= $form->field($model, 'iklan_id')->hiddenInput(['value' => $iklan->id])->label(false); ?>

            <?php ActiveForm::end(); ?>
     <!-- end of xpanel-->
  </div>
</div>


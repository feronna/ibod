<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\harta\TblJenisHarta;
use kartik\depdrop\DepDrop;
use app\models\harta\TblSenarai;
use yii\helpers\Url;
use app\models\harta\TblKeteranganHarta;
use dosamigos\datepicker\DatePicker;
use app\models\hronline\Negara;
use app\models\hronline\Negeri;
use app\models\hronline\Bandar;
use app\models\harta\Tblrefacqsrc;
use app\models\harta\Tblreffinancialsourcetype;

use kartik\number\NumberControl;
/* @var $this yii\web\View */
/* @var $model app\models\ptb\TblTugasBelumSelesai */
$options = [
        1 => 'Sendiri', 2 => 'Pasangan' , 3 => 'Anak',

];
?>


<div class="col-md-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Kemaskini Harta</h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
           
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
            
                <div class="form-group" id="jenisHarta">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenisHarta">HTA / HA <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'hartaCd')->widget(Select2::classname(), ['data' => ArrayHelper::map(TblJenisHarta::find()->all(), 'hartaCd', 'jenis_harta'),
                        'options' => [
                            'placeholder' => 'Pilh'],
                    ])->label(false);
                    ?>
                </div>
            </div>
         
            <div class="form-group" id="senarai" >
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="senarai">Jenis Harta <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'senarai_id')->widget(DepDrop::classname(), [
                        'type' => DepDrop::TYPE_SELECT2,
                        'data' => ArrayHelper::map(TblSenarai::find()->all(), 'senarai_id', 'keterangan'),
                        'options' => [
                            'multiple' => false],
                        'pluginOptions' => [
                            'placeholder' => 'Pilih',
                            'depends' => [Html::getInputId($model, 'hartaCd')],
                            'initialize' => true,
                            'url' => Url::to(['/harta/statelist'])
                        ]
                    ])->label(false)
                    ?>
                    
                  
                </div>
            </div>

            <div class="form-group" id="daerah" >
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Daerah">Spesifikasi Harta <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'hartas_id')->widget(DepDrop::classname(), [
                        'type' => DepDrop::TYPE_SELECT2,
                        'data' => ArrayHelper::map(TblKeteranganHarta::find()->all(), 'hartas_id', 'keterangan'),
                        'options' => [
                            'multiple' => false,],
                        'pluginOptions' => [
                            'placeholder' => 'Pilih Spesifikasi',
                            'depends' => [Html::getInputId($model, 'senarai_id')],
                            'initialize' => true,
                            'url' => Url::to(['/harta/citylist'])
                        ]
                    ])->label(false)
                    ?>
                </div>
            </div>



           <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Pemilikan<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
      
                <?=
                            $form->field($model, 'pemilikan')->label(false)->widget(Select2::classname(), [
                            'data' => [1 =>'Sendiri', 2 => 'Pasangan' , 3 => 'Anak', 4 => 'Bersama'],
                            'options' => ['placeholder' => 'Pilih Pemilikan', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                            ?>
                
                </div>
            </div>
            
              
            
             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >No Sijil Aset<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'AlAssetCertNo')->textarea(['maxlength' => true])->label(false) ?>
                </div>
            </div>
            
                <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12" >Nilai Pembelian Aset (RM)<span class="required" style="color:red;">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12" align="left">
                     <?=
                    $form->field($model, 'AlPurchasedValue')->widget(NumberControl::classname(), [
                         'name' => 'AlPurchasedValue',
                           'pluginOptions'=>[
                           'initialize' => true,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => 'RM',
                             'rightAlign' => false
                           ],
                         'options' => $saveOptions,
                         'displayOptions' => [
                            'placeholder' => 'Contoh: RM223437.04'
                                  ],
                                ])->label(false);
                            ?>
                </div>
            </div> 
            
              <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12" >Nilai Semasa Aset(RM)<span class="required" style="color:red;">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12" align="left">
                  <?=
                    $form->field($model, 'AlCurVal')->widget(NumberControl::classname(), [
                         'name' => 'AlCurVal',
                           'pluginOptions'=>[
                           'initialize' => true,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => 'RM',
                             'rightAlign' => false
                           ],
                         'options' => $saveOptions,
                         'displayOptions' => [
                            'placeholder' => 'Contoh: RM223437.04'
                                  ],
                                ])->label(false);
                            ?>
                 
                </div>
            </div>
            
               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Kuantiti Aset<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'AlQuantity')->textarea(['maxlength' => true])->label(false) ?>
                </div>
            </div>
            
               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Alamat Aset I<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'AlAddr1')->textarea(['maxlength' => true])->label(false) ?>
                </div>
            </div>
            
             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Alamat Aset II<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'AlAddr2')->textarea(['maxlength' => true])->label(false) ?>
                </div>
            </div>
            
             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Alamat Aset III<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'AlAddr3')->textarea(['maxlength' => true])->label(false) ?>
                </div>
            </div>
            
             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Poskod Aset<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'AlPostcode')->textInput(['maxlength' => true])->label(false) ?>
                </div>
            </div>
            
               <div class="form-group" id="negara">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Negara">Negara: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'CountryCd')->widget(Select2::classname(), ['data' => ArrayHelper::map(Negara::find()->orderBy(['CountryCd' => SORT_ASC,])->all(), 'CountryCd', 'Country'),
                        'options' => [
                            'placeholder' => 'Pilh Negara'],
                    ])->label(false);
                    ?>
                </div>
            </div>

            <div class="form-group" id="negeri" >
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Negeri">Negeri: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'StateCd')->widget(DepDrop::classname(), [
                        'type' => DepDrop::TYPE_SELECT2,
                        'data' => ArrayHelper::map(Negeri::find()->all(), 'StateCd', 'State'),
                        'options' => [
                            'multiple' => false],
                        'pluginOptions' => [
                            'placeholder' => 'Pilih Negeri',
                            'depends' => [Html::getInputId($model, 'CountryCd')],
                            'initialize' => true,
                            'url' => Url::to(['/alamat/statelist'])
                        ]
                    ])->label(false)
                    ?>
                </div>
            </div>

            <div class="form-group" id="daerah" >
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Daerah">Daerah: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'CityCd')->widget(DepDrop::classname(), [
                        'type' => DepDrop::TYPE_SELECT2,
                        'data' => ArrayHelper::map(Bandar::find()->all(), 'CityCd', 'City'),
                        'options' => [
                            'multiple' => false,],
                        'pluginOptions' => [
                            'placeholder' => 'Pilih Bandar',
                            'depends' => [Html::getInputId($model, 'StateCd')],
                            'initialize' => true,
                            'url' => Url::to(['/alamat/citylist'])
                        ]
                    ])->label(false)
                    ?>
                </div>
            </div>
            
                    <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Pemilikan<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                       <?= $form->field($model, 'AlAcqDt')->widget(DatePicker::className(),
                          ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                          ])->label(false);?>
                    </div>
                </div>
            
        
                  <div class="form-group">
                   <label class="control-label col-md-3 col-sm-3 col-xs-12" >Cara dan dari Siapa Harta Diperolehi(dipusakai,
                 dibeli, dihadiahkan, dll)<span class="required" style="color:red;">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
               
                    
                    
                    <?=  $form->field($model, 'AcqSrcCd')->widget(Select2::classname(), [
                             'name' => 'AcqSrcCd',
                            'data' => \yii\helpers\ArrayHelper::map(Tblrefacqsrc::find()->all(),'AcqSrcCd', 'AcqSrcNm'),
                             'options' => ['placeholder' => 'Pilih Cara', 'class' => 'form-control col-md-7 col-xs-12',
                                  ],
                        
                                    'pluginOptions' => [
                                    'allowClear' => true
                                    ],

                        ])->label(false); ?>
                        <br>
                   
                    </div>
                </div>
            
          
            
            
            
               <div class="form-group">
                   <label class="control-label col-md-3 col-sm-3 col-xs-12" >Jenis Sumber Kewangan<span class="required" style="color:red;">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
               <?=  $form->field($model, 'FinclSrcTypeCd')->widget(Select2::classname(), [
                            'name' => 'FinclSrcTypeCd',
                            'data' => ArrayHelper::map(Tblreffinancialsourcetype::find()->all(),'FinclSrcTypeCd', 'FinclSrcTypeNm'),
                             'options' => ['placeholder' => 'Pilih Sumber', 'class' => 'form-control col-md-7 col-xs-12',
                                  ],
                        
                                    'pluginOptions' => [
                                    'allowClear' => true
                                    ],

                        ])->label(false); ?>
                        
                       
                    </div>
                </div>
            
            
             <div class="form-group" align="right">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12" >Punca Dana,Jumlahnya, Maklumat Pembiaya & 
                 Keterangan Lain (jika perlu)<span class="required" style="color:red;">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'AlDesc')->textarea(['maxlength' => true])->label(false) ?>
                </div>
            </div>
            
            <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12" >Jumlah Keseluruhan Sumber Kewangan(RM)<span class="required" style="color:red;">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12" align="left">
                  <?=
                    $form->field($model, 'FinclSrcTotalAmt')->widget(NumberControl::classname(), [
                         'name' => 'FinclSrcTotalAmt',
                           'pluginOptions'=>[
                           'initialize' => true,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => 'RM',
                             'rightAlign' => false
                           ],
                         'options' => $saveOptions,
                         'displayOptions' => [
                            'placeholder' => 'Contoh: RM223437.04'
                                  ],
                                ])->label(false);
                            ?>
                 
                </div>
            </div>
            
              <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempoh bayaran balik Sumber Kewangan
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                         <?= $form->field($model, 'FinclSrcRepaymtPeriod')->textInput(['maxlength' => true, 'placeholder' => "Contoh: 360 BULAN"])->label(false) ?>
                    </div>
                </div>
            
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Ansuran Bulanan Sumber Kewangan(RM)
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                    $form->field($model, 'FinclSrcMthlyInstalmt')->widget(NumberControl::classname(), [
                         'name' => 'FinclSrcMthlyInstalmt',
                           'pluginOptions'=>[
                           'initialize' => true,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => 'RM',
                             'rightAlign' => false
                           ],
                         'options' => $saveOptions,
                         'displayOptions' => [
                            'placeholder' => 'Contoh: RM223437.04'
                                  ],
                                ])->label(false);
                            ?>
                    </div>
                </div>
            
             <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mula Bayar Ansuran Bulanan
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                       <?= $form->field($model, 'FinclSrcInstlmtStDt')->widget(DatePicker::className(),
                          ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                          ])->label(false);?>
                    </div>
                </div>
            
            
            
               <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Akhir Bayar Ansuran Bulanan
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                       <?= $form->field($model, 'FinclSrcInstlmtEndDt')->widget(DatePicker::className(),
                          ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                          ])->label(false);?>
                    </div>
                </div>
           
           
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <!--form-->
        </div>
    </div>
</div>


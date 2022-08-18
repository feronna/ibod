<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\hronline\RefEpfType;
use app\models\hronline\RefTaxFormulaType;
use app\models\hronline\RefTaxCategory;
use app\models\hronline\RefSocsoType;
error_reporting(0);

?>


        <div class ="row"> 
       <div class="col-md-12 col-xs-12"> 
         <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-money"></i><strong> PROFIL GAJI</strong></h2>
                <div class="clearfix"></div>
            </div> 
        <div class="container">
             <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left'], 'method' => 'post']); ?>
        
        <div class="table-responsive">
        <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT TARIKH</center></th>
                </thead></table>
              
            <table class="table table-sm table-bordered" >    
                <tr>
                        <td width="100px" height="100px">Tarikh Mula<span class="required" style="color:red;">*</span></td> 
                        <td colspan="5">
                           <?= $form->field($model, 'SS_START_DATE')->widget(DatePicker::className(),
                                  ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                                  'options' => [ 'id' => 'SS_START_DATE' ]])
                         ->label(false);?>
                         </td>
                       
                        <td valign="1" width="100px" height="20px">Tarikh Akhir</td>
                        <td colspan="5"> <?= $form->field($model, 'SS_END_DATE')->widget(DatePicker::className(),
                                  ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                                  'options' => [ 'id' => 'SS_END_DATE' ]])
                         ->label(false);?>
                        </td>
                </tr>
             </table>
            
             <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT GAJI</center></th>
                </thead></table>
             
              <table class="table table-sm table-bordered" >
                    <thead>      
                 <tr>
                      <td width="100px" height="10px">Jenis Gaji<span class="required" style="color:red;">*</span></td> 
                      <td colspan="5">  
                        <?=$form->field($model, 'SS_SALARY_TYPE')->label(false)->widget(Select2::classname(), [
                            'data' => [1 =>'Monthly Salary', 2 => 'Part-time/Claims-based Salary', 3 => 'Bonus/Cash Assist (Separate)' , 4 => 'BOD'],
                            'options' => ['placeholder' => Yii::t('app', 'Sila Pilih..'), 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                            ?> 
                         
                      </td>
                </tr>
                     
                <tr>
                     <td width="100px" height="10px">Status Gaji</td> 
                     <td colspan="5">  
                       <?=$form->field($model, 'SS_SALARY_STATUS')->label(false)->widget(Select2::classname(), [
                            'data' => [ 'Y' =>'YA', 'N' => 'TIDAK'],
                            'options' => ['placeholder' => Yii::t('app', 'Sila Pilih..'), 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                            ?> 
                        
                      </td>
                    <td valign="1" width="100px" height="10px">Kadar Harian/Jam</td> 
                         <td colspan="5">  
                               <?= $form->field($model, 'SS_RATE')->textInput(['maxlength' => true]) ->label(false);?>
                         </td>
                 </tr>

                    </thead>     
              </table>
            
            
              <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;"><center>CUKAI</center></th>
              
        </thead>
              </table>

               <table class="table table-sm table-bordered" >
                       <tr>
                       <td width="100px" height="10px">Cukai?</td> 
                      <td colspan="5">  
                                 <?=
                            $form->field($model, 'SS_TAX_STATUS')->label(false)->widget(Select2::classname(), [
                            'data' => [ 'Y' =>'YA', 'N' => 'TIDAK'],
                            'options' => ['placeholder' => Yii::t('app', 'Sila Pilih..'), 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                            ?>
                        </td>
                        </tr>
                        
                        
                        <tr>
                     <td width="100px" height="10px">Kategori Cukai</td> 
                      <td colspan="5">  
                     <?= $form->field($model, 'SS_TAX_CATEGORY')->label(false)->widget(Select2::classname(), [
                        'data' => $kategori_cukai,
                        'options' => ['placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                       'allowClear' => true
                        ],
                    ]);
                    ?>
                        </td>
                        </tr>
                        
                        
                    <tr>
                      <td width="100px" height="10px">Formula Cukai</td> 
                      <td colspan="5">  
                     <?= $form->field($model, 'SS_TAX_FORMULA')->label(false)->widget(Select2::classname(), [
                        'data' => $formula_cukai,
                        'options' => ['placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                       'allowClear' => true
                        ],
                    ]);
                    ?>
                    </td>
                    </tr>
                        
                        
                      <tr>
                     <td width="100px" height="10px">Cukai Bayar Zakat</td> 
                      <td>
           
                       <?=$form->field($model, 'SS_ZAKAT_STATUS')->label(false)->widget(Select2::classname(), [
                            'data' => ['Y' =>'YA', 'N' => 'TIDAK'],
                            'options' => ['placeholder' => Yii::t('app', 'Sila Pilih..'), 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                            ?> 
                        
                      </td>
                    <td valign="1" width="100px" height="10px">Zakat Bayar Kepada</td> 
                    <td colspan="5"> 
                       <?=$form->field($model, 'SS_ZAKAT_CODE')->label(false)->widget(Select2::classname(), [
                            'data' => [1 =>'LEMBAGA ZAKAT SELANGOR (MAIS)', 2 => 'MUIS (ZAKAT)', 3 => 'PERBADANAN BAITULMAL N.SABAH' , 4 => 'PUSAT PUNGUTAN ZAKAT (PPS)', 5 => 'PUSAT ZAKAT NEGERI SEMBILAN'],
                            'options' => ['placeholder' => Yii::t('app', 'Sila Pilih..'), 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                            ?> 
                            </td>
                </tr></table>
            
            
              <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;"><center>KWSP</center></th>
                </thead></table>
            
              <table class="table table-sm table-bordered" >
                 <tr>
                     <td width="100px" height="10px">KWSP?</td> 
                      <td colspan="5">  
                                 <?=
                            $form->field($model, 'SS_EPF_STATUS')->label(false)->widget(Select2::classname(), [
                            'data' => ['Y' =>'YA', 'N' => 'TIDAK'],
                            'options' => ['placeholder' => Yii::t('app', 'Sila Pilih..'), 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                            ?>
                      </td>
                </tr>

                    <tr>
                     <td width="100px" height="10px">Jenis KWSP</td> 
                      <td>
                          <?= $form->field($model, 'SS_EPF_TYPE')->label(false)->widget(Select2::classname(), [
                        'data' => $jenis_KWSP,
                        'options' => ['placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                       'allowClear' => true
                        ],
                    ]);
                    ?>
                        
                      </td>
                    <td valign="1" width="100px" height="10px">Kaedah Kiraan</td> 
                          <td>
                   
                      <?=$form->field($model, 'SS_EPF_METHOD')->label(false)->widget(Select2::classname(), [
                            'data' => ['SCHEDULE' =>'Jadual', 'PERCENTAGE' => 'Peratusan'],
                            'options' => ['placeholder' => Yii::t('app', 'Sila Pilih..'), 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                            ?> 
                            </td>
                </tr>
                
                 <tr>
                     <td width="100px" height="10px">Pekerja %</td> 
                      <td>
                      <?= $form->field($model, 'SS_EPF_EMPYEE_PCT')->textInput(['maxlength' => true, 'placeholder' => "Contoh: Xxx234"])->label(false) ?>
                      </td>
                    <td valign="1" width="100px" height="10px">Majikan %</td> 
                          <td>
                         <?= $form->field($model, 'SS_EPF_EMPYER_PCT')->textInput(['maxlength' => true, 'placeholder' => "Contoh: Xxx234"])->label(false) ?>
                            </td>
                </tr>
                          </table>
            
                <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;"><center>PERKESO</center></th>
                </thead></table>
            
            
             <table class="table table-sm table-bordered" >
                <tr>
                     <td width="100px" height="10px">PERKESO</td> 
                      <td>
                      <?=
                            $form->field($model, 'SS_SOCSO_STATUS')->label(false)->widget(Select2::classname(), [
                            'data' => ['Y' =>'YA', 'N' => 'TIDAK'],
                            'options' => ['placeholder' => Yii::t('app', 'Sila Pilih..'), 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                            ?>
                      </td>
                    <td valign="1" width="100px" height="10px">Jenis Perkeso</td> 
                          <td>
                           <?= $form->field($model, 'SS_SOCSO_TYPE')->label(false)->widget(Select2::classname(), [
                        'data' => $jenis_perkeso,
                        'options' => ['placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                       'allowClear' => true
                        ],
                    ]);
                    ?>
                            </td>
                </tr>
                 </table>
            
                    <table class="table table-sm table-bordered" >
               <thead>
                <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;"><center>LAIN-LAIN</center></th>
                </thead></table>
            
            <table class="table table-sm table-bordered" >
              <tr>
                     <td width="100px" height="10px">Pencen?</td> 
                      <td colspan="5">  
                            <?=
                            $form->field($model, 'SS_PENSION_STATUS')->label(false)->widget(Select2::classname(), [
                            'data' => ['Y' =>'YA', 'N' => 'TIDAK'],
                            'options' => ['placeholder' => Yii::t('app', 'Sila Pilih..'), 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                            ?>
                         </td>
                        </tr>
                        
                        <tr>
                     <td width="100px" height="10px">Sebab Perubahan<span class="required" style="color:red;">*</span></td> 
                      <td colspan="5">  
                            <?= $form->field($model, 'SS_CHANGE_REASON')->textarea(['maxlength' => true])->label(false)?>
                
                           </td>
                        </tr>

              </table>

           
        </div>
        <div class="form-group" align="center">
                <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2"> 
                    <br>
                    <?php // Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Simpan'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1', 'data' => ['disabled-text' => 'Please Wait..']])?>
                    <button class="btn btn-primary" type="reset">Reset</button>
                </div>
                </div>
            
             <?php ActiveForm::end(); ?>
        </div>
        </div>  
       </div>
    </div> 
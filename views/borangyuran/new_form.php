<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\kemudahan\Refbadanprof;
use kartik\number\NumberControl;
use kartik\date\DatePicker;

error_reporting(0); 
?> 

 <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
  
 <div class="col-md-12 col-xs-12"> 

       <div class ="row"> 
   
         <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-book"></i> PENGISIAN PERMOHONAN YURAN KEAHLIAN BADAN PROFESIONAL/BADAN IKHTISAS</strong></h2>
                <div class="clearfix"></div>
            </div> 
        <div class="container">
        <div class="table-responsive">
        <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan="6" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT YURAN KEAHLIAN BADAN PROFESIONAL/BADAN IKHTISAS</center></th>
               <tr>
                        <td valign="5">Nama Pegawai:<span class="required" style="color:red;">*</span></td>
                        <td colspan="5">  
                            
                             <?= $form->field($model, 'icno')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(app\models\elnpt\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                            'options' => [
                            'placeholder' => 'Name'],
                            ])->label(false); 
                    ?>
                            
                        </td>
                </tr>
                <tr>
                        <td valign="4">Nama Badan Professional:<span class="required" style="color:red;">*</span></td>
                        <td colspan="4">  
                         <?=
                         $form->field($model, 'badan_prof')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Refbadanprof::find()->all(), 'badanprof', 'badanprof'),
                        'options' => ['placeholder' => 'Pilih Badan Profesional', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        ]);
                        ?>
                         <?php // $form->field($model, 'badan_prof')->textInput(['maxlength' => true]) ->label(false);?> 

                        </td>
                </tr>

                <tr>
                        <td valign="4">Jumlah Tuntutan (RM):<span class="required" style="color:red;">*</span></td>
                        <td colspan="4"> 
                           <?=
                            $form->field($model, 'jumlah')->widget(NumberControl::classname(), [
                                 'name' => 'jumlah',
                                   'pluginOptions'=>[
                                   'initialize' => true,
                                                            ],
                                       'maskedInputOptions' => [
                                        'prefix' => 'RM',
                                     'rightAlign' => false
                                   ],

                                 'displayOptions' => [
                                 //   'placeholder' => 'Contoh: RM223437.04'
                                          ],
                                        ])->label(false);
                            ?>
                        </td>

                </tr> 

                <tr>
                        <td valign="4">Nombor Bil/Resit:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="4"> 
                             <?= $form->field($model, 'resit')->textInput(['maxlength' => true]) ->label(false);?>    
                        </div>
                          </td>

                </tr>
                <tr>
                        <td valign="4">Jenis Bayaran:<span class="required" style="color:red;">*</span></td>
                        <td colspan="4">
                             <?= $form->field($model, 'payment')->label(false)->widget(Select2::classname(), [
                                    'data' => ['Yuran Pendaftaran' => 'Yuran Pendaftaran', 
                                    'Yuran Keahlian' => 'Yuran Keahlian',
                                     
                                 ],
                                    'options' => [
                                            'placeholder' => 'Sila Pilih'],

                                ]); ?> 
                            
                        </td>
                </tr>
        </thead>
                          </table>
             <table class="table table-sm table-bordered" >
        <thead>
                <tr>
                    <td valign="4">Resit Pembayaran:<span class="required" style="color:red;">*</span></td>
                    <td colspan="4"> <?= $form->field($model, 'file')->fileInput()->label(false);?> </td>
                    <td valign="4">Dokumen Sokongan :<span class="required" style="color:red;">*</span></td>
                    <td colspan="4"> <?= $form->field($model, 'file2')->fileInput()->label(false);?> </td> 
                </tr>
        </thead>
             </table> 

        <div style="color: green; margin-top: 0px;">
                   <strong>  Sila pastikan maklumat tuntutan adalah tepat sebelum klik hantar. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini.</strong>
        </div>
        </div>
        <?= $form->field($model, 'jeniskemudahan')->hiddenInput(['jeniskemudahan' =>  $id = Yii::$app->request->get('id')])->label(false)?> 
        </div>
        </div> 
           
        
</div>


        <div class="row">  
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-book"></i><strong>  Status Kelulusan Ketua BSM</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
            </ul>
        <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?= $form->field($model, 'ver_date')->hiddenInput()->label(false)?>
            <div class="col-md-10 col-sm-10 col-xs-12">
                
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ketua BSM : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">    
               <?= $form->field($model, 'pelulus_by')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(app\models\elnpt\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                            'options' => [
                            'placeholder' => 'Name'],
                            ])->label(false); 
                    ?>
                </div>
            </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Diluluskan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <?= $form->field($model, 'app_date')->label(false)->widget(DatePicker::classname(),[
                                            'readonly' => false,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Kelulusan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">    
                <?= $form->field($model, 'status_kj')->label(false)->widget(Select2::classname(), [
                    'data' => [
                        
                        'DILULUSKAN' => 'DILULUSKAN', 
//                        'TIDAK DILULUSKAN' => 'TIDAK DILULUSKAN',
                        ],
                   'options' => [
                         'placeholder' => 'Sila Pilih'],

                ]); ?>
                </div>
            </div> 
             
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <?= $form->field($model, 'catatan_kj')->textarea(array('rows'=>6,'cols'=>5))->label(false);?>   
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
</div>   
       
        <?php ActiveForm::end(); ?>
</div>

 

  
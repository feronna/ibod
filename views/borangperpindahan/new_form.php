<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\number\NumberControl; 
use kartik\date\DatePicker; 
use kartik\select2\Select2;

error_reporting(0); 
?>  

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
 
<div class="col-md-12 col-xs-12">   
    <div class="row">  
       <div class ="row"> 
       <div class="col-md-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-user"></i> PENGISIAN PERMOHONAN PERPINDAHAN RUMAH</strong></h2>
                <div class="clearfix"></div>
            </div> 
        <div class="container">
        <div class="table-responsive">
        <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan="6" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT PERPINDAHAN RUMAH</center></th>
                <tr>
                        <td valign="4">Nama Pegawai:<span class="required" style="color:red;">*</span></td>
                        <td colspan="4">  
                             
                             <?= $form->field($model, 'icno')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(app\models\elnpt\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                            'options' => [
                            'placeholder' => 'Name'],
                            ])->label(false); 
                    ?>
                            
                        </td>
                </tr>
                <tr>
                        <td valign="4">Tarikh Pepindahan Rumah:<span class="required" style="color:red;">*</span></td>
                        <td colspan="4">  
                             <?= $form->field($model, 'tarikh_pindah')->label(false)->widget(DatePicker::classname(),[
                                            'readonly' => false,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd',
                                                 'startDate'=>date('tarikh_pindah'),
                                                'minDate'=>'0',
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>
                           
                           
                        </td>
                </tr>
                <tr>
                        <td valign="4">Alamat Rumah Baru:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="4"> 
                           <?= $form->field($model, 'new_add')->textArea(['maxlength' => true]) ->label(false);?> 

                           <?php 
//                           if ($model->alamat->addr2 == 'NULL' || $model->alamat->addr2 == '-' || $model->alamat->addr3 == '-' || $model->alamat->addr3 == 'NULL'){
//                                 
//                                    echo '<textarea disabled rows="3" cols="1" id= "new_add">'.$model->alamat->addr1.'</textarea>' ;  
//                            }else{ 
//                               echo '<textarea disabled rows="3" cols="1" id= "new_add">'.$model->alamat->addr1.' '.$model->alamat->addr2.' '.$model->alamat->addr3.'.</textarea>';
//
//                            } 
                        ?>
                             </div>
                        </div>
                        </td>
                          
                </tr>
                
                <tr>
                        <td valign="4">Alamat Rumah Lama:<span class="required" style="color:red;">*</span></td>
                        <td colspan="4"> 
                             <?= $form->field($model, 'old_add')->textArea(['maxlength' => true]) ->label(false);?> 
                        </td> 
                </tr>  
                <tr>
                        <td valign="4">Jumlah Tuntutan (RM):<span class="required" style="color:red;">*</span></td>
                        <td colspan="4">
                             <?=
                    $form->field($model, 'jumlah_tuntutan')->widget(NumberControl::classname(), [
                         'name' => 'jumlah',
                           'pluginOptions'=>[
                           'initialize' => true,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => 'RM',
                             'rightAlign' => false
                           ],
                         
                         'displayOptions' => [
                            'placeholder' => 'Contoh: RM223437.04'
                                  ],
                                ])->label(false);
                            ?>
                        </td>
                </tr>
        </thead>
                          </table>
             <table class="table table-sm table-bordered" >
        <thead>
                <tr>
                    <td valign="4">Dokumen Sokongan 1:<span class="required" style="color:red;">*</span></td>
                    <td colspan="4"> <?= $form->field($model, 'file')->fileInput()->label(false);?> </td>
                    <td valign="4">Dokumen Sokongan 2:<span class="required" style="color:red;">*</span></td>
                    <td colspan="4"> <?= $form->field($model, 'file2')->fileInput()->label(false);?> </td> 
                </tr> 
        </thead>
                        </table>  
                    </div>

        </div>
       </div>
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
         </div>
          
        <?php ActiveForm::end(); ?>
        </div> 
    </div>
      
</div>

 

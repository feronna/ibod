<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
?>
   
<?php echo $this->render('/kemudahan/_menu'); ?>
<?php  $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="form-horizontal form-label-left"> 
    <div class="x_panel">
        <div class="x_title">
           <h2><strong><i class="fa fa-list"></i> Permohonan Tuntutan Kemudahan</strong></h2>
            <div class="clearfix"></div>
        </div>
    <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Maklumat Peribadi Pemohon</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            
            <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Penuh <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <?= $form->field($model->kakitangan, 'CONm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                  
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No Kad Pengenalan <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <?= $form->field($model->kakitangan, 'ICNO')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">UMS-PER <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <?= $form->field($model->kakitangan, 'COOldID')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
        
        <div class="row"> 
    <div class="x_panel">
       
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Maklumat Perkhidmatan</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>   
        </div>
        <div class="x_content">
        <div class="col-md-10 col-sm-10 col-xs-12">
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jawatan dan Gred <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                 <?= $form->field($model->kakitangan->jawatan, 'fname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                 
            </div>
             <div class="form-group">
                 
                <label class="control-label col-md-3 col-sm-3 col-xs-12">J/ F/ P/ I/ B <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                <?= $form->field($model->kakitangan->department, 'fullname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                
            </div>
            <div class="form-group">
                
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Taraf Jawatan <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                <?= $form->field($model->kakitangan->statusLantikan, 'ApmtStatusNm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                
                </div>
              
            </div>
             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Emel <span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                 <?= $form->field($model->kakitangan, 'COEmail')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                
                  <label class="control-label col-md-2 col-sm-2 col-xs-12">No. Telefon  <span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                <?= $form->field($model->kakitangan, 'COOffTelNo')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                 
        </div>
    </div>
        </div>
    </div>
</div>
   

<div class="row"> 
    <div class="x_panel">
       
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i>BUTIR-BUTIR ELAUN PAKAIAN / PAKAIAN PANAS YANG DITERIMA DAHULU</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            
            <div class="clearfix"></div>
            
        </div>
        <div class="x_content">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <table class="table table-striped table-sm jambo_table table-bordered">
                <thead>
                <tr class="headings">
                    <th class="text-center">Tarikh</th>
                    <th class="text-center">Tujuan</th>
                    <th class="text-center">Tempat Berkhidmat</th>
                    <th class="text-center">Jumlah</th>
                </tr>
                </thead>
                
                        <tr>
                            <td class="text-center"  style="text-align:center">  </td>
                            <td class="text-center">  </td>
                            <td class="text-center">  </td>
                            <td class="text-center">  </td>
                        </tr>
                   
                        
            </table>
    </div>
        </div>
    </div>
</div>

        <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
             <h2><i class="fa fa-book"></i><strong> BUTIR-BUTIR TEMPAT BERTUGAS / PERJALANAN / KURSUS DI LUAR NEGARA</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            
            <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Butiran : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                   <?= $form->field($model, 'butiran')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Tempat :<span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                <?= $form->field($model, 'nama_tempat')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
                </div>
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Negara :<span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
              <?= $form->field($model, 'negara')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>   
                
            </div>
            </div> 
            
            <div class="form-group">
           <label class="control-label col-md-3 col-sm-3 col-xs-12">Dari :<span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
            <?= $form->field($model, 'date_from')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
            </div>
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Hingga :<span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
              <?= $form->field($model, 'date_to')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
            </div
            </div>  
                
                <div class="form-group">
           <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempoh :<span class="required"></span>
                </label>
                <div class="col-md-2 col-sm-2 col-xs-12">
           <?= $form->field($model, 'days')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
            </div>
            </div> 
                <?php if($model->upload!= NULL){?>
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Dokumen LN 1 :<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                    
            <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to('@web/'.$model->upload, true); ?>" target="_blank" ><i></i><u>Dokumen LN 1.pdf</u></a><br>
                    
            </div>
            </div> <?php }?>  
                 <?php if($model->upload2!= NULL){?>
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Dokumen Kelulusan :<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                    
            <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to('@web/'.$model->upload2, true); ?>" target="_blank" ><i></i><u>Dokumen Kelulusan.pdf</u></a><br>
                    
            </div>
                 <?php }?>  
            </div>
            
</div>
        </div>
        
    </div>
            
        
</div>
        <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
             <h2><i class="fa fa-book"></i><strong>  Status Kelulusan BSM</strong></h2>
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Kelulusan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                        
                
                    
                     <?= $form->field($model, 'status')->label(false)->widget(Select2::classname(), [
                    'data' => ['verified' => 'Permohonan Diperakui',
                                     'unverified' => 'Permohonan Tidak Diperakui',],
                    'options' => [
                            'placeholder' => 'Sila Pilih'],

                ]); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <?= $form->field($model, 'catatan')->textarea(array('rows'=>6,'cols'=>5))->label(false);?>  

                </div>
            </div>
           <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button class="btn btn-primary" type="reset">Reset</button>
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
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



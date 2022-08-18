<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

?>
 
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86,1295,1297,1299], 'vars' => []]); ?>
<?php  $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="form-horizontal form-label-left"> 
    <div class="x_panel">
        <div class="x_title">
           <h2><strong><i class="fa fa-list"></i> Permohonan Tuntutan Kemudahan</strong></h2>
           <div class="form-group text-right">
           <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?>
           </div>
           <div class="clearfix"></div>
        </div>
    <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Maklumat Pemohon</strong></h2>
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
                
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jawatan dan Gred <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                 <?= $form->field($model->kakitangan->jawatan, 'fname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                 
            </div>
             <div class="form-group">
                 
                <label class="control-label col-md-3 col-sm-3 col-xs-12">J/ F/ P/ I/ B <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                <?= $form->field($model->kakitangan->department, 'fullname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                
            </div>
            <div class="form-group">
                
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Taraf Jawatan <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                <?= $form->field($model->kakitangan->statusLantikan, 'ApmtStatusNm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
              
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Emel <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                 <?= $form->field($model->kakitangan, 'COEmail')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Telefon <span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                 <?= $form->field($model->kakitangan, 'COOffTelNo')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Ext  <span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                <?= $form->field($model->kakitangan, 'COOffTelNoExtn')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                 
        </div>
            </div>
        </div>
    </div>
</div> 

    <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-book"></i><strong> Butiran Permohonan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Tuntutan* :<span class="required"></span>
        </label>
        <div class="col-md-4 col-sm-4 col-xs-10">  
            <?= $form->field($model->displayjenis, 'kemudahan')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
        </div>
        </div>
          
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Kulit Kasut* :<span class="required"></span>
        </label>
        <div class="col-md-4 col-sm-4 col-xs-10">  
           <?= $form->field($model, 'jenis_belian')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
        </div>    
        </div>
         
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Bilangan Kulit Kasut* :<span class="required"></span>
        </label>
        <div class="col-md-4 col-sm-4 col-xs-10">  
           <?= $form->field($model, 'bil_belian')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
        </div>    
        </div>
            
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh* :<span class="required"></span>
        </label>
        <div class="col-md-4 col-sm-4 col-xs-10">  
           <?= $form->field($model, 'used_dt')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
        </div>    
        </div>
            
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombor Bil/Resit* :<span class="required"></span>
        </label>
        <div class="col-md-4 col-sm-4 col-xs-10"> 
            <?= $form->field($model, 'resit')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
        </div>
        </div>
            
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Tuntutan (RM)*:<span class="required"></span>
        </label>
        <div class="col-md-4 col-sm-4 col-xs-10"> 
            <?= $form->field($model, 'jumlah_tuntutan')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
        </div>
        </div>    
              
       <?php if($model->dokumen_sokongan!= NULL){?>
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Resit Bayaran :<span class="required"></span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12">
            <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" ><i></i><u>Resit.pdf</u></a><br>   
            </div><?php }?>  
            
            <?php if($model->dokumen_sokongan2!= NULL){?>
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Dokumen Sokongan :<span class="required"></span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12">
            <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan2), true); ?>" target="_blank" ><i></i><u>Dokumen Sokongan.pdf</u></a><br>
            </div
            </div><?php }?>    
                 
            </div> 
        </div>
        </div>   
       
          
         
    <div class="x_panel">
        <div class="x_title">
             <h2><i class="fa fa-book"></i><strong>  Semakan Oleh Pembantu Tadbir BSM</strong></h2>
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Semakan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                     <input type="text" class="form-control" value="<?php echo $model->status_pt;?>" disabled="disabled">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <?= $form->field($model, 'catatan_pt')->textarea(array('rows'=>6,'cols'=>5, 'disabled'=>'disabled'))->label(false);?>   
                </div>
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Semakan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->date_pt;?>" disabled="disabled">
                </div>
            </div> 
           
        </div> 
    </div>
    </div> 
         
            <?php if($model->status_pp == 'MENUNGGU KELULUSAN' || $model->status_pp == ''){?>  
            <div class="x_panel">
        <div class="x_title">
             <h2><i class="fa fa-book"></i><strong>  Status Perakuan Pegawai BSM</strong></h2>
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Perakuan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">    
                <?= $form->field($model, 'status_pp')->label(false)->widget(Select2::classname(), [
                    'data' => ['DIPERAKUI' => 'DIPERAKUI',
                                   'TIDAK DIPERAKUI' => 'TIDAK DIPERAKUI',],
                   'options' => [
                         'placeholder' => 'Sila Pilih'],

                ]); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <?= $form->field($model, 'catatan_pp')->textarea(array('rows'=>6,'cols'=>5))->label(false);?>  

                </div>
            </div>
                
            <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                <button class="btn btn-primary" type="reset">Reset</button> 
            </div>
        </div><?php }?>
           
             
            <?php if($model->status_pp == 'DIPERAKUI' || $model->status_pp == 'TIDAK DIPERAKUI'){?>  
            <div class="x_panel">
        <div class="x_title">
             <h2><i class="fa fa-book"></i><strong>  Status Perakuan Pegawai BSM</strong></h2>
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Perakuan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">    
                 <input type="text" class="form-control" value="<?php echo $model->status_pp;?>" disabled="disabled">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <?= $form->field($model, 'catatan_pp')->textarea(array('rows'=>6,'cols'=>5, 'disabled'=>'disabled'))->label(false);?>   
                </div>
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Semakan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->verdate;?>" disabled="disabled">
                </div>
            </div>
                
                 <?php }?>
        </div></div>
            
    </div>
    </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>



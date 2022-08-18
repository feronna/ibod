<?php
use yii\widgets\ActiveForm;
\yii\web\YiiAsset::register($this);
?>

<div class="row">
<div class="col-md-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Lihat Rekod Lantikan</strong></h2>
<!--            <p align="right"><= \yii\helpers\Html::a('Kembali', ['lihat-rekod-kakitangan', 'ICNO' => $model->ICNO], ['class' => 'btn btn-primary']) ?></p>   -->
        <div class="clearfix"></div>
        </div>
        
    <div class="tblrscoadminpost-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
    <div class="x_panel">
    <div class="x_content">
    
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">No IC</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=  $form->field($model, 'ICNO')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jawatan">Jawatan Pentadbiran</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=  $form->field($model->adminpos, 'position_name')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
        </div>
    </div>
        
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="program">Program Pengajaran</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?php if($model->program!= NULL){?>                   
            <?=  $form->field($model->program, 'NamaProgram')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
            <?php }else{
                echo "Tiada Rekod";
            }?>    
        </div>
    </div> 
        
<!--    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jawatan">Jawatan Pentadbiran (2)</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              
              <=  $form->field($model->jawatantadbir, 'name')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
            
                <php if($model->jawatantadbir!= NULL){?>                   
                <=  $form->field($model->jawatantadbir, 'name')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                <php }else{
                    echo "Tidak Berkaitan";
                }?>
                
            </div>
    </div>-->
        
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="statusjawatan">Status Jawatan</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=  $form->field($model->jobStatus0, 'jobstatus_desc')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
        </div>
    </div>   
     
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="statusbayaran">Status Bayaran</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=  $form->field($model->paymentStatus0, 'paymentstatus_desc')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
        </div>
    </div>  

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="catatan">Catatan</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'description')->textArea(['maxlength' => true, 'rows' => 4])->textArea(['disabled'=>'disabled'])->label(false); ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jabatan">JAFPIB</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=  $form->field($model->dept, 'fullname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
        </div>
    </div>    

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kampus">Kampus</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=  $form->field($model->campus, 'campus_name')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
        </div>
    </div>         

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="appointmentdate">Tarikh Lantikan</label>  
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'tarikhkuatkuasa')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="startdate">Tarikh Kuatkuasa</label>  
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'tarikhmula')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
        </div>
    </div> 

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="enddate">Tarikh Tamat</label>  
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'tarikhtamat')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
        </div>
    </div>
        
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="flag">Status</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=  $form->field($model->flag0, 'flagstatuss')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
        </div>
    </div>  
    
<!--    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fail">Nama Fail<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <php if($model->files!= NULL){?>
                <a class="form-control" style="border:0;box-shadow: none;" href="<php echo yii\helpers\Url::to('@web/'.$model->files, true); ?>" target="_blank" ><i></i><u>Dokumen.pdf</u></a><br>
                <php }else{
                    echo "Tiada Dokumen Disertakan";}?>  
            </div>
    </div> -->

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Fail<span class="required"></span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?php if($model->files!= NULL){?>
             <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->files), true); ?>" target="_blank" ><i></i><u>Dokumen.pdf</u></a><br>
            <?php }else{
                echo "Tiada Dokumen Disertakan";
            }?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="catatan">Ulasan</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'ulasan')->textArea(['maxlength' => true, 'rows' => 4])->textArea(['disabled'=>'disabled'])->label(false); ?>
        </div>
    </div>
    <br>
 
<!--    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="renew">Status Pembaharuan:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <?php//echo  $form->field($model->renew0, 'renew_desc')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
            </div>
    </div> -->       

<!--    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="campus">Status Tugas:</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <?php//echo  $form->field($model->tugasStatus0, 'tugasstatus_desc')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
            </div>
    </div>   -->

<!-- DARI BORANG TBLPENEMPATAN-->
    
<!--    <div class="x_title">
        <h2 style="color: red;">Maklumat Penempatan</h2>
        <div class="clearfix"></div>
    </div>
    <br>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sebabpenempatan">Sebab Perpindahan</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php if($model->sebabPenempatan0!= NULL){?>                   
                <?=  $form->field($model->sebabPenempatan0, 'name')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                <?php }else{
                    echo "Tiada Rekod";
                }?>    
            </div>
    </div> 
    
    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="catatan">No. Ruj. Surat Arahan Penempatan</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'letter_order_refno')->textArea(['maxlength' => true, 'rows' => 4])->textArea(['disabled'=>'disabled'])->label(false); ?>
                
                <php if($model->letter_order_refno!= NULL){?>                   
                <=  $form->field($model, 'letter_order_refno')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                <php }else{
                    echo "Tiada Rekod";
                }?>   
            </div>
    </div>
    
    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="enddate">Tarikh Surat Arahan Penempatan</label>  
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'tarikhletterorder')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
            
                <php if($model->tarikhletterorder!= NULL){?>                   
                <=  $form->field($model, 'tarikhletterorder')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                <php }else{
                    echo "Tiada Rekod";
                }?>   
            </div>
    </div>
    
    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="catatan">No. Ruj. Surat</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'letter_refno')->textArea(['maxlength' => true, 'rows' => 4])->textArea(['disabled'=>'disabled'])->label(false); ?>
            
                <php if($model->letter_refno!= NULL){?>                   
                <=  $form->field($model, 'letter_refno')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                <php }else{
                    echo "Tiada Rekod";
                }?>
            </div>
    </div>
    
    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="catatan">Catatan</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'remark')->textArea(['maxlength' => true, 'rows' => 4])->textArea(['disabled'=>'disabled'])->label(false); ?>
            
                <php if($model->remark!= NULL){?>                   
                <=  $form->field($model, 'remark')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                <php }else{
                    echo "Tiada Rekod";
                }?>
            </div>
    </div>
    
    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="enddate">Tarikh Mula Penempatan</label>  
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'tarikhmulapenempatan')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
            
                <php if($model->tarikhmulapenempatan!= NULL){?>                   
                <=  $form->field($model, 'tarikhmulapenempatan')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                <php }else{
                    echo "Tiada Rekod";
                }?>
            </div>
    </div>
    -->
                
    <br>

    <?php ActiveForm::end(); ?>
    
    </div>
    </div>
        
    </div>
        
    </div>
</div>
</div>

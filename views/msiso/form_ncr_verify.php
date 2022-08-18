<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;   
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;
use dosamigos\tinymce\TinyMce; 
use kartik\date\DatePicker;

error_reporting(0);
?> 
<?= $this->render('menu') ?> 

<?php  $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left','enctype' => 'multipart/form-data']]); ?>
 
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><i class="fa fa-list"></i><strong> NCR </strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
    <div class="table-responsive">

    <table class="table table-sm table-bordered" >
        <thead> 
        <th scope="col" colspan=8" width="100%" style="background-color:lightgrey;"><center>LAPORAN KETAKAKURAN (NON-CONFORMITY REPORT)</center></th>

                <tr>
                        <td valign="2">Rujukan Fail:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                        <?= $form->field($model, 'rujukan_fail')->textInput(['maxlength' => true, 'disabled'=>'disabled']) ->label(false);?> 
                        </td>
                        
                        <td valign="3">JAFPIB :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="4">
                        <?= $form->field($model, 'dept')->textInput(['maxlength' => true, 'disabled'=>'disabled']) ->label(false);?>  
                        </td>  
                </tr>
                
                <tr>
                        <td valign="2">Tarikh Audit :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                        <?= $form->field($model, 'tarikhAudit')->textInput(['maxlength' => true, 'disabled'=>'disabled']) ->label(false);?>  
                        </td> 
                </tr>
                
                <tr>
                        <td valign="2">Jenis Audit :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                        <?php // $form->field($model, 'jenis_audit')->label(false)->radioList( [ 1 => 'Audit Dalam', 2 => 'Audit Susulan'] );?> 
                        <?= $form->field($model, 'jenisAudit')->textInput(['maxlength' => true, 'disabled'=>'disabled']) ->label(false);?>  

                        </td>
                        
                        <td valign="3">Kalsifikasi :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="4">
                        <?= $form->field($model, 'jenisKlasifikasi')->textInput(['maxlength' => true, 'disabled'=>'disabled']) ->label(false);?>   
                        <?php // $form->field($model, 'klasifikasi')->label(false)->radioList( [ 1 => 'Minor', 2 => 'Major'] );?> 
                        </td> 
                   
                </tr> 
        </thead>
        </table>
  
        <table class="table table-sm table-bordered" > 
        <thead>
        <th scope="col" colspan=8" width="100%" style="background-color:lightgrey;"> </th>
              
                <tr> 
                        <td valign="8"><strong>Bahagian 1 - Butiran Ketakuran <p>Keperluan :</strong><p>
                        <?= $form->field($model, 'conformity_req')->textarea(array('rows'=>5,'cols'=>5, 'disabled'=>'disabled')) ->label(false);?> 

                        <strong><p>Penemuan :<p></strong>
                        <?= $form->field($model, 'conformity_find')->textarea(array('rows'=>5,'cols'=>5, 'disabled'=>'disabled')) ->label(false);?> 

                        <strong><p>Bukti Penemuan :<p></strong>
                        <?= $form->field($model, 'conformity_proof')->textarea(array('rows'=>5,'cols'=>5, 'disabled'=>'disabled')) ->label(false);?> 

                        <div class="col-md-1 col-sm-1 col-xs-12">
                        <p>Auditor :<p></div>
                        <div class="col-md-5 col-sm-5 col-xs-6">
                        <?= $form->field($model, 'auditor')->textInput(['maxlength' => true, 'disabled'=>'disabled']) ->label(false);?>
                        </div>  

                        <div class="col-md-1 col-sm-1 col-xs-12">
                        <p>Auditee :<p></div>
                        <div class="col-md-5 col-sm-5 col-xs-6"> 
                        <?= $form->field($model, 'auditee')->textInput(['maxlength' => true, 'disabled'=>'disabled']) ->label(false);?> 
                        </div>
                         
                        <span class="required" style="color:red;"></span> 
                        </td> 
                </tr>

                <tr> 
                        <td valign="8"><strong>Bahagian 2 - Keputusan hasil penyiasatan dan pengenalpastian punca </strong><p> 
                        <?= $form->field($model, 'invest_result')->textarea(array('rows'=>5,'cols'=>5, 'disabled'=>'disabled')) ->label(false);?>  
                         
                        <div class="col-md-1 col-sm-1 col-xs-12">
                        <p>Auditee :<p></div>
                        <div class="col-md-5 col-sm-5 col-xs-6">
                        <?= $form->field($model, 'auditee')->textInput(['maxlength' => true, 'disabled'=>'disabled']) ->label(false);?>
                        </div>  
 
                        <div class="col-md-1 col-sm-1 col-xs-12">
                        <p>Tarikh :<p></div>
                        <div class="col-md-5 col-sm-5 col-xs-6">
                        <?= $form->field($model, 'tarikhAuditee')->textInput(['maxlength' => true, 'disabled'=>'disabled']) ->label(false);?>
                        </div> 
                        </td> 
                </tr> 

                <tr> 
                    <td valign="8"><strong>Bahagian 3 - Pelan Tindakan Pembetulan termasuk tarikh pelaksanaan  </strong><p> 
                    <?= $form->field($model, 'action_plan')->textarea(array('rows'=>5,'cols'=>5, 'disabled'=>'disabled')) ->label(false);?>  
                     
                    <div class="col-md-1 col-sm-1 col-xs-12">
                    <p>Auditee :<p></div>
                    <div class="col-md-5 col-sm-5 col-xs-6">
                    <?= $form->field($model, 'auditee')->textInput(['maxlength' => true, 'disabled'=>'disabled']) ->label(false);?>
                    </div>  

                    <div class="col-md-1 col-sm-1 col-xs-12">
                    <p>Tarikh :<p></div>
                    <div class="col-md-5 col-sm-5 col-xs-6">
                    <?= $form->field($model, 'tarikhAuditee')->textInput(['maxlength' => true, 'disabled'=>'disabled']) ->label(false);?>
                    </div> 
                    </td>

            </tr>  
            <tr> 
                    <td valign="8"><strong>Bahagian 4 - Verifikasi  </strong><p> 
                    <?= $form->field($model, 'verifikasi')->textarea(array('rows'=>5,'cols'=>5, 'disabled'=>'disabled')) ->label(false);?>  
                     
                    <div class="col-md-1 col-sm-1 col-xs-12">
                    <p>Auditor :<p></div>
                    <div class="col-md-5 col-sm-5 col-xs-6">
                    <?= $form->field($model, 'auditor')->textInput(['maxlength' => true, 'disabled'=>'disabled']) ->label(false);?>
                    </div>  

                    <span class="required" style="color:red;"></span> 
                    </td> 
            </tr> 
        </thead> 
     </table> 
    </div> 
<div class="x_panel"> 
<div class="x_content"> 
<div class="customer-form">   
    <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Disemak Oleh :<span class="required"></span>
            </label>
            <div class="col-md-4 col-sm-4 col-xs-6"> 
            <?= $form->field($biodata, 'CONm')->textInput(['maxlength' => true, 'disabled' => true]) ->label(false);?> 
            </div>  
    </div> 
    <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Penutupan NCR :<span class="required"></span>
            </label>
            <div class="col-md-4 col-sm-4 col-xs-6">
            <?= $form->field($model, 'closing_ncr')->label(false)->radioList( [ 1 => 'Ya', 2 => 'Tidak'] );?> 
            </div> 
    </div> 
    <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Tarikh :<span class="required"></span>
            </label>
            <div class="col-md-4 col-sm-4 col-xs-6">
            <?= $form->field($model, 'closing_ncr_dt')->label(false)->widget(DatePicker::classname(),[
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
</div>
</div>
</div>
    </div> 
    <div class="x_panel">
        <div class="x_title">
             <h2><i class="fa fa-book"></i><strong>  BENGKEL ISO-AUDIT DALAM</strong></h2> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
           
            <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                <?= $form->field($model, 'tindakan_bengkel')->textInput(['maxlength' => true, 'disabled'=>'disabled']) ->label(false);?> 
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                <?= $form->field($model, 'catatan_bengkel')->textarea(array('rows'=>6,'cols'=>5, 'disabled' => true))->label(false);?>  
                </div>
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Bengkel : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                <input type="text" class="form-control" value="<?php echo $model->bengkelDt;?>" disabled="disabled"> 
                </div>
            </div>  
        </div>   
    </div>
   
</div>   
<div class="customer-form">  
        <div class="form-group" align="left">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5"> 
            <br>
            <!-- <?= Html::submitButton('Simpan', ['class' => 'btn btn-warning']) ?> -->
            <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
            <button class="btn btn-primary" type="reset">Reset</button> 
        </div>
        </div>
</div> 

</div>
</div>
</div> <?php ActiveForm::end(); ?>



 



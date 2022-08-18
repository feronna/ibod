<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;   
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata; 
use kartik\date\DatePicker;

error_reporting(0);
?> 
<?= $this->render('menu') ?> 
 
<?php  $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left','enctype' => 'multipart/form-data']]); ?>
   
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><i class="fa fa-list"></i><strong> NOTA AUDIT </strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
    <!-- <table class="table table-sm table-bordered" >
        <thead> 
        <th scope="col" colspan=8" width="100%" style="background-color:lightgrey;"><center>NOTA AUDIT DALAM</center></th>

                <tr>
                        <td valign="2">JAFPIB:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                        <?php $form->field($model, 'dept')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ->label(false);?> 
                         
                        </td>
                        
                        <td valign="3">Tarikh Audit :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="4">
                        <?php $form->field($model, 'audit_date')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ->label(false);?>  
                        <?php $form->field($model, 'audit_date')->label(false)->widget(DatePicker::classname(),[
                                            'readonly' => false,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>
                        </td>
                        </td>  
                </tr>
                
                <tr>
                        <td valign="2">Auditee :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                        <?php $form->field($model, 'auditee_name')->textInput(['maxlength' => true, 'disabled' => true]) ->label(false);?> 
                        
                        </td> 

                        <td valign="3">Auditor :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="4">
                        <?php $form->field($model, 'auditor_name')->textInput(['maxlength' => true, 'disabled' => true]) ->label(false);?> 
                        
                        </td>  
                </tr>
                
                <tr> 
                        <td valign="2">Standard :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3"> 
                        <?php $form->field($model, 'standard')->textInput(['maxlength' => true, 'disabled' => true]) ->label(false);?>  
                      
                        </td> 
                        <td valign="3"> <span class="required" style="color:red;"></span></td> 
                        <td colspan="4">  
                        </td> 
                   
                </tr> 
        </thead>
        </table>

        <table class="table table-sm table-bordered" >
            <thead>
            <th scope="col" colspan=8" width="30%" style="background-color:lightgrey;"><center> </center></th>
            <tr>
                <td valign="3"><strong>Rujukan<span class="required" style="color:red;">*</span>  </strong></td>
                <td colspan="5">
                <?php $form->field($model, 'rujukan_fail')->textInput(['maxlength' => true, 'disabled' => true]) ->label(false);?>  
                         
                </td> 
            </tr>      
            
            <tr> 
                <td colspan="8"><strong>Perkara perlu disemak <span class="required" style="color:red;">*</span></strong></td>  
                </tr> 

                <tr>
                <td colspan="8">
                <?php $form->field($model, 'list_check')->textarea(array('rows'=>15,'cols'=>5)) ->label(false);?>   
                </td>  
            </tr> 

            <tr> 
                <td colspan="8"><strong>Catatan <span class="required" style="color:red;">*</span></strong></td>  
                </tr> 

                <tr>
                <td colspan="8">
                <?php $form->field($model, 'catatan')->textarea(array('rows'=>15,'cols'=>5)) ->label(false);?>   
                </td>  
            </tr> 
                
            </thead>
        </table>  -->

        <table class="table table-sm table-bordered" >
        <thead> 
        <th scope="col" colspan=8" width="100%" style="background-color:lightgrey;"><center>NOTA AUDIT DALAM</center></th>

                <tr>
                <td valign="2">JAFPIB:<span class="required" style="color:red;"></span></td> 
                        <td colspan="2">
                        <div class="col-md-5 col-sm-5 col-xs-2">
                        <?= $form->field($model, 'dept')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ->label(false);?> 
                        </div>
                        </td>
                </tr>
                <td valign="3">Tarikh Audit :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="4">
                        <div class="col-md-5 col-sm-5 col-xs-2">
                        <?= $form->field($model, 'created_dt')->label(false)->widget(DatePicker::classname(),[
                                            'readonly' => false,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>
                        </div>
                        </td>
                        </td>  
                <tr>
                        <td valign="2">Nota Audit 
                        <i data-html="true" class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
                        title="Muat Naik Nota Audit"></i><span class="required" style="color:red;"> :*</span><br>
                        </i></td> 
                        <td colspan="3">
                        <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->attachment), true); ?>" target="_blank" ><i></i><u>Nota Audit.pdf</u></a>
                        </td>
                        
                         
                          
                </tr>
                
        </thead>
        </table> 
        <div class="customer-form">  
                <div class="form-group" align="left">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5"> 
                    <br>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                    <button class="btn btn-primary" type="reset">Reset</button>
                </div>
                </div>
        </div>
    </div>
</div>
     
</div>  
      
    </div>
    </div>
</div> <?php ActiveForm::end(); ?>



 



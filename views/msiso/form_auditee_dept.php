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
            <h2><i class="fa fa-list"></i><strong> OFI </strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
    <div class="table-responsive">

    <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Rujukan Fail :<span class="required"></span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-4">
            <?= $form->field($model, 'rujukan_fail')->textInput(['maxlength' => true,  'disabled' => 'disabled']) ->label(false);?> 
            </div>

            <label class="control-label col-md-3 col-sm-3 col-xs-6">JAFPIB :<span class="required"></span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-2">
            <?= $form->field($model, 'dept')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ->label(false);?> 

            <?php
            // $form->field($model, 'dept')->widget(Select2::classname(), 
            //                 ['data' => ArrayHelper::map(app\models\hronline\Department::find()->all(), 'shortname', 'shortname'),
            //                 'options' => [
            //                 'placeholder' => ''],
            //                 ])->label(false); 
                        ?> 
            </div>
              
    </div> 

        <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan=8" width="30%" style="background-color:lightgrey;"><center>PELUANG PENAMBAHBAIKAN</center></th>

                <tr>
                        <td valign="2"> Klausa :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                        <?= $form->field($model->klausa, 'clauseName')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ->label(false);?>  

                        </td>   
                </tr> 
        </thead>

        <thead> 
                <tr> 
                    <td colspan="8">Butiran Penemuan Audit <span class="required" style="color:red;">*</span></td> 
                </tr>  
                <tr>  
                <td colspan="8">
                    <?= $form->field($model, 'butiran')->textarea(array('rows'=>6,'cols'=>5, 'disabled' => true)) ->label(false);?>  
                    
                </td>  
                </tr> 
        
                <tr>
                        <td valign="2"> Auditor :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3"> 
                        <?= $form->field($model, 'auditor_name')->textInput(['disabled'=>'disabled'])->label(false); ?>
 

                        <td valign="2">Tarikh :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                        <?= $form->field($model, 'tarikhAudit')->textInput(['maxlength' => true, 'disabled'=>'disabled']) ->label(false);?>  
                        
                        </td>  
                </tr> 
        </thead>

        <thead> 
                <tr> 
                    <td colspan="6">Tindakan Penambahbaikan <span class="required" style="color:red;">*</span></td> 
                </tr>  
                <tr>  
                <td colspan="6">
                    <?= $form->field($model, 'penambahbaikan')->textarea(array('rows'=>6,'cols'=>5)) ->label(false);?>  
                    <?php
                //      $form->field($model, 'tindakan')->widget(TinyMce::className(), [
                // 'options' => ['rows' => 10],
                // 'language' => 'en',
                // 'clientOptions' => [
                //     'plugins' => [],
                //     'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"
                // ]
                // ])->label(false);
             ?>    
                </td>  
                </tr> 

                <tr>
                        <td valign="2"> Auditee :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3"> 
                        <?= $form->field($biodata, 'CONm')->textInput(['disabled'=>'disabled'])->label(false); ?>
                        
                        </td>  

                        <td valign="2">Tarikh :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                        <?= $form->field($model, 'deptDt')->textInput(['maxlength' => true, 'disabled'=>'disabled']) ->label(false);?>   
                        
                        </td>  
                </tr> 
        </thead> 
        </table> 
    </div> 
</div> 
 
        <div class="customer-form">  
                <div class="form-group" align="left">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4"> 
                    <br>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-warning', 'name' => 'simpan', 'value' => 'submit_1']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['id' => 'submitb', 'class' => 'btn btn-success', 'name' => 'hantar', 'value' => 'submit_2']) ?>
                    <button class="btn btn-primary" type="reset">Reset</button> 
                   
                  
                </div>
                </div>
            </div> 
        <div class="ln_solid"></div>
    </div>
    </div>
</div> <?php ActiveForm::end(); ?>



 



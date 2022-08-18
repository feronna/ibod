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

    <?php if($model->status_tindakan == '2') { ?>
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
            </div>
              
    </div> 

        <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan=8" width="30%" style="background-color:lightgrey;"><center>PELUANG PENAMBAHBAIKAN</center></th>

                <tr>
                        <td valign="2"> Klausa :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                        <?= $form->field($model, 'clause')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(app\models\msiso\TblClause::find() ->orderBy(['clause' => SORT_ASC])->all(), 'clause_order', 'clauseName'),

                            // 'options' => [
                            // 'placeholder' => 'Klausa'
                            // ],
                            ])->label(false); 
                        ?> 
                        </td>   
                </tr> 
        </thead> 
        <thead> 
                <tr> 
                    <td colspan="8">Butiran Penemuan Audit <span class="required" style="color:red;">*</span></td> 
                </tr>  
                <tr>  
                <td colspan="8">
                    <?= $form->field($model, 'butiran')->textarea(array('rows'=>6,'cols'=>5)) ->label(false);?>   
                </td>  
                </tr> 
        
                <tr>
                        <td valign="2"> Auditor :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3"> 
                        <?= $form->field($model, 'auditor_name')->textInput(['disabled'=>'disabled'])->label(false); ?>  
                        </td>  

                        <td valign="2">Tarikh :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                        <?php $form->field($model, 'tarikhAudit')->textInput(['disabled'=>'disabled'])->label(false); ?>  
                        <?= $form->field($model, 'tarikh_audit')->label(false)->widget(DatePicker::classname(),[
//                                            'readonly' => true,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd',    
                                                'minDate'=>'0'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>
                        </td>  
                </tr> 
        </thead> 
        
</table>  
</div>  
</div>  
        <div class="customer-form">  
                <div class="form-group" align="left">
                <div class="col-md-5 col-sm-5 col-xs-12 col-md-offset-4"> 
                    <br> 
                    <!-- <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-success']) ?>  -->
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-warning', 'name' => 'simpan', 'value' => 'submit_1']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['id' => 'submitb', 'class' => 'btn btn-success', 'name' => 'hantar', 'value' => 'submit_2']) ?>
                    <button class="btn btn-primary" type="reset">Reset</button> 
                </div>
                </div>
        </div>  
</div>
<?php }elseif($model->status_tindakan == '3' || $model->status_tindakan == '5'){ ?> 
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
            </div>
              
    </div> 

        <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan=8" width="30%" style="background-color:lightgrey;"><center>PELUANG PENAMBAHBAIKAN</center></th>

                <tr>
                        <td valign="2"> Klausa :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                        <?= $form->field($model, 'clause')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(app\models\msiso\TblClause::find()->orderBy(['clause' => SORT_ASC])->all(), 'clause_order', 'clauseName'),
                            // 'options' => [
                            // 'placeholder' => 'Klausa'
                            // ],
                            ])->label(false); 
                        ?> 
                        </td>   
                </tr> 
        </thead>

        <thead> 
                <tr> 
                    <td colspan="8">Butiran Penemuan Audit <span class="required" style="color:red;">*</span></td> 
                </tr>  
                <tr>  
                <td colspan="8">
                    <?= $form->field($model, 'butiran')->textarea(array('rows'=>6,'cols'=>5)) ->label(false);?>   
                </td>  
                </tr> 
        
                <tr>
                        <td valign="2"> Auditor :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3"> 
                        <?= $form->field($model, 'auditor_name')->textInput(['disabled'=>'disabled'])->label(false); ?>  
                        </td>  

                        <td valign="2">Tarikh :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                        <?php $form->field($model, 'tarikhAudit')->textInput(['disabled'=>'disabled'])->label(false); ?>  
                        <?= $form->field($model, 'tarikh_audit')->label(false)->widget(DatePicker::classname(),[
//                                            'readonly' => true,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd',    
                                                'minDate'=>'0'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>
                        </td>  
                </tr> 
        </thead>
        
</table>  
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
                <?= $form->field($model, 'tindakan_bengkel')->textInput(['disabled'=>'disabled'])->label(false); ?>

                 
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
    <div class="customer-form">  
            <div class="form-group" align="left">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5"> 
                <br>  
                    <?= Html::submitButton(Yii::t('app', 'Hantar'), ['id' => 'submitb', 'class' => 'btn btn-success', 'name' => 'hantar', 'value' => 'submit_2']) ?>
                   
            </div>
            </div>
    </div>  
    <?php } ?>

</div>
</div>
</div>
</div>
</div> <?php ActiveForm::end(); ?>



 



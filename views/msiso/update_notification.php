<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;   
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata; 
use kartik\date\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\msiso\RefAuditor;
 

error_reporting(0);
?> 
<?= $this->render('menu') ?> 

<?php $form = ActiveForm::begin(['options' => ['enableAjaxValidation' => true, 'class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
 
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><i class="fa fa-list"></i><strong> KEMASKINI AUDIT NOTIFICATION </strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
    <div class="table-responsive">

    <table class="table table-sm table-bordered" >
        <thead> 
        <th scope="col" colspan=8" width="100%" style="background-color:lightgrey;"><center> AUDIT NOTIFICATION</center></th>

                <tr>
                        <td valign="2">JAFPIB:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                        <?= $form->field($model, 'dept')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(app\models\hronline\Department::find()->all(), 'shortname', 'shortname'),
                            'options' => [
                            'placeholder' => ''],
                            ])->label(false); 
                        ?> 
                        </td> 
                </tr>
                
                <tr>
                        <td valign="2">Cadangan Tarikh :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                        <?= $form->field($model, 'plan_audit_dt')->label(false)->widget(DatePicker::classname(),[
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
                
                <tr>
                        <td valign="2">Cadanga Masa :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                        <?= $form->field($model, 'from_audit_time')->label(false)->widget(\kartik\time\TimePicker::classname(),[
                                            'readonly' => false,
                                            'pluginOptions' => [
                                                'format' => 'H:m:s',
                                                'autoclose'=>true,        
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>  
                        </td>  
                </tr> 
        </thead>
        </table> 
        
        <div class="customer-form">  
                <div class="form-group" align="center">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2"> 
                    <br> 
                    <?= Html::submitButton(Yii::t('app', 'Hantar'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1', 'data' => ['disabled-text' => 'Please Wait..']])?>
                    <!-- <button class="btn btn-primary" type="reset">Reset</button> -->
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

 



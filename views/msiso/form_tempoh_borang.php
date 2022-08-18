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
            <h2><i class="fa fa-list"></i><strong> PEMAKLUMAN TEMPOH PENGISIAN AUDIT</strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
    <div class="table-responsive">

    <table class="table table-sm table-bordered" >
        <thead> 
        <th scope="col" colspan=8" width="100%" style="background-color:lightgrey;"><center> TEMPOH PENGISIAN AUDIT</center></th>

                <!-- <tr>
                        <td valign="2">Jenis Borang:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="6">
                        <?php
                        // $form->field($model, 'jenis_borang')->label(false)->widget(Select2::classname(), [
                        //     'data' => ['../kadkontraktor/permohonan-kontraktor'  => 'BARU', 'ROSAK' => 'ROSAK', 'HILANG' => 'HILANG'],
                        //     'options' => ['placeholder' => 'Pilih Status', 'class' => 'form-control col-md-7 col-xs-12', 'id' => 'foo' ],
                        //     'pluginOptions' => [
                        //         'allowClear' => true
                        //     ],
                        // ]);
                        ?>
                        </td> 
                </tr> -->
                
                <!-- <tr>
                        <td valign="2">Cadangan Tarikh :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="6">
                       
                        </td> 
                </tr> -->
                
                <tr>
                        <td valign="2">Tarikh Mula :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                      
                        </td>  
                        <td valign="2">Cadangan Tarikh Tutup :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                        
                        </td>  
                </tr> 
        </thead>
        </table>
        
        <div class="customer-form">  
                <div class="form-group" align="center">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"> 
                    <br> 
                    <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Hantar'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1', 'data' => ['disabled-text' => 'Please Wait..']])?>
                    <button class="btn btn-primary" type="reset">Reset</button>
                </div>
                </div>
        </div>
    </div>  
</div> 
</div> 
                                     
</div>
 
 <?php ActiveForm::end(); ?>
 

 



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
                        <?= $form->field($model, 'rujukan_fail')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ->label(false);?> 
                        </td>
                        
                        <td valign="3">JAFPIB :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="4">
                        <?= $form->field($data, 'dept')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ->label(false);?> 
                        </td>  
                </tr>
                
                <tr>
                        <td valign="2">Tarikh Audit :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                        <?= $form->field($model, 'tarikh_audit')->label(false)->widget(DatePicker::classname(),[
                                            'readonly' => false,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>
                        </td> 
                </tr>
                
                <tr>
                        <td valign="2">Jenis Audit :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                        <?= $form->field($model, 'jenis_audit')->label(false)->radioList( [ 1 => 'Audit Dalam', 2 => 'Audit Susulan'] );?> 
                        </td>
                        
                        <td valign="3">Klasifikasi :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="4">
                        <?= $form->field($model, 'klasifikasi')->label(false)->radioList( [ 1 => 'Minor', 2 => 'Major'] );?> 
                        </td> 
                   
                </tr> 
        </thead>
        </table>
  
        <table class="table table-sm table-bordered" > 
        <thead>
        <th scope="col" colspan=8" width="100%" style="background-color:lightgrey;"> </th>
              
                <tr>  
                        <td valign="8"><strong>Bahagian 1 - Butiran Ketakuran </strong>
                        <p>Klausa :<p> 
                        <?= $form->field($model, 'clause')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(app\models\msiso\TblClause::find() ->orderBy(['id' => SORT_ASC])->all(), 'clause_order', 'clauseName'),
                            'options' => [
                            'placeholder' => 'Klausa'],
                            ])->label(false); 
                        ?> 

                        <p>Keperluan :</strong><p>
                        <?= $form->field($model, 'conformity_req')->textarea(array('rows'=>3,'cols'=>5)) ->label(false);?> 

                        <strong><p>Penemuan :<p></strong>
                        <?= $form->field($model, 'conformity_find')->textarea(array('rows'=>3,'cols'=>5)) ->label(false);?> 

                        <strong><p>Bukti Penemuan :<p></strong>
                        <?= $form->field($model, 'conformity_proof')->textarea(array('rows'=>3,'cols'=>5)) ->label(false);?> 

                        <div class="col-md-1 col-sm-1 col-xs-12">
                        <p>Auditor :<p></div>
                        <div class="col-md-5 col-sm-5 col-xs-6">
                        <?php $form->field($model, 'auditor')->textInput(['maxlength' => true, 'placeholder' => 'Auditor']) ->label(false);?>
                        <?= $form->field($biodata, 'CONm')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ->label(false);?>
                       
                        <?php
                          $form->field($model, 'auditor')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(app\models\msiso\msiso::find()->all(), 'name', 'name'),
                            'options' => [
                            'placeholder' => ''],
                            ])->label(false); 
                          ?> 
                        </div>  

                        <div class="col-md-1 col-sm-1 col-xs-12">
                        <p>Auditee :<p></div>
                        <div class="col-md-5 col-sm-5 col-xs-6"> 
                        <?php $form->field($model, 'auditee')->textInput(['maxlength' => true, 'placeholder' => 'Auditee']) ->label(false);?> 
                        <?=
                          $form->field($model, 'auditee_icno')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['DeptId' => $data->deptId, 'status' => 1 ])->all(), 'ICNO', 'CONm'),
                            'options' => [
                            'placeholder' => ''],
                            ])->label(false); 
                            ?> 
                        </div>
                         
                        <span class="required" style="color:red;"></span> 
                        </td> 
                </tr> 
        </thead> 
</table> 
</div> 
</div>  
        <div class="customer-form">  
                <div class="form-group" align="left">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5"> 
                    <br>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-warning', 'name' => 'simpan', 'value' => 'submit_1']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['id' => 'submitb', 'class' => 'btn btn-success', 'name' => 'hantar', 'value' => 'submit_2']) ?>
                    <button class="btn btn-primary" type="reset">Reset</button> 
                </div>
                </div>
        </div>  
    </div>
    </div>
</div> <?php ActiveForm::end(); ?>



 



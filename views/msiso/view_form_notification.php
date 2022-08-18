<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;   
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;
use dosamigos\tinymce\TinyMce;
// use app\models\msiso\TblClause;

error_reporting(0);
?> 
<?= $this->render('menu') ?> 
 
<?php  $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left','enctype' => 'multipart/form-data']]); ?>
   
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><i class="fa fa-list"></i><strong> Audit Notification </strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
    <table class="table table-sm table-bordered" >
        <thead> 
        <th scope="col" colspan=8" width="100%" style="background-color:lightgrey;"><center>AUDIT NOTIFICATION</center></th>

                <tr>
                        <td valign="2">JAFPIB:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="6"> 
                         <?= $form->field($model, 'dept')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ->label(false);?> 
                        </td> 
                </tr>
                
                <tr>
                        <td valign="2">Tarikh :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="6">
                        
                         <?= $form->field($model, 'auditDt')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ->label(false);?> 
                        </td> 
                </tr>
                
                <tr>
                        <td valign="2">Masa :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3"> 
                         <?= $form->field($model, 'from_audit_time')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ->label(false);?> 
                        </td>
                        
                        <td valign="2">Hingga :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3"> 
                         <?= $form->field($model, 'to_audit_time')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ->label(false);?> 
                        </td>
                </tr> 
        </thead>
        </table> 
        <div class="form-group text-right">
       
</div>
    </div>
       
</div> 
 
 
    <div class="x_panel" >
        <div class="x_title">
            <h2><i class="fa fa-list"></i><strong> Maklumat Juruadit </strong></h2> 
            <div class="form-group text-right">
          
            </div>
            <div class="clearfix"></div>
        </div>
    <div class="x_content"> 
    <?= GridView::widget([
                   'dataProvider' => $dataProvider,
                    'summary' => '',
                    'showFooter' => true,
                    // 'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],  
                    'options' => [
                            'class' => 'table-responsive',
                                ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                                        'header' => '#',
                            'headerOptions' => ['class'=>'text-center'],
                                            'contentOptions' => ['class'=>'text-center'], 
                                            ],  
                        [
                            'label' => 'Juruaudit',
                            'format' => 'raw',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => 'kakitangan.CONm',
                        ], 
                        [
                            'label' => 'Role',
                            'format' => 'raw',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => 'auditor.auditorRole',
                        ],  
 
                    ], 
                ]); ?> 
    </div>
       
</div> 
        
    </div>
    </div>
</div> <?php ActiveForm::end(); ?>



 



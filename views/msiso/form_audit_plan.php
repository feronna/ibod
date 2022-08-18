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

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><i class="fa fa-list"></i><strong> AUDIT PLAN </strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
    <div class="table-responsive">

    <table class="table table-sm table-bordered" >
        <thead> 
        <th scope="col" colspan=8" width="100%" style="background-color:lightgrey;"><center> DAFTAR AUDIT PLAN</center></th>

                <tr>
                        <td valign="2">Pelan Audit:<span class="required" style="color:red;"> </span>
                        <i data-html="true" class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
                        title="Muat Naik Pelan Audit<br>
                        "></i></td> 
                        <td colspan="3">
                        <?= $form->field($model, 'file')->fileInput()->label(false);?> 
                        
                        </td> 
                </tr>
                <tr>
                        <td valign="2">Tajuk :<span class="required" style="color:red;">*</span>
                        </td> 
                        <td colspan="3">
                        <?= $form->field($model, 'title')->textInput(['maxlength' => true,]) ->label(false);?>   
                        </td> 
                </tr>
                <tr>
                        <td valign="2">Catatan :<span class="required" style="color:red;"> </span>
                        <i data-html="true" class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
                        title="Muat Naik Pelan Audit<br>
                        "></i></td> 
                        <td colspan="3">
                        <?= $form->field($model, 'catatan')->textarea(array('rows'=>3,'cols'=>5)) ->label(false);?> 
                        
                        </td> 
                </tr>

        </thead>
        </table>  
    </div>   

    <div class="clearfix"></div>
        <div class="customer-form">  
                <div class="form-group" align="center">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2"> 
                    <br> 
                    <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Hantar'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1', 'data' => ['disabled-text' => 'Please Wait..']])?>
                    <button class="btn btn-primary" type="reset">Reset</button>
                </div>
                </div>
        </div>
</div>
</div>
<?php ActiveForm::end(); ?>

        <div class="x_panel" >
        <div class="x_title">
            <h2><i class="fa fa-list"></i><strong> AUDIT PLAN </strong></h2> 
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
    <div class="table-responsive">

   <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider, 
                    'summary' => '',
                    'showFooter' => true,
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
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
                            'label' => 'Audit Plan',
                            'format' => 'raw',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value'=>function ($list){   
                               return Html::a(' '. $list->title , Yii::$app->FileManager->DisplayFile($list->audit_plan), ['class'=>'fa fa-download', 'target' => '_blank']);  
                            },
                        ], 
                        [
                            'label' => 'Tarikh Muat Naik',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => 'uploadDt',
                        ],
                        [
                            'label' => 'Muat Naik Oleh',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => 'kakitangan.CONm',
                        ],
                        [
                            'label' => 'Catatan',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => 'catatan',
                        ],
                        [
                            'label' => 'Tindakan',
                            'format' => 'raw', 
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'], 
                            'value'=>function ($list){
                            // return Html::a('', ['msiso/update-plan', 'id' => $list->id], [
                             return Html::a('', ['msiso/replace-audit-plan', 'id' => $list->id], [ 
                            'class' => 'btn btn-primary fa fa-edit',
                             
                        ])      
                            .Html::a('', ['dlte', 'id' => $list->id], [
                            'class' => 'btn btn-danger fa fa-trash',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]);
                          
                        
                      },
                            
                        ], 
                                   
                    ],
                            
                ]); ?>
                        
            </table> 
    </div>  
</div> 

            </div>   
        </div>
        </div>
</div>
</div> 
 


 



<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;   
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;
use dosamigos\tinymce\TinyMce;
use wbraganca\dynamicform\DynamicFormWidget;

error_reporting(0);
?>

<?= $this->render('menu') ?> 

<?php $form = ActiveForm::begin(['options' => ['enableAjaxValidation' => true, 'class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
<div class="x_panel"> 
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><i class="fa fa-list"></i><strong> Tambah Klausa</strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
    <table class="table table-sm table-bordered" >
        <thead> 
        <th scope="col" colspan=8" width="100%" style="background-color:lightgrey;"><center> TAMBAH KLAUSA</center></th>
 
                <tr>
                        <td valign="2">KLAUSA :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                        <?= $form->field($model, 'clause')->textInput(['maxlength' => true, 'placeholder' => 'Klausa']) ->label(false);?>
                        </td>   
                </tr> 

                <tr> 
                        <td valign="2">TAJUK KLAUSA :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                        <?= $form->field($model, 'clause_title')->textInput(['maxlength' => true, 'placeholder' => 'Tajuk Klausa']) ->label(false);?> 
                        </td>  
                </tr> 
        </thead>
        </table> 

<div class="x_panel">
        <div class="x_title">
            <h2><strong>TAMBAH KLAUSA</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div> 
        <div class="x_content">
        
        <div class="customer-form"> 
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper1', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items1', // required: css class selector
                    'widgetItem' => '.item1', // required: css class
                    'limit' => 10, // the maximum times, an element can be added (default 999)
                    'min' => 0, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.remove-item', // css class
                    'model' => $modelsAddress[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'full_name',
                        'address_line1',
                        'address_line2',
                        'city',
                        'state',
                        'postal_code',
                    ],
                ]); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>
                    <i class="fa fa-plus-circle"></i> TAMBAH

                    <button type="button" class="add-item btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i>Tambah </button>
                </h4>
            </div>
            <div class="panel-body">
                <div class="container-items1"><!-- widgetBody -->
                <?php foreach ($modelsAddress as $i => $modelAddress): ?>
                    <div class="item1 panel panel-default"><!-- widgetItem -->
                        <div class="panel-heading">
                            <h3 class="panel-title pull-left">MSISO KLAUSA</h3>
                            <div class="pull-right">
                                <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button> 
                                <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <h5 style="color:red">
                                       <!-- * Suami/Isteri  <br/>* Anak-anak berusia 21 tahun ke bawah (Anak-anak berusia 21 tahun ke atas tidak layak menggunakan kemudahan ini).</h5> -->

                            <?php
                                // necessary for update action.
                                if (! $modelAddress->isNewRecord) {
                                    echo Html::activeHiddenInput($modelAddress, "[{$i}]id");
                                }
                            ?>
                            <table class="table table-sm table-bordered" >
        <thead> 
        <th scope="col" colspan=8" width="100%" style="background-color:lightgrey;"><center> </center></th>

        <tr>
                        <td valign="2">KLAUSA :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                        <?= $form->field($modelAddress,  "[{$i}]clause_order")->textInput(['maxlength' => true, 'placeholder' => 'Tajuk Klausa']) ->label(false);?> 
                        </td>  
                          
                </tr> 

                <tr> 
                        <td valign="2">TAJUK KLAUSA :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                        <?= $form->field($modelAddress,  "[{$i}]clause_title")->textInput(['maxlength' => true, 'placeholder' => 'Tajuk Klausa']) ->label(false);?> 
                        
                    </td>  
                </tr> 

        </thead>
        </table>  

                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            </div>
        </div>
        <!-- .panel -->
        <?php DynamicFormWidget::end(); ?>
        
        </div>
    </div>
</div> 
</div> 
</div> 
<div class="customer-form">  
                <div class="form-group" align="center">
                <div class="col-md-7 col-sm-7 col-xs-12 col-md-offset-2"> 
                    <br> 
                    <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Hantar'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1', 'data' => ['disabled-text' => 'Please Wait..']])?>
                    <button class="btn btn-primary" type="reset">Reset</button>
                </div>
                </div>
        </div>                 
<?php ActiveForm::end(); ?>

<!-- <div class="x_panel">
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><i class="fa fa-list"></i><strong> Senarai Klausa</strong></h2>
               
            <div class="clearfix"></div>
        </div> 
            
        <table class="table table-sm table-bordered jambo_table table-striped" style="width:100%;", > 
       
           
                            <tr>   
                                <th colspan="4"><center>Klausa</center></th>   
                                 <th colspan="4"><center> </center></th>  
                                <td colspan="2"><center>Nama Klausa</center></td> 
                            </tr>
                           
                            <?php if ($clause) { ?>
                                 <tr>    
                                <td rowspan="8"><center><strong> </strong></center></td> 
                            </tr>   
                        <?php foreach ($clause as $list) { ?>
                            
                            <tr>    
                                <td colspan="4"><center><strong><?php echo $list->clause;?> </strong></center> </td> 
                                <td colspan="4"><center><strong> </strong></center></td>    
                                <td colspan="2"><left><strong><?php echo $list->parent_clause;?> &nbsp; <?php echo $list->clause_title;?> </strong></left></td> 
                            </tr> 
                            
                              <?php } ?>    
                           
                            <tr>    
                                <td colspan="12" style="background-color:Gray;"> 
                                </td>    
                            </tr> 
                            <?php } ?>    
                            
            </table>
       </div>
    </div> 
</div>  

<!-- <div class="x_panel">
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><i class="fa fa-list"></i><strong> Senarai Klausa</strong></h2>
               
            <div class="clearfix"></div>
        </div> 
            
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
                        // ['class' => 'yii\grid\SerialColumn',
                        //                 'header' => '#',
                        //     'headerOptions' => ['class'=>'text-center'],
                        //                     'contentOptions' => ['class'=>'text-center'], 
                        //                     ], 
                        
                        [
                            'label' => 'Klausa',
                            'value' => 'clause', 
                        ],
                        [
                            'label' => '',
                            'value' => 'clause_order', 
                        ], 
                        [
                            'label' => 'Nama Klausa',
                            'value' => 'clause_title',
                                                       
                        ], 
                        // [
                        //     'label' => 'Butiran Klausa',
                        //     'value' => 'clause_details',
                                                       
                        // ], 
                        [
                            'label' => 'Tindakan',
                            'format' => 'raw', 
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'], 
                            'value'=>function ($list){ 
                             return Html::a('', ['clause/kemaskini-klausa', 'id' => $list->id], [
                            'class' => 'btn btn-primary fa fa-edit ' ,
                             
                            ])       
                            .Html::a(' ', ['delete', 'id' => $list->id], [
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
       </div>
    </div>
    </div> -->
</div> 
</div> 
 



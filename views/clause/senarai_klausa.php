<?php

$js=<<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use yii\helpers\Html;
use yii\widgets\ActiveForm;   
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;
  
error_reporting(0);
?>

<?= $this->render('menu') ?> 

<?php $form = ActiveForm::begin([ 'options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
   
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><i class="fa fa-list"></i><strong> Senarai Klausa</strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
    <table class="table table-sm table-bordered jambo_table table-striped" style="width:100%;", > 
       
           
                            <tr>   
                                <th colspan="4"><center>Klausa</center></th>   
                                <!-- <th colspan="4"><center> </center></th>  -->
                                <td colspan="2"><center>Nama Klausa</center></td> 
                                <td colspan="2"><center> </center></td> 
                            </tr>
                           
                            <?php if ($clause) { ?>
                                <!-- <tr>    
                                <td rowspan="8"><center><strong> </strong></center></td> 
                            </tr>  -->
                        <?php foreach ($clause as $list) { ?>
                            
                            <tr>    
                                <td colspan="4"><center><strong><?php echo $list->clause;?> </strong></center> </td> 
                                <!-- <td colspan="4"><center><strong> </strong></center></td>   -->
                                <td colspan="2"><left><strong><?php echo $list->parent_clause;?> &nbsp; <?php echo $list->clause_title;?> </strong></left></td> 
                                <td colspan="2"><center><strong><?= Html::a('', ['clause/kemaskini-klausa', 'id' => $list->id], ['class' => 'btn btn-primary fa fa-edit ']) 
                                .Html::a(' ', ['delete', 'id' => $list->id], [
                                    'class' => 'btn btn-danger fa fa-trash',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                ],
                                ]); ?> </strong></center></td> 
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
<!-- <div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><i class="fa fa-list"></i><strong> Senarai Klausa</strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
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
 
         
        <div class="ln_solid"></div>
    </div>
    </div>
</div> -->
 <?php ActiveForm::end(); ?>



 



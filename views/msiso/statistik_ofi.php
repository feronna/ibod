<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\export\ExportMenu; 
use app\models\msiso\TblOfi; 
use yii\bootstrap\Tabs;

echo $this->render('menu');

error_reporting(0);
                                         
$gridColumnsK = [
                                ['class' => 'kartik\grid\SerialColumn',
                                    'header' => 'BIL',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'headerOptions' => [
                                        'style' => 'display: none;',
                                    ],
                                ],
                                [
                                    'label' => 'JAFPIB',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'left',
                                    'format' => 'raw',
                                    'value' => function ($model) {return strtoupper($model->dept);}, 
                                    'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
                                    'headerOptions' => [
                                        'style' => 'display: none;',
                                    ],
                                    'footer' => 'Jumlah OFI',
                                    // 'pageSummary' => '<b>JUMLAH KESELURUHAN</b>',
                                ],
                                [
                                    'label' => 'OFI',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function($model) use ($year){
                                        return TblOfi::countTotalClauseByDept($model->dept, $model->clause, $model->year);  

                                        },
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    'headerOptions' => [
                                        'style' => 'display: none;',
                                    ],
                                    
                                    'footer' => $totalClause, 
                                    'pageSummary' => true,
                                ], 
                                //KLAUSA 4
                                [
                                    'label' => '4.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',  
                                    'value' => function($model) use ($year){
                                            return TblOfi::countClauseByDept($model->dept, '4.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    'pageSummary' => true,
                                ],
                                [
                                    'label' => '4.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '4.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    'pageSummary' => true,
                                ],
                                [
                                    'label' => '4.3',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '4.3', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '4.4',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '4.4', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '4.4.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '4.4.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '4.4.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '4.4.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                //KLAUSA 5
                                [
                                    'label' => '5.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '5.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    'pageSummary' => true,
                                ],
                                  [
                                    'label' => '5.1.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '5.1.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    'pageSummary' => true,
                                ],
                                [
                                    'label' => '5.1.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '5.1.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    'pageSummary' => true,
                                ],
                                [
                                    'label' => '5.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '5.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    'pageSummary' => true,
                                ],
                                [
                                    'label' => '5.2.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '5.2.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '5.2.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '5.2.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '5.3',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '5.3', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                //KLAUSA 6
                                [
                                    'label' => '6.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '6.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ], 
                                [
                                    'label' => '6.1.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '6.1.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ], 
                                [
                                    'label' => '6.1.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '6.1.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ], 
                                [
                                    'label' => '6.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '6.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    'pageSummary' => true,
                                ],
                                [
                                    'label' => '6.2.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '6.2.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '6.2.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '6.2.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],  
                                [
                                    'label' => '6.3',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '6.3', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                //KLAUSA 7
                                [
                                    'label' => '7.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '7.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    'pageSummary' => true,
                                ],
                                [
                                    'label' => '7.1.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '7.1.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    'pageSummary' => true,
                                ],
                                [
                                    'label' => '7.1.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '7.1.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    'pageSummary' => true,
                                ],
                                [
                                    'label' => '7.1.3',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '7.1.3', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '7.1.4',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '7.1.4', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '7.1.5',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '7.1.5', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '7.1.5.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '7.1.5.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    'pageSummary' => true,
                                ],
                                [
                                    'label' => '7.1.5.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '7.1.5.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    'pageSummary' => true,
                                ],
                                [
                                    'label' => '7.1.6',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '7.1.6', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '7.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '7.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '7.3',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '7.3', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '7.4',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '7.4', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '7.5',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '7.5', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    'pageSummary' => true,
                                ],
                                [
                                    'label' => '7.5.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '7.5.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '7.5.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '7.5.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '7.5.3',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '7.5.3', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '7.5.3.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '7.5.3.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    'pageSummary' => true,
                                ],
                                [
                                    'label' => '7.5.3.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '7.5.3.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                    'pageSummary' => true,
                                ],
                                //KLAUSA 8
                                [
                                    'label' => '8.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.2.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.2.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.2.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.2.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.2.3',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.2.3', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.2.3.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.2.3.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.2.3.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.2.3.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.2.4',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.2.4', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.3',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.3', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.3.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.3.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.3.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.3.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.3.3',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.3.3', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.3.4',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.3.4', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.3.5',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.3.5', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.3.6',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.3.6', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.4',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.4', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.4.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.4.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.4.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.4.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.4.3',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.4.3', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.5',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.5', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.5.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.5.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.5.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.5.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.5.3',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.5.3', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.5.4',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.5.4', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.5.5',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.5.5', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.5.6',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.5.6', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.6',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.6', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.7',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.7', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.7.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.7.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '8.7.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '8.7.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                //KLAUSA 9
                                [
                                    'label' => '9.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '9.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '9.1.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '9.1.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '9.1.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '9.1.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '9.1.3',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '9.1.3', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '9.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '9.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '9.2.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '9.2.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '9.2.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '9.2.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '9.3',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '9.3', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '9.3.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '9.3.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '9.3.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '9.3.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '9.3.3',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '9.3.3', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                //KLAUSA 10
                                [
                                    'label' => '10.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '10.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '10.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '10.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '10.2.1',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '10.2.1', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '10.2.2',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '10.2.2', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => '10.3',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw', 
                                    'value' => function($model) use ($year){
                                        return TblOfi::countClauseByDept($model->dept, '10.3', $model->year);   
                                    }, 
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                            ];

?>
<!---- Hide previous modal screen ---->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#modal").on('hidden.bs.modal', function(){
        $('#modalContent').empty();
  });
    });
</script>
<!--- /Hide previous modal screen ---->
<style>
a:link {
  color: green;
  background-color: transparent;
  text-decoration: none;
}
a:visited {
  color: indigo;
  background-color: transparent;
  text-decoration: none;
}
a:hover {
  color: red;
  background-color: transparent;
  text-decoration: underline;
}
a:active {
  color: yellow;
  background-color: transparent;
  text-decoration: underline;
}
</style>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Statistics Opportunities for Improvement (OFI)</h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', ['msiso/index-audit-report'], ['class' => 'btn btn-default btn-sm']) ?></p>  
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                
                <?= Tabs::widget([
                            'items' => [
                                [
                                    'label' => 'JAFPIB',
                                    'content' => ExportMenu::widget([
                                        'dataProvider' => $dataProvider,
                                        'columns' => $gridColumnsK,
                                        'responsive' => true, 
                                        'batchSize' => 10, 
                                        'clearBuffers' => true
                                    ]).'<br><br>'.
                                    GridView::widget([
                                                'dataProvider' => $dataProvider,
                                                //'filterModel' => $kursusJemputan,
                                                'showFooter' => true,
                                                'showPageSummary' => false,
                                                'emptyText' => 'Tiada data ditemui.',
                                                'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b> </b></i>'], 
                                                'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                                                'beforeHeader' => [
                                                    [
                                                        'columns' => [
                                                            ['content' => 'BIL', 'options' => ['colspan' => 1, 'rowspan' => 2], 
                                                                'vAlign' => 'middle',
                                                                'hAlign' => 'center'],
                                                            ['content' => 'JAFPIB', 'options' => ['colspan' => 1, 'rowspan' => 2]],
                                                            ['content' => 'OFI', 'options' => ['colspan' => 1, 'rowspan' => 2],
                                                                'vAlign' => 'middle',
                                                                'hAlign' => 'center'],
//                                                     
                                                            ['content' => 'KLAUSA 4', 'options' => ['colspan' => 6]], //KLAUSA 4
                                                            ['content' => 'KLAUSA 5', 'options' => ['colspan' => 7]],//KLAUSA 5
                                                            ['content' => 'KLAUSA 6', 'options' => ['colspan' => 7]],//KLAUSA 6
                                                            ['content' => 'KLAUSA 7', 'options' => ['colspan' => 19]],//KLAUSA 7
                                                            ['content' => 'KLAUSA 8', 'options' => ['colspan' => 30]],//KLAUSA 8
                                                            ['content' => 'KLAUSA 9', 'options' => ['colspan' => 11]],//KLAUSA 9
                                                            ['content' => 'KLAUSA 10', 'options' => ['colspan' => 5]],//KLAUSA 10
                                                        ],
                                                    ]
                                                ],
                                                'columns' => $gridColumnsK,
                                            ]),
                                    'active' => true
                                ],
                            ],
                        ]);
                ?>


            </div> <!-- x_content -->
        </div>
    </div>
</div>
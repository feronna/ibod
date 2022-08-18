<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\widgets\ListView;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\hronline\Department;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\myidp\AdminJfpiuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Admin Jfpius');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/idp/_topmenu'); ?>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Tetapan Akses</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
        
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                 <?=$form->field($aksesbaru, 'staffID')->label(false)->widget(Select2::classname(), [
                                'data' => $allBiodata,
                                'options' => ['placeholder' => 'Sila pilih nama', 'default' => 0],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                               
                            ]); ?>
            
            </div>
        </div>

        <div class="ln_solid"></div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
            <?php ActiveForm::end();?>
    </div>
    </div>
</div>
</div>


<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Akses</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
<!--            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">BIL </th>
                        <th class="column-title text-center">NAMA</th>
                        <th class="column-title text-center">JFPIU</th>
                        <th class="column-title text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
//                    $bil=1;
//                    if($akses){
//                    foreach ($akses as $akses) { 
                        ?>
                        <tr>
                            <td><?php //$bil++; ?></td>
                            <td><?php //$akses->biodata->CONm; ?></td>
                            <td><?php //$akses->biodata->department->shortname; ?></td>
                            <td>
        <?php
//        Html::a('<i class="fa fa-trash-o"></i>', ['delete-akses', 'id' => $akses->staffID], [
//            'data' => [
//                'confirm' => 'Are you sure you want to delete this item?',
//                'method' => 'post',
//            ],
//        ]) 
       ?>
    </td>
                    <?php //}} ?>
                </tbody>
            </table>-->
            
            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'emptyText' => 'Tiada data ditemui.',
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b> - </b></i>'], 
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Nama',
                'value' => 'biodata.CONm',
            ],
            [
                'label' => 'Gred',
                'value' => 'biodata.jawatan.gred',
            ],
            [
                'attribute' => 'DeptId',
//                'contentOptions' => ['style' => 'width:400px;'],
                'label' => 'JFPIU',
                'value' => function ($data){
                            return ucwords(strtoupper($data->biodata->department->shortname));
                           },
                'filter'    => ArrayHelper::map(Department::find()->all(), 'id', 'shortname'),
                'filterType' => GridView::FILTER_SELECT2,
            ],
            //'date_added',
//            'added_by',
//            'staff_dept_on_added',
//            [
//                'attribute' => 'date_added',
//                'format' => 'date',
//                'visible' => true
//            ],

            ['class' => 'yii\grid\ActionColumn',
                            //'header' => 'Penetapan',
                            //'headerOptions' => ['style' => 'color:#337ab7'],
                            'template' => '{delete}',
                            'buttons' => [
                              'delete' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
                                          ['data' => [
                                              'confirm' => 'Adakah anda pasti anda ingin menghapuskan rekod ini?',
                                              'method' => 'post',
                                              ],
                                          ],
                                          ['title' => Yii::t('app', 'Hapus'),]);     
                              },
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                              if ($action === 'delete') {
                                  $url ='delete-akses?id='.$model->staffID; 
                                  return $url;
                              }
                            }
                      ],
        ],
    ]); ?>
            
            
        </div>
    </div>
</div>

<div class="admin-jfpiu-index">

    <h1><?php //Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //Html::a(Yii::t('app', 'Create Admin Jfpiu'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php 
//        ListView::widget([
//            'dataProvider' => $dataProvider,
//            'itemOptions' => ['class' => 'item'],
//            'itemView' => function ($model, $key, $index, $widget) {
//                return Html::a(Html::encode($model->staffID), ['view', 'id' => $model->staffID]);
//            },
//        ]) 
    ?>
    
    <?php Pjax::end(); ?>
    
    <?php
//    GridView::widget([
//        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
//        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//
//            'staffID',
//            [
//                'attribute' => 'DeptId',
////                'contentOptions' => ['style' => 'width:400px;'],
////                'filterInputOptions' => [
////                    'class' => 'form-control',
////                    'placeholder' => 'Cari...'
////                ],
//                'label' => 'JFPIU',
//                'value' => function ($data){
//                            return ucwords(strtoupper($data->biodata->department->shortname));
//                           },
//                'filter'    => ArrayHelper::map(Department::find()->all(), 'id', 'shortname'),
//                'filterType' => GridView::FILTER_SELECT2,
//            ],
//            //'date_added',
//            'added_by',
//            'staff_dept_on_added',
//            [
//                'attribute' => 'date_added',
//                'format' => 'date',
//                'visible' => true
//            ],
//
//            ['class' => 'yii\grid\ActionColumn'],
//        ],
//    ]); 
                           ?>
</div>
</div>




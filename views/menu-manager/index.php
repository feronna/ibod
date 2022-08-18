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
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\system_core\TblMenuTopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Senarai Side Menu - Controller';
$this->params['breadcrumbs'][] = $this->title;


Modal::begin([
    'header' => '<strong>Senarai Action</strong>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();

?>

<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1,2,3, 1179, 1180,4]]) ?>
<div class="tbl-menu-top-index">
    <div class="row"> 
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">
                <div class="x_content">
                    
                    <div class="x_title">
                        <h2><?= Html::encode($this->title) ?></h2>                        
                        <div class="clearfix"></div>
                    </div>
                    
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <p>
                        <?= Html::a('Tambah Controller/Action', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                    
                    <div class="table-responsive">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => '',
                        //'filterModel' => $searchModel,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'header' => 'BIL',
                                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                            ],

                            [
                                'label' => 'ORDER',
                                'attribute' => 'order',
                                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                            ],
                            [
                                'label' => 'LABEL',
                                'attribute' => 'label',
                                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                            ],
                            [
                                'label' => 'URL',
                                'attribute' => 'url',
                                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                            ],
                            [
                                'label' => 'ICON',
                                //'attribute' => 'icon_id',
                                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
//                                'value' => function($model) {
//                                    return '<i class="fa fa-'.$model->icon->icon_label.'"></i> '.$model->icon->icon_label.'';
//                                },
                                'value' => function($model) {
                                    //$tmp = '<i class="fa fa-'.$model->icon->icon_label.'"></i> '.$model->icon->icon_label.'';
                                    return (!empty($model->icon)) 
                        ? '<i class="fa fa-'.$model->icon->icon_label.'"></i> '.$model->icon->icon_label.'' : '-'; 
                                },
                                'format' => 'raw'
                            ],
                            [
                                'label' => 'VISIBLE',
                                //'attribute' => 'visible'
                                'value' => function($model) {
                                    return (is_null($model->visible)) ? null : $model->visible;
                                },
                                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                            ],
                            [
                                'label' => 'STATUS',
                                //'attribute' => 'status'
                                'value' => function($model) {
                                    return ($model->status == 1) ? '<span class="label label-success">Enabled</span>' : 
                                            '<span class="label label-danger">Disabled</span>';
                                },
                                'format' => 'raw',
                                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                            ],

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'TINDAKAN',
                                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                                'template' => '{view} {update} {delete}',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        $url = Url::to(['menu-manager/sort-side-child', 'parent_id' => $model->id]);
                                        return Html::button('<span class="glyphicon glyphicon-sort"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton', 
                                            'title' => 'Senarai Action']);
                                    },
                                    'update' => function ($url, $model) {
                                        $url = Url::to(['menu-manager/update', 'id' => $model->id]);
                                        //return Html::button('<span class="glyphicon glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm']);
                                        return Html::a('<span class="glyphicon glyphicon glyphicon-edit"></span>', $url, [
                                        'title' => 'Update Controller/Action', 'class' => 'btn btn-default btn-sm']);
                                    },
                                    'delete' => function ($url, $model) {
                                        $url = Url::to(['menu-manager/delete', 'id' => $model->id]);
                                        //return Html::button('<span class="glyphicon glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm']);
                                        return Html::a('<span class="glyphicon glyphicon glyphicon-trash"></span>', $url, [
                                        'title' => 'Delete Controller/Action', 'class' => 'btn btn-default btn-sm', 
                                            'data' => [
                                                'method' => 'post',
                                                 // use it if you want to confirm the action
                                                 'confirm' => 'Adakah anda pasti untuk padam rekod ini?',
                                             ],]);
                                    },
                                ],
                                'visibleButtons' => [
                                    'view' => function ($model, $key, $index) {
                                        return (!empty($model->child)) ? true : false;
                                    },
                                ]
                            ],
                        ],
                    ]); ?>
                    </div>
                </div> 
            </div>                
        </div>
    </div>
</div>

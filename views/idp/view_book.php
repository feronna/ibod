<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\detail\DetailView;
use yii\helpers\Url;
use app\models\myidp\Author;

$this->title='View Book'; // $model->name;
$this->params['breadcrumbs'][]=['label'=>'Books', 'url'=>['index']];
$this->params['breadcrumbs'][]=$this->title;

// setup your attributes
// DetailView Attributes Configuration
$attributes = [
    [
        'group'=>true,
        'label'=>'SECTION 1: Identification Information',
        'rowOptions'=>['class'=>'table-info']
    ],
    [
        'columns' => [
            [
                'attribute'=>'id', 
                'label'=>'Book #',
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:30%']
            ],
            [
                'attribute'=>'book_code', 
                'format'=>'raw', 
                'value'=>'<kbd>'.$model->book_code.'</kbd>',
                'valueColOptions'=>['style'=>'width:30%'], 
                'displayOnly'=>true
            ],
        ],
    ],
    [
        'columns' => [
            [
                'attribute'=>'book_name',
                'valueColOptions'=>['style'=>'width:30%'],
            ],
            [
                'attribute'=>'color', 
                'format'=>'raw', 
                'value'=>"<span class='badge' style='background-color: {$model->color}'> </span>  <code>" . $model->color . '</code>',
                'type'=>DetailView::INPUT_COLOR,
                'valueColOptions'=>['style'=>'width:30%'], 
            ],
        ],
    ],
    [
        'group'=>true,
        'label'=>'SECTION 2: Price / Valuation Amounts',
        'rowOptions'=>['class'=>'table-info'],
        //'groupOptions'=>['class'=>'text-center']
    ],
    [
        'attribute'=>'buy_amount',
        'label'=>'Buy Amount ($)',
        'format'=>['decimal', 2],
        'inputContainer' => ['class'=>'col-sm-6'],
    ],
    [
        'attribute'=>'sale_amount',
        'label'=>'Sale Amount ($)',
        'format'=>['decimal', 2],
        'inputContainer' => ['class'=>'col-sm-6'],
    ],
    [
        'label'=>'Difference ($)',
        'value'=>$model->buy_amount - $model->sale_amount,
        'format'=>['decimal', 2],
        'inputContainer' => ['class'=>'col-sm-6'],
        // hide this in edit mode by adding `kv-edit-hidden` CSS class
        'rowOptions'=>['class'=>'warning kv-edit-hidden', 'style'=>'border-top: 5px double #dedede'],
    ],
    [
        'group'=>true,
        'label'=>'SECTION 3: Book Details',
        'rowOptions'=>['class'=>'table-info'],
        //'groupOptions'=>['class'=>'text-center']
    ],
    [
        'columns' => [
            [
                'attribute'=>'publish_date', 
                'format'=>'date',
                'type'=>DetailView::INPUT_DATE,
                'widgetOptions' => [
                    'pluginOptions'=>['format'=>'yyyy-mm-dd']
                ],
                'valueColOptions'=>['style'=>'width:30%']
            ],
            [
                'attribute'=>'status', 
                'label'=>'Available?',
                'format'=>'raw',
                'value'=>$model->status ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-danger">No</span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => 'Yes',
                        'offText' => 'No',
                    ]
                ],
                'valueColOptions'=>['style'=>'width:30%']
            ],
        ]
    ],
    [
        'columns' => [
            [
                'attribute'=>'author_id',
                'format'=>'raw',
                'value'=>Html::a('Johnny Steinbeck', '#', ['class'=>'kv-author-link']),
                'type'=>DetailView::INPUT_SELECT2, 
                'widgetOptions'=>[
                    'data'=>ArrayHelper::map(Author::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
                    'options' => ['placeholder' => 'Select ...'],
                    'pluginOptions' => ['allowClear'=>true, 'width'=>'100%'],
                ],
                'valueColOptions'=>['style'=>'width:30%']
            ],
//            [
//                'attribute'=>'rememberMe', 
//                'label'=>'Remember?',
//                'format'=>'raw',
//                'type'=>DetailView::INPUT_SWITCH,
//                'widgetOptions' => [
//                    'pluginOptions' => [
//                        'onText' => 'Yes',
//                        'offText' => 'No',
//                    ]
//                ],
//                'value'=>$model->rememberMe ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-danger">No</span>',
//                'valueColOptions'=>['style'=>'width:30%']
//            ],
        ]
    ],
    [
        'attribute'=>'synopsis',
        'format'=>'raw',
        'value'=>'<span class="text-justify"><em>' . $model->synopsis . '</em></span>',
        'type'=>DetailView::INPUT_TEXTAREA, 
        'options'=>['rows'=>4]
    ]
];

//// View file rendering the widget
echo DetailView::widget([
    'model' => $model,
    'attributes' => $attributes,
    'mode' => 'view',
    'bordered' => true,
    'striped' => true,
    'condensed' => true,
    'responsive' => true,
    'hover' => true,
    'hAlign' => 'right',
    'vAlign' => 'middle',
    'fadeDelay' => 1,
    'panel' => [
        'type' => 'default', 
        'heading' => 'Book Details',
        'footer' => '<div class="text-center text-muted">This is a sample footer message for the detail view.</div>'
    ],
    'deleteOptions'=>[ // your ajax delete parameters
        'params' => ['id' => $model->id, 'kvdelete'=>true],
    ],
    'container' => ['id'=>'kv-demo'],
    'formOptions' => ['action' => Url::current(['#' => 'kv-demo'])] // your action to delete
]);

//echo DetailView::widget([
//    'model'=>$model,
//    'attributes'=>$attributes,
//    'deleteOptions' => [ // your ajax delete parameters
//        'params' => ['custom_param' => true, 'id' => $model->id],
//    ],
//    'panel' => [
//        'type' => 'default', 
//        'heading' => 'Book Details',
//        'footer' => '<div class="text-center text-muted">This is a sample footer message for the detail view.</div>'
//    ],
//]);

?>
<head>  
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v3.3.1/css/all.css">
</head>
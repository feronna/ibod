<?php 
use yii\grid\GridViewAsset;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$colorPluginOptions =  [
    'showPalette' => true,
    'showPaletteOnly' => true,
    'showSelectionPalette' => true,
    'showAlpha' => false,
    'allowEmpty' => false,
    'preferredFormat' => 'name',
    'palette' => [
        [
            "white", "black", "grey", "silver", "gold", "brown", 
        ],
        [
            "red", "orange", "yellow", "indigo", "maroon", "pink"
        ],
        [
            "blue", "green", "violet", "cyan", "magenta", "purple", 
        ],
    ]
];
$gridColumns = [
[
    'class'=>'kartik\grid\SerialColumn',
    'contentOptions'=>['class'=>'kartik-sheet-style'],
    'width'=>'36px',
    'pageSummary'=>'Total',
    'pageSummaryOptions' => ['colspan' => 6],
    'header'=>'',
    'headerOptions'=>['class'=>'kartik-sheet-style']
],
[
    'class' => 'kartik\grid\RadioColumn',
    'width' => '36px',
    'headerOptions' => ['class' => 'kartik-sheet-style'],
],
[
    'class' => 'kartik\grid\ExpandRowColumn',
    'width' => '50px',
    'value' => function ($model, $key, $index, $column) {
        return GridView::ROW_COLLAPSED;
    },
    // uncomment below and comment detail if you need to render via ajax
    // 'detailUrl' => Url::to(['/site/book-details']),
    'detail' => function ($model, $key, $index, $column) {
        return Yii::$app->controller->renderPartial('_expand-row-details', ['model' => $model]);
    },
    'headerOptions' => ['class' => 'kartik-sheet-style'] ,
    'expandOneOnly' => true
],
[
    'class' => 'kartik\grid\EditableColumn',
    'attribute' => 'name',
    'pageSummary' => 'Total',
    'vAlign' => 'middle',
    'width' => '210px',
    'readonly' => function($model, $key, $index, $widget) {
        return (!$model->status); // do not allow editing of inactive records
    },
    'editableOptions' =>  function ($model, $key, $index) use ($colorPluginOptions) {
        return [
            'header' => 'Name', 
            'size' => 'md',
            'afterInput' => function ($form, $widget) use ($model, $index, $colorPluginOptions) {
                return $form->field($model, "color")->widget(\kartik\color\ColorInput::classname(), [
                    'showDefaultPalette' => false,
                    'options' => ['id' => "color-{$index}"],
                    'pluginOptions' => $colorPluginOptions,
                ]);
            }
        ];
    }
],
[
    'attribute' => 'color',
    'value' => function ($model, $key, $index, $widget) {
        return "<span class='badge' style='background-color: {$model->color}'> </span>  <code>" . $model->color . '</code>';
    },
    'width' => '8%',
    'filterType' => GridView::FILTER_COLOR,
    'filterWidgetOptions' => [
        'showDefaultPalette' => false,
        'pluginOptions' => $colorPluginOptions,
    ],
    'vAlign' => 'middle',
    'format' => 'raw',
    'noWrap' => $this->noWrapColor
],
[
    'attribute' => 'author_id', 
    'vAlign' => 'middle',
    'width' => '180px',
    'value' => function ($model, $key, $index, $widget) { 
        return Html::a($model->author->name,  
            '#', 
            ['title' => 'View author detail', 'onclick' => 'alert("This will open the author page.\n\nDisabled for this demo!")']);
    },
    'filterType' => GridView::FILTER_SELECT2,
    'filter' => ArrayHelper::map(Author::find()->orderBy('name')->asArray()->all(), 'id', 'name'), 
    'filterWidgetOptions' => [
        'pluginOptions' => ['allowClear' => true],
    ],
    'filterInputOptions' => ['placeholder' => 'Any author', 'multiple' => true], // allows multiple authors to be chosen
    'format' => 'raw'
],
[
    'class' => 'kartik\grid\EditableColumn',
    'attribute' => 'publish_date',    
    'hAlign' => 'center',
    'vAlign' => 'middle',
    'width' => '9%',
    'format' => 'date',
    'xlFormat' => "mmm\\-dd\\, \\-yyyy",
    'headerOptions' => ['class' => 'kv-sticky-column'],
    'contentOptions' => ['class' => 'kv-sticky-column'],
    'readonly' => function($model, $key, $index, $widget) {
        return (!$model->status); // do not allow editing of inactive records
    },
    'editableOptions' => [
        'header' => 'Publish Date', 
        'size' => 'md',
        'inputType' => \kartik\editable\Editable::INPUT_WIDGET,
        'widgetClass' =>  'kartik\datecontrol\DateControl',
        'options' => [
            'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
            'displayFormat' => 'dd.MM.yyyy',
            'saveFormat' => 'php:Y-m-d',
            'options' => [
                'pluginOptions' => [
                    'autoclose' => true
                ]
            ]
        ]
    ],
],
[
    'class' => 'kartik\grid\EditableColumn',
    'attribute' => 'buy_amount', 
    'readonly' => function($model, $key, $index, $widget) {
        return (!$model->status); // do not allow editing of inactive records
    },
    'editableOptions' => [
        'header' => 'Buy Amount', 
        'inputType' => \kartik\editable\Editable::INPUT_SPIN,
        'options' => [
            'pluginOptions' => ['min' => 0, 'max' => 5000]
        ]
    ],
    'hAlign' => 'right', 
    'vAlign' => 'middle',
    'width' => '7%',
    'format' => ['decimal', 2],
    'pageSummary' => true
],
[
    'attribute' => 'sell_amount', 
    'vAlign' => 'middle',
    'hAlign' => 'right', 
    'width' => '7%',
    'format' => ['decimal', 2],
    'pageSummary' => true
],
[
    'class' => 'kartik\grid\FormulaColumn', 
    'header' => 'Buy + Sell<br>(BS)', 
    'vAlign' => 'middle',
    'value' => function ($model, $key, $index, $widget) { 
        $p = compact('model', 'key', 'index');
        return $widget->col(7, $p) + $widget->col(8, $p);
    },
    'headerOptions' => ['class' => 'kartik-sheet-style'],
    'hAlign' => 'right', 
    'width' => '7%',
    'format' => ['decimal', 2],
    'mergeHeader' => true,
    'pageSummary' => true,
    'footer' => true
],
[
    'class' => 'kartik\grid\FormulaColumn', 
    'header' => 'Buy %<br>(100 * B/BS)', 
    'vAlign' => 'middle',
    'hAlign' => 'right', 
    'width' => '7%',
    'value' => function ($model, $key, $index, $widget) { 
        $p = compact('model', 'key', 'index');
        return $widget->col(9, $p) != 0 ? $widget->col(7, $p) * 100 / $widget->col(9, $p) : 0;
    },
    'format' => ['decimal', 2],
    'headerOptions' => ['class' => 'kartik-sheet-style'],
    'mergeHeader' => true,
    'pageSummary' => true,
    'pageSummaryFunc' => GridView::F_AVG,
    'footer' => true
],
[
    'class' => 'kartik\grid\BooleanColumn',
    'attribute' => 'status', 
    'vAlign' => 'middle'
], 
[
    'class' => 'kartik\grid\ActionColumn',
    'dropdown' => $this->dropdown,
    'dropdownOptions' => ['class' => 'float-right'],
    'urlCreator' => function($action, $model, $key, $index) { return '#'; },
    'viewOptions' => ['title' => 'This will launch the book details page. Disabled for this demo!', 'data-toggle' => 'tooltip'],
    'updateOptions' => ['title' => 'This will launch the book update page. Disabled for this demo!', 'data-toggle' => 'tooltip'],
    'deleteOptions' => ['title' => 'This will launch the book delete action. Disabled for this demo!', 'data-toggle' => 'tooltip'],
    'headerOptions' => ['class' => 'kartik-sheet-style'],
],
[
    'class' => 'kartik\grid\CheckboxColumn',
    'headerOptions' => ['class' => 'kartik-sheet-style'],
    'pageSummary' => '<small>(amounts in $)</small>',
    'pageSummaryOptions' => ['colspan' => 3, 'data-colspan-dir' => 'rtl'],
],
];
?>
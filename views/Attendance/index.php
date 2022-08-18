<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\widgets\DatePicker;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TblrekodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tbl Rekods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-rekod-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tbl Rekod', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'icno',
                'value' => 'kakitangan.CONm',
            ],
            [
                'attribute' => 'tarikh',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'tarikh',
                    'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                    'value' => date('Y-m-d'),
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                    ]
                ]),
                'format' => 'html',
            ],
            'day',
            'late_in',
            'early_out',
            'incomplete',
            'absent',
            'external',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>

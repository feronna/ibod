<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\widgets\DatePicker;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TblrekodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-rekod-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
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
                'attribute' => 'JFPIB',
                'value' => 'department.shortname',
            ],
            [
                'attribute' => 'GCR Dimohon',
                'value' => 'gcr_applied',

            ],
            [
                'attribute' => 'CBTH Dimohon',
                'value' => 'cbth_applied',
            ],
            [
                'attribute' => 'status',
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Tindakan',
                'template' => '{delete}',
                'contentOptions' => ['style' => 'padding:0px 0px 0px 30px;vertical-align: middle;'],
            ],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>

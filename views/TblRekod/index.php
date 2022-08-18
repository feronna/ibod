<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TblRekodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tbl Rekods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-rekod-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tbl Rekod', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'icno',
            'day',
            'tarikh',
            'time_in',
            //'time_out',
            //'ot_in',
            //'ot_out',
            //'reason_id',
            //'remark',
            //'status_in',
            //'status_out',
            //'absent',
            //'app_by',
            //'app_dt',
            //'remark_status',
            //'wp_id',
            //'latitude',
            //'longitude',
            //'in_ip',
            //'out_ip',
            //'ot_in_ip',
            //'ot_out_ip',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

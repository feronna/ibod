<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\updatestatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Updatestatuses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="updatestatus-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Updatestatus', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'usern',
            'COTableName',
            'COActivity',
            'COUpadteDate',
            'COUpdateIP',
            //'COUpdateComp',
            //'COUpdateCompUser',
            //'COUpdateSQL:ntext',
            //'id',
            //'idval',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

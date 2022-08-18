<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\kemudahan\BorangehsanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Borangehsans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="borangehsan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Borangehsan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'icno',
            'jeniskemudahan',
            'pohon',
            'tujuan',
            //'tarikh_mohon',
            //'status_pt',
            //'catatan_pt',
            //'semakan_pt',
            //'status_pp',
            //'catatan_pp',
            //'ver_date',
            //'status_kj',
            //'catatan_kj',
            //'app_date',
            //'tarikh_terima',
            //'pengakuan',
            //'isActive',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

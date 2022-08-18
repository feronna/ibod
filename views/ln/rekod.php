<?php
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ln\LnSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Lns';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ln-rekod">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Mohon', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'icno',
            'tujuan',
            'nama_tempat',
            //'negara',
            //'date_from',
            //'date_to',
            //'days',
            //'bil_peserta',
            //'perbelanjaan',
            //'entry_date',
            //'status',
            //'app_by',
            //'app_date',
            //'status_jfpiu',
            //'ulasan_jfpiu:ntext',
            //'ver_by',
            //'ver_date',
            'status_semakan',
            //'ulasan_semakan:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

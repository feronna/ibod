<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Borangehsans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="borangehsan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Borangehsan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'icno',
            'jeniskemudahan',
            'pohon',
            'tujuan',
            //'used_dt',
            //'entry_date',
            //'resit',
            //'status_pt',
            //'catatan_pt',
            //'semakan_pt',
            //'status_pp',
            //'catatan_pp',
            //'ver_date',
            //'tarikh_hantar',
            //'status_kj',
            //'catatan_kj',
            //'app_date',
            //'stat_bendahari',
            //'catatan_bendahari',
            //'bendahari_date',
            //'pengakuan',
            //'mohon',
            //'isActive2',
            //'jumlah',
            //'dokumen_sokongan:ntext',
            //'dokumen_sokongan2:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

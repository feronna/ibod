<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KontraktorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kontraktors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kontraktor-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Kontraktor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'ICNO',
            'CONm',
            'COBirthDt',
            'GenderCd',
            //'COOffTelNo',
            //'ReligionCd',
            //'CountryCd',
            //'Addr1',
            //'Addr2',
            //'Addr3',
            //'Postcode',
            //'CityCd',
            //'StateCd',
            //'created_at',
            //'created_by',
            //'updated_at',
            //'updated_by',
            //'id_kontraktor',
            //'no_permit',
            //'filename_vaksin_pm',
            //'filename_sijil_pm',
            //'filename_kad_cidb',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

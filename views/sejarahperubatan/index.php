<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\TblsejarahperubatanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tblsejarahperubatans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblsejarahperubatan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tblsejarahperubatan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ICNO',
            'IllnessCd',
            'IllnessOther',
            'Year',
            'MedTreatment',
            //'TreatmentStartDt',
            //'TreatmentEndDt',
            //'id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

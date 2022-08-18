<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\TbllesenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tbllesens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbllesen-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tbllesen', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'licId',
            'ICNO',
            'LicNo',
            'LicCd',
            'LicClassCd',
            //'LicExpiryDt',
            //'LicRnwlFee',
            //'FirstLicIssuedDt',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

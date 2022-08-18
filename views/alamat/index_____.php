<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\TblpraddressSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tblpraddresses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblpraddress-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tblpraddress', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ICNO',
            'StateCd',
            'CityCd',
            'AddrTypeCd',
            'CountryCd',
            //'Addr1',
            //'Addr2',
            //'Addr3',
            //'Postcode',
            //'TelNo',
            //'id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

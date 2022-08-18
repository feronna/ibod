<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\TblpendidikanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tblpendidikans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblpendidikan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tblpendidikan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ICNO',
            'InstCd',
            'HighestEduLevelCd',
            'SponsorshipCd',
            'Sponsorship',
            //'MajorCd',
            //'MinorCd',
            //'EduCertTitle',
            //'EduCertTitleBI',
            //'ConfermentDt',
            //'OverallGrade',
            //'AcrtdEduAch',
            //'id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

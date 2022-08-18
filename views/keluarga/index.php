<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\TblkeluargaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tblkeluargas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tblkeluarga-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tblkeluarga', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ICNO',
            'FamilyId',
            'TitleCd',
            'ReligionCd',
            'MrtlStatusCd',
            //'RaceCd',
            //'FmyStatusCd',
            //'CorpBodyTypeCd',
            //'OccSectorCd',
            //'HighestEduLevelCd',
            //'GenderCd',
            //'CountryCd',
            //'NatCd',
            //'StateCd',
            //'FmyBirthPlaceCd',
            //'CityCd',
            //'RelCd',
            //'NatStatusCd',
            //'FmyNm',
            //'FmyMomNm',
            //'FmyTelNo',
            //'FmyBirthDt',
            //'FmyTwinStatus',
            //'FmyMarriageDt',
            //'FmyMarriageCertNo',
            //'FmyDeceaseDt',
            //'FmyBumiStatus',
            //'FmyDivorceDt',
            //'FmyEmployerNm',
            //'FmyDisabilityStatus',
            //'FmyDependencyStatus',
            //'FmyAddr1',
            //'FmyAddr2',
            //'FmyAddr3',
            //'FmyPostcode',
            //'FmyNextOfKinStatus',
            //'FmyEmerContactStatus',
            //'FmyPensionRecipient',
            //'ChildReliefInd',
            //'FmyEmailAddr:email',
            //'FmyDependencyCd',
            //'FmyDependencyICTypeCd',
            //'FmyBirthCertNo',
            //'FmyPassportNo',
            //'id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

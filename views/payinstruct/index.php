<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\kemudahan\TblPayinstructSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tbl Payinstructs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-payinstruct-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tbl Payinstruct', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'PAY_ID',
            'PAY_REF_ID',
            'PAY_ELAUN_ID',
            'PAY_STAFF_ICNO',
            'PAY_CMPY_CODE',
            //'PAY_STAFF_ID',
            //'PAY_CHANGE_TYPE',
            //'PAY_ROC_TYPE',
            //'PAY_DATE_FROM',
            //'PAY_DATE_TO',
            //'PAY_NEW_VALUE',
            //'PAY_CALC_TYPE',
            //'PAY_ACCOUNT_NO',
            //'PAY_ACCHOLDER_NAME',
            //'PAY_CCTR_CHARGE',
            //'PAY_PROJECT_CODE',
            //'PAY_ALLOWANCE_CODE',
            //'PAY_ENTRY_BATCH',
            //'PAY_CHANGE_REASON',
            //'PAY_REMARK:ntext',
            //'PAY_STATUS',
            //'PAY_ENTER_BY',
            //'PAY_ENTER_DATE',
            //'PAY_VERIFY_BY',
            //'PAY_VERIFY_DATE',
            //'PAY_APPROVE_BY',
            //'PAY_APPROVE_DATE',
            //'PAY_CANCEL_BY',
            //'PAY_CANCEL_DATE',
            //'PAY_CANCEL_REASON:ntext',
            //'PAY_UPDATE_BY',
            //'PAY_UPDATE_DATE',
            //'PAY_UPDATE_SEQ_NO',
            //'PAY_PROCESS_REMARK:ntext',
            //'PAY_GLPROGRAM_CODE',
            //'PAY_PRINT',
            //'PAY_PROCESS_DEPT',
            //'PAY_PARENT_ID',
            //'PAY_ENTRY_TYPE',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

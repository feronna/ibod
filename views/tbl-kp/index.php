<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $searchModel app\models\TblKpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?><div class="col-md-12">
    <?php echo $this->render('/kontrak/_menu');?> 
</div><?php
$this->title = 'Senarai Ketua Pentadbiran';
?>
<div class="tbl-kp-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Jabatan',
                'value' => 'department.fullname'
            ],
            [
                'label' => 'Nama',
                'value' => 'kakitangan.CONm'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

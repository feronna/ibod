<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Pergigian\KlinikSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1261, 1264, 1291], 'vars' => []]); ?>
<div class="col-md-12">

</div>

<div class="col-md-12"> 
    <div class="x_panel">
        <div class="table-responsive">
        <div class="x_title">
            <h2><i class="fa fa-list-alt"></i><strong> Senarai Klinik Pergigian</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'klinik_nama',
            'klinik_alamat',
            'klinik_no_tel',

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
</div>

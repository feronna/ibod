<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Akaun';

?>

<div class="table-responsive">

    <?=
    GridView::widget([
        'emptyText' => 'Tiada Rekod',
        'summary' => '',
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label' => 'Akaun',
                'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey',],
                'value' => function ($model) {
                    return $model->tujakaun;
                },
            ],
            [
                'label' => 'Dari',
                'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey',],
                'value' => function ($model) {
                    return '';
                },
            ],
            [
                'label' => 'Sehingga',
                'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey',],
                'value' => function ($model) {
                    return '';
                },
            ],
            [
                'label' => 'Bank',
                'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey',],
                'value' => function ($model) {
                    return $model->namakaun;
                },
            ],
            [
                'label' => 'Jenis',
                'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey',],
                'value' => function ($model) {
                    return $model->jenakaun;
                },
            ],
            [
                'label' => 'No Akaun',
                'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey',],
                'value' => 'AccNo',
            ],
            [
                'label' => 'Cawangan',
                'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey',],
                'value' => function ($model) {
                    return $model->cawakaun;
                },
            ],
            [
                'label' => 'Status',
                'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey',],
                'value' => function ($model) {
                    return $model->staakaun;
                },
            ],
        ],
    ]);
    ?>
</div>
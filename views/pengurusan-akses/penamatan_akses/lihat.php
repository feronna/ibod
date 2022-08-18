<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

$this->title = 'Penamatan Akses';
?>
<style>
    .fix-width>tbody>tr>th {
        width: 30%;
    }
</style>
<div class="x_panel">

    <div class="x_title">
        <h4><?= "SENARAI SEMAK PENAMATAN AKSES PENGGUNA" ?></h4>
        <div class="clearfix"></div>
    </div>


    <p>
        <?= \yii\helpers\Html::a('Kembali', ['penamatan-akses'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Kemaskini Borang', ['kemaskini', 'id' => $model->id], ['class' => 'btn btn-success',]) ?>


    </p>
    <div class="row">

        <?= DetailView::widget([
            'options' => ['class' => 'table table-bordered detail-view fix-width'],
            'model' => $model,
            'attributes' => [
                [
                    'label' => 'MAKLUMAT PENGGUNA',
                    'attribute' => ' ',
                    'captionOptions' => ['class'=>'text-center bg-primary','colspan' => '2'],
                    'contentOptions' => ['style' => 'display: none;'],
                ],
                [
                    'label' => 'IC / Passport No',
                    'attribute' => 'icno',
                ],
                [
                    'label' => 'NAMA',
                    'attribute' =>  'nama',
                ],

                [
                    'label' => 'JFPIB',
                    'attribute' =>  'jfpib',
                ],
                [
                    'label' => 'SEBAB PERUBAHAN',
                    'attribute' => 'sebab_perubahan',
                ],
                [
                    'label' => 'TARIKH KUATKUASA',
                    'value' => function ($model) {
                        return Yii::$app->MP->Tarikh($model->tarikh_kuatkuasa);
                    },
                ],
            ],
        ]); ?>
    </div>
    <div class="row">

        <?= DetailView::widget([
            'options' => ['class' => 'table  table-bordered detail-view fix-width'],
            'model' => $model,
            'attributes' => [
                [
                    'label' => 'UNTUK KEGUNAAN PENTADBIR KESELAMATAN / PENTADBIR PENGKALAN DATA / PUSAT DATA ',
                    'attribute' => ' ',
                    'captionOptions' => ['class'=>'text-center bg-primary','colspan' => '2'],
                    'contentOptions' => ['style' => 'display: none;'],
                ],
                [
                    'label' => 'AKSES KE PELAYAN',
                    'attribute' => ' ',
                    'captionOptions' => ['class'=>'text-center bg-warning','colspan' => '2'],
                    'contentOptions' => ['style' => 'display: none;'],
                ],
                [
                    'label' => 'STATUS',
                    'value' => is_null($model->status_pelayan)  ? $model->status_pelayan : ($model->status_pelayan ? 'Sudah Selesai' : 'Belum Selesai'),
                ],
                [
                    'label' => 'PENERANGAN',
                    'attribute' => 'penerangan_pelayan',
                    'format' => 'ntext',
                ],

                [
                    'label' => 'TANDATANGAN',
                    'attribute' =>  'tandatangan_pelayan',
                ],
                [
                    'label' => 'TARIKH',
                    'value' =>  Yii::$app->MP->Tarikh($model->tarikh_tt_pelayan),
                ],

                [
                    'label' => 'AKSES KE PENGKALAN DATA',
                    'attribute' => ' ',
                    'captionOptions' => ['class'=>'text-center bg-warning','colspan' => '2'],
                    'contentOptions' => ['style' => 'display: none;'],
                ],
                [
                    'label' => 'STATUS',
                    'value' => is_null($model->status_pd)  ? $model->status_pd : ($model->status_pd ? 'Sudah Selesai':'Belum Selesai'),
                ],
                [
                    'label' => 'PENERANGAN',
                    'attribute' => 'penerangan_pd',
                    'format' => 'ntext',
                ],

                [
                    'label' => 'TANDATANGAN',
                    'attribute' =>  'tandatangan_pd',
                ],
                [
                    'label' => 'TARIKH',
                    'value' =>  Yii::$app->MP->Tarikh($model->tarikh_tt_pd),
                ],

                [
                    'label' => 'AKSES KE SISTEM APLIKASI',
                    'attribute' => ' ',
                    'captionOptions' => ['class'=>'text-center bg-warning','colspan' => '2'],
                    'contentOptions' => ['style' => 'display: none;'],
                ],
                [
                    'label' => 'STATUS',
                    'value' => is_null($model->status_sa)  ? $model->status_sa : ($model->status_sa ? 'Sudah Selesai' : 'Belum Selesai'),
                ],
                [
                    'label' => 'PENERANGAN',
                    'attribute' => 'penerangan_sa',
                    'format' => 'ntext',
                ],

                [
                    'label' => 'TANDATANGAN',
                    'attribute' =>  'tandatangan_sa',
                ],
                [
                    'label' => 'TARIKH',
                    'value' =>  Yii::$app->MP->Tarikh($model->tarikh_tt_sa),
                ],

                [
                    'label' => 'AKSES FIZIKAL',
                    'attribute' => ' ',
                    'captionOptions' => ['class'=>'text-center bg-warning','colspan' => '2'],
                    'contentOptions' => ['style' => 'display: none;'],
                ],
                [
                    'label' => 'STATUS',
                    'value' => is_null($model->status_fizikal)  ? $model->status_fizikal : ($model->status_fizikal ? 'Sudah Selesai' : 'Belum Selesai'),
                ],
                [
                    'label' => 'PENERANGAN',
                    'attribute' => 'penerangan_fizikal',
                    'format' => 'ntext',
                ],

                [
                    'label' => 'TANDATANGAN',
                    'attribute' =>  'tandatangan_fizikal',
                ],
                [
                    'label' => 'TARIKH',
                    'value' =>  Yii::$app->MP->Tarikh($model->tarikh_tt_fizikal),
                ],

            ],
        ]); ?>
    </div>



</div>


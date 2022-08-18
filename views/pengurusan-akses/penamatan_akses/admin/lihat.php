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
        <?= \yii\helpers\Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>
    <div class="row">

        <?= DetailView::widget([
            'options' => ['class' => 'table table-striped table-bordered detail-view fix-width'],
            'model' => $model,
            'attributes' => [
                // [
                //     'label' => 'IC / Passport No',
                //     'attribute' => 'icno',
                // ],
                [
                    'label' => 'NAMA',
                    'value' =>  $model->biodata->CONm,
                ],

                [
                    'label' => 'JFPIB',
                    'value' =>  $model->biodata->department->fullname,
                ],
                [
                    'label' => 'SEBAB PERUBAHAN',
                    'attribute' => 'perubahan',
                ],
                [
                    'label' => 'TARIKH KUATKUASA',
                    'value' => function ($model) {
                        return Yii::$app->MP->Tarikh($model->tarikh_kuatkuasa);
                    },
                ],

            ],
        ]); ?>
        <div class="text-center">
                <?php // Html::a('Tandatangan', ['tandatangan-ketua', 'id' => $model->id], ['class' => 'btn btn-success ']) ?>
            </div>
    </br>
    </div>

    <div class="row">

        <?php
        if (!empty($model->tindakan)) {
            foreach ($model->tindakan as $tindakan)
            {
            echo DetailView::widget([
                'options' => ['class' => 'table table-striped table-bordered detail-view fix-width'],
                'model' => $tindakan,
                'attributes' => [
                    // [
                    //     'label' => 'IC / Passport No',
                    //     'attribute' => 'icno',
                    // ],
                    [
                        'label' => ' Akses Ke',
                        'value' => $tindakan->akses->nama_akses,
                    ],

                    [
                        'label' => 'Penerangan',
                        'value' => nl2br($tindakan->penerangan),
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Status',
                        'value' => $tindakan->status ? '<span class="label label-success" style="font-size:12px">Sudah Selesai</span>' 
                        : '<span class="label label-danger" style="font-size:12px">Belum Selesai</span>',
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Tandatangan',
                        'value' => '<span style="font-family:balmoral">'.$tindakan->tandatangan.'</span>' ,
                        'format' => 'raw',
                        'visible' => $tindakan->status ? true : false,
                    ],
                    [
                        'label' => 'Tarikh Selesai',
                        'value' => Yii::$app->MP->Tarikh($tindakan->tarikh_selesai),
                        'visible' => $tindakan->status ? true : false,
                    ],

                ],
            ]);
            }   
        } ?>

    </div>

    <div class="row">


    </div>


</div>
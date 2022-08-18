<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\VarDumper;

$this->title = 'Lihat Permohonan';
?>
<style>
    .fix-width>tbody>tr>th {
        width: 30%;
    }
</style>
<div class="x_panel">
    <h4><?= $this->title ?></h4>
    <div class="clearfix"></div>
    <p>
        <?= \yii\helpers\Html::a('Kembali', ['senarai-permohonan'], ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="row">

        <?= DetailView::widget([
            'options' => ['class' => 'table table-striped table-bordered detail-view fix-width'],
            'model' => $model,
            'attributes' => [
                [
                    'label' => 'ID permohonan',
                    'attribute' => 'id',
                ],
                [
                    'label' => 'Nama Pemohon',
                    'value' =>  $model->biodata ?  $model->biodata->CONm : ' ',
                    'format' => 'raw',
                ],
                [
                    'label' => 'No. Tel',
                    'value' =>  $model->no_tel ? $model->no_tel : Yii::$app->user->identity->COHPhoneNo,
                    'format' => 'raw',
                ],
                [
                    'label' => 'Jabatan',
                    'value' =>  $model->biodata->department ?  $model->biodata->department->fullname : ' ',
                    'format' => 'raw',
                ],
                [
                    'label' => 'Status',
                    'value' => function ($model) {
                        switch ($model->status_jafpib) {
                            case '2':
                                $status = '<span class="label label-success">Lulus</span>';
                                break;
                            case '3':
                                $status = '<span class="label label-danger">Ditolak</span>';
                                break;

                            default:
                                $status = '<span class="label label-primary">Dihantar</span>';
                                break;
                        }
                        return $status;
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'No. Tracking',
                    'value' =>  $model->tracking_no,
                    'visible' => ($model->status_pom == 2),
                ],
                [
                    'label' => 'Tarikh Dihantar',
                    'value' =>  Yii::$app->MP->Tarikh($model->tarikh_dihantar),
                    'visible' => ($model->status_pom == 2),
                ],
                [
                    'label' => 'Jumlah Bayaran',
                    'value' =>  'RM '.$model->bayaran_mel,
                    'visible' => ($model->status_pom == 2),
                ],
            ],
        ]); ?>
    </div>
    <div class="x_panel">

        <?php
        if ($model->barang) {
            foreach ($model->barang as $i => $barang) {
        ?>
                <div class="row">
                    <h4><?= "Barang " . ($i + 1) ?></h4>
                    <div class="clearfix"></div>
                    <?php

                    echo DetailView::widget([
                        'options' => ['class' => 'table table-striped table-bordered detail-view fix-width'],
                        'model' => $barang,
                        'attributes' => [
                            [
                                'label' => 'Nama Barang',
                                'attribute' =>  'nama_barang',
                            ],
                            [
                                'label' => 'Penerangan',
                                'attribute' => 'penerangan_barang',
                            ],
                            [
                                'label' => 'Jenis Barang',
                                'value' => $barang->jenisBarang->jenis_barang,
                            ],
                            [
                                'label' => 'Kuantiti',
                                'attribute' => 'kuantiti',
                            ],

                        ],
                    ]);

                    ?>
                </div>

        <?php

            }
        } else {
            echo '<span class="label label-danger" style="font-size:12px">Maklumat Belum Dikemaskini</span>';
        }

        ?>
    </div>

</div>
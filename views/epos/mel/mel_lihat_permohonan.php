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
    <div class="x_content">
        <span class="required" style="color:#062f49;">
            <strong>
                <center><?= strtoupper('
    PERMOHONAN PERKHIDMATAN MEL RASMI
 '); ?>
                </center>
            </strong>
        </span>
    </div>
</div>
<div class="x_panel">
 <div class="panel panel-success">

        <div class="panel-heading">
            <h6><strong><i class="fa fa-th-list"></i> LIHAT PERMOHONAN</strong></h6>
        </div>
    </div>
    <div class="clearfix"></div>
    <p>
        <?= \yii\helpers\Html::a('Kembali', ['mel-senarai-permohonan'], ['class' => 'btn btn-primary']) ?>
        <?= ($model->status_pom != 1) ? Html::button('Tambah Maklumat Mel', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tambah-maklumat-mel','id'=>$model->id]),'class' => 'btn btn-success mapBtn ']) : '' ?>
    </p> 

    <div class="row">

        <?= DetailView::widget([
            'options' => ['class' => 'table table-striped table-bordered detail-view fix-width'],
            'model' => $model,
            'attributes' => [
//                [
//                    'label' => 'ID permohonan',
//                    'attribute' => 'id',
//                ],
                [
                    'label' => 'NAM PEMOHON',
                    'value' =>  $model->biodata ?  $model->biodata->CONm : ' ',
                    'format' => 'raw',
                ],
                [
                    'label' => 'NO. TEL',
                    'value' =>  $model->no_tel ? $model->no_tel : Yii::$app->user->identity->COHPhoneNo,
                    'format' => 'raw',
                ],
                [
                    'label' => 'JABATAN',
                    'value' =>  $model->biodata->department ?  $model->biodata->department->fullname : ' ',
                    'format' => 'raw',
                ],
                [
                    'label' => 'STATUS JAFPIB',
                    'headerOptions' => ['class' => '', 'bgcolor' => '#e8e9ea'],
                    'value' => function ($model) {
                        switch ($model->status_jafpib) {
                            case '2':
                                $status = '<span class="label label-success">Lulus</span>';
                                break;
                            case '3':
                                $status = '<span class="label label-danger">Gagal</span>';
                                break;

                            default:
                                $status = '<span class="label label-primary">Mohon</span>';
                                break;
                        }
                        return $status;
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'STATUS BPG',
                    'value' => function ($model) {
                        switch ($model->status_pom) {
                            case '2':
                                $status = '<span class="label label-success">Lulus</span>';
                                break;
                            case '3':
                                $status = '<span class="label label-danger">Gagal</span>';
                                break;

                            default:
                                $status = '<span class="label label-primary">Mohon</span>';
                                break;
                        }
                        return $status;
                    },
                    'format' => 'raw',
                ],
              
            ],
        ]); ?>
    </div>
</div>
<div class="x_panel">
 <div class="panel panel-success">

        <div class="panel-heading">
            <h6><strong><i class="fa fa-car"></i> MAKLUMAT PENGHANTARAN</strong></h6>
        </div>
    </div>
    <div class="clearfix"></div>
  
    <div class="row">

        <?= DetailView::widget([
            'options' => ['class' => 'table table-striped table-bordered detail-view fix-width'],
            'model' => $model,
            'attributes' => [
//                [
//                    'label' => 'ID permohonan',
//                    'attribute' => 'id',
//                ],
               
                [
                    'label' => 'NO. TRACKING',
                    'value' =>  $model->tracking_no,
                    'visible' => ($model->status_pom == 2),
                ],
                [
                    'label' => 'TARIKH DIHANTAR',
                    'value' =>  Yii::$app->MP->Tarikh($model->tarikh_dihantar),
                    'visible' => ($model->status_pom == 2),
                ],
                [
                    'label' => 'JUMLAH BAYARAN',
                    'value' =>  'RM '.$model->bayaran_mel,
                    'visible' => ($model->status_pom == 2),
                ],
            ],
        ]); ?>
    </div>
</div>
    <div class="x_panel">
    <div class="panel panel-success">
        <?php
        if ($model->barang) {
            foreach ($model->barang as $i => $barang) {
        ?>
                <div class="panel-heading">
                    <h6><strong><i class="fa fa-inbox"></i> MAKLUMAT BARANG <?= ($i + 1) ?></strong></h6>
                </div>
    </div>
       
                <div class="row">
                    <?php

                    echo DetailView::widget([
                        'options' => ['class' => 'table table-striped table-bordered detail-view fix-width'],
                        'model' => $barang,
                        'attributes' => [
                            [
                                'label' => 'NAMA BARANG',
                                'attribute' =>  'nama_barang',
                            ],
                            [
                                'label' => 'PENERANGAN',
                                'attribute' => 'penerangan_barang',
                            ],
                            [
                                'label' => 'JENIS BARANG',
                                'value' => $barang->jenisBarang->jenis_barang,
                            ],
                            [
                                'label' => 'KUANTITI',
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
    <?php
    if ($model->status_pom == 1) {
    ?>
        <div class="form-group text-center">
            <?= \yii\helpers\Html::a('Tolak', ['mel-tolak-permohonan', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
            <?= \yii\helpers\Html::a('Lulus', ['mel-lulus-permohonan', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        </div>

    <?php
    }
    ?>


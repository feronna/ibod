<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

$this->title = 'Program Vaksinasi';
?>
<style>
    .fix-width>tbody>tr>th {
        width: 30%;
    }
</style>
<div class="x_panel">

    <div class="x_title">
        <h4><?= "Program Vaksinasi" ?></h4>
        <div class="clearfix"></div>
    </div>


    <p>
        <?= \yii\helpers\Html::a('Kembali', ['biodata/userview'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Kemaskini', ['update'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="row">

        <?= DetailView::widget([
            'options' => ['class' => 'table table-striped table-bordered detail-view fix-width'],
            'model' => $model,
            'attributes' => [
                [
                    'label' => 'IC / Passport No',
                    'attribute' => 'icno',
                ],
                [
                    'label' => 'ID MySejahtera',
                    'value' =>  $model->biodata ?  $model->biodata->mySejahteraId : '<span class="label label-primary">Sila kemaskini ID MySejahtera anda.</span>',
                    'format' => 'raw',
                ],
                [
                    'label' => 'Status Berdaftar',
                    'value' => function ($model) {
                        if ($model->daftar_st == '1') {
                            return 'Telah Berdaftar</i> ';
                        }
                        return 'Belum Berdaftar';
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Sebab Belum Berdaftar',
                    'attribute' => 'sebab_1',
                    'visible' => $model->daftar_st == 0 ? true : false,
                ],
                [
                    'label' => 'Status Menerima Vaksin',
                    'value' => function ($model) {
                        if ($model->setuju_st == '1') {
                            return 'Telah Bersetuju';
                        }
                        return 'Belum Bersetuju';
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Sebab Belum Bersetuju',
                    'attribute' => 'sebab_2',
                    'visible' => $model->setuju_st == 0 ? true : false,
                ],
            ],
        ]); ?>
    </div>

</div>
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
    <div class="x_panel">
        <h4><?= "MAKLUMAT VAKSIN" ?></h4>
        <div class="clearfix"></div>
        <div class="x_panel">
        <p>
            <?= \yii\helpers\Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?>
            <?php // Html::a('Kemaskini', ['update-status-vaksinasi'], ['class' => 'btn btn-success']) ?>
            <?= Html::button('Kemaskini', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['not-registered',]),'class' => 'btn btn-primary mapBtn ']) ?>
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
                        'label' => 'Telah Menerima Vaksin',
                        'value' => function ($model) {

                            switch ($model->status_vaksin) {
                                case '1':
                                    $status = 'Sudah Terima';
                                    break;
                                case '0':
                                    $status = 'Belum Terima';
                                    break;

                                default:
                                    $status = 'Sila kemaskini';
                                    break;
                            }
                            return $status;
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Sebab Belum Terima Vaksin',
                        'value' => function ($model) {

                            switch ($model->sebab_belum_terima) {
                                case '1':
                                    $status = 'Tidak Layak';
                                    break;
                                case '2':
                                    $status = 'Menolak';
                                    break;
                                case '3':
                                    $status = 'Belum Dapat Temujanji';
                                    break;

                                default:
                                    $status = 'Sila Kemaskini';
                                    break;
                            }
                            return $status;
                        },
                        'format' => 'raw',
                        'visible' => $model->status_vaksin == 0 ? true : false,
                    ],
                    [
                        'label' => 'Catatan',
                        'value' => $model->catatan ? $model->catatan : 'Tidak Berkaitan',
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Lampiran',
                        'value' => $model->displayLinkLampiran,
                        'format' => 'raw',
                    ],
                ],
            ]); ?>
        </div>

        </div>
    </div>
</div>
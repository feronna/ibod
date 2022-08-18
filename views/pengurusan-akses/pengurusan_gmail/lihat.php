<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

?>
<style>
    .fix-width>tbody>tr>th {
        width: 30%;
    }
</style>
<div class="x_panel">

    <div class="x_title">
        <h4><?= "MAKLUMAT PENGGUNA" ?></h4>
        <div class="clearfix"></div>
    </div>


    <p>
        <?= \yii\helpers\Html::a('Kembali', ['pengurusan-gmail'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Kemaskini', ['p-g-tindakan', 'id' => $model->id], ['class' => 'btn btn-success',]) ?>


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
                    'label' => 'STAF ID',
                    'value' =>  $model->biodata ? $model->biodata->COOldID : '',
                ],
                [
                    'label' => 'JFPIB',
                    'attribute' =>  'jfpib',
                ],
                [
                    'label' => 'JAWATAN',
                    'value' =>  $model->biodata ? $model->biodata->jawatan->fname : '',
                ],
                [
                    'label' => 'NO. HP.',
                    'value' =>  $model->biodata ? $model->biodata->COHPhoneNo : '',
                ],
                [
                    'label' => 'EMEL PERIBADI',
                    'value' =>  $model->biodata ? $model->biodata->COEmail2 : '',
                ],
                [
                    'label' => 'TARIKH MULA',
                    'value' =>  $model->biodata ? Yii::$app->MP->Tarikh($model->biodata->startDateLantik) : '',
                ],
                [
                    'label' => 'TARIKH AKHIR',
                    'value' =>  $model->biodata ? Yii::$app->MP->Tarikh($model->biodata->endDateLantik) : '',
                ],
                [
                    'label' => 'EMEL CADANGAN / AD',
                    'value' =>  $model->biodata ? '<b><i style="color:#ff0000;">'.$model->biodata->COEmail.'</i></b>' : '',
                    'format' => 'raw',
                ],
                [
                    'label' => 'SEBAB PERUBAHAN',
                    'attribute' => 'sebab_perubahan',
                ],
                [
                    'label' => 'TINDAKAN',
                    'attribute' => ' ',
                    'captionOptions' => ['class'=>'text-center bg-primary','colspan' => '2'],
                    'contentOptions' => ['style' => 'display: none;'],
                ],
                [
                    'label' => 'STATUS',
                    'value' => function($model){
                        if(!$model->tindakan4){
                            return 'Belum Diambil Tindakan';
                        }
                        else if($model->tindakan4->status == 1){
                            return 'Selesai';
                        }else{
                            return 'Belum Selesai';
                        }
                    },
                ],
                [
                    'label' => 'TARIKH STATUS',
                    'value' => function($model){
                        if($model->tindakan4){
                            return Yii::$app->MP->Tarikh($model->tindakan4->tarikh_selesai);
                        }
                        return '-';
                    },
                ],
                [
                    'label' => 'NAMA PENGEMASKINI',
                    'value' => function($model){
                        if($model->tindakan4){
                            return $model->tindakan4->nama_staf;
                        }
                        return '-';
                    },
                ],
                [
                    'label' => 'PENERANGAN',
                    'value' => function($model){
                        if($model->tindakan4){
                            return $model->tindakan4->penerangan;
                        }
                        return '-';
                    },
                    'format' => 'raw',
                ],
            ],
        ]); ?>
    </div>



</div>


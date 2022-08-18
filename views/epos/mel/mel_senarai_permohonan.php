<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$this->title = 'Senarai Permohonan';
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
   SENARAI PERMOHONAN PERKHIDMATAN MEL RASMI
 '); ?>
                </center>  </strong>
            </span> 
        </div>
    </div>
<div class="x_panel">
  

    <div class="row">
        <div class="x_content">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel,
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'header' => 'BIL.',
                    'headerOptions' => ['class' => '', 'style' => 'width:5%', 'bgcolor' => '#e8e9ea'],
                ],
                [
                        //'attribute' => 'CONm',
                        'label' => 'NAMA PEMOHON',
                        'headerOptions' => ['class' => '', 'bgcolor' => '#e8e9ea'],
                        'value' => function($model) {

                    return Html::a('<strong>' . $model->biodata->CONm . '</strong>') . '<br><small>' . $model->biodata->department->fullname . '</small>' .
                            '<br><small>' . $model->biodata->jawatan->nama . ' ' . $model->biodata->jawatan->gred;
                },
                        'format' => 'html',
                    ],
                [
                    'label' => 'TUJUAN MEL',
                    'attribute' => 'tujuan_mel',
                    'headerOptions' => ['class' => '', 'bgcolor' => '#e8e9ea'],
                ],
                [
                    'label' => 'TARIKH MOHON',
                    'value' => function ($model) {
                        $date = DateTime::createFromFormat('Y-m-d H:i:s', $model->tarikh_mohon);
                        return Yii::$app->MP->Tarikh($date->format('Y-m-d'));
                    },
                    'headerOptions' => ['class' => '', 'bgcolor' => '#e8e9ea'],
                ],
//                [
//                    'label' => 'JABATAN',
//                    'value' => function($model){
//                       return $model->jabatan ? $model->jabatan->fullname : 'Not Detected';
//                    },
//                    'headerOptions' => ['class' => '', 'bgcolor' => '#e8e9ea'],
//                ],
                [
                    'label' => 'JENIS MEL',
                    'value' => function ($model) {
                        return $model->jenisKhidmatMel->jenis;
                    },
                    'headerOptions' => ['class' => '', 'bgcolor' => '#e8e9ea'],
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
                    'label' => 'STATUS',
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
                    'headerOptions' => ['class' => '', 'bgcolor' => '#e8e9ea'],
                    'format' => 'raw',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'TINDAKAN',
                    'template' => '{lihat}',
                    'buttons' => [
                        'lihat' => function ($url,$model) {
                            return Html::a('<span class="fa fa-eye"></span>', ['mel-lihat-permohonan','id'=>$model->id], ['class' => 'text-center']);
                        },
                    ],
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['class' => 'text-center', 'style' => 'width:10%', 'bgcolor' => '#e8e9ea'],
                ],
            ],
        ]) ?>
        </div>
    
    </div>

</div>
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\form\ActiveForm;
use kartik\daterange\DateRangePicker;
use yii\bootstrap\Modal;
?>
 <div class="x_title">
                <h5><b> <i class="fa fa-user-circle"></i> MAKLUMAT PERMOHONAN</b></h5><div  class="pull-right">
            </div>
            
        </div>
<div class="table-responsive">
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'NAMA',
                'attribute' => 'kakitangan.CONm',
            ],
            [
                'label' => 'JAWATAN',
                'attribute' => 'kakitangan.jawatan.fname',
            ],
            [
                'label' => 'TARIKH CUTI PENYELIDIKAN',
                'value' => ((!$model->full_date) ? "Tiada Maklumat" : $model->full_date.' ('.$model->tempohpenyelidikan.')'),
            ],
            [
                'label' => 'CATATAN',
                'value' => ((!$model->remark) ? "Tiada Maklumat" : $model->remark),
            ],
            [
                'label' => 'TARIKH MOHON',
                'attribute' => 'mohon_dt',
            ],
        // 'mohon_dt:datetime',
        ],
    ]);
    ?>
    <?=
    DetailView::widget([
        'model' => $mod,
        'attributes' => [
            [
                'label' => 'PROJECT',
                'attribute' => 'ProjectID',
            ],
            [
                'label' => 'TAJUK PENYELIDIKAN',
                'attribute' => 'TajukPenyelidikan',
            ],
            [
                'label' => 'RINGKASAN PENYELIDIKAN',
                'attribute' => 'RingkasanPenyelidikan',
            ],
            [
                'label' => 'TEMPAT PENYELIDIKAN',
                'value' => ((!$mod->TempatPenyelidikan) ? "Tiada Maklumat" : $mod->TempatPenyelidikan),
            ],
            [
                'label' => 'PENGANJUR',
//                'attribute' => 'Penganjur',
                 'value' => ((!$mod->Penganjur) ? "Tiada Maklumat" : $mod->Penganjur),

            ],
            [
                'label' => 'JANGKAAN HASIL',
                'attribute' => 'JangkanHasil',
            ],
        ],
    ])
    ?>
</div>

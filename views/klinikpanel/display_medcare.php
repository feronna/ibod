<?php
use yii\widgets\DetailView;
?>

<div class="table-responsive">
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
                ['label' => 'Tarikh Rawatan',
                'value' => $model->visit_dt],
                ['label' => 'Tarikh Rawatan Direkodkan',
                'value' => $model->entry_dt],
                ['label' => 'Nama Kakitangan',
                'value' => $model->kakitangan->kakitangan->CONm,
                'contentOptions' => ['style' => 'width:auto'],
                'captionOptions' => ['style' => 'width:26%'],],
                ['label' => 'No. KP Kakitangan',
                'value' => $model->staff_icno],
                ['label' => 'Nama Pesakit',
                'value' => !empty($model->keluarga->FmyNm) ? $model->keluarga->FmyNm : $model->kakitangan->kakitangan->CONm],
                ['label' => 'No.KP Pesakit',
                'value' => !empty($model->keluarga->FamilyId) ? $model->keluarga->FamilyId : $model->patient_icno],
                ['label' => 'No. Resit',
                'value' => $model->receipt_no],                        
                ['label' => 'Jumlah Tuntutan (RM)',
                'value' => $model->deduct_amt
            ],            
        ],
    ])
    ?>
</div>
<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1162], 'vars' => []]); ?>
<div class="tblmaxtuntutan-search">
<div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-book"></i> Butiran Rawatan</h2>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
        <p>
            <?= Html::a('Kembali', ['papar', 'id' => $model->staff_icno], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Padam', ['delete-medcare', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Anda pasti ingin memadam rekod ini?',
                    'method' => 'post',
                ],
            ])
            ?>
        </p>
    </div>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Tarikh Rawatan',
                'value' => $model->visit_dt
            ],
            [
                'label' => 'Tarikh Rawatan Direkodkan',
                'value' => $model->entry_dt
            ],
            [
                'label' => 'Nama Kakitangan',
                'value' => $model->kakitangan->kakitangan->CONm,
                'contentOptions' => ['style' => 'width:auto'],
                'captionOptions' => ['style' => 'width:26%'],
            ],
            [
                'label' => 'No. KP Kakitangan',
                'value' => $model->staff_icno
            ],
            [
                'label' => 'Nama Pesakit',
                'value' => !empty($model->keluarga->FmyNm) ? $model->keluarga->FmyNm : $model->kakitangan->kakitangan->CONm
            ],
            [
                'label' => 'No.KP Pesakit',
                'value' => !empty($model->keluarga->FamilyId) ? $model->keluarga->FamilyId : $model->patient_icno
            ],
            [
                'label' => 'No. Resit',
                'value' => $model->receipt_no
            ],
            [
                'label' => 'Jumlah Tuntutan (RM)',
                'value' => $model->deduct_amt
            ],
        ],
    ])
    ?>
</div>
</div>
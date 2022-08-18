<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Lihat Keahlian';

?>
<div class="col-md-12 col-sm-12 col-xs-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="tblpraddress-view">
                <p>
                    <?= Html::a('Kembali', ['admin-view','icno'=>$model->ICNO], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Kemaskini', ['admin-update-bp', 'id' => $model->profId], ['class' => 'btn btn-primary']) ?>
                </p>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'label' => 'Badan Profesional',
                            'value' => $model->nambadanprofesional,
                            'contentOptions' => ['style' => 'width:auto'],
                            'captionOptions' => ['style' => 'width:26%'],
                        ],
                        [
                            'label' => 'Peringkat',
                            'value' => $model->peringkat ? $model->peringkat->LvlNm : '<span style="background-color:yellow;color:black;">Sila kemaskini peringkat Kelab/Persatuan/Institusi/Kesatuan ini.</span>',
                            'format' => 'raw',
                        ],
                        [
                            'label' => 'No. Keahlian',
                            'value' => $model->membershipNo,
                            'format' => 'raw',
                        ],
                        [
                            'label' => 'Taraf Keahlian',
                            'value' => $model->tarkeahlian,
                        ],
                        [
                            'label' => 'Jawatan',
                            'value' => $model->jaw,
                        ],
                        [
                            'label' => 'Tarikh Mula Menyertai',
                            'value' => $model->tarikhmula,
                        ],
                        [
                            'label' => 'Tarikh Tamat Menyertai',
                            'value' => $model->tarikhakhir,
                        ],
                        [
                            'label' => 'Yuran Dikenakan',
                            'value' => $model->yuran,
                        ],
                        [
                            'label' => 'Status Keahlian',
                            'value' => $model->staaktif,
                        ],
                        [
                            'label' => 'Status Badan Kedoktoran',
                            'value' => $model->staMedicBody,
                        ],
                        [
                            'label' => 'Status Disahkan',
                            'value' => $model->stasah,
                            'format' => 'raw',
                        ],
                        [
                            'label' => 'File',
                            'value' => $model->displayLink,
                            'format' => 'raw',
                        ],
                        [
                            'label' => 'URL',
                            'value' => $model->url ? $model->url : '<span class="label label-warning">Sila Kemaskini</span>',
                            'format' => 'raw',
                        ],

                    ],
                ]) ?>


            </div>
            <?php
    if (Yii::$app->MP->IsFPSKPP()) {
    ?>
        <div class="form-group text-center">
            <?= \yii\helpers\Html::a('Reject', ['reject-bp', 'id' => $model->profId], ['class' => 'btn btn-danger']) ?>
            <?= \yii\helpers\Html::a('Approve', ['approve-bp', 'id' => $model->profId], ['class' => 'btn btn-success']) ?>
        </div>
    <?php
    }
    ?>
        </div>
    </div>
</div>
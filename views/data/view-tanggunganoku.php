<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
?>
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2>Butiran Maklumat Kurang Upaya</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
                <p>
                    <?= Html::a('<i class="fa fa-sign-out"></i> Kembali', ['senaraitanggungan-oku'], ['class' => 'btn btn-primary']) ?>                 
                </p>

        <div class="table-responsive">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'label' => 'Nama Kakitangan',
                        'value' => $model->keluarga->biodata->CONm
                    ],                                    
                    [
                        'label' => 'Nama Tanggungan',
                        'value' => $model->keluarga->FmyNm
                    ],                                    
                    [
                        'label' => 'Hubungan',
                        'value' => $model->keluarga->Hubkeluarga
                    ],                                    
                    [
                        'label' => 'No. Fail Kebajikan',
                        'value' => $model->SocialWelfareNo 
                    ],                   
                    [
                        'label' => 'No. Laporan Doktor',
                        'value' => $model->DrRptNo
                    ],                    
                    [
                        'label' => 'Jenis Kecacatan',
                        'value' => $model->JenKecacatan
                    ],
                    [
                        'label' => 'Tarikh Kad Dikeluarkan',
                        'value' => Yii::$app->formatter->asDate($model->ConferredDt,'php:d M Y'),
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Dokumen Sokongan',
                        'value' => $model->DisplayLink,
                        'format' => 'raw'
                    ],
                ],
            ])
            ?>
        </div>
        </div>
    </div>
    </div>
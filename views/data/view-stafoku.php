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
                    <?= Html::a('<i class="fa fa-sign-out"></i> Kembali', ['senaraistaf-oku'], ['class' => 'btn btn-primary']) ?>                 
                </p>

        <div class="table-responsive">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'label' => 'Nama Kakitangan',
                        'value' => $model->biodata->CONm
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
                        'value' => $model->jenisKecacatan->DisabilityType
                    ],
                    [
                        'label' => 'Tarikh Kad Dikeluarkan',
                        'value' => Yii::$app->formatter->asDate($model->DisabilityDt,'php:d M Y'),
                        'format' => 'raw'
                    ],
                ],
            ])
            ?>
        </div>
        </div>
    </div>
    </div>
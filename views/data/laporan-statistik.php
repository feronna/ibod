<?php

use yii\helpers\Html;
?>
<div>
    <?php echo $this->render('_topmenu'); ?>
</div>
<div class="col-md-12 col-xs-12">
    <div class="x_panel">


        <div class="x_title">
            <h2><strong>Laporan dan Statistik</strong></h2>
            <div class="clearfix"></div>
        </div>

        <div class="col-xs-12 col-md-3">
            <?php
            $terima_tawaran = \yiister\gentelella\widgets\StatsTile::widget(
                [
                    'icon' => 'address-card',
                    'header' => Yii::t('app', 'Senarai Kakitangan Berstatus OKU'),
                    //   'text' => Yii::t('app','Keterangan Mengenai Pegawai'),
                    'number' => '.',
                ]
            );
            echo Html::a($terima_tawaran, ['data/senaraistaf-oku']);
            ?>
        </div>
        <div class="col-xs-12 col-md-3">
            <?php
            $terima_tawaran = \yiister\gentelella\widgets\StatsTile::widget(
                [
                    'icon' => 'wheelchair',
                    'header' => Yii::t('app', 'Senarai Tanggungan Berstatus OKU'),
                    //   'text' => Yii::t('app','Keterangan Mengenai Pegawai'),
                    'number' => '.',
                ]
            );
            echo Html::a($terima_tawaran, ['data/senaraitanggungan-oku']);
            ?>
        </div>
        <div class="col-xs-12 col-md-3">
            <?php
            $ME = \yiister\gentelella\widgets\StatsTile::widget(
                [
                    'icon' => 'bar-chart',
                    'header' => Yii::t('app', 'Maklumat Eksekutif'),
                    //   'text' => Yii::t('app','Keterangan Mengenai Pegawai'),
                    'number' => '.',
                ]
            );
            echo Html::a($ME, ['data/maklumat-eksekutif']);
            ?>
        </div>


    </div>
</div>
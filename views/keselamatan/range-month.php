<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use app\models\kehadiran\TblYears;
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-search"></i> Search</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= Html::beginForm(['range-month'], 'POST'); ?>

                <?php

                echo Select2::widget([
                    'name' => 'id',
                    'data' =>  ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->where(['status' => 1])->all(), 'ICNO', 'CONm'),
                    'options' => ['placeholder' => 'Pilih Nama ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);

                ?>
                <br>
                <?= Html::dropDownList('tahun', $tahun, ArrayHelper::map(TblYears::findAll(['status' => 1]), 'year', 'year'), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']); ?>

                    <br><br>
                <?= Html::dropDownList('start_mth', $start_mth, ['01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April', '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
                <br><br>
                <?= Html::dropDownList('end_mth', $end_mth, ['01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April', '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
     

                <br><br><br>
                <?= Html::submitButton('<i class="fa fa-print"></i> Generate PDF', ['class' => 'btn btn-primary']); ?>
                <?= Html::endForm(); ?>

            </div>
        </div>
    </div>
</div>
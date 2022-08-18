
<?php

use yii\widgets\DetailView;
?>
<!--<h4><strong>Maklumat Teperinci</strong></h4>-->
<div class="table-responsive">
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'kakitangan.CONm',
            'kakitangan.jawatan.fname',
            'day',
            'formatTarikh',
            'formatTimeIn',
            'formatTimeOut',
            'hoursMinutes',
                [
                'attribute' => 'in_ip',
                'value' => ((!$model->in_ip) ? "-" : $model->in_ip),
            ],
                [
                'attribute' => 'in_lat_lng',
                'value' => ((!$model->in_lat_lng) ? "-" : $model->in_lat_lng),
            ],
                [
                'attribute' => 'out_ip',
                'value' => ((!$model->out_ip) ? "-" : $model->out_ip),
            ],
                [
                'attribute' => 'out_lat_lng',
                'value' => ((!$model->out_lat_lng) ? "-" : $model->out_lat_lng),
            ],
                ['attribute' => 'statusAll', 'format' => 'raw'],
            'catatan',
            'peraku',
            'statusRemark',
                [
                'attribute' => 'app_remark',
                'value' => ((!$model->app_remark) ? "Tiada Catatan" : $model->app_remark),
            ],
                [
                'attribute' => 'app_dt',
                'value' => ((!$model->app_dt) ? "-" : $model->app_dt),
            ],
        ],
    ])
    ?>
</div>
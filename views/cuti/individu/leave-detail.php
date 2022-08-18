
<?php

use yii\widgets\DetailView;
?>
<!--<h4><strong>Maklumat Teperinci</strong></h4>-->
<div class="table-responsive">
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'Nama/Name',
                'value' => function($model){
                    return $model->kakitangan->CONm;
                },
            ],
            [
                'attribute' => 'Jawatan / Position',
                'value' => function($model){
                    return $model->kakitangan->jawatan->fname;
                },
            ],
            [
                'attribute' => 'Tarikh Bercuti / Leave Date',
                'value' => function($model){
                    return $model->full_date;
                },
            ],
            [
                'attribute' => 'Tarikh Mohon / Apply Date',
                'value' => function($model){
                    return $model->mohon_dt;
                },
            ],
        
                [
                'attribute' => 'remark',
                'value' => ((!$model->remark) ? "No Remark" : $model->remark),
            ],
        ],
    ])
    ?>
</div>
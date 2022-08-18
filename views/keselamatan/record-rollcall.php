<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
?>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-list"></i> Senarai keseluruhan kesalahan dan Ketidakpatuhan</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="text-center">
                    <h5><strong><?= $biodata->CONm ?></strong></h5>
                    <h5><strong><?= $biodata->jawatan->fname; ?></strong></h5>
                    <h5><strong><?= $biodata->department->fullname; ?></strong></h5>
                </div>
                <hr>
                <div class="table-responsive">
<?php Pjax::begin(); ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $model,
                        'columns' => [
                            'date',
                            // 'day',
                            'syif',
                            // 'wbb.jenis_wp',
                            // 'formatTimeIn',
                            // 'formatTimeOut',
                                ['attribute' => 'statusH','label'=>'Kesalahan', 'format' => 'raw'],
                            'catatan',
                            'remark',
                            // 'app_remark',
                            // 'app_dt',
                        ],
                    ])
                    ?>

                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
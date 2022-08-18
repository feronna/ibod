<?php

use yii\grid\GridView;

?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Kakitangan akademik yang pegang jawatan pentadbiran</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="table-responsive">
                    <?=
                        GridView::widget([
                            'dataProvider' => $provider,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                'kakitangan.CONm',
                                'adminpos.position_name',
                                'description',
                                'dept.shortname',
                                [
                                    'attribute' => 'start_date',
                                    'format' => ['date', 'php:d/m/Y']
                                ],
                                [
                                    'attribute' => 'end_date',
                                    'format' => ['date', 'php:d/m/Y']
                                ],
                                [
                                    'attribute' => 'curWp',
                                    'format' => 'raw',
                                ],
                                [
                                    'attribute' => 'btnWp',
                                    'format' => 'raw',
                                ],
                            ],
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
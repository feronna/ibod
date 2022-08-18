<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
?>
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2>PERMOHONAN - <?= $title; ?> (STAFF)</h2> 
            <p align ="right">
                <?php echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?>  
            </p>
            <div class="clearfix"></div>
        </div> 
        <div class="x_content">
            <div class="table-responsive">   
                <?=
                GridView::widget([
                    'dataProvider' => $staff,
                    'layout' => "{items}\n{pager}",
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'label' => 'Nama Pemohonon',
                            'value' => function($model) {
                                return $model->biodataStaff->CONm;
                            },
                        ],
                        [
                            'label' => 'Resume',
                            'value' => function($model) {
                                $ICNO = $model->ICNO;
                                $jenis_user_id = 1;

                                return Html::a('<i class="fa fa-search"></i>', ['resume', 'jenis_user_id' => $jenis_user_id, 'ICNO' => $ICNO], ['class' => 'btn btn-link']);
                            },
                                    'format' => 'raw',
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div> 

            <div class="x_panel">
                <div class="x_title">
                    <h2>PERMOHONAN - <?= $title; ?> (ORANG AWAM)</h2> 
                    <div class="clearfix"></div>
                </div> 
                <div class="x_content">
                    <div class="table-responsive">  
                        <?=
                        GridView::widget([
                            'dataProvider' => $orgAwam,
                            'layout' => "{items}\n{pager}",
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'label' => 'Nama Pemohonon',
                                    'value' => function($model) {
                                        return strtoupper($model->biodataOrgAwam->CONm);
                                    },
                                ],
                                [
                                    'label' => 'Resume',
                                    'value' => function($model) {
                                        $ICNO = $model->ICNO;
                                        $jenis_user_id = 2;
                                        return Html::a('<i class="fa fa-search"></i>', ['resume', 'jenis_user_id' => $jenis_user_id, 'ICNO' => $ICNO], ['class' => 'btn btn-link']);
                                    },
                                            'format' => 'raw',
                                        ],
                                        [
                                            'label' => 'Lampiran',
                                            'value' => function($model) {
                                                $ICNO = $model->ICNO;
                                                return Html::a('<i class="fa fa-file"></i>', ['attachment', 'ICNO' => $ICNO], ['class' => 'btn btn-link']);
                                            },
                                                    'format' => 'raw',
                                                ],
                                            ],
                                        ]);
                                        ?>
            </div>
        </div>
    </div> 
</div> 

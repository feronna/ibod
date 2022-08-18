<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
?>
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2>Senarai Nama Pemohon Pengajian Lanjutan - Cuti Belajar</h2> 
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
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'label' => 'Nama Pemohon',
                            'value' => function($model) {
                                return $model->biodataStaff->CONm;
                            },
                        ],

                        [
                            'label' => 'UMSPER',
                            'value' => function($model) {
                                return $model->biodataStaff->COOldID;
                            },
                        ],

                        [
                            'label' => 'Jawatan & Gred',
                            'value' => function($model) {
                                return $model->biodataStaff->jawatan->nama." "."(".$model->biodataStaff->jawatan->gred .")";
                            },
                        ],

                        [
                            'label' => 'J/F/I/P/U',
                            'value' => function($model) {
                                return $model->biodataStaff->displayDepartment;
                            },
                        ],

                         [
                            'label' => 'Tarikh Mohon',
                            'value' => function($model) {
                                return $model->tarikhmohon;
                            },
                        ],


                        [
                            'label' => 'Tindakan',
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                return Html::a('<i class="fa fa-search"></i>', ['maklumat-pemohon', 'ICNO' => $ICNO], ['class' => 'btn btn-link']);
                                    },
                                            'format' => 'raw',
                                        ],

                           [
                                            'label' => 'Lampiran',
                                            'value' => function($model) {
                                                $ICNO = $model->icno;
                                                return Html::a('<i class="fa fa-file"></i>', ['attachment','ICNO' => $ICNO], ['class' => 'btn btn-link']);
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

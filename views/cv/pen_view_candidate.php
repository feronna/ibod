<?php
use app\models\cv\TemudugaPentadbiran;
use yii\helpers\Html;
use yii\grid\GridView; 
?> 

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
<?php echo $this->render('menu'); ?>
        <div class="x_panel"> 
            <div class="x_title">
                <h2>List -  <?= $iv->jawatan->fname; ?></h2>
                <p align="right" >
<?php echo Html::a('Back', [$back], ['class' => 'btn btn-primary btn-sm']); ?>   
                </p>
                <div class="clearfix"></div>
            </div> 
            <div class="table-responsive">   
                <?php
                $Columns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Name',
                        'value' => function($model) {
                            return $model->biodata->CONm;
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => 'Document',
                        'value' => function($model) {
                            if ($model->checkJd($model->ICNO)) {
                                $btn = 'btn-default';
                            } else {
                                $btn = 'btn-danger';
                            }
                            $iklan = TemudugaPentadbiran::findOne(['id'=>$model->iv_id]);

                            return Html::a('RESUME', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'personal'], ['class' => 'btn btn-default btn-md', 'target' => '_blank']) . Html::a('JD', [ 'jd', 'id' => $model->ICNO], ['class' => 'btn-md btn ' . $btn, 'target' => '_blank']) . Html::a('APPLICATION INFORMATION', ['download-cv', 'id' => sha1($model->ICNO), 'gred_id' => $iklan->ads_id], ['class' => 'btn btn-default btn-md', 'target' => '_blank']);
                                        
                        },
                                'format' => 'raw'
                            ],
                            [
                                'label' => 'Result',
                                'value' => function($model) {
                                    return Html::a('<i class="fa fa-eye"></i>', ['view-mark', 'id' => $model->id], ['class' => 'btn btn-default btn-sm']);
                                },
                                        'format' => 'raw'
                                    ],
                                    [
                                        'label' => 'Mark',
                                        'value' => function($model) {
                                            if ($model->checkMarkahIv($model->id)) {
                                                return $model->jumlahMarkahIv($model->id);
                                            } else {
                                                return '';
                                            }
                                        },
                                        'format' => 'raw',
                                        'contentOptions' => ['class' => 'text-center'],
                                        'headerOptions' => ['style' => 'width:15%', 'class' => 'text-center'],
                                    ],
                                    [
                                        'label' => 'Qualified',
                                        'value' => function($model) use ($back) {

                                            if ($model->temuduga->tarikh_iv < date('Y-m-d')) {
                                                if ($model->qualified == 0) {
                                                    $status = Html::a('<i class="fa fa-check-square-o fa-lg"></i>', ['qualified-pen', 'id' => $model->id, 'status' => 1, 'url' => $back], ['class' => 'btn btn-default btn-sm']);
                                                } else {
                                                    $status = "<span class='label label-success'>Qualified</span>  " . Html::a('<i class="fa fa-window-close-o fa-lg"></i>', ['qualified-pen', 'id' => $model->id, 'status' => 0, 'url' => $back], ['class' => 'btn btn-default btn-sm']);
                                                }
                                            } else {
                                                $status = '';
                                            }

                                            return $status;
                                        },
                                                'format' => 'raw',
                                                'contentOptions' => ['class' => 'text-center'],
                                                'headerOptions' => ['style' => 'width:15%', 'class' => 'text-center'],
                                            ],
                                        ];

                                        echo GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'columns' => $Columns,
                                            'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                                            'layout' => "{items}\n{pager}",
                                        ]);
                                        ?> 
            </div>
        </div> 
    </div>
</div>
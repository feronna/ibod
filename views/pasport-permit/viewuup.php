<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use app\models\hronline\RptPassport;
use app\models\hronline\Tblprcobiodata;
use kartik\grid\GridView;

$this->title = 'Passport Holder List';

?>
<div class="col-md-12 col-sm-12 col-xs-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">

            <?= Html::a('<i class="fa fa-repeat"> Reset</i>', ['view-u-u-p'], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<i class="fa fa-refresh"> Refresh</i>', ['refresh'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('<i class="fa fa-download"> Download</i>', ['download-excel', 'pp' => 'ps'], ['class' => 'btn btn-success', 'target' => '_blank']) ?>

            <?= Html::a('<i class="fa fa-bell"> to Not Exist Only</i>', ['send-noty', 'status_value' => '3'], ['class' => 'btn btn-success',
                'data' => [
                    'confirm' => 'Do you wish to send notifications to Not Exist Only ?',
                    'method' => 'post',
                        ],]) ?>
            <?= Html::a('<i class="fa fa-bell"> to Exipred Only</i>', ['send-noty', 'status_value' => '2'], ['class' => 'btn btn-success',
                'data' => [
                    'confirm' => 'Do you wish to send notifications to Expired Only ?',
                    'method' => 'post',
                        ],]) ?>
            <?= Html::a('<i class="fa fa-bell"> to Both</i>', ['send-noty'], ['class' => 'btn btn-success',
                'data' => [
                    'confirm' => 'Do you wish to send notifications to both ?',
                    'method' => 'post',
                        ],]) ?>


            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => true,
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'header' => 'Bil.',
                            'contentOptions' => ['class' => 'text-left'],
                            'headerOptions' => ['class' => 'text-left', 'style' => 'width:3%', 'bgcolor' => '#e8e9ea'],
                        ],
                        [
                            'label' => 'ICNO / Paspot',
                            'format' => 'raw',
                            'filter' => Select2::widget([
                                'name' => 'ICNO',
                                'value' => isset(Yii::$app->request->queryParams['ICNO']) ? Yii::$app->request->queryParams['ICNO'] : '',
                                'data' => ArrayHelper::map(RptPassport::find()->all(), 'ICNO', 'ICNO'),
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]),
                            'value' => 'ICNO',
                            'contentOptions' => ['class' => 'text-left'],
                            'headerOptions' => ['class' => 'text-left', 'style' => 'width:20%', 'bgcolor' => '#e8e9ea'],
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        [
                            'label' => 'Staff Name',
                            'format' => 'raw',
                            'filter' => Select2::widget([
                                'name' => 'name',
                                'value' => isset(Yii::$app->request->queryParams['name']) ? Yii::$app->request->queryParams['name'] : '',
                                'data' => ArrayHelper::map(RptPassport::find()->all(), 'ICNO', function ($model) {
                                    if ($model->biodata) {
                                        return $model->biodata->CONm;
                                    }
                                    return $model->ICNO;
                                }),
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]),
                            'value' => function ($model) {
                                if ($model->biodata) {
                                    return $model->biodata->CONm;
                                }
                                return $model->ICNO;
                            },
                            'contentOptions' => ['class' => 'text-left'],
                            'headerOptions' => ['class' => 'text-left', 'style' => 'width:20%', 'bgcolor' => '#e8e9ea'],
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        [
                            'label' => 'Sabah Status',
                            'format' => 'raw',
                            'filter' => Select2::widget([
                                'name' => 'isSabahan',
                                'value' => isset(Yii::$app->request->queryParams['isSabahan']) ? Yii::$app->request->queryParams['isSabahan'] : '',
                                'data' => ['1' => 'Sabah', '0' => 'Non-Sabah'],
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]),
                            'value' => function ($model) {
                                switch ($model->isSabahan) {
                                    case '1':
                                        $status = 'Sabahan';
                                        break;

                                    default:
                                        $status = 'Non-Sabahan';
                                        break;
                                }
                                return $status;
                            },
                            'contentOptions' => ['class' => 'text-left'],
                            'headerOptions' => ['class' => 'text-left', 'style' => 'width:20%', 'bgcolor' => '#e8e9ea'],
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        [
                            'label' => 'Notification Status',
                            'format' => 'raw',
                            'filter' => Select2::widget([
                                'name' => 'ps_noty_status',
                                'value' => isset(Yii::$app->request->queryParams['ps_noty_status']) ? Yii::$app->request->queryParams['ps_noty_status'] : '',
                                'data' => ['1' => 'ON', '0' => 'OFF'],
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]),
                            'value' => function ($model) {
                                switch ($model->ps_noty_status) {
                                    case '1':
                                        $status = 'ON';
                                        break;
                                    default:
                                        $status = 'OFF';
                                        break;
                                }
                                return $status;
                            },
                            'contentOptions' => ['class' => 'text-left'],
                            'headerOptions' => ['class' => 'text-left', 'style' => 'width:20%', 'bgcolor' => '#e8e9ea'],
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        [
                            'label' => 'Passport Status',
                            'format' => 'raw',
                            'filter' => Select2::widget([
                                'name' => 'pasport_status',
                                'value' => isset(Yii::$app->request->queryParams['pasport_status']) ? Yii::$app->request->queryParams['pasport_status'] : '',
                                'data' => ['1' => 'Updated', '2' => 'Expired', '3' => 'Not Exist'],
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]),
                            'value' => function ($model) {
                                switch ($model->pasport_status) {
                                    case '1':
                                        $status = 'Updated';
                                        break;
                                    case '2':
                                        $status = 'Expired';
                                        break;

                                    default:
                                        $status = 'Not Exist';
                                        break;
                                }
                                return $status;
                            },
                            'contentOptions' => ['class' => 'text-left'],
                            'headerOptions' => ['class' => 'text-left', 'style' => 'width:20%', 'bgcolor' => '#e8e9ea'],
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        [
                            'label' => 'Lock Status',
                            'format' => 'raw',
                            'filter' => Select2::widget([
                                'name' => 'lock',
                                'value' => isset(Yii::$app->request->queryParams['lock']) ? Yii::$app->request->queryParams['lock'] : '',
                                'data' => ['1' => 'Locked', '0' => 'Not Locked'],
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]),
                            'value' => function ($model) {
                                switch ($model->lock) {
                                    case '1':
                                        $status = 'Locked';
                                        break;

                                    default:
                                        $status = 'Not Locked';
                                        break;
                                }
                                return $status;
                            },
                            'contentOptions' => ['class' => 'text-left'],
                            'headerOptions' => ['class' => 'text-left', 'style' => 'width:20%', 'bgcolor' => '#e8e9ea'],
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],


                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Tindakan',
                            'template' => '{adminview}{update-noty-status}{send-noty}{lock-noty}',
                            'buttons' => [
                                'adminview' => function ($url) {
                                    return Html::a('<span class="fa fa-eye"></span>', $url, ['class' => 'text-center btn btn-primary', 'target' => '_blank']);
                                },
                                'update-noty-status' => function ($url, $model) {
                                    $noty = 'ON';
                                    $fa = 'fa fa-volume-up';
                                    if($model->ps_noty_status == 1){
                                        $noty = 'OFF';
                                        $fa = 'fa fa-volume-off';
                                    }
                                    return Html::a('<span class="'.$fa.'"></span>', $url, ['class' => 'text-center btn btn-primary',
                                    'data' => [
                                        'confirm' => 'Do you wish to turn '.$noty.' this notification ?',
                                        'method' => 'post',
                                            ],]);
                                },
                                'send-noty' => function ($url, $model) {
                                    if($model->ps_noty_status == 0){
                                        return null;
                                    }
                                    return Html::a('<span class="fa fa-bell"></span>', $url, ['class' => 'text-center btn btn-primary',
                                    'data' => [
                                        'confirm' => 'Do you wish to send notifications ?',
                                        'method' => 'post',
                                            ],]);
                                },
                                'lock-noty' => function ($url, $model) {
                                    $lock = 'fa fa-unlock';
                                    $status = 'unlock';
                                    if($model->lock == 0){
                                        $lock = 'fa fa-lock';
                                        $status = 'lock';
                                    }
                                    return Html::a('<span class="'.$lock.'"></span>', $url, ['class' => 'text-center btn btn-primary',
                                    'data' => [
                                        'confirm' => 'Do you wish to '.$status.' notification ?',
                                        'method' => 'post',
                                            ],]);
                                },
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                                if ($action === 'adminview') {
                                    $url = $action . '?icno=' . $model->ICNO;
                                    return $url;
                                    //return Url::to(['biodata/adminview', 'id' => $model->ICNO]);
                                }
                                if ($action === 'update-noty-status') {
                                    $url = $action . '?icno=' . $model->ICNO. '&pp=ps';
                                    return $url;
                                    //return Url::to(['biodata/adminview', 'id' => $model->ICNO]);
                                }
                                if ($action === 'send-noty') {
                                    $url = $action . '?id=' . $model->ICNO. '&pp=ps' ;
                                    return $url;
                                    //return Url::to(['biodata/adminview', 'id' => $model->ICNO]);
                                }
                                if ($action === 'lock-noty') {
                                    $url = $action . '?icno=' . $model->ICNO;
                                    return $url;
                                    //return Url::to(['biodata/adminview', 'id' => $model->ICNO]);
                                }
                            },
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => ['class' => 'text-center', 'style' => 'width:10%', 'bgcolor' => '#e8e9ea'],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
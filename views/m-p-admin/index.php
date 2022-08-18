<?php

$js = <<<js
    $('.modalButton').on('click', function () {
            $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;
use yii\db\Expression;

$JENIS_NOTI = ['1' => 'Paspot', '2' => 'Permit Kerja'];
?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian Pengguna</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?php $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                    'options' => ['class' => 'form-horizontal form-label-left']
                ]); ?>
                <div class="form-group">
                    <div class=" col-md-4 col-sm-4 col-xs-12">
                        <?=
                            $form->field($searchModel, 'mp_type')->label(false)->widget(Select2::classname(), [
                                'data' => ['1' => 'Paspot', '2' => 'Permit Kerja'],
                                'options' => ['placeholder' => 'Jenis Notifikasi', 'class' => 'form-control col-md-2 col-xs-12'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                    <div class=" col-md-4 col-sm-4 col-xs-12">
                        <?=
                            $form->field($searchModel, 'icno')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Tblprcobiodata::find()
                                    ->select(new Expression('CONCAT(CONm, \' - \', ICNO) as CONm, ICNO'))
                                    ->orderBy(['CONm' => SORT_ASC])->all(), 'ICNO', 'CONm'),
                                'options' => ['placeholder' => 'IC/KP/Nama', 'class' => 'form-control col-md-2 col-xs-12'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                    <div class=" col-md-1 col-sm-1 col-xs-12">
                        <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Cari', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Notifikasi</strong></h2>
                <?= Html::a('Kembali', ['biodata/userview'], ['class' => 'btn btn-primary pull-right']) ?>
                <?= Html::a('Batch Deletion', ['batch-deletion'], ['class' => 'btn btn-primary pull-right ',]) ?>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <?=
                            GridView::widget([
                                //'tableOptions' => [
                                //  'class' => 'table table-striped jambo_table',
                                //],
                                'emptyText' => 'Tiada Rekod',
                                'summary' => '',
                                'dataProvider' => $dataProvider,
                                'columns' => [

                                    [
                                        'label' => 'IC/KP',
                                        'headerOptions' => ['class' => 'column-title text-center col-md-1'],
                                        'contentOptions' => ['class' => 'text-center'],
                                        'value' => 'icno',
                                        'format' => 'html',
                                    ],
                                    [
                                        'label' => 'NAMA PENGGUNA',

                                        'headerOptions' => ['class' => 'text-center'],
                                        'contentOptions' => ['class' => 'col-md-4'],

                                        'value' => 'name',
                                    ],
                                    [
                                        'label' => 'JENIS NOTIFIKASI',

                                        'headerOptions' => ['class' => 'text-center'],
                                        'contentOptions' => ['class' => 'col-md-4'],

                                        'value' => function ($model) {
                                            switch ($model->mp_type) {
                                                case '1':
                                                    return 'PASPOT';
                                                    break;
                                                case '2':
                                                    return 'PERMIT KERJA';
                                                    break;
                                                default:
                                                    return '-';
                                                    break;
                                            };
                                        },
                                    ],
                                    [
                                        'label' => 'TINDAKAN',
                                        'headerOptions' => ['class' => 'text-center'],
                                        'contentOptions' => ['class' => 'text-center col-md-2'],
                                        'value' => function ($model) {
                                            //                                        $url = Url::to(['lppums/kemaskini-buka-borang', 'id' => $model->id]);
                                            return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => Url::to(['noti-info', 'id' => $model->id]), 'class' => 'btn btn-default btn-sm modalButton']) .
                                                Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete-noti', 'id' => $model->id], [
                                                    'data' => [
                                                        'confirm' => 'Anda ingin memadam notifikasi ini?',
                                                        'method' => 'post',
                                                    ],
                                                    'class' => 'btn btn-default btn-sm'
                                                ]);
                                        },
                                        'format' => 'raw',
                                    ]
                                ],
                            ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
Modal::begin([
    'header' => 'Noti Info',
    'id' => 'modal',
    'size' => 'modal-md',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>
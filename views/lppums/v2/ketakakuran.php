<?php

$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;

$url = \yii\helpers\Url::to(['name-list']);

Modal::begin([
    'header' => '<strong>Tambah / Kemaskini Ketakakuran Staf</strong>',
    'size' => 'modal-lg',
    'options' => [
        'id' => 'modal',
        'tabindex' => false, // important for Select2 to work properly
    ],
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<?= $this->render('//lppums/_menuAdmin'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian Ketakakuran Staf</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php $form = ActiveForm::begin(['action' => ['ketakakuran-staf'], 'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => 1]]); ?>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama</label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <?=
                            $form->field($searchModel, 'icno')->widget(Select2::classname(), [
                                'options' => [
                                    'id' => 'test',
                                    'placeholder' => 'Pilih Staff',
                                    'class' => 'form-control col-md-7 col-xs-12',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => $url,
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term, page:params.page || 1}; }')
                                    ],
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                                ],
                            ])->label(false);
                            ?>
                        </div>
                    </div>

                    <div class="ln_solid"></div>

                    <div class="form-group">
                        <div class="pull-right">
                            <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Hasil Carian</strong></h2>
                <?= Html::button('Tambah Rekod', ['value' =>  Url::to(['lppums/tambah-ketakakuran-staf']), 'class' => 'btn btn-success btn-sm modalButton pull-right']) ?>
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
                                    'class' => 'yii\grid\SerialColumn',
                                    'header' => 'BIL',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'label' => 'NAMA',
                                    'headerOptions' => ['class' => 'text-center col-md-3'],
                                    'value' => function ($model) {
                                        return $model->staff->CONm;
                                    },
                                    'format' => 'raw',
                                ],
                                [
                                    'label' => 'PERKARA',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return $model->content;
                                    },
                                ],
                                [
                                    'label' => 'DOKUMEN',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                                    'value' => function ($model) {
                                        return ($model->filehash) ? Html::a("<i class='fa fa-file' aria-hidden='true'></i>
                                    ", Url::to(['lppums/view-file', 'hashfile' => $model->filehash, 'lpp_id' => '']), ['data-pjax' => 0, 'target' => '_blank', 'class' => 'btn btn-xs btn-default']) : '';
                                        // return $model->id;
                                    },
                                    'format' => 'raw',
                                ],
                                [
                                    'label' => 'ADDED BY',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                                    'value' => function ($model) {
                                        return $model->uploader->CONm;
                                    },
                                ],
                                [
                                    'label' => 'DATE ADDED',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                                    'value' => function ($model) {
                                        return \Yii::$app->formatter->asDate($model->created_dt, 'yyyy-MM-dd');
                                    },
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    //'attribute' => 'CONm',
                                    'header' => 'TINDAKAN',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'template' => '{update} {delete}',
                                    //'header' => 'TINDAKAN',
                                    'buttons' => [
                                        'update' => function ($url, $model) {
                                            $url = Url::to(['lppums/kemaskini-ketakakuran-staf', 'id' => $model->id]);
                                            return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                        },
                                        'delete' => function ($url, $model) {
                                            $url = Url::to(['lppums/padam-ketakakuran-staf', 'id' => $model->id]);
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                                'class' => 'btn btn-default btn-sm',
                                                'data' => [
                                                    'confirm' => 'Adakah anda ingin membuang rekod ini?',
                                                    'method' => 'post',
                                                ],
                                            ]);
                                        },
                                    ],
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
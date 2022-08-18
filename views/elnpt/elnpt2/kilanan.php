<?php
/* @var $this yii\web\View */

$this->registerCss("
    td {
        color: black;
        font-size: 15px;
    }
");

$js = <<<js
    $('.modalBtn').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
        $('#modalHeader').text('Tambah Sebab & Cadangan');
    });
    $('.modalBtn1').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
        $('#modalHeader').text('Kemaskini  Sebab & Cadangan');
    });
    $("#btn-alert").on("click", function() {
        krajeeDialog.alert("Data berjaya disimpan!")
    });
js;
$this->registerJs($js);

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use kartik\dialog\Dialog;

echo Dialog::widget();

Modal::begin([
    'header' => '<strong id="modalHeader"></strong>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<?php
echo ($lpp->PYD == Yii::$app->user->identity->ICNO) ? $this->render('//elnpt/elnpt2/_menu', ['menu' => $menu, 'lppid' => $lppid, 'sah' => isset($lpp) ? $lpp->PYD_sah : false]) : $this->render('//elnpt/elnpt2/_semakMenu', ['mrkh_all' => $menu, 'lppid' => $lppid]);
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Perkhidmatan Tahun <?= $lpp->tahun ?></strong></h2>
                <?= ($lpp->PYD == Yii::$app->user->identity->ICNO ? $check : true) ? '' : Html::button('Tambah Data', ['value' => yii\helpers\Url::to(['elnpt2/tambah-sebab-cadangan', 'lppid' => $lppid]), 'class' => 'pull-right btn-success btn-sm modalBtn']); ?>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'emptyText' => 'Perkara yang anda terkilan dengan universiti? Tiada.',
                            'summary' => '',
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'header' => 'BIL',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'label' => 'SEBAB JIKA ADA',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'attribute' => 'sebab',
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'CADANGAN UNTUK MEMPERBAIKI',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'attribute' => 'cadangan',
                                    'format' => 'html',
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'TINDAKAN',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'template' => '{update} {delete}',
                                    //'header' => 'TINDAKAN',
                                    'buttons' => [
                                        'update' => function ($url, $model) use ($lppid) {
                                            $url =  yii\helpers\Url::to(['elnpt2/edit-sebab-cadangan', 'id' => $model->id, 'lppid' => $lppid]);
                                            return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalBtn1']);
                                        },
                                        'delete' => function ($url, $model)  use ($lppid) {
                                            $url =  yii\helpers\Url::to(['elnpt2/padam-sebab-cadangan', 'id' => $model->id, 'lppid' => $lppid]);
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['class' => 'btn btn-default btn-sm', 'data-confirm' => 'Adakah anda pasti?',]);
                                        },
                                    ],
                                ],
                            ],
                        ]); ?>
                    </div>
                </div>
                <div class="row">
                    <div style="clear: both;" class="form-group pull-right">
                        <?= ($lpp->PYD == \Yii::$app->user->identity->ICNO ? !$check : false) ? Html::submitButton('Simpan', ['class' => 'btn btn-primary', 'id' => 'btn-alert']) : '' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
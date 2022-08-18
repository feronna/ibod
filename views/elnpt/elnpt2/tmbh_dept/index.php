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
/* @var $this yii\web\View */
/* @var $searchModel app\models\elnpt\elnpt2\TblKumpDeptSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<?php
Modal::begin([
    'header' => '<strong>Tambah / Kemaskini</strong>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<?= $this->render('//elnpt/_menuAdmin'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4>Carian Kumpulan Ruberik - JFPIB</h4>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">

                    <?php
                    echo $this->render('_search', ['model' => $searchModel]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h4>Senarai Kumpulan Ruberik - JFPIB</h4>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <p>
                        <?= Html::button('Tambah Entry', ['value' => 'create', 'class' => 'btn btn-success modalButton']) ?>
                    </p>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        // 'filterModel' => $searchModel,
                        'columns' => [
                            // ['class' => 'yii\grid\SerialColumn'],

                            [
                                'class' => 'yii\grid\SerialColumn',
                                'header' => 'BIL',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],

                            [
                                'label' => 'Kumpulan',
                                'headerOptions' => ['class' => 'text-center'],
                                // 'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return is_null($model->refKump) ? '<span class="label label-warning">Belum set</span>' : $model->refKump->kump_dept;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'JFPIB',
                                'headerOptions' => ['class' => 'text-center'],
                                // 'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return is_null($model->dept) ? '<span class="label label-warning">Belum set</span>' : $model->dept->fullname;
                                },
                                'format' => 'html',
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
                                        $url = Url::to(['elnpt/update', 'id' => $model->id]);
                                        return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    },
                                    'delete' => function ($url, $model) {
                                        $url = Url::to(['elnpt/delete', 'id' => $model->id]);
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['class' => 'btn btn-default btn-sm']);
                                    },
                                ],
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
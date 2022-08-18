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
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\web\JsExpression;
use kartik\widgets\StarRating;
use yii\widgets\ActiveForm;

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>

<?php
Modal::begin([
    'header' => '<span id="modalHeaderTitle"></span>',
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    // 'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<?= $this->render('_menuAdmin'); ?>

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
                <?php $form = ActiveForm::begin(['id' => 'search',  'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left']]); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">NAMA</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($model, 'CONm')->textInput([
                            // 'placeholder' => 'Cari Nama',
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">ICNO</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($model, 'email')->textInput([
                            // 'placeholder' => 'Cari Nama',
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group jspiu">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="senarai">JFPIB</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?=
                        $form->field($model, 'DeptId')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\Department::find()->orderBy(['fullname' => SORT_ASC])->all(), 'id', 'fullname'),
                            'options' => [
                                'placeholder' => 'Pilih JFPIB',
                                'class' => 'form-control col-md-7 col-xs-12',
                                //'selected'    => 2,
                                //'id' => 'senarai',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary'])
                        ?>
                        <?= Html::submitButton('Cari', ['class' => 'btn btn-success'])
                        ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Hasil Carian</strong></h2>
                <?= Html::button('Tambah Pengguna Baru', ['value' =>  Url::to(['i-kalendar/create-pengguna']), 'class' => 'pull-right btn-success btn-sm showModalButton', 'title' => 'Tambah Pengguna']) ?>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <?=
                    GridView::widget([
                        //'tableOptions' => [
                        //  'class' => 'table table-striped jambo_table',
                        //],
                        'emptyText' => 'Tiada Rekod',
                        'summary' => '',
                        // 'pager' => [
                        //     'class' => \kop\y2sp\ScrollPager::className(),
                        //     'container' => '.grid-view tbody',
                        //     'triggerOffset' => 10,
                        //     'item' => 'tr',
                        //     'paginationSelector' => '.grid-view .pagination',
                        //     'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer">{text}</a></td></tr>',
                        // ],
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
                                'attribute' => 'CONm',
                                'value' => 'staf.CONm'
                            ],
                            [
                                'label' => 'ICNO',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'attribute' => 'email',
                            ],
                            [
                                'label' => 'JFPIB',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'attribute' => 'DeptId',
                                'value' => 'staf.department.shortname'
                            ],
                            [
                                'label' => 'VIEW?',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'attribute' => 'view',
                                // 'value' => 'staf.department.shortname'
                            ],
                            [
                                'label' => 'POST?',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'attribute' => 'post',
                                // 'value' => 'staf.department.shortname'
                            ],
                            [
                                'label' => 'EDIT CATEGORIES?',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'attribute' => 'add_categories',
                                // 'value' => 'staf.department.shortname'
                            ],
                            [
                                'label' => 'EDIT GROUPS?',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'attribute' => 'add_groups',
                                // 'value' => 'staf.department.shortname'
                            ],
                            [
                                'label' => 'EDIT USERS?',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'attribute' => 'add_users',
                                // 'value' => 'staf.department.shortname'
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'TINDAKAN',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'template' => '{update} {delete}',
                                'buttons' => [
                                    'update' => function ($url, $model) {
                                        $url = Url::to(['i-kalendar/update-pengguna', 'user_id' => $model->user_id]);
                                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm showModalButton', 'title' => 'Kemaskini Pengguna']);
                                    },
                                    'delete' => function ($url, $model) {
                                        $url = Url::to(['i-kalendar/delete-pengguna', 'user_id' => $model->user_id]);
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['class' => 'btn btn-default btn-sm', 'title' => 'Padam Pengguna', 'data' => [
                                            'confirm' => 'Are you sure you want to delete this item?',
                                            'method' => 'post',
                                        ]]);
                                        // return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['class' => 'btn btn-default btn-sm']);
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
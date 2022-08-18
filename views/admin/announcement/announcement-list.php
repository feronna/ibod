<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TblrekodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Announcements List';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-bullhorn"></i>&nbsp;<strong><?= Html::encode($this->title) ?></strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <p>
            <?php echo Html::a('<span class="fa fa-plus"></span>&nbsp;Add New Announcement', ['admin/create'], $options = ['class' => 'btn btn-success pull-right']) ?>

        </p>
        <?php Pjax::begin(); ?>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => [
                'id' => 'theDatatable',
                'class' => 'table table-striped table-bordered table-condensed'
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'tag',
                'title',
                'full_dt',
                ['attribute' => 'crawlerAlt', 'format' => 'raw'],
                ['attribute' => 'statusAlt', 'format' => 'raw'],
                ['attribute' => 'detailView', 'format' => 'raw'],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Action',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::a('<span class="fa fa-pencil"></span>', ['admin/update', 'id' => $model->id, 'class' => 'btn btn-default btn-sm']);
                        },
                    ],
                ],
            ],
        ]);
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>

<?php
Modal::begin([
    'header' => '<strong>Announcement</strong>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<?php

$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);
?>
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TblrekodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Senarai Semakan Seksyen Perkhidmatan, Bahagian Sumber Manusia';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-list-alt"></i>&nbsp;<strong><?= Html::encode($this->title) ?></strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
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
                ['attribute'=>'icno',
                    'value'=>'kakitangan.CONm',
                    ],
                'full_date',
                'tempoh',
                'jenis_cuti_id',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Action',
                    'template' => '{update}',
                    'buttons' => [
                                'update' => function ($url, $model) {
                                    $url = Url::to(['cuti/semakan-update', 'id' => $model->id]);
                                    return Html::button('<span class="fa fa-pencil"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    
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
    'header' => '<strong>Semakan Seksyen Perkhidmatan, Bahagian Sumber Manusia</strong>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<?php

$js=<<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);
?>
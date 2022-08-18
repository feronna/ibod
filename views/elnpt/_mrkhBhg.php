<?php
/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\ListView;
?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <?=
                    ListView::widget([
                        'dataProvider' => $dataProvider,
                        'options' => [
                            'tag' => 'div',
                            'class' => 'list-wrapper',
                            'id' => 'list-wrapper',
                        ],
                        'layout' => "{pager}\n{items}\n{summary}",
                        'itemView' => function ($model, $key, $index, $widget) {
                            return '<strong>Bahagian ' . $model->bhg_id . ': ' . (($model->borang->tahun >= 2020) ? ($model->markah * 100) : Yii::$app->formatter->asDecimal($model->markah)) . '</strong><br>';
                        },
                        'itemOptions' => [
                            'tag' => false,
                        ],
                        'pager' => [
                            'firstPageLabel' => 'first',
                            'lastPageLabel' => 'last',
                            'nextPageLabel' => 'next',
                            'prevPageLabel' => 'previous',
                            'maxButtonCount' => 3,
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
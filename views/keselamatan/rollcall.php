<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use app\models\keselamatan\RefPosKawalan;
use app\models\keselamatan\RefUnit;
use app\widgets\TopMenuWidget;
use app\models\keselamatan\RefRollcall;
?>
<?= $this->render('/keselamatan/_topmenu') ?>

<div class="col-md-12"> 
    <div class="x_panel">
        <div class="x_title">


            <!--// Control your pjax options-->
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'options' => [
                    'class' => 'table-responsive',
                ],
                /*   'filterModel' => $searchModel, */ //to hide the search row
                'columns' => [
                    ['class' => 'kartik\grid\SerialColumn'],
                    [
                        'label' => 'Jenis Syif',
                        'value' => 'jenis_shifts',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                    [
                        'label' => 'Perincian',
                        'value' => 'details',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                   
                    [
                        'label' => 'Tindakan',
                        'format' => 'raw',
                        'value' => function ($data) {
//                            return Html::a('<i class="fa fa-eye">', ["keselamatan/anggota-seliaan", 'id' => $data->id]);
                            return Html::a('<i class="fa fa-eye">', ["keselamatan/periksa-anggota", 'id' => $data->id]);
                        },
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Surat Tunjuk Sebab',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Html::a('<i class="fa fa-edit">', ["keselamatan/sts", 'id' => $data->id]);
                        },
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                ],
                'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                'resizableColumns' => true,
                'responsive' => false,
                'responsiveWrap' => false,
                'hover' => true,
                'floatHeader' => true,
                'floatHeaderOptions' => [
                    'position' => 'absolute',
                ],
            ]);
            ?>



        </div>
    </div>
</div>

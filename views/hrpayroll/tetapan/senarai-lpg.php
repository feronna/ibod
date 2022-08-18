<?php

use yii\helpers\Html;
use kartik\grid\GridView;

?>
<?php echo $this->render('/hrpayroll/_menu'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-list"></i>&nbsp;<strong><?= $this->title ?></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?= Html::a('<i class="fa fa-undo"></i>&nbsp;Back', ['index'], ['class' => 'btn btn-warning']); ?>
                <ul class="nav nav-tabs">
                    <li class="active"><?= Html::a('<i class="fa fa-list"></i> Senarai LPG', ['senarai-lpg', 'id' => $id]) ?></li>
                    <li><?= Html::a('<i class="fa fa-users"></i> Senarai Staf', ['senarai-staf', 'id' => $id]) ?></li>
                </ul>
                <br>
                <?= Html::a('<i class="fa fa-plus"></i>&nbsp;Tambah LPG', ['tambah-lpg', 'id' => $id], ['class' => 'btn btn-primary']); ?>
                <br><br>
                <div class="table-responsive">
                    <?=
                    GridView::widget([
                        'options' => [
                            'class' => 'table-responsive',
                        ],
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            [
                                'class' => 'kartik\grid\SerialColumn',
                                'header' => 'Bil.',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],
                            'lpgName',
                            [
                                'label' => 'Buang',
                                'value' => function ($model) {

                                    return Html::a('<i class="fa fa-trash-o"></i>', ['delete-lpg', 'id' => $model->id], [
                                        'class' => '',
                                        'data' => [
                                            'confirm' => 'Anda pasti untuk buang lpg ini?',
                                            'method' => 'post',
                                        ],


                                    ]);
                                },
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center', 'style' => 'width: 10%;'],
                            ],

                        ],

                        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                        'resizableColumns' => true,
                        'responsive' => false,
                        'responsiveWrap' => false,
                        'floatHeader' => true,
                        'floatHeaderOptions' => ['position' => 'absolute'],
                        'resizableColumnsOptions' => ['resizeFromBody' => true]

                    ]);
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
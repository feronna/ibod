<?php

use app\models\gaji\TblKumpulan;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\VarDumper;

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
                <?= Html::a('<i class="fa fa-plus"></i>&nbsp;Tambah Kumpulan', ['tambah-kumpulan'], ['class' => 'btn btn-primary']); ?>
                <br><br>
                <div class="table-responsive">
                    <?=
                    GridView::widget([
                        'options' => [
                            'class' => 'table-responsive',
                        ],
                        'dataProvider' => $dataProvider,
                        // 'filterModel' => true,
                        'columns' => [
                            [
                                'class' => 'kartik\grid\SerialColumn',
                                'header' => 'Bil.',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                            ],
                            'nama',
                            [
                                'label' => 'Status',
                                'value' => function ($model) {

                                    if ($model->status == 1) {
                                        return '<span class="label label-success">Aktif</span>';
                                    }

                                    return '<span class="label label-danger">Tidak Aktif</span>';
                                },
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center', 'style' => 'width: 10%;'],
                            ],
                            'create_dt:datetime',
                            [
                                'label' => 'Perincian',
                                'value' => function ($model) {
                                    return Html::a('<i class="fa fa-eye"></i>', ['senarai-lpg', 'id' => $model->id], ['class' => '']);
                                },
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center', 'style' => 'width: 10%;'],
                            ],
                            [
                                'label' => 'Kemaskini',
                                'value' => function ($model) {
                                    return Html::a('<i class="fa fa-pencil"></i>', ['update-kumpulan', 'id' => $model->id], ['class' => '']);
                                },
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center', 'style' => 'width: 10%;'],
                            ],
                            [
                                'label' => 'Buang',
                                'value' => function ($model) {

                                    return Html::a('<i class="fa fa-trash-o"></i>', ['delete-kumpulan', 'id' => $model->id], [
                                        'class' => '',
                                        'data' => [
                                            'confirm' => 'Anda pasti untuk buang kumpulan ini?',
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

<?php

// $test = TblKumpulan::findRole('890426495038', 'ENTRY');
$test2 = TblKumpulan::lpgListByRole('890426495037', 'ENTRY', true);

// var_dump($test);
VarDumper::dump( $test2, $depth = 10, $highlight = true);

?>
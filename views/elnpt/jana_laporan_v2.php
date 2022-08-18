<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\export\ExportMenu;
use app\models\elnpt\TblLppTahun;
use app\models\hronline\Department;

?>

<?= $this->render('_menuAdmin'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Jana Borang V2</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(['id' => 'search',  'method' => 'post', 'options' => ['class' => 'form-horizontal form-label-left']]); ?>

                <!-- <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Emel UMS</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?php
                        // $form->field($model, 'email')->textInput([
                        //     'placeholder' => 'Email UMS',
                        //     ])->label(false);
                        ?>
                    </div>
                </div> -->

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">J/F/P/I/U</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($model, 'jfpiu')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Department::find()->orderBy(['fullname' => SORT_ASC,])->all(), 'id', 'fullname'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Cari JFPIU',
                                //'class' => 'form-control col-md-7 col-xs-12',
                                //'id' => 'jenis_carian',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                        $form->field($model, 'tahun')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(TblLppTahun::find()->orderBy(['lpp_tahun' => SORT_ASC,])->all(), 'lpp_tahun', 'lpp_tahun'),
                            'hideSearch' => true,
                            'options' => [
                                'placeholder' => 'Pilih Tahun',
                                //'class' => 'form-control col-md-7 col-xs-12',
                                //'id' => 'jenis_carian',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Operator</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                        $form->field($model, 'range')->label(false)->widget(Select2::classname(), [
                            'data' => [
                                '>' => '>',
                                '<' => '<',
                                '=' => '=',
                                '>=' => '>=',
                                '<=' => '<=',
                                '!=' => '!=',
                            ],
                            'hideSearch' => true,
                            'options' => [
                                'id' => 'range',
                                'placeholder' => 'Operator',
                                //'class' => 'form-control col-md-7 col-xs-12',
                                //'id' => 'jenis_carian',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Markah Purata</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                        $form->field($model, 'purata')->textInput([
                            'placeholder' => 'Markah Purata',
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                        <?= Html::submitButton('Jana / Hantar', ['class' => 'btn btn-success']) ?>
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
                <h2><strong>Senarai Jana</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
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
                        'dataProvider' => $listDownloads,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'header' => 'BIL',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                //'attribute' => 'CONm',
                                'label' => 'NAMA',
                                'headerOptions' => ['class' => 'text-center'],
                                'attribute' => 'file_name',
                            ],
                            [
                                //'attribute' => 'CONm',
                                'label' => 'USER',
                                'headerOptions' => ['class' => 'text-center col-md-2'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->createUser->CONm;
                                }
                            ],
                            [
                                //'attribute' => 'CONm',
                                'label' => 'DATE CREATED',
                                'headerOptions' => ['class' => 'text-center col-md-2'],
                                'contentOptions' => ['class' => 'text-center'],
                                'attribute' => 'created_dt',
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'TINDAKAN',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'template' => '{download} {delete}',
                                //'header' => 'TINDAKAN',
                                'buttons' => [
                                    'download' => function ($url, $model) use ($uapi) {
                                        return Html::a('<span class="glyphicon glyphicon-download-alt"></span>', $uapi->DisplayFile($model->filehash, true), ['title' => 'Download']);
                                    },
                                    'delete' => function ($url, $model) {
                                        $url = Url::to(['elnpt/delete-file', 'filehash' => $model->filehash]);
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => 'Delete', 'data-confirm' => 'Adakah anda pasti?']);
                                    },
                                ],
                            ]
                        ],
                    ]);
                    ?>
                </div>

            </div>
        </div>
    </div>
</div>
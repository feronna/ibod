<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
//use \yiister\gentelella\widgets\grid\GridView; //use this one to called 'hover'
//use kartik\grid\GridView;
use app\models\myidp\Tahap;
use yii\helpers\ArrayHelper;
use kartik\detail\DetailView;
use yii\bootstrap\ActiveForm;
//use kartik\grid\GridView;
use app\models\myidp\Kategori;
use yii\grid\GridView; //this Yii2 Gridview cannot use 'hover'

error_reporting(0);

echo $this->render('/idp/_topmenu');

// the grid columns setup (only two column entries are shown here
// you can add more column entries you need for your use case)
$gridColumns = [
    [
        'class' => 'yii\grid\SerialColumn',
        'header' => 'Bil',
        // 'headerOptions' => ['class' => 'kartik-sheet-style'],
        // 'contentOptions' => ['class' => 'kartik-sheet-style'],
        // 'width' => '36px',
        // 'pageSummary' => 'Jumlah',
        // 'pageSummaryOptions' => ['colspan' => 6],


    ],
    [
        'label' => 'Jawatan',
        // 'hAlign' => 'center',
        // 'vAlign' => 'middle',
        'value' => function ($data) {
            return ucwords(strtoupper($data->jawatan->fname));
        }
    ],
    [
        'label' => 'Tahap',
        // 'hAlign' => 'center',
        // 'vAlign' => 'middle',
        'value' => function ($data) {
            return ucwords(strtolower($data->tahapKhidmat));
        }
    ],
    [
        'label' => 'Kategori',
        // 'hAlign' => 'center',
        // 'vAlign' => 'middle',
        'format' => 'raw',
        'value' => 'kategori.jenisKursus',
        // 'value' => function ($data) {
        //     return ucwords(strtolower($data->kategori->kategori_nama));
        // }
    ],
    // [
    //     'label' => 'Jumlah Sasaran',
    //     // 'hAlign' => 'center',
    //     // 'vAlign' => 'middle',
    //     'value' => function ($model) {
    //         return $model->SasaranAmount($model->gredJawatanID);
    //         //var_dump($model->StaffAmount($model->gredJawatanID));
    //     },
    // ],
    // [
    //     'label' => 'Jumlah Memohon',
    //     // 'hAlign' => 'center',
    //     // 'vAlign' => 'middle',
    //     'value' => function ($model) {
    //         return $model->PohonAmount($model->siriLatihanID, $model->gredJawatanID);
    //         //var_dump($model->StaffAmount($model->gredJawatanID));
    //     },
    // ],
    // [
    //     'label' => 'Jumlah Jemputan',
    //     'value' => function ($model) {
    //         return $model->JemputanAmount($model->siriLatihanID, $model->gredJawatanID);
    //         //var_dump($model->StaffAmount($model->gredJawatanID));
    //     },
    // ],
    // [
    //     'label' => 'Baki',
    //     // 'hAlign' => 'center',
    //     // 'vAlign' => 'middle',
    //     'format' => 'raw',
    //     'value' => function ($model) {
    //         $baki = $model->SasaranAmount($model->gredJawatanID) - ($model->PohonAmount($model->siriLatihanID, $model->gredJawatanID)) - ($model->JemputanAmount($model->siriLatihanID, $model->gredJawatanID));
    //         return $baki;
    //         //return $baki.' '.Html::a('JEMPUT', ["idp/view-senarai-jawatan?id='.$model->kursusLatihanID", 'id' => $model->kursusLatihanID], ['class' => 'btn btn-sm btn-primary']);
    //         //var_dump($model->StaffAmount($model->gredJawatanID));
    //     },
    // ],
    // [
    //     'label' => 'Tindakan',
    //     'format' => 'raw',
    //     'value' => function ($data) {
    //         return Html::a('JEMPUT', ["idp/jemput-latihan", 'id' => $data->siriLatihanID, 'gredJawatanID' => $data->gredJawatanID, 'tahap' => $data->tahap, 'kursusID' => $data->sasaran->sasaran3->kursusLatihanID, 'kategori' => $data->kategoriKursusID], ['class' => 'btn btn-sm btn-primary']);
    //         //Html::a("Refresh", ['site/index'], ['class' => 'btn btn-lg btn-primary']);
    //     },
    // ],
    [
        'label' => 'Tindakan',
        // 'hAlign' => 'center',
        // 'vAlign' => 'middle',
        'format' => 'raw',
        'value' => function ($data) {
            return Html::a(
                '<span class="glyphicon glyphicon-trash"></span>',
                'delete-sasaran?id=' . $data->sasaranID,
                [
                    'data' => [
                        'confirm' => 'Adakah anda pasti anda ingin menghapuskan rekod ini?',
                        'method' => 'post',
                    ],
                ],
                ['title' => Yii::t('app', 'Hapus'),]
            );
        },
    ],

];
?><?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5>Semakan Kursus <h3><span class="label label-success" style="color: white"><?= ucwords(strtolower($modelLatihan->sasaran3->tajukLatihan)) . ' Siri ' . ucwords(strtolower($modelLatihan->siri)) ?></span></h3>
                </h5>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5>Senarai Jawatan<h3><span class="label label-primary" style="color: white">Sasaran</span></h3>
                </h5>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php echo
                GridView::widget([
                    'dataProvider' => $dataProviderK,
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>TIADA DATA</b></i>'],
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumns,
                ]);
                ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5>Borang<h3><span class="label label-danger" style="color: white">Penetapan Sasaran</span></h3>
                </h5>
                <div class="clearfix"></div>
            </div>
        <div class="x_content">
            <div>
                <!-- ubah kat sini -->
                <?php
                //$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]);
                //$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]);
                $form = ActiveForm::begin([
                    'method' => 'get',
                    'action' => ['view-senarai-jawatan?id=' . $modelLatihan->siriLatihanID],
                ]);
                ?>
                <div class="form-group">
                    <label class="control-label col-md-12 col-sm-12 col-xs-12"><?= $form->field($kursusSasaran, 'siriLatihanID')->hiddenInput(['value' => $modelLatihan->siriLatihanID])->label(false); ?></label>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="id">Kategori:
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <?php

                        //use app\models\Kategori;
                        $kategori = Kategori::find()
                            ->orderBy("kategori_id")
                            ->all();

                        //use yii\helpers\ArrayHelper;
                        $listData2 = ArrayHelper::map($kategori, 'kategori_id', 'kategori_nama');

                        echo $form->field($kursusSasaran, 'kategoriKursusID')->dropDownList(
                            $listData2,
                            ['prompt' => 'Select...']
                        )->label(false)
                        ?>

                    </div>
                    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="id">Tahap:
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <?php

                        //use app\models\Tahap;
                        $tahap = Tahap::find()
                            ->orderBy("tahap_id")
                            ->all();

                        //use yii\helpers\ArrayHelper;
                        $listData2 = ArrayHelper::map($tahap, 'tahap_id', 'tahap_nama');

                        echo $form->field($kursusSasaran, 'tahap')->dropDownList(
                            $listData2,
                            ['prompt' => 'Select...']
                        )->label(false);
                        ?>

                    </div>
                </div>
                <?php
                Pjax::begin([
                    // PJax options
                ]);
                echo
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'header' => 'Bil',
                        ],
                        [
                            'label' => 'Kategori',
                            'attribute' => 'job_category',
                            'value' => 'jobCategoryy',
                            'filter'    => [1 => "AKADEMIK", 2 => "PENTADBIRAN"]
                        ],
                        //                        ['attribute' => 'gred',
                        //                            //'contentOptions' => ['style' => 'width:400px;'],
                        //                            'enableSorting' => true,
                        //                            'filterInputOptions' => [
                        //                                'class'       => 'form-control',
                        //                                'placeholder' => 'Sila taip gred dikehendaki...'
                        //                            ],
                        //                        ],
                        [
                            'attribute' => 'fname',
                            'enableSorting' => true,
                            'label' => 'Jawatan',
                            'filterInputOptions' => [
                                'class'       => 'form-control',
                                'placeholder' => 'Nama jawatan dikehendaki...'
                            ],
                        ],
                        [
                            'attribute' => 'gred_skim',
                            'filterInputOptions' => [
                                'class'       => 'form-control',
                                'placeholder' => 'Gred skim dikehendaki...'
                            ],
                            'label' => 'Skim',
                        ],
                        [
                            'attribute' => 'gred_no',
                            'filterInputOptions' => [
                                'class'       => 'form-control',
                                'placeholder' => 'Gred skim dikehendaki...'
                            ],
                            'label' => 'Gred Spesifik',
                        ],
                        [
                            'attribute' => 'min_gredjawatan',
                            'filterInputOptions' => [
                                'class'       => 'form-control',
                                'placeholder' => 'Nombor gred dikehendaki...'
                            ],
                            'label' => 'Gred Minimum',
                            'value' => 'gred_no'
                        ],
                        [
                            'attribute' => 'max_gredjawatan',
                            'filterInputOptions' => [
                                'class'       => 'form-control',
                                'placeholder' => 'Nombor gred dikehendaki...'
                            ],
                            'label' => 'Gred Maksimum',
                            'value' => 'gred_no'
                        ],
                        //                        [ 'attribute' => 'grade',
                        //                            'filterInputOptions' => [
                        //                                'class'       => 'form-control',
                        //                                'placeholder' => 'Nombor gred dikehendaki...'
                        //                            ],
                        //                            'label' => 'Gred',
                        //                        ],
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            //'header' => 'KLIK',
                            'name' => 'momo',
                            'checkboxOptions' => function ($model, $key, $index, $column) {
                                return ['value' => $model->id];
                            },
                        ],
                        //                        ['class' => 'yii\grid\CheckboxColumn',
                        //                            'header' => Html::checkBox('selection_all', false, ['class' => 'select-on-check-all','label' => 'Pilih Semua']),
                        ////                            'name' => 'momo',
                        //                            'checkboxOptions' => function ($model, $key, $index, $column){
                        //                                return ['value' => $model->id];                               
                        //                            },
                        //                        ],
                        [
                            'label' => 'Jumlah Staf',
                            'value' => function ($model) {
                                return $model->StaffAmount($model->id);
                            },
                        ],
                        //                        [
                        //                          'label' => 'Gred Jawatan',
                        //                            'attribute' => 'gredJawatan',
                        //                        ],
                        //                        [
                        //                          'label' => 'Jumlah Staf',
                        //                            'attribute' => 'count',
                        //                        ],
                    ],
                ]); //tutup Widget
                Pjax::end();
                /******************************** Use the code below to print out if have error **************************/
                //                        \yii\helpers\VarDumper::dump('gred',10,true);
                //                        exit();

                /*********************************************************************************************************/
                ?>
                <div class="form-group">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']); ?>
                        <?= Html::a('Kembali', ['form-tambah-siri?id=' . $modelLatihan->kursusLatihanID], ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div> <!-- ubah sini -->
        </div>
    </div>
</div>
</div>
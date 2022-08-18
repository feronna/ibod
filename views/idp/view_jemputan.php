<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use kartik\detail\DetailView;
use yii\helpers\Url;
use kartik\select2\Select2;
use app\models\hronline\Department;
use app\models\myidp\Kategori;

echo $this->render('/idp/_topmenu');

// setup your attributes
// DetailView Attributes Configuration
$attributes = [
    [
        'group'=>true,
        'label'=>'BAHAGIAN 1: Informasi Kursus Latihan',
        'rowOptions'=>['class'=>'table-info']
    ],
    [
        'columns' => [
            [
                'attribute'=>'kursusLatihanID', 
                'label'=>'Kursus Latihan #',
                'format'=>'raw', 
                'value'=>'<kbd>'.$modelLatihan->kursusLatihanID.'</kbd>',
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:100%']
            ],
        ],
    ],
    [
        'columns' => [
            [
                'attribute'=>'tajukLatihan',
                'value'=> ucwords(strtolower($modelLatihan->sasaran3->tajukLatihan)),
                'displayOnly'=>true,
                'type'=>DetailView::INPUT_TEXTAREA, 
                'options'=>['rows'=>4]
                //'valueColOptions'=>['style'=>'width:90%'],
            ],
        ],
    ],
    [
        'columns' => [ 
            [
                'attribute'=>'penggubalModul', 
                'label'=>'Pemilik Modul',
                'format'=>'raw', 
                'value'=>$modelLatihan->sasaran3->penggubalModul,
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:50%']
            ],
            [
                'label'=>'Tahun Tawaran', 
                'format'=>'raw',
                'value'=>'<span class="text-justify">' . $modelLatihan->sasaran3->tahunTawaran  . '</span>',
                'valueColOptions'=>['style'=>'width:50%']
            ],
        ],
    ],
//    [
//        'columns' => [ 
//            [   
//                'label' => 'Penceramah',
//                'format'=>'raw',
//                'value'=>Html::a(ucwords(strtolower($modelLatihan->penceramah->displayGelaran . ' ' . $modelLatihan->penceramah->CONm)), '#', ['class'=>'kv-author-link']),
////                'type'=>DetailView::INPUT_SELECT2, 
////                'widgetOptions'=>[
////                    'data'=>ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->orderBy('CONm')->asArray()->all(), 'ICNO', 'CONm'),
////                    'options' => ['placeholder' => 'Sila Pilih ...'],
////                    'pluginOptions' => ['allowClear'=>true, 'width'=>'100%'],
////                ],
//                'valueColOptions'=>['style'=>'width:50%']
//            ],
//            [
//                'label'=>'Kategori Jawatan', 
//                'format'=>'raw',
//                'value'=>'<span class="text-justify">' . $modelLatihan->kategoriJawatanID  . '</span>',
//                'valueColOptions'=>['style'=>'width:50%']
//            ],
//        ],
//    ],
    [
        'group'=>true,
        'label'=>'BAHAGIAN 2: Informasi Siri Latihan',
        'rowOptions'=>['class'=>'table-info'],
        //'groupOptions'=>['class'=>'text-center']
    ],
    [
        'columns' => [
            [
                'attribute'=>'siriLatihanID', 
                'label'=>'Siri Latihan ID',
                'format'=>'raw', 
                'value'=>'<kbd>'.$modelLatihan->siriLatihanID.'</kbd>',
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:50%']
            ],
            [
                'attribute'=>'siri', 
                'label'=>'Siri Latihan #',
                'format'=>'raw', 
                'value'=>'<kbd>'.$modelLatihan->siri.'</kbd>',
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:50%']
            ],
        ],
    ],
    [
        'columns' => [
            [
                'attribute'=>'lokasi',
                'value'=> ucwords(strtolower($modelLatihan->lokasi)),
                'displayOnly'=>true,
                'type'=>DetailView::INPUT_TEXTAREA, 
                'options'=>['rows'=>4]
                //'valueColOptions'=>['style'=>'width:90%'],
            ],
        ],
    ],
    [
        'columns' => [
            [
                'attribute'=>'tarikhMula',
                'value' => $modelLatihan->tarikhMula,
//                'value'=> function ($model){               
//                                if (($model->tarikhMula != null) && ($model->tarikhMula != 0000-00-00)){
//                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
//                                    $formatteddate = $myDateTime->format('d-m-Y');
//                                } else {
//                                    $formatteddate = '<em><b>TIADA DATA</b></em>';
//                                } 
//                                return $formatteddate;
//                            },
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:50%']
            ],
            [
                'attribute'=>'tarikhAkhir',
                'value' => $modelLatihan->tarikhAkhir,
//                'value'=> function ($model){               
//                                if (($model->tarikhMula != null) && ($model->tarikhMula != 0000-00-00)){
//                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
//                                    $formatteddate = $myDateTime->format('d-m-Y');
//                                } else {
//                                    $formatteddate = '<em><b>TIADA DATA</b></em>';
//                                } 
//                                return $formatteddate;
//                            },
                'displayOnly'=>true,
                'valueColOptions'=>['style'=>'width:50%']
            ],
        ],
    ],
    [
        'columns' => [
            [
                'label'=>'Sinopsis Kursus',
                'format'=>'raw',
                'value'=>'<span class="text-justify"><em>' . $modelLatihan->sasaran3->sinopsisKursus  . '</em></span>',
                'type'=>DetailView::INPUT_TEXTAREA, 
                'options'=>['rows'=>4]
            ],
        ],
    ],
];
?><?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>
<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-info-circle"></i> Maklumat Kursus</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        
            <?=
                // View file rendering the widget
                DetailView::widget([
                    'model' => $modelLatihan,
                    'attributes' => $attributes,
                    'mode' => 'view',
                    'bordered' => true,
                    'striped' => true,
                    'condensed' => true,
                    'responsive' => true,
                    'hover' => true,
                    'hAlign' => 'right',
                    'vAlign' => 'middle',
                    'fadeDelay' => 1,
//                    'panel' => [
//                        'type' => 'info', 
//                        'heading' => 'Butir-Butir Latihan',
//                        //'footer' => '<div class="text-center text-muted">This is a sample footer message for the detail view.</div>'
//                    ],
                    'buttons1' => false,
                    'deleteOptions'=>[ // your ajax delete parameters
                        'params' => ['id' => $modelLatihan->siriLatihanID, 'kvdelete'=>true],
                    ],
                    'container' => ['id'=>'kv-demo'],
                    'formOptions' => ['action' => Url::current(['#' => 'kv-demo'])] // your action to delete
                ]);
                
            ?>
        </div>
    </div>
</div>

<div class="row"> 
    <div class="x_panel">      
        <div class="x_title">
            <h2><strong><i class="fa fa-plus-circle"></i> Jemputan Kursus</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'emptyText' => 'Tiada data ditemui.',
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                'header' => 'Bil'],

            //'jemputanID',
            //'siriLatihanID',
            'jabatan.shortname',
            [
                'label' => 'Kategori Jawatan',
                'format' => 'raw',
                'value' => 'jobCategoryy',
            ],
            [
                'label' => 'Jenis Kursus',
                'format' => 'raw',
                'value' => 'kategoriKursus.jenisKursus',
            ],
            //['class' => 'yii\grid\ActionColumn'],
            [
                'label' => 'Hapus',
                'format' => 'raw',
                'value'=> function ($data){
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'delete-jemputan?id='.$data->jemputanID,
                                          ['data' => [
                                              'confirm' => 'Adakah anda pasti anda ingin menghapuskan rekod ini?',
                                              'method' => 'post',
                                              ],
                                          ],
                                          ['title' => Yii::t('app', 'Hapus'),]);
                          },
            ],
        ],
    ]); ?>
        </div>
    </div>
</div>

<div class="row"> 
    <div class="x_panel">      
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Tambah Jemputan Siri</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pilih Jabatan :
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= 
                                $form->field($model, 'deptID')->label(false)->widget(Select2::classname(),
                                    [
    //                                    'data' => [
    //                                        '1' => 'Agensi Luar (External Agencies)',
    //                                        '2' => 'UMS (JFPIU/Persatuan/Kesatuan/Kelab)'
    //                                        ],
                                        'data' => ArrayHelper::map(Department::find()->all(), 'id', 'shortname'),
                                        'options' => [
                                            'placeholder' => 'Jabatan',
                                            ],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                            'multiple' => false
                                            ],
                                        'theme' => Select2::THEME_CLASSIC,
                                    ]); 
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pilih Kategori :
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= 
                            $form->field($model, 'jobCategory')->label(false)->widget(Select2::classname(),
                                [
//                                    'data' => [
//                                        '1' => 'Agensi Luar (External Agencies)',
//                                        '2' => 'UMS (JFPIU/Persatuan/Kesatuan/Kelab)'
//                                        ],
                                    'data' =>  [2 => "PENTADBIRAN", 1 => "AKADEMIK", 3 => "AKADEMIK & PENTADBIRAN"],
                                    'options' => [
                                        'placeholder' => 'Kategori',
                                        ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'multiple' => false
                                        ],
                                    'theme' => Select2::THEME_CLASSIC,
                                ]); 
                        ?>
                    </div>
                    </div>
                    <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pilih Jenis Kursus :
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= 
                            $form->field($model, 'kategoriKursusID')->label(false)->widget(Select2::classname(),
                                [
//                                    'data' => [
//                                        '1' => 'Agensi Luar (External Agencies)',
//                                        '2' => 'UMS (JFPIU/Persatuan/Kesatuan/Kelab)'
//                                        ],
                                    'data' => ArrayHelper::map(Kategori::find()->all(), 'kategori_id', 'kategori_nama'),
                                    'options' => [
                                        'placeholder' => 'Jenis Kursus',
                                        ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'multiple' => false
                                        ],
                                    'theme' => Select2::THEME_CLASSIC,
                                ]); 
                        ?>
                    </div>
                    </div>

                
            <div class="form-group" align="right" >
                    <?= Html::submitButton(' Hantar', ['class' => 'btn btn-primary','name' => 'search', 'value' => 'submit_1']) ?>
                </div>
<?php ActiveForm::end(); ?>
            </div>
    </div>
</div>



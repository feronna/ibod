<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\select2\Select2;
use app\models\hronline\Campus;
use app\models\hronline\Department;

echo $this->render('/idp/_topmenu');

error_reporting(0);

$gridColumnsP = [
                                ['class' => 'kartik\grid\SerialColumn',
                                    'header' => 'Bil',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                ],
                                ['class' => 'yii\grid\ActionColumn',
                                    'header' => 'Nama',
                                    //'headerOptions' => ['style' => 'color:#337ab7'],
                                    'template' => '{view}',
                                    'buttons' => [
                                      'view' => function ($url, $model) {
                                          return Html::a($model->biodata->CONm, $url, [
                                                      'title' => Yii::t('app', 'Papar Profil'),
                                                      'data-pjax' => 0,
                                                      'target' => "_blank",
                                          ]);
                                      },
                                    ],
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                      if ($action === 'view') {
                                          $url ='profil?staffChosen='.$model->icno;
                                          return $url;
                                      }
                                    }
                                ],
                                [
                                    'label' => 'Gred',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => 'biodata.jawatan.gred',
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'JFPIU',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'left',
                                    'format' => 'raw',
                                    'value' => 'biodata.department.shortname',
                                    'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Kampus',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'left',
                                    'format' => 'raw',
                                    'value' => function ($model){return strtoupper($model->biodata->kampus->campus_name); },
                                    'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
                                ],
                                [
                                    'header' => 'Mata Min <br>Kumpulan',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => 'idp_mata_min',
                                    'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Wajib Teras Universiti',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function ($model){return '('.$model->idp_mata_teras_uni.'/'.$model->idp_kom_teras_uni.')'; },
                                    'contentOptions' => ['style' => 'width:80px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Wajib Teras Skim',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function ($model){return '('.$model->idp_mata_teras_skim.'/'.$model->idp_kom_teras_skim.')'; },
                                    'contentOptions' => ['style' => 'width:80px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Elektif',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function ($model){return '('.$model->idp_mata_elektif.'/'.$model->idp_kom_elektif.')'; },
                                    'contentOptions' => ['style' => 'width:80px; white-space: normal;'],
                                ],
                                [
                                    'header' => 'Jumlah Mata <br> Diambil Kira',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => 'jum_mata_dikira',
                                    'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Baki',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => 'bakii',
                                    'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                                ],
                            ];
                                    
$gridColumnsA = [
                                ['class' => 'kartik\grid\SerialColumn',
                                    'header' => 'Bil',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                ],
                                [
                                    'label' => 'Nama',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'left',
                                    'format' => 'raw',
                                    'value' => 'biodata.CONm',
                                    'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Gred',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => 'biodata.jawatan.gred',
                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'JFPIU',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'left',
                                    'format' => 'raw',
                                    'value' => 'biodata.department.shortname',
                                    'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Kampus',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'left',
                                    'format' => 'raw',
                                    'value' => function ($model){return strtoupper($model->biodata->kampus->campus_name); },
                                    'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
                                ],
                                [
                                    'header' => 'Mata Min <br> Kumpulan',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => 'mataMinKump',
                                    'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Teras',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => function ($model){return '('.$model->idp_mata_teras.'/'.$model->idp_kom_teras.')'; },
                                    'contentOptions' => ['style' => 'width:80px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Elektif',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'headerOptions' => [
//                                        'colspan' => '2', 
//                                    ],
                                    'value' => function ($model){return '('.$model->idp_mata_elektif.'/'.$model->idp_kom_elektif.')'; },
                                    'contentOptions' => ['style' => 'width:80px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Umum',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
//                                    'headerOptions' => [
//                                        'colspan' => '2', 
//                                    ],
                                    'value' => function ($model){return '('.$model->idp_mata_umum.'/'.$model->idp_kom_umum.')'; },
                                    'contentOptions' => ['style' => 'width:80px; white-space: normal;'],
                                ],
                                [
                                    'header' => 'Jumlah Mata <br> Diambil Kira',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => 'jum_mata_dikira',
                                    'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                                ],
                                [
                                    'label' => 'Baki',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                    'format' => 'raw',
                                    'value' => 'bakii',
                                    'contentOptions' => ['style' => 'width:40px; white-space: normal;'],
                                ],
                            ];
?>
<!---- Hide previous modal screen ---->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#modal").on('hidden.bs.modal', function(){
        $('#modalContent').empty();
  });
    });
</script>
<!--- /Hide previous modal screen ---->
<style>
a:link {
  color: green;
  background-color: transparent;
  text-decoration: none;
}
a:visited {
  color: indigo;
  background-color: transparent;
  text-decoration: none;
}
a:hover {
  color: red;
  background-color: transparent;
  text-decoration: underline;
}
a:active {
  color: yellow;
  background-color: transparent;
  text-decoration: underline;
}
</style>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Senarai Rekod Pencapaian Mata IDP Staf</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                
 <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2>Carian</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content <?= Yii::$app->request->queryParams? collapse:''?>">
                <?php
                $forms = ActiveForm::begin([
                            'action' => ['index-laporan'],
                            'method' => 'get',
                            'options' => [
                                'data-pjax' => 1, 
                                'class' => 'disable-submit-buttons'
                            ],

                ]);
                ?>
<!--                <div class="form-group">
                <?php
//                DatePicker::widget([
//                    'name' => 'tahun',
//                    'value' => Yii::$app->request->queryParams['tahun'],
//                    'type' => DatePicker::TYPE_INPUT,
//                    'options' => ['placeholder' => 'Tahun'],
//                    'pluginOptions' => [
//                        'autoclose'=>true,
//                        'format' => 'yyyy',
////                        'viewMode' => "years", 
//                        'minViewMode'=> "years"
//                    ]
//                ]);
                ?>
                </div>-->
                <div class="form-group">
                    <?= Select2::widget([
                        'name' => 'kampus',
                        'value' => Yii::$app->request->queryParams['kampus'],
                        'data' => ArrayHelper::map(Campus::find()->all(), 'campus_id', 'campus_name'),
                        'options' => [
                            'allowClear' => true,
                            'placeholder' => 'Kampus',
                        ],
                    ]);?>
                    <div class="help-block"></div>
                </div>
                <div class="form-group">
                 <?= Select2::widget([
                        'name' => 'job_category',
                        'value' => Yii::$app->request->queryParams['job_category'],
                        'data' =>  [1 => "Akademik", 2 => "Pentadbiran"],
                        'options' => [
                            'allowClear' => true,
                            'placeholder' => 'Kategori Jawatan'
                        ],
                    ]);?>
                </div>
                <div class="form-group">
                    <?= Select2::widget([
                        'name' => 'department',
                        'value' => Yii::$app->request->queryParams['department'],
                        'data' => ArrayHelper::map(Department::find()->all(), 'id', 'shortname'),
                        'options' => [
                            'allowClear' => true,
                            'placeholder' => 'JFPIU',
                        ],
                    ]);?>
                    <div class="help-block"></div>
                </div>

         
                <div class="form-group">
                    <p align="right">
                    <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Cari', ['class' => 'btn btn-primary','name' => 'search', 'value' => 'submit_1']) ?>
                    </p>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
                
                
                
                
                
<?php if(Yii::$app->request->queryParams) { ?>

                
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Staf Pentadbiran</h2>
                <div  class="pull-right">
                <?=
                ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumnsP,
                    'filename' => 'laporan_myidp_pentadbiran_'.date('Y-m-d'),
                    'clearBuffers' => true,
                    'stream' => false,
                    'folder' => '@app/web/files/myidp/.',
                    'linkPath' => '/files/myidp/',
                    'batchSize' => 10,
    //                'deleteAfterSave' => true
                ]); 
                ?>
                </div>
                <div class="clearfix"></div>    
        </div>
            <div class="x_content">
               <?= 
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'emptyText' => 'Tiada data ditemui.',
                            'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b> - </b></i>'], 
                            'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                            'columns' => $gridColumnsP,
                        ]); ?> 
            </div> <!-- x_content -->
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Staf Akademik</h2>
                <div  class="pull-right">
                <?=
                ExportMenu::widget([
                    'dataProvider' => $dataProvider2,
                    'columns' => $gridColumnsA,
                    'filename' => 'laporan_myidp_akademik_'.date('Y-m-d'),
                    'clearBuffers' => true,
                    'stream' => false,
                    'folder' => '@app/web/files/myidp/.',
                    'linkPath' => '/files/myidp/',
                    'batchSize' => 10,
    //                'deleteAfterSave' => true
                ]); 
                ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider2,
                            //'filterModel' => $kursusJemputan,
                            'emptyText' => 'Tiada data ditemui.',
                            'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b> - </b></i>'], 
                            'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                            'columns' => $gridColumnsA,
                        ]); 
                 ?> 
            </div> <!-- x_content -->
        </div>
    </div>
</div>

<?php } ?>


            </div> <!-- x_content -->
        </div>
    </div>
</div>
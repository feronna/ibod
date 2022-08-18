<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Fruit */

error_reporting(0);

echo $this->render('/idp/_topmenu');
                          
$gridColumnsPenceramah = [
            [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions'=>['class'=>'kartik-sheet-style'],
                'width'=>'36px',
                'pageSummary'=>'Total',
                'pageSummaryOptions' => ['colspan' => 6],
                'header' => 'Bil',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                
            ],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                // uncomment below and comment detail if you need to render via ajax
                // 'detailUrl' => Url::to(['/site/book-details']),
                'detail' => function ($model, $key, $index, $column) {
                    return Yii::$app->controller->renderPartial('view_penceramah', ['model' => $model]);
                },
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'expandOneOnly' => true
            ],
            [
                'label' => 'Nama',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtolower($data->penceramah->displayGelaran)).' '.ucwords(strtolower($data->penceramah->CONm));
                            }
            ],
            [
                'label' => 'Jawatan Disandang',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtolower($data->penceramah->jawatan->nama)).' ('.ucwords(strtoupper($data->penceramah->jawatan->gred)).')';
                            }
            ],
            [
                'label' => 'JAFPIB',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtoupper($data->penceramah->department->shortname));
                            }
            ],
            [
                'label' => 'Tindakan',
                'format' => 'raw',
                'value'=> function ($data){
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'delete-penceramah?siriID='.$data->siriLatihanID.'&penceramahID='.$data->penceramahID,
                                          ['data' => [
                                              'confirm' => 'Adakah anda pasti anda ingin menghapuskan rekod penceramah ini?',
                                              'method' => 'post',
                                              ],
                                          ],
                                          ['title' => Yii::t('app', 'Batal'),]
                                          
                                    );
                          },
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
];
                          
$gridColumnsPenceramahLuar = [
            [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions'=>['class'=>'kartik-sheet-style'],
                'width'=>'36px',
                'pageSummary'=>'Total',
                'pageSummaryOptions' => ['colspan' => 6],
                'header' => 'Bil',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
                
            ],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                // uncomment below and comment detail if you need to render via ajax
                // 'detailUrl' => Url::to(['/site/book-details']),
                'detail' => function ($model, $key, $index, $column) {
                    return Yii::$app->controller->renderPartial('view_penceramah', ['model' => $model, 'id' => '1']);
                },
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'expandOneOnly' => true
            ],
            [
                'label' => 'Nama',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtolower($data->penceramahluar->penceramah_title)).' '.ucwords(strtolower($data->penceramahluar->penceramah_name));
                            }
            ],
            [
                'label' => 'Agensi',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtoupper($data->penceramahluar->agensi));
                            }
            ],
            [
                'label' => 'Emel',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtoupper($data->penceramahluar->email));
                            }
            ],
            [
                'label' => 'No Tel',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                
                            if ($data->penceramahluar->office_number){
                                $a = '<span class="glyphicon glyphicon-phone-alt"></span> '.$data->penceramahluar->office_number;
                            }
                            
                            if ($data->penceramahluar->mobile_number){
                                $b = '<span class="glyphicon glyphicon-phone"></span> '.$data->penceramahluar->mobile_number;
                            }
                            
                            return $a.'<br>'.$b;
                            }
            ],
            [
                'label' => 'Tindakan',
                'format' => 'raw',
                'value'=> function ($data){
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'delete-penceramah?siriID='.$data->siriLatihanID.'&penceramahID='.$data->penceramahID,
                                          ['data' => [
                                              'confirm' => 'Adakah anda pasti anda ingin menghapuskan rekod penceramah ini?',
                                              'method' => 'post',
                                              ],
                                          ],
                                          ['title' => Yii::t('app', 'Batal'),]
                                          
                                    );
                                    
//                                    .' | '.
//                                    Html::a('<span class="glyphicon glyphicon-pencil"></span>', 'view-penceramah?siriID='.$data->siriLatihanID.'&penceramahID='.$data->penceramahID,
//                                          ['title' => Yii::t('app', 'Papar'),]
//                                          
//                                    );
                          },
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
];

?>
<script>
    $(function(){
    
    $('.mapBtn').click(function (){
       $('#modal').modal('show')
               .find('#modalContent')
               .load($(this).attr('value'));
    });
    
    
    
});
</script>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h5>Semakan Kursus <h3><span class="label label-danger" style="color: white"><?= ucwords($model->sasaran3->tajukLatihan).' Siri '.ucwords(strtolower($model->siri)) ?></span></h3></h5>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">    
        <div class="x_title">
            <h5>Senarai Penceramah
                <h3>
                    <span class="label label-success" style="color: white">Dalaman</span>
                    
                    <?php
//                    ExportMenu::widget([
//                            'dataProvider' => $dataProviderKehadiran,
//                            'columns' => $gridColumnsPesertaExport,
//                            'filename' => 'Kehadiran Kursus '.ucwords(strtolower($model->sasaran3->tajukLatihan)).' (Siri '.$model->siri.' - Slot '.$modelSlot->slot.')',
//                            'clearBuffers' => true,
//                            'stream' => false,
//                            'folder' => '@app/web/files/myidp/.',
//                            'linkPath' => '/files/myidp/',
//                            'batchSize' => 10,
//                        ]); 
                    ?>
                
                </h3>
                
            </h5>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    //'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsPenceramah,
//                    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
//                    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
//                    'filterRowOptions' => ['class' => 'kartik-sheet-style'],
//                    'pjax' => true, // pjax is set to always true for this demo
//                    // set your toolbar
//                    'toolbar' =>  [
//                        [
//                            'content' =>
//                                Html::button('<i class="fas fa-plus"></i>', [
//                                    'class' => 'btn btn-success',
//                                    'title' => Yii::t('kvgrid', 'Add Book'),
//                                    'onclick' => 'alert("This will launch the book creation form.\n\nDisabled for this demo!");'
//                                ]) . ' '.
//                                Html::a('<i class="fas fa-redo"></i>', ['grid-demo'], [
//                                    'class' => 'btn btn-outline-secondary',
//                                    'title'=>Yii::t('kvgrid', 'Reset Grid'),
//                                    'data-pjax' => 0, 
//                                ]), 
//                            'options' => ['class' => 'btn-group mr-2']
//                        ],
//                        '{export}',
//                        '{toggleData}',
//                    ],
//                    'toggleDataContainer' => ['class' => 'btn-group mr-2'],
//                    // set export properties
//                    'export' => [
//                        'fontAwesome' => true
//                    ],
//                    // parameters from the demo form
//                    'bordered' => true,
//                    'striped' => true,
//                    'condensed' => true,
//                    'responsive' => true,
//                    'hover' => true,
//                    'showPageSummary' => true,
//                    'panel' => [
//                        'type' => GridView::TYPE_PRIMARY,
//                        'heading' => '<i class="fas fa-user"></i>  Peserta Slot',
//                    ],
//                    'persistResize' => false,
//                    'toggleDataOptions' => ['minCount' => 10],
//                    //'exportConfig' => $exportConfig,
//                    'itemLabelSingle' => 'book',
//                    'itemLabelPlural' => 'books'
                ]);
            ?>
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
            <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12"></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                 <?php echo
                 $form->field($aksesbaru, 'penceramahID')->label(false)->widget(Select2::classname(), [
                                'name' => 'first',
                                'data' => $allBiodata,
                                'options' => ['placeholder' => 'Sila pilih...', 'default' => 0],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                               
                            ]); 
                 ?>
            
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12">
                <?= Html::submitButton('Tambah Penceramah', ['class' => 'btn btn-success', 'name' => 'submit', 'value' => '0']) ?>
            </div>
            </div>

            <?php ActiveForm::end();?>
        </div>
    </div>
</div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h5>Senarai Penceramah
                <h3>
                    <span class="label label-primary" style="color: white">Luar</span>
                    
                    <?php
//                    ExportMenu::widget([
//                            'dataProvider' => $dataProviderKehadiran,
//                            'columns' => $gridColumnsPesertaExport,
//                            'filename' => 'Kehadiran Kursus '.ucwords(strtolower($model->sasaran3->tajukLatihan)).' (Siri '.$model->siri.' - Slot '.$modelSlot->slot.')',
//                            'clearBuffers' => true,
//                            'stream' => false,
//                            'folder' => '@app/web/files/myidp/.',
//                            'linkPath' => '/files/myidp/',
//                            'batchSize' => 10,
//                        ]); 
                    ?>
                </h3>
            </h5>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?=
                GridView::widget([
                    'dataProvider' => $dataProvider2,
                    //'filterModel' => $searchModel,
                    //'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumnsPenceramahLuar,
                ]);
            ?>
            <?php $forms = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
            <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12"></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                 <?php
//                 $forms->field($aksesbaru2, 'penceramahID')->label(false)->widget(Select2::classname(), [
//                                'name' => 'second',
//                                'data' => $allPenceramahLuar,
//                                'options' => ['placeholder' => 'Sila pilih nama', 'default' => 0],
//                                'pluginOptions' => [
//                                    'allowClear' => true
//                                ],
//                               
//                            ]); 
                 ?>
                <?= 
                    // With a model and without ActiveForm
                    Select2::widget([
                        'name' => 'addPenceramahLuar',
                        'data' => $allPenceramahLuar,
                        'options' => ['placeholder' => 'Sila pilih...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'multiple' => false,
                        ],
                    ]);
                    ?>
            
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12">
                <?= Html::submitButton('Tambah Penceramah', ['class' => 'btn btn-success', 'name' => 'submit', 'value' => '1']) ?>
            </div>
            <div>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button>
            </div>
            </div>

            <?php ActiveForm::end();?>
            
            <!---->
            <?php $formk = ActiveForm::begin([
                        'method' => 'post',
                        'action' => ['view-senarai-penceramah?id='.$model->siriLatihanID],
                        'options' => ['class' => 'form-horizontal form-label-left'],
                    ]);
                ?>
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body">
                                  <div class="form-group">
                                      
                                    <div class="latihan-form"> 
    <div class="col-md-12"> 
        <div class="x_panel">
                <div class="x_title">
                    <h2>Borang Daftar Penceramah Baru</h2> 
                    <div class="clearfix"></div>
                </div>
            <div class="x_content">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kod">NO KP/ NO Pasport: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $formk->field($model2, 'penceramah_id')->textInput(['maxlength' => true, 'style' => 'text-transform:capitalize'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Nama: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $formk->field($model2, 'penceramah_name')->textInput(['maxlength' => true, 'style' => 'text-transform:capitalize'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Biodata: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $formk->field($model2, 'penceramah_bio')->textarea(['rows' => '6'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                    </div>    
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Emel: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $formk->field($model2, 'email')->textInput(['maxlength' => true, 'type' => 'email'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">No Tel Pejabat: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $formk->field($model2, 'office_number')->textInput(['maxlength' => true, 'style' => 'text-transform:capitalize'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">No Tel Bimbit: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $formk->field($model2, 'mobile_number')->textInput(['maxlength' => true, 'style' => 'text-transform:capitalize'], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <?= Html::resetButton('Batal', ['class' => 'btn btn-primary']) ?>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success', 'name' => 'submit', 'value' => '2']) ?>
                </div>
                
       </div>
        </div>
    </div>
</div>
                                  
                              </div>
                              <div class="modal-footer">
                              </div>
                            </div>

                          </div>
                        </div>
                
                </div>
            <?php ActiveForm::end();?> 
        </div>
    </div>
</div>
</div>

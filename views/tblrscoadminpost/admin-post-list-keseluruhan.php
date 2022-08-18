<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
error_reporting(0); 
?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Papar Lantikan Keseluruhan</strong></h2>
<!--                <p align="right"><= \yii\helpers\Html::a('Kembali', ['halaman-utama-keseluruhan'], ['class' => 'btn btn-primary']) ?></p>   -->
                <div class="clearfix"></div>
            </div>
            <?= Html::a('<div style="float: right; font-size:18px;"><i class="text-success fa fa-download"></i> Muat Turun</div>', ['reportlantikankeseluruhan', 'icno' => Yii::$app->request->queryParams['icno'], 'adminpos_id' => Yii::$app->request->queryParams['adminpos_id'], 'program_id' => Yii::$app->request->queryParams['program_id'], 'dept_id' => Yii::$app->request->queryParams['dept_id'], 'campus_id' => Yii::$app->request->queryParams['campus_id'], 'flag' => Yii::$app->request->queryParams['flag']]) ?>
            <div class="x_content">

                <div class="table-responsive">
                    <?=
                        GridView::widget([
                        'options' => [
                        'class' => 'table-responsive'
                        ],
                        'dataProvider' => $dataProvider,
                        'filterModel' => true,
                        //'summary' => '',
                        //'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                        //'filterModel' => $searchModel,
                        'columns' => [
                             
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil.',
                            'vAlign' => 'middle',
                            'hAlign' => 'center'
                        ],
  
                        [
                            'format' => 'raw',
                            'label' => 'Nama Penyandang',
                            'value' => function($data){
                            return Html::a($data->kakitangan->CONm, ["lihat-rekod-lantikan", 'id' => $data->id], ['target' => '_blank']);
                            },
                            'filter' => Select2::widget([
                                'name' => 'icno',
                                'value' => $icno,
                                'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->all(), 'ICNO', 'kakitangan.CONm'),
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]),
                            'contentOptions' => ['style' => 'text-decoration: underline;'],
                            'vAlign' => 'middle',
                            'hAlign' => 'center'
                        ],
                                
                        [
                            'label' => 'Jawatan Hakiki',
                            'value' => 'kakitangan.jawatan.fname',
                            'vAlign' => 'middle',
                            'hAlign' => 'center'
                        ],
                                   
                        [
                            'label' => 'Jawatan Pentadbiran',
                            'value' => 'adminpos.position_name',
                            'filter' => Select2::widget([
                                'name' => 'adminpos_id',
                                'value' => $adminpos_id,
                                //'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->joinWith('adminpos')->where(['flag' => '1'])->orderBy(['position_type' => SORT_ASC, 'adminpos_id' => SORT_ASC])->all(), 'adminpos_id', 'adminpos.ref_position_name'),
                                'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->joinWith('adminpos')->orderBy(['position_type' => SORT_ASC, 'adminpos_id' => SORT_ASC])->all(), 'adminpos_id', 'adminpos.ref_position_name'),
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => ['allowClear' => true],
                            ]),
                            'vAlign' => 'middle',
                            'hAlign' => 'center'
                        ],
                                
                        [
                            'label' => 'Program Pengajaran',
                            'value' => 'program.NamaProgram',
                            'filter' => Select2::widget([
                                'name' => 'program_id',
                                'value' => $program_id,
                                'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->all(), 'program_id', 'program.NamaProgram'),
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => ['allowClear' => true  ],
                            ]),
                            'vAlign' => 'middle',
                            'hAlign' => 'center'
                        ],
                            
                        [
                            'label' => 'Catatan',
                            'value' => 'description',
                            'vAlign' => 'middle',
                            'hAlign' => 'center'
                        ],  
                                
                                
                        [
                            'label' => 'JAFPIB',
                            'value' => 'dept.fullname',
                                'filter' => Select2::widget([
                                'name' => 'dept_id',
                                'value' => $dept_id,
                                'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->orderBy(['dept_id' => SORT_ASC])->all(), 'dept_id', 'dept.fullname'),
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => ['allowClear' => true ],
                            ]),
                            'vAlign' => 'middle',
                            'hAlign' => 'center'
                        ],    
                                     
                        [
                            'label' => 'Kampus',
                            'value' => 'campus.campus_name',
                                'filter' => Select2::widget([
                                'name' => 'campus_id',
                                'value' => $campus_id,
                                'data' => ArrayHelper::map(\app\models\hronline\Tblrscoadminpost::find()->orderBy(['campus_id' => SORT_ASC])->all(), 'campus_id', 'campus.campus_name'),
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]),
                            'vAlign' => 'middle',
                            'hAlign' => 'center'
                        ],           
                                
                        [
                            'label' => 'Tarikh Kuatkuasa',
                            'attribute' => 'tarikhmula',
                            'vAlign' => 'middle',
                            'hAlign' => 'center'
                        ],            
                                
                        [
                            'label' => 'Tarikh Tamat',
                            'attribute' => 'tarikhtamat',
                            'vAlign' => 'middle',
                            'hAlign' => 'center'
                        ],  
                                    
                        [
                            'label' => 'Ulasan',
                            'value' => 'ulasan',
                            'vAlign' => 'middle',
                            'hAlign' => 'center'
                        ],  
                                
                        [
                            'header' => 'Status',
                            'attribute' => 'displayflag.flagstatus',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'filter' => Select2::widget([
                                'name' => 'flag',
                                'value' => $flag,
                                'data' => ['0'=>'<span class="label label-warning">Belum Disahkan</span>',
                                    '1' => '<span class="label label-success">Aktif</span>',
                                    '2' => '<span class="label label-danger">Tidak Aktif</span>'],
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                ],
                            ]),
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
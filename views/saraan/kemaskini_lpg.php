<?php
/* @var $this yii\web\View */

use yii\bootstrap\Alert;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\db\Expression;
use yii\helpers\Html;

$js = <<<SCRIPT
/* To initialize BS3 tooltips set this below */
$(function () { 
    $("[data-toggle='tooltip']").tooltip(); 
});;
/* To initialize BS3 popovers set this below */
$(function () { 
    $("[data-toggle='popover']").popover(); 
});
SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);

?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Kemaskini LPG</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php
                    echo DetailView::widget([
                        'model' => $model,
                        'attributes' => [
//                            'title',               // title attribute (in plain text)
//                            'description:html',    // description attribute in HTML
                            [                      // the owner name of the model
                                'label' => 'Nama',
                                'value' => (is_null($model->staf->gelaran) ? '' : strtoupper($model->staf->gelaran->Title).' ').$model->staf->CONm
                            ],
                            [                      // the owner name of the model
                                'label' => 'KP / Pasport',
                                'value' => $model->staf->ICNO
                            ], 
                            [                      // the owner name of the model
                                'label' => 'Jawatan',
                                'value' => $model->staf->jawatan->fname
                            ],
                            [                      // the owner name of the model
                                'label' => 'JSPIU',
                                'value' => $model->staf->department->fullname
                            ],
                            [                      // the owner name of the model
                                'label' => 'Pengesahan (Oleh)',
                                'value' => is_null($model->pengesah) ? '' : $model->pengesah->CONm,
                            ],
                            [                      // the owner name of the model
                                'label' => 'Jumlah LPG (RM)',
                                'value' => is_null($model->t_lpg_amount) ? '' : Yii::$app->formatter->asDecimal($model->t_lpg_amount)
                            ],
//                            'created_at:datetime', // creation date formatted as datetime
                        ],
                    ]);
                    
                    ?>
                </div>
                
                <div class="row">
                    <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
                    <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>
                
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Gaji Pokok (RM)</label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <?=
                                $form->field($model, 't_lpg_amount')->textInput([
    //                                'placeholder' => 'Jam Kredit',
                                    ])->label(false);
                            ?>
                        </div>
                        
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Bulan</label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                        <?=
                            $form->field($model, 'bulan')->label(false)->widget(Select2::classname(), [
                                'data' => [
                                    '01' => 'Januari',
                                    '02' => 'Februari',
                                    '03' => 'Mac',
                                    '04' => 'April',
                                    '05' => 'Mei',
                                    '06' => 'Jun',
                                    '07' => 'Julai',
                                    '08' => 'Ogos',
                                    '09' => 'September',
                                    '10' => 'Oktober',
                                    '11' => 'November',
                                    '12' => 'Disember',
                                ],
                                'hideSearch' => false,
                                'options' => [
                                    'placeholder' => 'Carian ...', 
    //                                'id' => 'ppp'
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis</label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                        <?=
                            $form->field($model, 't_lpg_cd')->label(false)->widget(Select2::classname(), [
                                'data' => yii\helpers\ArrayHelper::map(app\models\gaji\RefRocReason2::find()
                                        ->all(), 'lpgCd', 'lpgNm'),
                                'hideSearch' => false,
                                'options' => [
                                    'placeholder' => 'Carian ...', 
    //                                'id' => 'ppp'
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Kuatkuasa</label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <?=
                                $form->field($model, 't_lpg_date_start')->widget(DateTimePicker::classname(), [
                                    'options' => ['placeholder' => 'Pilih tarikh'],
                                    'pluginOptions' => [
                                            'autoclose' => true
                                    ]
                                ])->label(false);
                            ?>
                        </div>
                    </div>  
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Tamat</label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <?=
                                $form->field($model, 't_lpg_date_end')->widget(DateTimePicker::classname(), [
                                    'options' => ['placeholder' => 'Pilih tarikh'],
                                    'pluginOptions' => [
                                            'autoclose' => true
                                    ]
                                ])->label(false);
                            ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Jawatan</label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                        <?=
                            $form->field($model, 't_lpg_jawatan_id')->label(false)->widget(Select2::classname(), [
                                'data' => yii\helpers\ArrayHelper::map(app\models\hronline\GredJawatan::find()
                                        ->select(new Expression('`hronline`.`gredjawatan`.`id` as id, CONCAT(`hronline`.`gredjawatan`.`gred` , \' - \' , `hronline`.`gredjawatan`.`nama`) as gred'))
                                        ->orderBy(['gred' => SORT_ASC])
                                        ->all(), 'id', 'gred'),
                                'hideSearch' => false,
                                'options' => [
                                    'placeholder' => 'Carian ...', 
    //                                'id' => 'ppp'
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <?=
                                $form->field($model, 't_lpg_remark')->textarea([
    //                                'placeholder' => 'Jam Kredit',
                                    'rows' => 6,
                                    'cols' => 5,
                                    'style' => 'resize:none'
                                    ])->label(false);
                            ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Dihantar Kpd Pegawai Utk Disahkan</label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                        <?=
                            $form->field($model, 't_lpg_app_status')->label(false)->widget(Select2::classname(), [
                                'data' => [
                                    'approve' => 'Disahkan / Dihantar',
                                    'disprove' => 'Tidak Disahkan / Tidak Dihantar',
                                ],
                                'hideSearch' => true,
                                'options' => [
                                    'placeholder' => 'Carian ...', 
    //                                'id' => 'ppp'
                                    //'class' => 'form-control col-md-7 col-xs-12',
                                    //'id' => 'jenis_carian',
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                        </div>
                        <div>
                            <?= Html::tag('i', '', [
                                'title'=>'Sila pastikan maklumat LPG telah lengkap dan tepat sebelum Disahkan / Dihantar untuk pengesahan pegawai.',
                                'data-toggle'=>'tooltip',
                                'style'=>'text-decoration: underline; cursor:pointer;',
                                'class' => 'fa fa-info'
                            ]);?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Pengesahan Oleh</label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                        <?=
                            $form->field($model, 't_lpg_app_by')->label(false)->widget(Select2::classname(), [
                                'data' => yii\helpers\ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()
//                                        ->select(new Expression('`hronline`.`gredjawatan`.`id` as id, CONCAT(`hronline`.`gredjawatan`.`gred` , \' - \' , `hronline`.`gredjawatan`.`nama`) as gred'))
                                        ->innerJoin(['a' => 'gaji.staf_akses'], 'a.staf_akses_icno = ICNO')
//                                        ->orderBy(['gred' => SORT_ASC])
                                        ->all(), 'ICNO', 'CONm'),
                                'hideSearch' => false,
                                'options' => [
                                    'placeholder' => 'Carian ...', 
                                    'id' => 'ppp'
                                    //'class' => 'form-control col-md-7 col-xs-12',
                                    //'id' => 'jenis_carian',
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                        </div>
                        <div>
                            <?= Html::tag('i', '', [
                                'title'=>'Emel notifikasi akan dihantar kepada pegawai yang dipilih untuk membuat pengesahan LPG ini.',
                                'data-toggle'=>'tooltip',
                                'style'=>'text-decoration: underline; cursor:pointer;',
                                'class' => 'fa fa-info'
                            ]);?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Pengesahan (Status)</label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                        <?=
                            $form->field($model, 't_lpg_ver_status')->label(false)->widget(Select2::classname(), [
                                'data' => [
                                    'approve' => 'Disahkan',
                                    'disprove' => 'Tidak Disahkan',
                                ],
                                'hideSearch' => true,
                                'options' => [
                                    'placeholder' => 'Carian ...', 
    //                                'id' => 'ppp'
                                    //'class' => 'form-control col-md-7 col-xs-12',
                                    //'id' => 'jenis_carian',
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                        </div>
                        <div>
                            <?= Html::tag('i', '', [
                                'title'=>'Sila ambil maklum, LPG yang telah dibuat pengesahan tidak boleh lagi dikemaskini oleh pegawai yang tidak mempunyai akses untuk mengesahkan LPG.',
                                'data-toggle'=>'tooltip',
                                'style'=>'text-decoration: underline; cursor:pointer;',
                                'class' => 'fa fa-info'
                            ]);?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-push-3 col-sm-6 col-xs-12">
                            <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                            <?= Html::submitButton('Kemaskini', ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
            
                <?php ActiveForm::end(); ?>
                <?php yii\widgets\Pjax::end() ?>
                </div>
                
                <hr>
                
                <h4> Senarai Elaun</h4>
                
                <div class="row">
                    <div class="table-responsive">
                    <?=
                        GridView::widget([
                            //'tableOptions' => [
                              //  'class' => 'table table-striped jambo_table',
                            //],
                            'emptyText' => 'Tiada Rekod',
                //                                'pager' => [
                //                                    'class' => \kop\y2sp\ScrollPager::className(),
                //                                    'container' => '.grid-view tbody',
                //                                    'triggerOffset' => 10,
                //                                    'item' => 'tr',
                //                                    'paginationSelector' => '.grid-view .pagination',
                //                                    'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer">{text}</a></td></tr>',
                //                                 ],
                            'summary' => '',
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'header' => 'BIL',
                                    'headerOptions' => ['class'=>'text-center col-md-1'],
                                    'contentOptions' => ['class'=>'text-center'],
                                ],
                                [
                //                                        'class' => 'yii\grid\SerialColumn',
                                    'header' => 'NAMA ELAUN',
                                    'headerOptions' => ['class'=>'text-center'],
//                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model){
                                        return $model->elaunName->nama_ringkas.' - '.$model->elaunName->nama_penuh;
                                    }
                                ],
                                [
                //                                        'class' => 'yii\grid\SerialColumn',
//                                    'header' => 'JUMLAH (RM)',
//                                    'headerOptions' => ['class'=>'text-center col-md-2'],
//                                    'contentOptions' => ['class'=>'text-center'],
//                                    'value' => function($model){
//                                        return Yii::$app->formatter->asDecimal($model->el_amount);
//                                    },
                                    'class'=>'kartik\grid\EditableColumn',
                                    'attribute'=>'el_amount',
                                    'editableOptions'=> function ($model, $key, $index) {
                                        return [
                                            'header'=>'JUMLAH (RM)', 
                                            'size'=>'md',
//                                            'beforeInput' => function ($form, $widget) use ($model, $index) {
//                                                echo $form->field($model, "el_amount")->textInput([
//                //                                'placeholder' => 'Jam Kredit',
//                                                ])->label(false);
//                                            },
//                                            'afterInput' => function ($form, $widget) use ($model, $index) {
//                                                echo $form->field($model, "el_amount")->textInput([
//                //                                'placeholder' => 'Jam Kredit',
//                                                ])->label(false);
//                                            }
                                        ];
                                    }
                                ],        
                //                    [
                //                        'class' => 'yii\grid\ActionColumn',
                //                        'header' => 'TINDAKAN',
                //                        'headerOptions' => ['class'=>'text-center col-md-2'],
                //                        'contentOptions' => ['class'=>'text-center'],
                //                        'template' => '{update}',
                //                        'buttons' => [
                //                            'update' => function ($url, $model) {
                //                                $url1 = Url::to(['saraan/kemaskini-lpg', 'icno' => $model->t_lpg_ICNO, 'lpg_id' => $model->t_lpg_id]);
                //                                return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url1, 'class' => 'btn btn-default btn-sm modalButton']);
                //                            },
                ////                                            'delete' => function ($url, $model) {
                ////                                                $url2 = Url::to(['elnpt/padam-rubrik-gred', 'id' => $model->id]);
                ////                                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url2, ['class' => 'btn btn-default btn-sm']);
                ////                                                //Html::button('<span class="glyphicon glyphicon-trash"></span>', ['value' => $url2, 'class' => 'btn btn-default btn-sm']);
                ////                                            },       
                //                        ],        
                //                    ],          
                            ],
                        ]);
                    ?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
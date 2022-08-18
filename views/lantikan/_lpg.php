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

$( document ).ready(function() {        
    $('#lpg').change(function(){
        if ($(this).val() == 11) {
           $('#bulan').attr('disabled',false);
        }else{
           $('#bulan').attr('disabled',true);
        }
    });   
});        
SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);

?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Tambah LPG</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php
                    echo DetailView::widget([
                        'model' => $bio,
                        'attributes' => [
                            [ 
                                'label' => 'Nama',
                                'value' => (is_null($bio->gelaran) ? '' : $bio->gelaran->Title.' ').$bio->CONm
                            ],
                            [   
                                'label' => 'KP / Pasport',
                                'value' => $bio->ICNO
                            ], 
                            [  
                                'label' => 'Jawatan',
                                'value' => $bio->jawatan->fname
                            ],
                            [  
                                'label' => 'JSPIU',
                                'value' => $bio->department->fullname
                            ],
                            [ 
                                'label' => 'Jenis Lantikan',
                                'value' => $bio->statusLantikan->ApmtStatusNm
                            ],
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
                                $form->field($model, 't_lpg_amount')->textInput(['placeholder'=>'Gaji Pokok'])->label(false);
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
                                    'id' => 'lpg',
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Bulan (LPG)</label>
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
                                    'id' => 'bulan',
                                    'disabled' => true
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                        </div>
                        <div>
                            <?= Html::tag('i', '', [
                                'title'=>'Pilih bulan untuk LPG',
                                'data-toggle'=>'tooltip',
                                'style'=>'text-decoration: underline; cursor:pointer;',
                                'class' => 'fa fa-info'
                            ]);?>
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
                                'data' => $data,
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Jabatan</label>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                        <?=
                            $form->field($model, 't_lpg_dept_id')->label(false)->widget(Select2::classname(), [
                                'data' => yii\helpers\ArrayHelper::map(app\models\hronline\Department::find()
                                        ->select(new Expression('`hronline`.`department`.`id` as id, CONCAT(`hronline`.`department`.`shortname` , \' - \' , `hronline`.`department`.`fullname`) as fullname'))
                                        ->orderBy(['fullname' => SORT_ASC])
                                        ->all(), 'id', 'fullname'),
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
                            <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
            
                <?php ActiveForm::end(); ?>
                <?php yii\widgets\Pjax::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
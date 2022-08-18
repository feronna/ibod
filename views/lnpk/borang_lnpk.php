<?php
$js = <<< JS
$("#login-form").on("beforeSubmit",function(e){
    // alert('test');
    $("#buttonBhg1").prop('disabled', true);
    $("#resetBhg1").prop('disabled', true);
    e.preventDefault();
    $("#login-form").css({pointerEvents:'none'});
    return true;
});

$( document ).ready(function() {
    if($('#ispp').val() == 0){
        $('.ppkdiv').show(); 
    }else{
        $('.ppkdiv').hide(); 
    }  
});

JS;
$this->registerJs($js, \yii\web\View::POS_READY);

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\elnpt\RefPnpKursus;
use app\models\lnpk\RefJenisLnpk;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\SwitchInput;

use app\models\hronline\GredJawatan;
use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;
use app\models\lppums\TblLppTahun;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">

            <div class="panel-body">
                <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
                <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Borang</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?=
                        $form->field($lnpk, 'lnpk_jenis')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(RefJenisLnpk::find()->all(), 'id', 'lnpk_desc'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Pilih Jenis',
                                'class' => 'form-control col-md-7 col-xs-12',
                                //'selected'    => 2,
                                //'id' => 'senarai',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun Penilaian</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                        $form->field($lnpk, 'tahun')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(TblLppTahun::find()->orderBy(['lpp_tahun' => SORT_DESC,])->all(), 'lpp_tahun', 'lpp_tahun'),
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Yang Dinilai</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?=
                        $form->field($lnpk, 'PYD')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Tblprcobiodata::find()->where(['!=', 'Status', 6])->all(), 'ICNO', 'CONm'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Pilih PYD',
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Penilai Pertama</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?=
                        $form->field($lnpk, 'PPP')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Tblprcobiodata::find()->where(['!=', 'Status', 6])->all(), 'ICNO', 'CONm'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Pilih PPP',
                                //                                'id' => 'ppp'
                                //'class' => 'form-control col-md-7 col-xs-12',
                                //'id' => 'jenis_carian',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]) . ' ' . $form->field($lnpk, 'isPP')->widget(\kartik\checkbox\CheckboxX::classname(), [
                            'autoLabel' => true,
                            'options' => ['id' => 'ispp'],
                            'labelSettings' => [
                                'label' => 'Set sebagai PP',
                                'position' => \kartik\checkbox\CheckboxX::LABEL_RIGHT
                            ],
                            'pluginOptions' => ['threeState' => false],
                            'pluginEvents' => [
                                "change" => "function(event) {
                                    if($(this).val() == 0){
                                        $('.ppkdiv').show(); 
                                    }else{
                                        $('.ppkdiv').hide(); 
                                    }       
                                }",
                            ],
                        ])->label((false));
                        ?>
                    </div>
                </div>

                <div class="form-group ppkdiv">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Penilai Kedua</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <?=
                        $form->field($lnpk, 'PPK')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Tblprcobiodata::find()->where(['!=', 'Status', 6])->all(), 'ICNO', 'CONm'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Pilih PPK',
                                //                                'id' => 'ppp'
                                //'class' => 'form-control col-md-7 col-xs-12',
                                'id' => 'setppk',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <?php if (!$lnpk->isNewRecord) { ?>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <?=
                            $form->field($lnpk, 'catatan')->textarea([
                                // 'placeholder' => 'Diisi pada PYD sekiranya berkaitan',
                                'style' => 'resize: none;',
                            ])->label(false);
                            ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Padam Borang?</label>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <?=
                            $form->field($lnpk, 'is_deleted')->widget(SwitchInput::classname(), [
                                'pluginOptions' => [
                                    'onText' => 'Ya',
                                    'offText' => 'Tidak',
                                    'size' => 'small',
                                    'onColor' => 'success',
                                    'offColor' => 'danger',
                                ]
                            ])->label(false)
                            ?>
                        </div>
                    </div>

                <?php } ?>

                <div class="form-group">
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary', 'id' => 'resetBhg1']) ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'id' => 'buttonBhg1']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
                <?php yii\widgets\Pjax::end() ?>
            </div>
        </div>
    </div>
</div>
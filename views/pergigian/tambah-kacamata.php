<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Pergigian\Klinik;
use kartik\number\NumberControl;
use app\models\hronline\Tblkeluarga;
use app\models\hronline\Tblprcobiodata;

?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

<div class="pergigian-create">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> Tuntutan Baru</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="form-group row">
                <label class="control-label col-md-3 col-sm-3  col-md-offset-1">JENIS TUNTUTAN</label>
                <div class="col-md-4 col-sm-4 ">
                    <select class="form-control" id="foo">
                        <option value=" ../pergigian/tambah-kacamata ">Tuntutan Kacamata</option>
                        <option value=" ../pergigian/tambah-tuntutangigi ">Tuntutan Rawatan Pergigian</option>
                    </select>
                </div>
            </div>

        </div>

        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="col-md-12 col-xs-12">
                    <div class="x_panel">

                        <div class="x_title">
                            <h2><i class="fa fa-book"></i><strong> Tambah Tuntutan Pembelian Kacamata</strong></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Kakitangan<span class="required" style="color:red;">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?= $form->field($model, 'icno')->widget(Select2::classname(), [
                                    'data' => \yii\helpers\ArrayHelper::map(Tblprcobiodata::find()->where(['<>', 'Status', '6'])->andWhere(['IN', 'statLantikan', [1, 3]])->all(), 'ICNO', 'CONm'),
                                    'options' => [
                                        'placeholder' => 'Carian Kakitangan', 'class' => 'form-control col-md-7 col-xs-12',
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label(false); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Kedai Kacamata<span class="required" style="color:red;">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?= $form->field($model, 'kacamata')->textInput(['maxlength' => true, 'rows' => 2])->label(false); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="used_dt">Tarikh Pembelian <span class="required" style="color:red;">*</span>
                            </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <!--<input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">-->
                                <?=
                                DatePicker::widget([
                                    'model' => $model,
                                    'attribute' => 'used_dt',
                                    'template' => '{input}{addon}',
                                    'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                                    'clientOptions' => [
                                        'autoclose' => true,
                                        'format' => 'yyyy-mm-dd'
                                    ]
                                ]);
                                ?>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Tuntutan (RM)<span class="required" style="color:red;">*</span>
                            </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <?=
                                $form->field($model, 'jumlah_tuntutan')->widget(NumberControl::classname(), [
                                    'name' => 'jumlah_tuntutan',
                                    'pluginOptions' => [
                                        'initialize' => true,
                                    ],
                                    'maskedInputOptions' => [
                                        'prefix' => 'RM',
                                        'rightAlign' => false
                                    ],

                                    'displayOptions' => [
                                        'placeholder' => 'Contoh: RM223437.04'
                                    ],
                                ])->label(false);
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombor Bil/Resit<span class="required" style="color:red;">*</span>
                            </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <?= $form->field($model, 'catatan')->textInput(['maxlength' => true, 'rows' => 2])->label(false); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Penyemak
                            </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" value="NORJAIDAH JAFFAR" disabled />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Melulus
                            </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" value="ROZAIDAH AMIR HUSSEIN" disabled />
                            </div>
                        </div>

                        <div class="ln_solid"></div>

                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button class="btn btn-primary" type="reset">Reset</button>
                                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById("foo").onchange = function() {
        if (this.selectedIndex !== 0) {
            window.location.href = this.value;
        }
    };
</script>
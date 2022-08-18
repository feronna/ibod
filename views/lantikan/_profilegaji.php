<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\hronline\RefEpfType;
use app\models\hronline\RefTaxFormulaType;
use app\models\hronline\RefTaxCategory;
use app\models\hronline\RefSocsoType;


?>


<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-money"></i><strong> PROFIL GAJI</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="container">
                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons'], 'method' => 'post']); ?>

                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;">
                                <center>MAKLUMAT TARIKH</center>
                            </th>
                        </thead>
                    </table>

                    <table class="table table-sm table-bordered">
                        <tr>
                            <td width="200px" height="20px">Tarikh Mula<span class="required" style="color:red;">*</span></td>
                            <td>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <?= $form->field($model, 'SS_START_DATE')->widget(
                                        DatePicker::className(),
                                        [
                                            'clientOptions' => ['changeMonth' => true, 'yearRange' => '1996:2099', 'changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                                            'options' => ['id' => 'SS_START_DATE','disabled'=>true]
                                        ]
                                    )
                                        ->label(false); ?>
                                </div>
                            </td>

                            <td valign="1" width="200px" height="20px">Tarikh Akhir</td>
                            <td>
                                <div class="col-md-9 col-sm-9 col-xs-12">

                                    <?= $form->field($model, 'SS_END_DATE')->widget(
                                        DatePicker::className(),
                                        [
                                            'clientOptions' => ['changeMonth' => true, 'yearRange' => '1996:2099', 'changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                                            'options' => ['id' => 'SS_END_DATE','disabled'=>true]
                                        ]
                                    )
                                        ->label(false); ?>
                                </div>
                            </td>



                        </tr>
                    </table>

                    <table class="table table-sm table-bordered">
                        <thead>
                            <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;">
                                <center>MAKLUMAT GAJI</center>
                            </th>
                        </thead>
                    </table>

                    <table class="table table-sm table-bordered">
                        <thead>

                            <tr>
                                <td width="200px" height="10px">Jenis Gaji<span class="required" style="color:red;">*</span></td>
                                <td colspan="5">
                                    <div class="col-md-6 col-sm-6 col-xas-10">

                                        <?= $form->field($model, 'SS_SALARY_TYPE')->label(false)->widget(Select2::classname(), [
                                            'data' => [1 => 'Monthly Salary', 2 => 'Part-time/Claims-based Salary', 3 => 'Bonus/Cash Assist (Separate)', 4 => 'BOD'],
                                            'options' => ['placeholder' => Yii::t('app', 'Sila Pilih..'), 'class' => 'form-control col-md-7 col-xs-12'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ]);
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="200px" height="10px">Status Gaji</td>
                                <td>

                                    <?= $form->field($model, 'SS_SALARY_STATUS')->label(false)->widget(Select2::classname(), [
                                        'data' => ['Y' => 'YA', 'N' => 'TIDAK'],
                                        'options' => ['placeholder' => Yii::t('app', 'Sila Pilih..'), 'class' => 'form-control col-md-7 col-xs-12'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                    ?>

                                </td>
                                <td valign="1" width="200px" height="10px">Kadar Harian/Jam</td>
                                <td>
                                    <?= $form->field($model, 'SS_RATE')->textInput(['maxlength' => true])->label(false); ?>
                                </td>




                            </tr>

                        </thead>
                    </table>


                    <table class="table table-sm table-bordered">
                        <thead>
                            <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;">
                                <center>CUKAI</center>
                            </th>

                        </thead>
                    </table>

                    <table class="table table-sm table-bordered">
                        <tr>
                            <td width="200px" height="10px">Cukai?</td>
                            <td colspan="5">
                                <div class="col-md-6 col-sm-6 col-xs-10">
                                    <?=
                                        $form->field($model, 'SS_TAX_STATUS')->label(false)->widget(Select2::classname(), [
                                            'data' => ['Y' => 'YA', 'N' => 'TIDAK'],
                                            'options' => ['placeholder' => Yii::t('app', 'Sila Pilih..'), 'class' => 'form-control col-md-7 col-xs-12'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ]);
                                    ?>
                                </div>
                            </td>
                        </tr>


                        <tr>
                            <td width="200px" height="10px">Kategori Cukai</td>
                            <td colspan="5">
                                <div class="col-md-6 col-sm-6 col-xs-10">
                                    <?= $form->field($model, 'SS_TAX_CATEGORY')->label(false)->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(RefTaxCategory::find()->all(), 'TC_CATEGORY_CODE', 'TC_CATEGORY_DESC'),
                                        'options' => ['placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                    ?>
                                </div>
                            </td>
                        </tr>


                        <tr>
                            <td width="200px" height="10px">Formula Cukai</td>
                            <td colspan="5">
                                <div class="col-md-6 col-sm-6 col-xs-10">
                                    <?= $form->field($model, 'SS_TAX_FORMULA')->label(false)->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(RefTaxFormulaType::find()->all(), 'TFT_FORMULA_TYPE_CODE', 'TFT_DESC'),
                                        'options' => ['placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                    ?>
                                </div>
                            </td>
                        </tr>


                        <tr>
                            <td width="200px" height="10px">Cukai Bayar Zakat</td>
                            <td>

                                <?= $form->field($model, 'SS_ZAKAT_STATUS')->label(false)->widget(Select2::classname(), [
                                    'data' => ['Y' => 'YA', 'N' => 'TIDAK'],
                                    'options' => ['placeholder' => Yii::t('app', 'Sila Pilih..'), 'class' => 'form-control col-md-7 col-xs-12'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>

                            </td>
                            <td valign="1" width="200px" height="10px">Zakat Bayar Kepada</td>
                            <td>

                                <?= $form->field($model, 'SS_ZAKAT_CODE')->label(false)->widget(Select2::classname(), [
                                    'data' => [1 => 'LEMBAGA ZAKAT SELANGOR (MAIS)', 2 => 'MUIS (ZAKAT)', 3 => 'PERBADANAN BAITULMAL N.SABAH', 4 => 'PUSAT PUNGUTAN ZAKAT (PPS)', 5 => 'PUSAT ZAKAT NEGERI SEMBILAN'],
                                    'options' => ['placeholder' => Yii::t('app', 'Sila Pilih..'), 'class' => 'form-control col-md-7 col-xs-12'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                            </td>
                        </tr>
                    </table>


                    <table class="table table-sm table-bordered">
                        <thead>
                            <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;">
                                <center>KWSP</center>
                            </th>
                        </thead>
                    </table>

                    <table class="table table-sm table-bordered">
                        <tr>
                            <td width="200px" height="10px">KWSP?</td>
                            <td colspan="5">
                                <div class="col-md-6 col-sm-6 col-xs-10">
                                    <?=
                                        $form->field($model, 'SS_EPF_STATUS')->label(false)->widget(Select2::classname(), [
                                            'data' => ['Y' => 'YA', 'N' => 'TIDAK'],
                                            'options' => ['placeholder' => Yii::t('app', 'Sila Pilih..'), 'class' => 'form-control col-md-7 col-xs-12'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ]);
                                    ?>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td width="200px" height="10px">Jenis KWSP</td>
                            <td>
                                <?= $form->field($model, 'SS_EPF_TYPE')->label(false)->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(RefEpfType::find()->all(), 'ET_CODE', 'ET_DESC'),
                                    'options' => ['placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>

                            </td>
                            <td valign="1" width="200px" height="10px">Kaedah Kiraan</td>
                            <td>

                                <?= $form->field($model, 'SS_EPF_METHOD')->label(false)->widget(Select2::classname(), [
                                    'data' => ['SCHEDULE' => 'Jadual', 'PERCENTAGE' => 'Peratusan'],
                                    'options' => ['placeholder' => Yii::t('app', 'Sila Pilih..'), 'class' => 'form-control col-md-7 col-xs-12'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td width="200px" height="10px">Pekerja %</td>
                            <td>
                                <?= $form->field($model, 'SS_EPF_EMPYEE_PCT')->textInput(['maxlength' => true, 'placeholder' => "Contoh: Xxx234"])->label(false) ?>
                            </td>
                            <td valign="1" width="200px" height="10px">Majikan %</td>
                            <td>
                                <?= $form->field($model, 'SS_EPF_EMPYER_PCT')->textInput(['maxlength' => true, 'placeholder' => "Contoh: Xxx234"])->label(false) ?>
                            </td>
                        </tr>
                    </table>

                    <table class="table table-sm table-bordered">
                        <thead>
                            <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;">
                                <center>PERKESO</center>
                            </th>
                        </thead>
                    </table>


                    <table class="table table-sm table-bordered">
                        <tr>
                            <td width="150px" height="10px">PERKESO</td>
                            <td>
                                <?=
                                    $form->field($model, 'SS_SOCSO_STATUS')->label(false)->widget(Select2::classname(), [
                                        'data' => ['Y' => 'YA', 'N' => 'TIDAK'],
                                        'options' => ['placeholder' => Yii::t('app', 'Sila Pilih..'), 'class' => 'form-control col-md-7 col-xs-12'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                ?>
                            </td>
                            <td valign="1" width="150px" height="10px">Jenis Perkeso</td>
                            <td>
                                <?= $form->field($model, 'SS_SOCSO_TYPE')->label(false)->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(RefSocsoType::find()->all(), 'ST_CODE', 'ST_DESC'),
                                    'options' => ['placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                            </td>
                        </tr>
                    </table>

                    <table class="table table-sm table-bordered">
                        <thead>
                            <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;">
                                <center>LAIN-LAIN</center>
                            </th>
                        </thead>
                    </table>

                    <table class="table table-sm table-bordered">
                        <tr>
                            <td width="200px" height="10px">Pencen?</td>
                            <td colspan="5">
                                <div class="col-md-6 col-sm-6 col-xs-10">
                                    <?=
                                        $form->field($model, 'SS_PENSION_STATUS')->label(false)->widget(Select2::classname(), [
                                            'data' => ['Y' => 'YA', 'N' => 'TIDAK'],
                                            'options' => ['placeholder' => Yii::t('app', 'Sila Pilih..'), 'class' => 'form-control col-md-7 col-xs-12'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ]);
                                    ?>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td width="200px" height="10px">Sebab Perubahan<span class="required" style="color:red;">*</span></td>
                            <td colspan="5">
                                <div class="col-md-6 col-sm-6 col-xs-10">
                                    <?= $form->field($model, 'SS_CHANGE_REASON')->textarea(['maxlength' => true])->label(false) ?>

                                </div>
                            </td>
                        </tr>

                    </table>


                </div>
                <div class="form-group" align="center">
                    <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2">
                        <?= \yii\helpers\Html::a('Kembali', ['view-utama', 'id' => $ICNO], ['class' => 'btn btn-primary']) ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please wait..']]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
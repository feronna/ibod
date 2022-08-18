<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use app\models\hronline\Gelaran;
use app\models\hronline\Agama;
use app\models\hronline\Bangsa;
use app\models\hronline\Etnik;
use app\models\hronline\JenisDarah;
use app\models\hronline\Jantina;
use app\models\hronline\TarafPerkahwinan;
use app\models\hronline\Negara;
use app\models\hronline\Negeri;
use app\models\hronline\StatusWarganegara;
use app\models\hronline\PendidikanTertinggi;
use app\models\hronline\StatusUniform;
use app\models\hronline\ProgramPengajaran;
use app\models\hronline\StatusLantikan;
use app\models\hronline\GredJawatan;
use app\models\hronline\StatusSandangan;
use app\models\hronline\JenisLantikan;
use app\models\hronline\Kampus;
use dosamigos\datepicker\DatePicker;

$this->title = 'Kemaskini Biodata';

?>
<div class="col-md-12 col-sm-12 col-xs-12 ">
        <div class="x_content">
            <div class="tblprcobiodata-update">

                    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?= $this->title; ?></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">No. KP / Paspot: <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?= $form->field($model, 'ICNO')->textInput(['disabled' => true, 'maxlength' => true])->label(false) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="umsper">UMSPER: <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?= $form->field($model, 'COOldID')->textInput(['disabled' => true, 'maxlength' => true])->label(false) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gelaran">Gelaran: <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <?=
                                    $form->field($model, 'TitleCd')->label(false)->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(Gelaran::find()->all(), 'TitleCd', 'Title'),
                                        'options' => ['placeholder' => 'Pilih Gelaran', 'class' => 'form-control col-md-7 col-xs-12'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama">Nama: <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?= $form->field($model, 'CONm')->textInput(['disabled' => true, 'maxlength' => true])->label(false) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="agama">Agama: <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <?=
                                    $form->field($model, 'ReligionCd')->label(false)->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(Agama::find()->all(), 'ReligionCd', 'Religion'),
                                        'options' => ['placeholder' => 'Pilih Agama', 'class' => 'form-control col-md-7 col-xs-12'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bangsa">Bangsa: <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <?=
                                    $form->field($model, 'RaceCd')->label(false)->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(Bangsa::find()->all(), 'RaceCd', 'Race'),
                                        'options' => ['placeholder' => 'Pilih Bangsa', 'class' => 'form-control col-md-7 col-xs-12'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="etnik">Etnik: <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <?=
                                    $form->field($model, 'EthnicCd')->label(false)->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(Etnik::find()->all(), 'EthnicCd', 'Ethnic'),
                                        'options' => ['placeholder' => 'Pilih Etnik', 'class' => 'form-control col-md-7 col-xs-12'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenisDarah">Jenis Darah: <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <?=
                                    $form->field($model, 'BloodTypeCd')->label(false)->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(JenisDarah::find()->where(['isActive' => 1])->all(), 'BloodTypeCd', 'BloodType'),
                                        'options' => ['placeholder' => 'Pilih Jenis Darah', 'class' => 'form-control col-md-7 col-xs-12'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jantina">Jantina: <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <?=
                                    $form->field($model, 'GenderCd')->label(false)->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(Jantina::find()->all(), 'GenderCd', 'Gender'),
                                        'options' => ['placeholder' => 'Pilih Jantina', 'class' => 'form-control col-md-7 col-xs-12'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="statusPerkahwinan">Status Perkahwinan : <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <?=
                                    $form->field($model, 'MrtlStatusCd')->label(false)->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(TarafPerkahwinan::find()->all(), 'MrtlStatusCd', 'MrtlStatus'),
                                        'options' => ['placeholder' => 'Pilih Taraf Perkahwinan', 'class' => 'form-control col-md-7 col-xs-12'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="noSijilLahir">No. Sijil Lahir: <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?= $form->field($model, 'COBirthCertNo')->textInput(['maxlength' => true])->label(false) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tarikhLahir">Tarikh Lahir: <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">

                                    <?=
                                    DatePicker::widget([
                                        'model' => $model,
                                        'attribute' => 'COBirthDt',
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="negaraKelahiran">Negara Kelahiran: <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?=
                                    $form->field($model, 'COBirthCountryCd')->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(app\models\hronline\Negara::find()->orderBy(['CountryCd' => SORT_ASC,])->all(), 'CountryCd', 'Country'),
                                        'options' => [
                                            'placeholder' => 'Pilh Negara',
                                        ],
                                    ])->label(false);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tempatKelahiran">Tempat Kelahiran: <span class="required" style="color:red;"></span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <?=
                                    $form->field($model, 'COBirthPlaceCd')->widget(DepDrop::classname(), [
                                        'type' => DepDrop::TYPE_SELECT2,
                                        'data' => ArrayHelper::map(app\models\hronline\Negeri::find()->all(), 'StateCd', 'State'),
                                        'options' => [
                                            'multiple' => false
                                        ],
                                        'pluginOptions' => [
                                            'depends' => [Html::getInputId($model, 'COBirthCountryCd')],
                                            'initialize' => true,
                                            'placeholder' => 'Pilih Negeri',
                                            'url' => Url::to(['/biodata/citylist'])
                                        ]
                                    ])->label(false)
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Negara Asal Staf: <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?=
                                    $form->field($model, 'NegaraAsalCd')->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(app\models\hronline\Negara::find()->orderBy(['CountryCd' => SORT_ASC,])->all(), 'CountryCd', 'Country'),
                                        'options' => [
                                            'placeholder' => 'Pilh Negara',
                                        ],
                                    ])->label(false);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="negeriasalstaf">Negeri Asal Staf: <span class="required" style="color:red;"></span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <?=
                                    $form->field($model, 'NegeriAsalCd')->widget(DepDrop::classname(), [
                                        'type' => DepDrop::TYPE_SELECT2,
                                        'data' => ArrayHelper::map(app\models\hronline\Negeri::find()->all(), 'StateCd', 'State'),
                                        'options' => [
                                            'multiple' => false
                                        ],
                                        'pluginOptions' => [
                                            'depends' => [Html::getInputId($model, 'COBirthCountryCd')],
                                            'initialize' => true,
                                            'placeholder' => 'Pilih Negeri',
                                            'url' => Url::to(['/biodata/citylist'])
                                        ]
                                    ])->label(false)
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="warganegara">Negeri Asal Ibu: <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <?=
                                    $form->field($model, 'NegeriAsalIbu')->label(false)->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(Negeri::find()->all(), 'StateCd', 'State'),
                                        'options' => ['placeholder' => 'Pilih Negeri', 'class' => 'form-control col-md-7 col-xs-12'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="warganegara">Negeri Asal Bapa: <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <?=
                                    $form->field($model, 'NegeriAsalBapa')->label(false)->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(Negeri::find()->all(), 'StateCd', 'State'),
                                        'options' => ['placeholder' => 'Pilih Negeri', 'class' => 'form-control col-md-7 col-xs-12'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="warganegara">Warganegara: <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <?=
                                    $form->field($model, 'NatCd')->label(false)->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(Negara::find()->all(), 'CountryCd', 'Country'),
                                        'options' => ['placeholder' => 'Pilih Negara', 'class' => 'form-control col-md-7 col-xs-12'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="statusWarganegara">Status Warganegara: <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <?=
                                    $form->field($model, 'NatStatusCd')->label(false)->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(StatusWarganegara::find()->all(), 'NatStatusCd', 'NatStatus'),
                                        'options' => [
                                            'placeholder' => 'Pilih Status', 'class' => 'form-control col-md-7 col-xs-12',
                                            'onchange' => 'javascript:if ($(this).val() == "1"){ $("#warganegara").show();}
                        else{$("#warganegara").hide();}'
                                        ],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group" id="warganegara" style="display:none;">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="statusBumiputera">Status Bumiputera: <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?= $form->field($model, 'COBumiStatus')->checkbox(['label' => 'Tandakan jika Bumiputera', 'value' => 1, 'uncheck' => 0])->label(false) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">E-mel Rasmi (@ums.edu.my): <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?= $form->field($model, 'COEmail')->textInput(['maxlength' => true,'disabled'=>true])->label(false) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">E-mel Peribadi (jika ada): <span class="required" style="color:red;"></span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?= $form->field($model, 'COEmail2')->textInput(['maxlength' => true])->label(false) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="noTelefonBimbit">No. Telefon Bimbit: <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?= $form->field($model, 'COHPhoneNo')->textInput(['maxlength' => true])->label(false) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="noTelefonBimbit">No. Telefon Bimbit 2: <span class="required" style="color:red;"></span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?= $form->field($model, 'COHPhoneNo2')->textInput(['placeholder' => 'Jika ada'], ['maxlength' => true])->label(false) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="statusTelefonBimbit">Status Telefon Bimbit: <span class="required" style="color:red;"></span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?= $form->field($model, 'COHPhoneStatus')->checkbox(['label' => 'Tandakan jika aktif', 'value' => 1, 'uncheck' => 0])->label(false) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="noTelefonBimbit">No. Telefon Pejabat: <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?= $form->field($model, 'COOffTelNo')->textInput(['maxlength' => true])->label(false) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="noTelefonBimbit">No. Sambungan: <span class="required" style="color:red;"></span>
                                </label>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <?= $form->field($model, 'COOffTelNoExtn')->textInput(['maxlength' => true])->label(false) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="noTelefonBimbit">No. Sambungan 2: <span class="required" style="color:red;"></span>
                                </label>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <?= $form->field($model, 'COOffTelNoExtn2')->textInput(['maxlength' => true])->label(false) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" >No. Sambungan UC: <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <?= $form->field($model, 'COOUCTelNo')->textInput(['maxlength' => true])->label(false) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" >ID MySejahtera : <span class="required" style="color:red;">*</span>
                                </label>
                                <div class="col-md-3 col-sm-6 col-xs-12">
                                    <?= $form->field($model, 'mySejahteraId')->textInput(['maxlength' => true])->label(false) ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <?= Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

            </div>
        </div>
</div>
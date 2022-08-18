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

?>
 
<div class="tblprcobiodata-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

    <div class="x_panel" style="background-color:#b4bdcc;color:black;">
        <div class="x_title">
            <h2>Maklumat Asas Kakitangan</h2>
            <ul class="nav navbar-right panel_toolbox">

            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">No. KP / Paspot: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($user, 'ICNO')->textInput(['maxlength' => true])->label(false) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="umsper">UMSPER: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($user, 'COOldID')->textInput(['placeholder' => 'Auto Generate', 'disabled' => true, 'maxlength' => true])->label(false) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gelaran">Gelaran: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($user, 'TitleCd')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Gelaran::find()->all(), 'TitleCd', 'Title'),
                        'options' => ['placeholder' => 'Pilih Gelaran', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group nama" id="nama">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama">Nama: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 nama" id="nama">
                    <?= $form->field($user, 'CONm')->textInput(['maxlength' => true])->label(false) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="agama">Agama: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($user, 'ReligionCd')->label(false)->widget(Select2::classname(), [
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
                    $form->field($user, 'RaceCd')->label(false)->widget(Select2::classname(), [
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
                    $form->field($user, 'EthnicCd')->label(false)->widget(Select2::classname(), [
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
                    $form->field($user, 'BloodTypeCd')->label(false)->widget(Select2::classname(), [
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
                    $form->field($user, 'GenderCd')->label(false)->widget(Select2::classname(), [
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
                    $form->field($user, 'MrtlStatusCd')->label(false)->widget(Select2::classname(), [
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
                    <?= $form->field($user, 'COBirthCertNo')->textInput(['maxlength' => true])->label(false) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tarikhLahir">Tarikh Lahir: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">

                    <?=
                    DatePicker::widget([
                        'model' => $user,
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
                    $form->field($user, 'COBirthCountryCd')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Negara::find()->orderBy(['Country' => SORT_ASC,])->all(), 'CountryCd', 'Country'),
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
                    $form->field($user, 'COBirthPlaceCd')->widget(DepDrop::classname(), [
                        'type' => DepDrop::TYPE_SELECT2,
                        'data' => ArrayHelper::map(Negeri::find()->all(), 'StateCd', 'State'),
                        'options' => [
                            'multiple' => false
                        ],
                        'pluginOptions' => [
                            'depends' => [Html::getInputId($user, 'COBirthCountryCd')],
                            'initialize' => true,
                            'placeholder' => 'Pilih Negeri',
                            'url' => Url::to(['/biodata/citylist'])
                        ]
                    ])->label(false)
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="negaraasalstaf">Negara Asal Staf: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($user, 'NegaraAsalCd')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Negara::find()->orderBy(['Country' => SORT_ASC])->all(), 'CountryCd', 'Country'),
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
                    $form->field($user, 'NegeriAsalCd')->widget(DepDrop::classname(), [
                        'type' => DepDrop::TYPE_SELECT2,
                        'data' => ArrayHelper::map(Negeri::find()->all(), 'StateCd', 'State'),
                        'options' => [
                            'multiple' => false
                        ],
                        'pluginOptions' => [
                            'depends' => [Html::getInputId($user, 'NegaraAsalCd')],
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
                    $form->field($user, 'NegeriAsalIbu')->label(false)->widget(Select2::classname(), [
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
                    $form->field($user, 'NegeriAsalBapa')->label(false)->widget(Select2::classname(), [
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
                    $form->field($user, 'NatCd')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Negara::find()->orderBy(['Country'=>SORT_ASC])->all(), 'CountryCd', 'Country'),
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
                    $form->field($user, 'NatStatusCd')->label(false)->widget(Select2::classname(), [
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
                    <?= $form->field($user, 'COBumiStatus')->checkbox(['label' => 'Tandakan jika Bumiputera', 'value' => 1, 'uncheck' => 0])->label(false) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Sabah: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($user, 'isSabahan')->label(false)->widget(Select2::classname(), [
                        'data' => ['1' => 'Sabah', '0' => 'Bukan Sabah'],
                        'options' => ['placeholder' => 'Sila Pilih...', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" >E-mel: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($user, 'COEmail2')->textInput(['maxlength' => true,'value'=>$user->user->email])->label(false) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="noTelefonBimbit">No. Telefon Bimbit: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($user, 'COHPhoneNo')->textInput(['maxlength' => true])->label(false) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="noTelefonBimbit">No. Telefon Bimbit 2: <span class="required" style="color:red;"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($user, 'COHPhoneNo2')->textInput(['placeholder' => 'Jika ada'], ['maxlength' => true])->label(false) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="statusTelefonBimbit">Status Telefon Bimbit: <span class="required" style="color:red;"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($user, 'COHPhoneStatus')->checkbox(['label' => 'Tandakan jika aktif', 'value' => 1, 'uncheck' => 0])->label(false) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pendidikanTertinggi">Pendidikan Tertinggi: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($user, 'HighestEduLevelCd')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(PendidikanTertinggi::find()->where(['isActive' => 1])->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
                        'options' => ['placeholder' => 'Pilih Pendidikan Tertinggi', 'class' => 'form-control col-md-7 col-xs-12','value'=>$user->getPendidikanTertinggi('id')],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tarikhDianugerahkanPendidikantertinggi">Tarikh Dianugerahkan Pendidikan Tertinggi: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">

                    <?=
                    DatePicker::widget([
                        'model' => $user,
                        'attribute' => 'ConfermentDt',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12','value'=>$user->getPendidikanTertinggi('date')],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="statusuniform">Status Uniform: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($user, 'ArmyPoliceCd')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(StatusUniform::find()->all(), 'ArmyPoliceCd', 'ArmyPolice'),
                        'options' => ['placeholder' => 'Pilih Status Uniform', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="x_panel" style="background-color:#b4bdcc;color:black;">
        <div class="x_title">
            <h2>Program Pengajaran: Kakitangan Akademik Sahaja</h2>
            <ul class="nav navbar-right panel_toolbox">

            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="programPengajaran">Program Pengajaran:
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($user, 'KodProgram')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(ProgramPengajaran::find()->orderBy(['NamaProgram' => SORT_ASC])->all(), 'id', 'NamaProgram'),
                        'options' => ['placeholder' => 'Pilih Program Pengajaran', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="x_panel" style="background-color:#b4bdcc;color:black;">
        <div class="x_title">
            <h2>Maklumat Rekod Perkhidmatan</h2>
            <ul class="nav navbar-right panel_toolbox">

            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="form-group ">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="statusLantikan">Status Lantikan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12 ">
                    <?=
                    $form->field($user, 'statLantikan')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(StatusLantikan::find()->orderBy(['ApmtStatusCd' => SORT_ASC])->all(), 'ApmtStatusCd', 'ApmtStatusNm'),
                        'options' => [
                            'placeholder' => 'Pilih Status Lantikan',
                            'class' => 'form-control col-md-7 col-xs-12',
                            'id' => 'statuslantikan'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tarikhMulaLantikan">Tarikh Mula Lantikan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">

                    <?=
                    DatePicker::widget([
                        'model' => $user,
                        'attribute' => 'startDateLantik',
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tarikhAkhirLantikan">Tarikh Akhir Lantikan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">

                    <?=
                    DatePicker::widget([
                        'model' => $user,
                        'attribute' => 'endDateLantik',
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gredJawatan">Gred Jawatan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($user, 'gredJawatan')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(GredJawatan::find()->orderBy(['fname' => SORT_ASC])->all(), 'id', 'fname'),
                        'options' => ['placeholder' => 'Pilih Gred Jawatan', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="statusSandangan">Status Sandangan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($user, 'statSandangan')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(StatusSandangan::find()->where(['isActive' => 1])->all(), 'sandangan_id', 'sandangan_name'),
                        'options' => ['placeholder' => 'Pilih Status Sandangan', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenisLantikan">Jenis Lantikan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($user, 'ApmtTypeCd')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(JenisLantikan::find()->all(), 'ApmtTypeCd', 'ApmtTypeNm'),
                        'options' => ['placeholder' => 'Pilih Jenis Lantikan', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="noWaran">No. Waran:
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($user, 'noWaran')->textInput()->label(false) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jabatan">Jabatan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($user, 'DeptId')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Department::find()->orderBy(['fullname' => SORT_ASC])->all(), 'id', 'fullname'),
                        'options' => ['placeholder' => 'Pilih Jabatan', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kampus">Kampus: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($user, 'campus_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Kampus::find()->all(), 'campus_id', 'campus_name'),
                        'options' => ['placeholder' => 'Pilih Kampus', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>


    <div class="form-group text-center">
        <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please wait..']]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
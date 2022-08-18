<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
use app\models\hronline\HubunganKeluarga;
use app\models\hronline\JenisIc;
use app\models\hronline\Gelaran;
use app\models\hronline\TempatLahir;
use app\models\hronline\Jantina;
use app\models\hronline\Agama;
use app\models\hronline\Bangsa;
use app\models\hronline\PendidikanTertinggi;
use app\models\hronline\Warganegara;
use app\models\hronline\TarafPerkahwinan;
use app\models\hronline\StatusWarganegara;
use app\models\hronline\JenisTanggungan;
use app\models\hronline\StatusPekerjaanAhliKeluarga;
use app\models\hronline\JenisBadanMajikan;
use app\models\hronline\SektorPekerjaan;
use app\models\hronline\Negara;
use app\models\hronline\Negeri;
use app\models\hronline\Bandar;
use app\models\hronline\IdType;
use kartik\depdrop\DepDrop;

use yii\helpers\Url;

//disability
use app\models\hronline\JenisKecacatan;
use app\models\hronline\PuncaKecacatan;

?>
<script src="jquery-1.11.2.js"></script>

<div class="tblkeluarga-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

    <div class="x_panel">
        <div class="x_title">
            <h2>Maklumat Asas Keluarga</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
         
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="HubunganKeluarga">Hubungan Keluarga: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=
            $form->field($model, 'RelCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(HubunganKeluarga::find()->all(), 'RelCd', 'RelNm'),
                'options' => ['placeholder' => 'Pilih Hubungan Keluarga', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>

        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NoKP">No.KP/Paspot: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <?= $form->field($model, 'FamilyId')->textInput(['placeholder'=>'eg: K/P or Passport'],['maxlength' => true])->label(false);?>  
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Jenis No.KP/Paspot: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=
            $form->field($model, 'IdTypeCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(IdType::find()->where(['isActive'=>1])->all(), 'IdTypeCd', 'IdType'),
                'options' => ['placeholder' => 'Pilih Jenis Pengenalan', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Nama">Nama: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <?= $form->field($model, 'FmyNm')->textInput(['maxlength' => true])->label(false);?>  
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Gelaran">Gelaran: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=
            $form->field($model, 'TitleCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Gelaran::find()->orderBy(['Title'=>SORT_ASC])->all(), 'TitleCd', 'Title'),
                'options' => ['placeholder' => 'Pilih Gelaran', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="JenisKadPengenalan">Jenis K/P: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=
            $form->field($model, 'FmyDependencyICTypeCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(JenisIc::find()->all(), 'ICTypeCd', 'ICType'),
                'options' => ['placeholder' => 'Jika Pemegang K/P Malaysia', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NoSuratBeranak">No. Surat Beranak: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <?= $form->field($model, 'FmyBirthCertNo')->textInput(['maxlength' => true])->label(false);?>  
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tarikhLahir">Tarikh Lahir: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
             
            <?=
            DatePicker::widget([
                'model' => $model,
                'attribute' => 'FmyBirthDt',
                'template' => '{input}{addon}',
                'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12','required'=>true],
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
            ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TempatLahir">Tempat Lahir: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=
            $form->field($model, 'FmyBirthPlaceCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(TempatLahir::find()->orderBy(['state'=>SORT_ASC])->all(), 'StateCd', 'State'),
                'options' => ['placeholder' => 'Negeri / State', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Jantina">Jantina: <span class="required" style="color:red;">*</span>
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
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Agama">Agama: <span class="required" style="color:red;">*</span>
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
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Bangsa">Bangsa: <span class="required" style="color:red;">*</span>
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
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="PendidikanTertinggi">Pendidikan Tertinggi: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=
            $form->field($model, 'HighestEduLevelCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(PendidikanTertinggi::find()->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
                'options' => ['placeholder' => 'Pilih Pendidikan Tertinggi', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Warganegara">Warganegara: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=
            $form->field($model, 'NatCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Warganegara::find()->all(), 'CountryCd', 'Country'),
                'options' => ['placeholder' => 'Pilih Warganegara', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NamaIbu">Nama Ibu: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <?= $form->field($model, 'FmyMomNm')->textInput(['placeholder'=>'Isi jika anak anda'],['maxlength' => true])->label(false);?>  
        </div>
        </div>
            
        </div>
    </div>
    <div class="x_panel">
        <div class="x_title">
            <h2>Status</h2>
            <ul class="nav navbar-right panel_toolbox">
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TarafPerkahwinan">Taraf Perkahwinan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=
            $form->field($model, 'MrtlStatusCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(TarafPerkahwinan::find()->all(), 'MrtlStatusCd', 'MrtlStatus'),
                'options' => ['placeholder' => 'Pilih Taraf Perkahwinan', 'class' => 'form-control col-md-7 col-xs-12',
                'onchange' => 'javascript:if ($(this).val() == "1" || $(this).val() == "0"){ $("#maklumatperkahwinan").hide();}
                    else{$("#maklumatperkahwinan").show();}'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="StatusKembar">Status Kembar: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <?= $form->field($model, 'FmyTwinStatus')->checkbox(['label'=>'tanda jika mempunyai kembar', 'value'=>1, 'uncheck'=>0]) ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="StatusWarganegara">Status Warganegara: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=
            $form->field($model, 'NatStatusCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(StatusWarganegara::find()->all(), 'NatStatusCd', 'NatStatus'),
                'options' => ['placeholder' => 'Pilih Status Warganegara', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="StatusBumiputera">Status Bumiputera: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'FmyBumiStatus')->checkbox(['label'=>'tanda jika bumiputera', 'value'=>1, 'uncheck'=>0]) ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="StatusKecacatan">Status Kecacatan: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'FmyDisabilityStatus')->checkbox(['label'=>'tanda jika ada',
             'value'=>1, 
             'uncheck'=>0,
            ]) ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="StatusTanggungan">Status Tanggungan: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'FmyDependencyStatus')->checkbox(['label'=>'tanda jika tanggungan', 'value'=>1, 'uncheck'=>0]) ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="KebergantunganKepadaAnda">Kebergantungan Kepada Anda: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=
            $form->field($model, 'FmyDependencyCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(JenisTanggungan::find()->all(), 'DependencyCd', 'DependencyNm'),
                'options' => ['placeholder' => 'Pilih Jenis Tanggungan', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="PelepasanCukai">Pelepasan Cukai: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'ChildReliefInd')->checkbox(['label'=>'tanda jika ada pelepasan cukai', 'value'=>1, 'uncheck'=>0]) ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TarikhKematian">Tarikh Kematian: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">            
            <?=
            DatePicker::widget([
                'model' => $model,
                'attribute' => 'FmyDeceaseDt',
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
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Status">Status: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=
            $form->field($model, 'FmyStatusCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(StatusPekerjaanAhliKeluarga::find()->all(), 'FmyStatusCd', 'FmyStatus'),
                'options' => ['placeholder' => 'Pilih Status', 'class' => 'form-control col-md-7 col-xs-12',
                'onchange' => 'javascript:if ($(this).val() == "02" || $(this).val() == "04"){ $("#pekerjaan").show();}
                    else{$("#pekerjaan").hide();}'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div> 
            
        </div>
    </div>
    <div class="x_panel" id="maklumatperkahwinan">
        <div class="x_title">
            <h2>Maklumat Perkahwinan</h2>
            <ul class="nav navbar-right panel_toolbox">
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TarikhPerkahwinan">Tarikh Perkahwinan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">            
            <?=
            DatePicker::widget([
                'model' => $model,
                'attribute' => 'FmyMarriageDt',
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
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NoSijilPerkahwinan">No. Sijil Perkahwinan: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <?= $form->field($model, 'FmyMarriageCertNo')->textInput(['maxlength' => true])->label(false);?>  
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TarikhPerceraian">Tarikh Perceraian: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">            
            <?=
            DatePicker::widget([
                'model' => $model,
                'attribute' => 'FmyDivorceDt',
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
            
        </div>
    </div>

    <div class="x_panel" id="pekerjaan">
        <div class="x_title">
            <h2>Pekerjaan</h2>
            <ul class="nav navbar-right panel_toolbox">
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NamaMajikan">Nama Majikan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <?= $form->field($model, 'FmyEmployerNm')->textInput(['maxlength' => true])->label(false);?>  
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="JenisMajikan">Jenis Majikan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=
            $form->field($model, 'CorpBodyTypeCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(JenisBadanMajikan::find()->all(), 'CorpBodyTypeCd', 'CorpBodyType'),
                'options' => ['placeholder' => 'Pilih Majikan', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="SektorPekerjaan">Sektor Pekerjaan: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?=
            $form->field($model, 'OccSectorCd')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(SektorPekerjaan::find()->all(), 'OccSectorCd', 'OccSector'),
                'options' => ['placeholder' => 'Pilih Sektor Pekerjaan', 'class' => 'form-control col-md-7 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        </div>
            
        </div>
    </div>
    <div class="x_panel">
        <div class="x_title">
            <h2>Alamat</h2>
            <ul class="nav navbar-right panel_toolbox"></ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Alamat1">Alamat 1: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <?= $form->field($model, 'FmyAddr1')->textInput(['maxlength' => true])->label(false);?>  
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Alamat2">Alamat 2: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <?= $form->field($model, 'FmyAddr2')->textInput(['maxlength' => true])->label(false);?>  
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Alamat3">Alamat 3: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <?= $form->field($model, 'FmyAddr3')->textInput(['maxlength' => true])->label(false);?>  
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Poskod">Poskod: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <?= $form->field($model, 'FmyPostcode')->textInput(['maxlength' => true])->label(false);?>  
        </div>
        </div>
        <div class="form-group" id="negara">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Negara">Negara: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'CountryCd')->widget(Select2::classname(), ['data' => ArrayHelper::map(Negara::find()->where(['isActive'=>1])->orderBy(['CountryCd' => SORT_ASC,])->all(), 'CountryCd', 'Country'),
                        'options' => [
                            'placeholder' => 'Pilh Negara'],
                    ])->label(false);
                    ?>
                </div>
            </div>
        <div class="form-group" id="negeri" >
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Negeri">Negeri: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'StateCd')->widget(DepDrop::classname(), [
                        'type' => DepDrop::TYPE_SELECT2,
                        'data' => ArrayHelper::map(Negeri::find()->all(), 'StateCd', 'State'),
                        'options' => [
                            'multiple' => false],
                        'pluginOptions' => [
                            'placeholder' => 'Pilih Negeri',
                            'depends' => [Html::getInputId($model, 'CountryCd')],
                            'initialize' => true,
                            'url' => Url::to(['/alamat/statelist'])
                        ]
                    ])->label(false)
                    ?>
                </div>
            </div>
        <div class="form-group" id="daerah" >
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Daerah">Daerah: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'CityCd')->widget(DepDrop::classname(), [
                        'type' => DepDrop::TYPE_SELECT2,
                        'data' => ArrayHelper::map(Bandar::find()->all(), 'CityCd', 'City'),
                        'options' => [
                            'multiple' => false,],
                        'pluginOptions' => [
                            'placeholder' => 'Pilih Bandar',
                            'depends' => [Html::getInputId($model, 'StateCd')],
                            'initialize' => true,
                            'url' => Url::to(['/alamat/citylist'])
                        ]
                    ])->label(false)
                    ?>
                </div>
            </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NoTelefonBimbit">No. Telefon Bimbit: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <?= $form->field($model, 'FmyTelNo')->textInput(['maxlength' => true])->label(false);?>  
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Email">Email: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <?= $form->field($model, 'FmyEmailAddr')->textInput(['maxlength' => true])->label(false);?>  
        </div>
        </div> 
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Pewaris">Pewaris: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <?= $form->field($model, 'FmyNextOfKinStatus')->checkbox(['label'=>'tanda jika pewaris', 'value'=>1, 'uncheck'=>0]);?>  
        </div>
        </div> 
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NoDihubungiSekiranyaKecemasan">No. Dihubungi Sekiranya Kecemasan: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <?= $form->field($model, 'FmyEmerContactStatus')->checkbox(['label'=>'tanda jika boleh dihubunngi', 'value'=>1, 'uncheck'=>0]);?>  
        </div>
        </div> 
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="PenerimaPencen">Penerima Pencen: <span class="required" style="color:red;"></span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <?= $form->field($model, 'FmyPensionRecipient')->checkbox(['label'=>'tanda jika penerima pencen', 'value'=>1, 'uncheck'=>0]);?>  
        </div>
        </div> 
            
        </div>
    </div>
    
    <div class="form-group text-center">
        <?= \yii\helpers\Html::a( 'Kembali', ['adminview','icno'=>$model->ICNO], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text'=>'Please wait..']]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


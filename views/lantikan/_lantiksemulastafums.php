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
<div class="x_panel">
    <div class="x_title">
        <h2><?= 'Maklumat Dan Rekod Kakitangan' ?></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="row text-center">
            <div class="col-lg-1 col-sm-3 col-xs-12 text-center">
                <div class="col-lg-1 col-md-1 col-xs-12 text-center" rowspan="6" valign="top"><span><img height='100px' width="80px" src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(hash('sha1', $model->ICNO)); ?>.jpeg"></span></div>
            </div>
            <div class="col-lg-11 col-sm-9 col-xs-12">
                <div class="row">
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>Nama:</b></div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 text-left"><?= $model->gelaran->Title . " " . ucwords(strtolower($model->CONm)) ?></div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>No. KP / Paspot:</b></div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 text-left "><?= $model->ICNO ?></div>
                </div>
                <div class="row ">
                    <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jabatan:</b></div>
                    <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= ucwords(strtolower($model->department->fullname)) ?></div>
                    <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Kampus Cawangan:</b></div>
                    <div class="col-lg-4 col-sm-6 col-xs-6 text-left "><?= ucwords(strtolower($model->kampus->campus_name)) ?></div>
                </div>
                <div class="row">
                    <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>UMSPER:</b></div>
                    <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model->COOldID ?></div>
                    <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jawatan Disandang:</b></div>
                    <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->jawatan->nama . " (" . $model->jawatan->gred . ")"; ?></div>
                </div>
                <div class="row">
                    <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Sandangan:</b></div>
                    <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model->statusSandangan->sandangan_name ?></div>
                    <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tarikh Mula Sandangan:</b></div>
                    <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->displayStartSandangan ?></div>
                </div>
                <div class="row">
                    <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Jawatan:</b></div>
                    <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model->statusLantikan->ApmtStatusNm ?></div>
                    <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tempoh Lantikan:</b></div>
                    <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->displayStartLantik ?> hingga <?= $model->tarikhbersara ?></div>
                </div>
                <div class="row">
                    <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Pekerja:</b></div>
                    <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><span><?= $model->Status ? $model->serviceStatus->ServStatusNm : 'Not Set' ?></span></div>
                    <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tarikh Mula Status:</b></div>
                    <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->displayStartDateStatus ?></div>
                </div>
            </div>
        </div> </br>

    </div>


</div>
<!-- form start -->
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

<div class="x_panel" style="background-color:#b4bdcc;color:black;">
    <div class="x_title">
        <h2>MELAKSANAKAN LANTIKAN BARU KAKITANGAN SEDIA ADA</h2>
        <ul class="nav navbar-right panel_toolbox">

        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="umsper">UMSPER: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= Html::input('text','dummy','', $options=['placeholder'=>$umsper_ex,'class'=>'form-control', 'maxlength'=>10, 'style'=>'width:350px','disabled' => true])?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="statusLantikan">Status Lantikan: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">

                <?=
                    $form->field($model, 'statLantikan')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(StatusLantikan::find()->all(), 'ApmtStatusCd', 'ApmtStatusNm'),
                        'options' => ['placeholder' => 'Pilih Status Lantikan', 'class' => 'form-control col-md-7 col-xs-12'],
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
                        'model' => $model,
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
                        'model' => $model,
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
                    $form->field($model, 'gredJawatan')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(GredJawatan::find()->orderBy(['nama' => SORT_ASC])->all(), 'id', 'fname'),
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
                    $form->field($model, 'statSandangan')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(StatusSandangan::find()->all(), 'sandangan_id', 'sandangan_name'),
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
                    $form->field($model, 'ApmtTypeCd')->label(false)->widget(Select2::classname(), [
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
                <?= $form->field($model, 'noWaran')->textInput()->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jabatan">Jabatan: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">

                <?=
                    $form->field($model, 'DeptId')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Department::find()->where(['isActive'=>'1'])->all(), 'id', 'fullname'),
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
                    $form->field($model, 'campus_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Kampus::find()->all(), 'campus_id', 'campus_name'),
                        'options' => ['placeholder' => 'Pilih Kampus', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pendidikanTertinggi">Pendidikan Tertinggi: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">

                <?=
                    $form->field($model, 'HighestEduLevelCd')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(PendidikanTertinggi::find()->where(['isActive'=>'1'])->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
                        'options' => ['placeholder' => 'Pilih Pendidikan Tertinggi', 'class' => 'form-control col-md-7 col-xs-12'],
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
                        'model' => $model,
                        'attribute' => 'ConfermentDt',
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

<div class="form-group text-center">
    <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?>
    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
<!-- form end -->
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use app\models\hronline\Institut;
use app\models\hronline\PendidikanTertinggi;
use app\models\hronline\Penaja;
use app\models\hronline\MajorMinor;
use yii\helpers\Url;

$js = <<<js
    $(document).ready(function(){

        ////////Bon/////////////////

        var val1 = $("#bon").val();
        switch(parseInt(val1)) {
            case 1:
                $(".jumlahbon").show();
                break;
            default:
                $(".jumlahbon").hide();
                break;
        }  
    });

    ////////tarikh mula pengajian/////////////////
        var tp = $("#tahap_pendidikan").val();
        switch(parseInt(tp)) {
            case 1:
                $(".tarikh_mula_pengajian").show();
                $("#tarikhmulapengajian").prop('required',true);
                break;
            default:
                $(".tarikh_mula_pengajian").hide();
                $("#tarikhmulapengajian").prop('required',false);
                break;
        }

    $('#tahap_pendidikan').on('select2:close', function(e) {
        var tp = $('#tahap_pendidikan').val();
        switch(parseInt(tp)) {
            case 1:
                $(".tarikh_mula_pengajian").show();
                $("#tarikhmulapengajian").prop('required',true);
                break;
            default:
                $(".tarikh_mula_pengajian").hide();
                $("#tarikhmulapengajian").prop('required',false);
                $("#tarikhmulapengajian").val("");
                break;
        }
        $('#tahap_pendidikan').val(tp);
    }); 

    
js;
$this->registerJs($js);

?>

<div class="tblpendidikan-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

    <div class="x_panel">
        <div class="x_title">
            <h2><?= $this->title; ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Institut">Institusi: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                        $form->field($model, 'InstCd')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Institut::find()->where(['isActive' => 1])->all(), 'InstCd', 'InstNm'),
                            'options' => ['placeholder' => 'Pilih Institusi', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NamaSijilBm">Nama Institusi: <span class="required" style="color:red;"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'InstNm')->textInput(['placeholder' => 'Jika ada'], ['maxlength' => true])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TahapPendidikan">Tahap Pendidikan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                        $form->field($model, 'HighestEduLevelCd')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(PendidikanTertinggi::find()->where(['isActive' => 1])->orderBy(['newEduRank' => SORT_ASC])->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
                            'options' => ['placeholder' => 'Pilih Tahap Pendidikan', 'class' => 'form-control col-md-7 col-xs-12','id'=>'tahap_pendidikan'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Tajaan">Tajaan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                        $form->field($model, 'SponsorshipCd')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Penaja::find()->where(['isActive' => 1])->all(), 'SponsorshipCd', 'SponsorshipNm'),
                            'options' => ['placeholder' => 'Pilih Tajaan', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Major">Bon: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-2 col-sm-2 col-xs-12">
                    <?=
                        $form->field($model, 'Bon')->label(false)->widget(Select2::classname(), [
                            'data' => ["1" => "Ya", "0" => "Tidak"],
                            'options' => [
                                'placeholder' => 'Ya jika ada', 'class' => 'form-control col-md-7 col-xs-12',
                                'onchange' => 'javascript: if($(this).val() == 1){
                    $("#jumlahbon").show();
                }else{
                    $("#jumlahbon").hide();
                } '
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?>
                </div>
            </div>
            <div class="form-group jumlahbon" id="jumlahbon">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Bon: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <?= $form->field($model, 'JumlahBon')->textInput(['placeholder' => 'Jumlah bulan'], ['maxlength' => true])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Major">Major: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                        $form->field($model, 'MajorCd')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(MajorMinor::find()->all(), 'MajorMinorCd', 'MajorMinor'),
                            'options' => ['placeholder' => 'Pilih Major', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Minor">Minor (Jika ada): <span class="required" style="color:red;"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                        $form->field($model, 'MinorCd')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(MajorMinor::find()->all(), 'MajorMinorCd', 'MajorMinor'),
                            'options' => ['placeholder' => 'Pilih Minor', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NamaSijilBm">Nama Sijil (Malay): <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'EduCertTitle')->textInput(['maxlength' => true])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NamaSijilBi">Nama Sijil (English): <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'EduCertTitleBI')->textInput(['maxlength' => true])->label(false); ?>
            </div>
        </div>
        <div class="form-group tarikh_mula_pengajian">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TarikhDianugerahkan">Tarikh Mula Pengajian: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'StartEduDt',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12','id'=>'tarikhmulapengajian'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TarikhDianugerahkan">Tarikh Dianugerahkan: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
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
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="GredKeseluruhan">Gred Keseluruhan: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <?= $form->field($model, 'OverallGrade')->textInput(['placeholder' => 'LULUS / 3.00 / A'], ['maxlength' => true])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="StatusPengiktirafan">Status Pengiktirafan: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <?= $form->field($model, 'AcrtdEduAch')->checkbox(['label' => 'Tanda jika Diiktiraf', 'value' => 1, 'uncheck' => 0]); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Upload File: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-4 col-sm-4 col-xs-10">
                <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                <?php 
                    if( $model->isNewRecord ? $msg = 'Please provide file in pdf format.' : ($model->filename ? $msg =  Yii::$app->FileManager->NameFile($model->filename) : $msg = 'Please provide related file.'));
                    echo $form->field($model, 'file')->fileInput()->label($msg." (Max size 6.0 MB)");?>
            </div>
            <div class="jtooltip"><i class="fa fa-info-circle fa-md"></i>
                <text>If you have more than one PDF file, please combine into one unified document. Uploading new file will replace the old file.</text>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 text-right">
            <?= Html::a('Semak Pengiktirafan', "http://www2.mqa.gov.my/esisraf/", ['target' => 'blank', 'class' => 'btn btn-primary']) ?>
            <p></p>
        </div>
    </div>

</div>
</div>

<div class="form-group text-center">
    <?= Html::a('Kembali', ['adminview', 'icno'=>$model->ICNO],  ['class' => 'btn btn-primary']) ?>
    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please wait..']]) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
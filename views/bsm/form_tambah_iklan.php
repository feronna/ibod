<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use yii\widgets\ActiveForm;
use app\models\hronline\PendidikanTertinggi;

$title = $this->title = 'Iklan';

?>
<?php echo $this->render('menu', ['title' => $title]) ?> 
<div class="iklan-form"> 
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Tambah Iklan</h2> 
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Jawatan: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($iklan, 'jawatan_id')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\GredJawatan::find()->all(), 'id', 'fname'),
                            'options' => ['placeholder' => 'Pilih Jawatan'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                        ?>
                    </div>
                </div> 

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Klasifikasi: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($iklan, 'klasifikasi_id')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\ejobs\KlasifikasiJawatan::find()->all(), 'id', 'name'),
                            'options' => ['placeholder' => 'Pilih Klasifikasi'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Penempatan: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($iklan, 'penempatan_id')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\Kampus::find()->all(), 'campus_id', 'campus_name'),
                            'options' => ['placeholder' => 'Pilih Penempatan'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Kategori: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($iklan, 'kategori_iklan_id')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\ejobs\KategoriJawatan::find()->all(), 'id', 'name'),
                            'options' => ['placeholder' => 'Pilih Kategori'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Taraf Jawatan: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($iklan, 'taraf_jawatan')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\StatusLantikan::find()->all(), 'ApmtStatusCd', 'ApmtStatusNm'),
                            'options' => ['placeholder' => 'Pilih Taraf Jawatan', 'multiple' => true],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Jumlah Kekosongan: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($iklan, 'jumlah_kekosongan')->textInput()->label(false); ?> 
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Tarikh Buka: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($iklan, 'tarikh_buka')->widget(
                                DatePicker::className(), [
                            'template' => '{input}{addon}',
                            'options' => [array('tarikh_buka', 'date', 'format' => 'yyyy-mm-dd', 'class' => 'col-lg-4'), 'placeholder' => 'Tarikh Buka'],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ])->label(false);
                        ?> 
                    </div>
                </div>  
                <div class="x_title">
                    <h2>Kelayakan</h2> 
                    <div class="clearfix"></div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Pendidikan Tertinggi: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($iklan, 'min_edu')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(PendidikanTertinggi::find()->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
                            'options' => ['placeholder' => 'Pilih Pendidikan Tertinggi', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                        ?>
                    </div>
                </div> 

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kredit Bahasa Melayu (SPM):  
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">

                        <?= $form->field($iklan, 'min_bm_spm')->checkbox(['label' => 'Tanda jika YA', 'value' => 1, 'uncheck' => 0])->label(false); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kredit Bahasa Melayu (PMR):  
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">

                        <?=
                        $form->field($iklan, 'min_bm_pmr')->checkbox(['label' => 'Tanda jika YA', 'value' => 1, 'uncheck' => 0])->label(false);
                        ;
                        ?>
                    </div>
                </div> 

                <div class="form-group">
                    <div class="col-sm-3"></div> 
                    <div class="col-sm-9">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']); ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>

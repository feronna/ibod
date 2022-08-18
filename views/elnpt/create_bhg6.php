<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;    
use app\models\elnpt\TblPenyelidikan;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kategori</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($pnp, 'kategori')->label(false)->widget(Select2::classname(), [
                            'data' => [
                                'PERUNDINGAN' => 'PERUNDINGAN',
                                'KHIDMAT MASYARAKAT' => 'KHIDMAT MASYARAKAT',
                                'SANJUNGAN DAN KEPAKARAN' => 'SANJUNGAN DAN KEPAKARAN',
                                'ANUGERAH' => 'ANUGERAH',
                            ],
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Projek</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                            $form->field($pnp, 'nama_projek')->textInput([
//                                'placeholder' => 'Jam Kredit',
                                ])->label(false);
                        ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Peranan</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($pnp, 'peranan')->label(false)->widget(Select2::classname(), [
                            // 'data' => ['Ketua' => 'Ketua',
                            //     'Ahli' => 'Ahli Biasa',
                            //     'Pembentang' => 'Pembentang',
                            //     'Pengerusi Sesi' => 'Pengerusi Sesi',
                            //     'Keynote Speaker' => 'Keynote Speaker',
                            //     'Panel' => 'Panel',
                            //     'Pengerusi Viva Voce' => 'Pengerusi Viva Voce',
                            //     'Peserta' => 'Peserta',
                            //     'Reviewer' => 'Reviewer',
                            //     'Editor' => 'Editor',
                            //     'Berjawatan' => 'Ahli Berjawatan',
                            //     'Setiausaha' => 'Setiausaha', 
                            //     'Bendahari' => 'Bendahari', 
                            //     'Timbalan Pengerusi' => 'Timbalan Pengerusi', 
                            //     'Timbalan Setiausaha' => 'Timbalan Setiausaha',
                            //     'Examiner' => 'Examiner',
                            //     'Penceramah' => 'Penceramah',
                            //     'Penilai Tesis' => 'Penilai Tesis',
                            //     'Perunding' => 'Perunding',
                            //     'Penilai Permohonan' => 'Penilai Permohonan Geran Penyelidikan',
                            //     'Anugerah PNP' => 'Penerima Anugerah Pengajaran & Pembelajaran',
                            //     'Anugerah Penyeliaan' => 'Penerima Anugerah Penyeliaan',
                            //     'Anugerah Penyelidikan' => 'Penerima Anugerah Penyelidikan',
                            //     'Anugerah Penerbitan' => 'Penerima Anugerah Penerbitan',
                            //     'Anugerah SNI' => 'Penerima Anugerah Persidangan Dan Inovasi',
                            //     'Ketua Panel' => 'Ketua Panel',
                            //     'Ketua Perunding' => 'Ketua Perunding',
                            //     'Ketua Penilai Geran' => 'Ketua Penilai Geran',
                            //     'Ketua Editor Jurnal' => 'Ketua Editor Jurnal',
                            //     ],
                            'data' => ArrayHelper::map(app\models\elnpt\elnpt2\RefAspekSkor::find()->where(['bahagian'=> 6, 'aspek_id' => 19])->all(), 'desc', 'desc'),
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahap Penyertaan</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($pnp, 'tahap_penyertaan')->label(false)->widget(Select2::classname(), [
                                    'data' => [
                                        'Kampung' => 'Kampung',
                                        'Sekolah' => 'Sekolah',
                                        'Daerah' => 'Daerah',
                                        'University' => 'University / Fakulti',
                                'State' => 'State',
                                'National' => 'National',
                                'International' => 'International',
                                        ],
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Amaun Geran (RM)</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($pnp, 'amaun')->label(false)->widget(Select2::classname(), [
                            'data' => ['0' => 'RM0', '1' => 'RM1-RM5,000', 
                                '5001' => 'RM5,000 - RM25,000', '25001' => 'RM25,001 dan ke atas'],
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
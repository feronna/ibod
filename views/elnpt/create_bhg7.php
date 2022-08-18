<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;    
use app\models\elnpt\TblPenyelidikan;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use app\models\elnpt\elnpt2\RefAspekSkor;

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
                            // 'data' => ['PENTADBIRAN' => 'PENTADBIRAN',
                            //     'PENGANJURAN PROGRAM (BUKAN AKADEMIK)' => 'PENGANJURAN PROGRAM BUKAN AKADEMIK',
                            //     'PENGANJURAN PROGRAM (AKADEMIK)' => 'PENGANJURAN PROGRAM AKADEMIK',
                            //     'BADAN PROFESIONAL (BUKAN AKADEMIK)' => 'BADAN PROFESIONAL BUKAN AKADEMIK',],
                            'data' => ArrayHelper::map(RefAspekSkor::find()->where(['bahagian'=> 7, 'aspek_id' => 22])->all(), 'desc', 'desc'),
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Jawatankuasa</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?=
                            $form->field($pnp, 'nama_jawatan')->textInput([
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
                                //     'data' => ['JAWATAN BERELAUN DI UNIVERSITI' => 'JAWATAN BERELAUN DI UNIVERSITI',
                                // 'PENGERUSI' => 'PENGERUSI',
                                // 'TIMBALAN PENGERUSI' => 'TIMBALAN PENGERUSI',
                                // 'PENASIHAT' => 'PENASIHAT',
                                // 'PENYELARAS' => 'PENYELARAS',
                                // 'AHLI' => 'AHLI'],
                                'data' => ArrayHelper::map(RefAspekSkor::find()->where(['bahagian'=> 7, 'aspek_id' => 23])->all(), 'desc', 'desc'),
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahap Lantikan</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($pnp, 'tahap_lantikan')->label(false)->widget(Select2::classname(), [
                            // 'data' => ['PROGRAM' => 'PROGRAM', 'FAKULTI' => 'FAKULTI', 
                            //     'UNIVERSITI' => 'UNIVERSITI', 'DAERAH' => 'DAERAH'
                            //     , 'NEGERI' => 'NEGERI'
                            //     , 'KEBANGSAAN' => 'KEBANGSAAN'
                            //      , 'ANTARABANGSA' => 'ANTARABANGSA'],
                            'data' => ArrayHelper::map(RefAspekSkor::find()->where(['bahagian'=> 7, 'aspek_id' => 24])->all(), 'desc', 'desc'),
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
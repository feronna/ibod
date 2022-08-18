<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;    
use app\models\elnpt\RefPnpKursus;
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kod Kursus</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($pnp, 'kod_kursus')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(RefPnpKursus::find()
                                    ->select(['distinct(KodSubjek)'])
//                                    ->where(['like', 'KodSesi_Sem', '2019'])
//                                    ->groupBy(['SMP07_KodMP'])
                                    ->all(), 'KodSubjek', 'KodSubjek'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Carian ...', 
                                'id' => 'ppp'
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Kursus</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($pnp, 'nama_kursus')->label(false)->widget(DepDrop::classname(), [
                            'type' => DepDrop::TYPE_SELECT2,
//                            'data' => ArrayHelper::map(RefPnpKursus::find()
//                                    ->select('distinct(SMP07_KodMP) as id, NamaKursus as name')
////                                    ->select(['SMP07_KodMP'])
////                                    ->where(['like', 'KodSesi_Sem', '2019'])
////                                    ->groupBy(['SMP07_KodMP'])
//                                    ->all(), 'NamaKursus', 'NamaKursus'),
                            'options' => ['id' => 'subcat1-id', 'placeholder' => 'Carian ...'],
                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                            'pluginOptions' => [
                                //'placeholder' => 'Pilih PPP',
                                'depends' => ['ppp'],
                                'url' => Url::to(['/elnpt/pnp-kursus-list']),
//                                'params' => ['input-type-1', 'input-type-2']
                            ]
                        ]);
                    ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Bil Pelajar</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                            $form->field($pnp, 'bil_pelajar')->textInput([
//                                'placeholder' => 'Bil Pelajar',
                                ])->label(false);
                        ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Seksyen</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                            $form->field($pnp, 'seksyen')->textInput([
//                                'placeholder' => 'Bil Pelajar',
                                ])->label(false);
                        ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Sesi</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                    <?=
                        $form->field($pnp, 'sesi')->label(false)->widget(Select2::classname(), [
                            'data' => [
                                '1-2018/2019' => '1 - 2018/2019', 
                                '2-2018/2019' => '2 - 2018/2019',
                                '3-2018/2019' => '3 - 2018/2019',
                                '1-2019/2020' => '1 - 2019/2020', 
                                '2-2019/2020' => '2 - 2019/2020',
                                '3-2019/2020' => '3 - 2019/2020',
                                ],
                            'hideSearch' => true,
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jam Kredit</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                            $form->field($pnp, 'jam_kredit')->textInput([
//                                'placeholder' => 'Jam Kredit',
                                ])->label(false);
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
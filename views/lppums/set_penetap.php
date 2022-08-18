<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun Penilaian</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($model, 'tahun')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\lppums\TblLppTahun::find()->orderBy(['lpp_tahun' => SORT_DESC,])->all(), 'lpp_tahun', 'lpp_tahun'),
                            'options' => [
                              'placeholder' => 'Carian ...',
                                'id'=>'tahun'
                              ],
                            ])
                        ->label(false);
                    ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">J/F/P/I/U</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($model, 'dept_id')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\elnpt\Department::find()->orderBy(['fullname' => SORT_ASC,])->all(), 'id', 'fullname'),
                            'options' => [
                              'placeholder' => 'Carian ...',
                                'id'=>'dept_id'
                              ],
                            ])
                        ->label(false);
                    ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Penetap Penilai</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($model, 'penetap_icno')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->orderBy(['CONm' => SORT_ASC,])->all(), 'ICNO', 'CONm'),
                            'options' => [
                              'placeholder' => 'Carian ...',
                                'id'=>'penetap'
                              ],
                            ])
                        ->label(false);
                    ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                        <?= Html::submitButton('Daftar', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            
            <?php ActiveForm::end(); ?>
            <?php yii\widgets\Pjax::end() ?>
        </div>
    </div>
    </div>
</div>       
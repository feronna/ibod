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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">J/F/P/I/U</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                        $form->field($model, 'penetap_jfpiu')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\elnpt\Department::find()->orderBy(['fullname' => SORT_ASC,])->all(), 'id', 'fullname'),
                            'options' => [
                              'placeholder' => 'Pilh J/F/P/I/U',
                                'id'=>'jabatan'
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
                        $form->field($model, 'penetap_icno')->widget(DepDrop::classname(), [
                            'type' => DepDrop::TYPE_SELECT2,
                            'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                            'options' => ['id' => 'penetap-icno-id', 'placeholder' => 'Pilih Penetap'],
                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                            'pluginOptions' => [
//                                'placeholder' => 'Pilih Penetap',
                                'depends' => ['jabatan'],
                                'initialize' => $model->isNewRecord ? false : true,
                                'url' => Url::to(['elnpt/list-penetap'])
                            ]
                        ])->label(false);
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
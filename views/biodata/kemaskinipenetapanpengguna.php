<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\hronline\AksesLevel;
use app\models\hronline\AksesLevelKedua;

$this->title = 'Kemaskini Capaian';

?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
    	<div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
        <div class="x_content">
<div class="tblprcobiodata-create">

    <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="negaraKelahiran">Peringkat Capaian: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'accessLevel')->widget(Select2::classname(), ['data' => ArrayHelper::map(AksesLevel::find()->orderBy(['id' => SORT_ASC,])->all(), 'id', 'nama'),
                             'options' => [
                              'placeholder' => 'Pilh Peringkat Capaian',
                              ], 
                    ])->label(false);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tempatKelahiran">Peringkat Capaian Kedua: <span class="required" style="color:red;"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'accessSecondLevel')->widget(DepDrop::classname(), [
                        'type' => DepDrop::TYPE_SELECT2,
                        'data' => ArrayHelper::map(AksesLevelKedua::find()->all(), 'id', 'nama'),
                        'options' => [
                            'multiple' => false],
                        'pluginOptions' => [
                            'depends' => [Html::getInputId($model, 'accessLevel')],
                            'initialize' => true,
                            'placeholder' => 'Pilih Peringkat Capaian Kedua',
                            'url' => Url::to(['/biodata/peringkatcapaiankedua']),
                        ]
                    ])->label(false)
                    ?>
                </div>
            </div>
    </div>
    <div class="form-group text-center">
        <?= Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
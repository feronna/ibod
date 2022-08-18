<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use app\models\hronline\PendidikanTertinggi;
?>

<div class="tblpendidikan-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

    <div class="x_panel">
        <div class="x_title">
            <h2>Pendidikan</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TahapPendidikan">Tahap Pendidikan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                        $form->field($model, 'HighestEduLevelCd')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(PendidikanTertinggi::find()->where(['isActive' => 1])->orderBy(['newEduRank' => SORT_ASC])->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
                            'options' => ['placeholder' => 'Pilih Tahap Pendidikan', 'class' => 'form-control col-md-7 col-xs-12',],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?>
                </div>
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
    </div>



<div class="form-group text-center">
    <?= \yii\helpers\Html::a('Kembali', ['view-lantikan', 'id' => $model->ICNO], ['class' => 'btn btn-primary']) ?>
    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please wait..']]) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
</div>
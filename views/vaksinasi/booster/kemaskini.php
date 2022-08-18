<?php

use app\models\hronline\jenis_vaksin;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblvaksinasi;
use kartik\popover\PopoverX;
use dosamigos\datepicker\DatePicker;
use kartik\datetime\DateTimePicker;
use app\models\hronline\JenisDospenggalak;

$js = <<<js
    
js;
$this->registerJs($js);



?>

<?php
$content =  Html::img('@web/uploads/hronline/keluarga/mysj.png', ['class' => 'pull-left img-responsive']);


?>


<div class="tblvaksinasi-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

    <div class="x_panel">
        <div class="x_title">
            <h4><?= "DOS PENGGALAK" ?></h4>
            <div class="clearfix"></div>
        </div>
        <div class="x_content ">
            
        <div class="form-group ">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Dos: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                    $form->field($model, 'jenis_dos')->label(false)->widget(Select2::classname(), [
                        'data' =>  ArrayHelper::map(JenisDospenggalak::find()->all(), 'id', 'nama'),
                        'options' => ['placeholder' => 'Pilih..', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Terima Dos: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                     DateTimePicker::widget([
                        'model' => $model,
                        'attribute' => 'tarikh_dos',
                        'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                        'options' => ['required'=>true],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd hh:ii',
                        ]
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Tempat Pemberian Dos Penggalak: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'tempat_dos')->textArea(['rows' => '4'],['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>

                </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Batch No.: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'batch_dos')->textArea(['rows' => '3'],['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Luput Dos: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'tarikh_luput',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12','required'=>true],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'catatan')->textArea(['placeholder'=>'Jika Ada','rows' => '4'],['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>

                </div>
            </div>
        </div>
    </div>

    <div class="form-group text-center">
        <?= Html::a('Kembali', ['view-st-vaksinasi'],  ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
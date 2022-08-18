<?php

use app\models\hronline\jenis_vaksin;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblvaksinasi;
use kartik\popover\PopoverX;
use kartik\datetime\DateTimePicker;

$js = <<<js
    
js;
$this->registerJs($js);



?>

<?php
$content =  Html::img('@web/uploads/hronline/keluarga/mysj.png', ['class' => 'pull-left img-responsive']);
$dos = ['0'=>'PERTAMAsss','1'=>'KEDUA'];

?>


<div class="tblvaksinasi-form">

    <div class="x_panel">
        <div class="x_title">
            <h4><?= "KEMASKINI DOS ". $dos[$indexdos]   ?></h4>
            <div class="clearfix"></div>
        </div>
        <div class="x_content ">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Terima Dos: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                     DateTimePicker::widget([
                        'model' => $modeldos,
                        'attribute' => "[{$indexdos}]tarikh_vaksin",
                        'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                        'options' => ['required'=>true],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd HH:ii',
                        ]
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Vaksin: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                    $form->field($modeldos,"[{$indexdos}]jenis_vaksin")->label(false)->widget(Select2::classname(), [
                        'data' =>  ArrayHelper::map(jenis_vaksin::find()->all(), 'id', 'nama_vaksin'),
                        'options' => ['placeholder' => 'Pilih..', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Pusat Pemberian Vaksin / PPV: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($modeldos, "[{$indexdos}]tempat_vaksin")->textArea(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>

                </div>
            </div>
            <div class="form-group ">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Batch Vaksin: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($modeldos, "[{$indexdos}]batch_vaksin")->textArea(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>

                </div>
            </div>
        </div>
    </div>

</div>
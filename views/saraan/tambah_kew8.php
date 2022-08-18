<?php
/* @var $this yii\web\View */

use yii\bootstrap\Alert;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;

// $js = <<<SCRIPT
// /* To initialize BS3 tooltips set this below */
// $(function () { 
//     $("[data-toggle='tooltip']").tooltip(); 
// });;
// /* To initialize BS3 popovers set this below */
// $(function () { 
//     $("[data-toggle='popover']").popover(); 
// });

// $( document ).ready(function() {        
//     $('#lpg').change(function(){
//         if ($(this).val() == 11) {
//            $('#bulan').attr('disabled',false);
//         }else{
//            $('#bulan').attr('disabled',true);
//         }
//     });   
// });        
// SCRIPT;

// $this->registerJs($js);

?>

<div class="row">
    <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
    <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sebab Perubahan</label>
        <div class="col-md-5 col-sm-5 col-xs-12">
            <?=
                $form->field($model, 'srb_change_reason')->label(false)->widget(Select2::classname(), [
                    'data' => yii\helpers\ArrayHelper::map(app\models\gaji\RefRocReason::find()
                        ->all(), 'RR_REASON_CODE', 'RR_REASON_DESC'),
                    'hideSearch' => false,
                    'options' => [
                        'placeholder' => 'Carian ...',
                        'id' => 'sebab',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'pluginEvents' => [
                        'select2:select' => "function() {
                            console.log('change!');
                            $.get('get-remark?code='+$(this).val(), function( data ) {
                                $('#remark').val(data.trim());
                            });
                        }"
                    ]
                ]);
            ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mula Baru</label>
        <div class="col-md-5 col-sm-5 col-xs-12">
            <?=
                $form->field($model, 'srb_effective_date')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => 'Pilih tarikh'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'minView' => 2,
        'maxView' => 4,
                    ]
                ])->label(false);
            ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Akhir Baru</label>
        <div class="col-md-5 col-sm-5 col-xs-12">
            <?=
                $form->field($model1, 'SR_DATE_TO')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => 'Pilih tarikh'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'minView' => 2,
        'maxView' => 4,
                    ]
                ])->label(false);
            ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan</label>
        <div class="col-md-5 col-sm-5 col-xs-12">
            <?=
                $form->field($model, 'srb_remarks')->textarea(['id'=>'remark'])->label(false);
            ?>
        </div>

    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">JFPIU Proses</label>
        <div class="col-md-5 col-sm-5 col-xs-12">
            <?=
                $form->field($model, 'srb_dept_code')->label(false)->widget(Select2::classname(), [
                    'data' => yii\helpers\ArrayHelper::map(app\models\gaji\TblDepartment::find()->all(), 'dm_dept_code', 'dm_dept_desc'),
                    'hideSearch' => false,
                    'options' => [
                        'placeholder' => 'Carian ...',
                        'id' => 'proses'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
            ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
        <div class="col-md-5 col-sm-5 col-xs-12">
            <?=
                $form->field($model, 'elaun_potongan')->hiddenInput(['value' => implode(",", $keylist)])->label(false);
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
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\checkbox\CheckboxX;
use yii\widgets\DetailView;
use kartik\select2\Select2;
use yii\db\Expression;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\color\ColorInput;
// return \yii\helpers\VarDumper::dump($result, $depth = 10, $highlight = true);

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<?php yii\widgets\Pjax::begin(['id' => 'user-frm']) ?>
<?php $form = ActiveForm::begin(['id' => 'user-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Category Name</label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <?=
        $form->field($model, 'name')->textInput([
            // 'placeholder' => 'Cari Nama',
        ])->label(false);
        ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Parent Category</label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <?=
        $form->field($model, 'sub_of')->label(false)->widget(Select2::classname(), [
            'data' => ArrayHelper::map(app\models\ikalendar\RefHrCategories::find()
                ->all(),  'category_id', 'name'),
            'hideSearch' => false,
            'options' => [
                'placeholder' => ' ...',
            ],
            // 'pluginOptions' => [
            //     'allowClear' => true
            // ],
        ]);
        ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Sequence</label>
    <div class="col-md-1 col-sm-1 col-xs-12">
        <?=
        $form->field($model, 'sequence')->textInput([
            'type' => 'number'
            // 'placeholder' => 'Cari Nama',
        ])->label(false);
        ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Text Color</label>
    <div class="col-md-5 col-sm-5 col-xs-12">
        <?=
        $form->field($model, 'color')->widget(ColorInput::classname(), [
            'options' => ['placeholder' => 'Select color ...'],
        ])->label(false);
        ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Background</label>
    <div class="col-md-5 col-sm-5 col-xs-12">
        <?=
        $form->field($model, 'background')->widget(ColorInput::classname(), [
            'options' => ['placeholder' => 'Select color ...'],
        ])->label(false);
        ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
    <div class="col-md-6 col-sm-6 col-xs-12">
        <?=
        $form->field($model, 'description')->textInput([
            // 'placeholder' => 'Cari Nama',
        ])->label(false);
        ?>
    </div>
</div>

<hr style="border-top: dotted 1px;" />

<div class="form-group">
    <div class="col-md-push-3 col-sm-6 col-xs-12">
        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
<?php yii\widgets\Pjax::end() ?>
<br />
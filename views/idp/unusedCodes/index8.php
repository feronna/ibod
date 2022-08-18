<?php
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
// or 'use kartikile\FileInput' if you have only installed yii2-widget-fileinput in isolation

$form = ActiveForm::begin([
//                'action' => ['view_senarai_latihan'],
//                'method' => 'post',
    ]);
 
// Usage with ActiveForm and model
echo $form->field($model, 'avatar')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
]);
 
// With model & without ActiveForm
// Note for multiple file upload, the attribute name must be appended with 
// `[]` for PHP to be able to read an array of files
echo '<label class="control-label">Add Attachments</label>';
echo FileInput::widget([
    'model' => $model,
    'attribute' => 'attachment_1[]',
    'options' => ['multiple' => true]
]);
 
// Usage without a model
echo '<label class="control-label">Upload Document</label>';
echo FileInput::widget([
    'name' => 'attachment_3',
]);
 
// A disabled fileinput input
echo '<label class="control-label">Select Attachment</label>';
echo FileInput::widget([
    'name' => 'attachment_4',
    'disabled' => true
]);
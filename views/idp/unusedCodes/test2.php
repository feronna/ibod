<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin(['layout' => 'horizontal']);

// Form field without label
echo $form->field($model, 'kursus_id', [
    'inputOptions' => [
        'placeholder' => $model->getAttributeLabel('kursus_id'),
    ],
])->label(false);

// Inline radio list
//echo $form->field($model, 'kursus_id')->inline()->radioList($items);

// Control sizing in horizontal mode
echo $form->field($model, 'kursus_id', [
    'horizontalCssClasses' => [
        'wrapper' => 'col-sm-2',
    ]
]);
//
// With 'default' layout you would use 'template' to size a specific field:
echo $form->field($model, 'kursus_id', [
    'template' => '{label} <div class="row"><div class="col-sm-4">{input}{error}{hint}</div></div>'
]);
//
// Input group
echo $form->field($model, 'kursus_id', [
    'inputTemplate' => '<div class="input-group"><span class="input-group-addon">TEST</span>{input}</div>',
]);

ActiveForm::end();
<?php
use yii\helpers\Html;
use kartik\popover\PopoverX;
//use kartik\helpers\Html;
use kartik\form\ActiveForm;
use app\assets\AppAsset;

$bundle = yiister\gentelella\assets\Asset::register($this);
AppAsset::register($this);
     
$content = '<p class="text-justify">' .
        'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.' . 
        '</p>';
        
// right
echo PopoverX::widget([
    'header' => 'Hello world',
    'placement' => PopoverX::ALIGN_RIGHT,
    'content' => $content,
    'footer' => Html::button('Submit', ['class'=>'btn btn-sm btn-primary']),
    'toggleButton' => ['label'=>'Right', 'class'=>'btn btn-default'],
]);
     
// left
echo PopoverX::widget([
    'header' => 'Hello world',
    'placement' => PopoverX::ALIGN_LEFT,
    'content' => $content,
    'footer' => Html::button('Submit', ['class'=>'btn btn-sm btn-primary']),
    'toggleButton' => ['label'=>'Left', 'class'=>'btn btn-default'],
]);
     
// top
echo PopoverX::widget([
    'header' => 'Hello world',
    'placement' => PopoverX::ALIGN_TOP,
    'content' => $content,
    'footer' => Html::button('Submit', ['class'=>'btn btn-sm btn-primary']),
    'toggleButton' => ['label'=>'Top', 'class'=>'btn btn-default'],
]);
     
// bottom
echo PopoverX::widget([
    'header' => 'Hello world',
    'placement' => PopoverX::ALIGN_BOTTOM,
    'content' => $content,
    'footer' => Html::button('Submit', ['class'=>'btn btn-sm btn-primary']),
    'toggleButton' => ['label'=>'Bottom', 'class'=>'btn btn-default'],
]);
     
echo '<hr>';
     
// top left
echo PopoverX::widget([
    'header' => 'Hello world',
    'placement' => PopoverX::ALIGN_TOP_LEFT,
    'content' => $content,
    'footer' => Html::button('Submit', ['class'=>'btn btn-sm btn-primary']),
    'toggleButton' => ['label'=>'Top Left', 'class'=>'btn btn-default'],
]);
     
// bottom left
echo PopoverX::widget([
    'header' => 'Hello world',
    'placement' => PopoverX::ALIGN_BOTTOM_LEFT,
    'content' => $content,
    'footer' => Html::button('Submit', ['class'=>'btn btn-sm btn-primary']),
    'toggleButton' => ['label'=>'Bottom Left', 'class'=>'btn btn-default'],
]);
     
// top right
echo PopoverX::widget([
    'header' => 'Hello world',
    'placement' => PopoverX::ALIGN_TOP_RIGHT,
    'content' => $content,
    'footer' => Html::button('Submit', ['class'=>'btn btn-sm btn-primary']),
    'toggleButton' => ['label'=>'Top Right', 'class'=>'btn btn-default'],
]);
     
// bottom right
echo PopoverX::widget([
    'header' => 'Hello world',
    'placement' => PopoverX::ALIGN_BOTTOM_RIGHT,
    'content' => $content,
    'footer' => Html::button('Submit', ['class'=>'btn btn-sm btn-primary']),
    'toggleButton' => ['label'=>'Bottom Right', 'class'=>'btn btn-default'],
]);
     
    echo '<hr>';
     
    // right top
    echo PopoverX::widget([
        'header' => 'Hello world',
        'placement' => PopoverX::ALIGN_RIGHT_TOP,
        'content' => $content,
        'footer' => Html::button('Submit', ['class'=>'btn btn-sm btn-primary']),
        'toggleButton' => ['label'=>'Right Top', 'class'=>'btn btn-default'],
    ]);
     
    // right bottom
    echo PopoverX::widget([
        'header' => 'Hello world',
        'placement' => PopoverX::ALIGN_RIGHT_BOTTOM,
        'content' => $content,
        'footer' => Html::button('Submit', ['class'=>'btn btn-sm btn-primary']),
        'toggleButton' => ['label'=>'Right Bottom', 'class'=>'btn btn-default'],
    ]);
     
    // left top
    echo PopoverX::widget([
        'header' => 'Hello world',
        'placement' => PopoverX::ALIGN_LEFT_TOP,
        'content' => $content,
        'footer' => Html::button('Submit', ['class'=>'btn btn-sm btn-primary']),
        'toggleButton' => ['label'=>'Left Top', 'class'=>'btn btn-default'],
    ]);
     
    // left bottom
    echo PopoverX::widget([
        'header' => 'Hello world',
        'placement' => PopoverX::ALIGN_LEFT_BOTTOM,
        'content' => $content,
        'footer' => Html::button('Submit', ['class'=>'btn btn-sm btn-primary']),
        'toggleButton' => ['label'=>'Left Bottom', 'class'=>'btn btn-default'],
    ]);
     
    // large
    echo PopoverX::widget([
        'header' => 'Hello world',
        'size' => PopoverX::SIZE_LARGE,
        'placement' => PopoverX::ALIGN_RIGHT,
        'content' => $content,
        'toggleButton' => ['label'=>'Large', 'class'=>'btn btn-default'],
    ]);
     
    // medium
    echo PopoverX::widget([
        'header' => 'Hello world',
        'size' => PopoverX::SIZE_MEDIUM,
        'placement' => PopoverX::ALIGN_RIGHT,
        'content' => $content,
        'toggleButton' => ['label'=>'Medium', 'class'=>'btn btn-default'],
    ]);
     
    // primary
    echo PopoverX::widget([
        'header' => 'Hello world',
        'type' => PopoverX::TYPE_PRIMARY,
        'placement' => PopoverX::ALIGN_BOTTOM,
        'content' => $content,
        'toggleButton' => ['label'=>'Primary', 'class'=>'btn btn-primary'],
    ]);
     
    // info
    echo PopoverX::widget([
        'header' => 'Hello world',
        'type' => PopoverX::TYPE_INFO,
        'placement' => PopoverX::ALIGN_BOTTOM,
        'content' => $content,
        'toggleButton' => ['label'=>'Info', 'class'=>'btn btn-info'],
    ]);
     
    // success
    echo PopoverX::widget([
        'header' => 'Hello world',
        'type' => PopoverX::TYPE_SUCCESS,
        'placement' => PopoverX::ALIGN_BOTTOM,
        'content' => $content,
        'toggleButton' => ['label'=>'Success', 'class'=>'btn btn-success'],
    ]);
     
    // danger
    echo PopoverX::widget([
        'header' => 'Hello world',
        'type' => PopoverX::TYPE_DANGER,
        'placement' => PopoverX::ALIGN_BOTTOM,
        'content' => $content,
        'toggleButton' => ['label'=>'Danger', 'class'=>'btn btn-danger'],
    ]);
     
    // warning
    echo PopoverX::widget([
        'header' => 'Hello world',
        'type' => PopoverX::TYPE_WARNING,
        'placement' => PopoverX::ALIGN_BOTTOM,
        'content' => $content,
        'toggleButton' => ['label'=>'Warning', 'class'=>'btn btn-warning'],
    ]);
     
//    // advanced html content (forms) with popover footer
//    use kartik\popover\PopoverX;
//    use kartik\helpers\Html;
//    use kartik\form\ActiveForm;
    
    PopoverX::begin([
        'placement' => PopoverX::ALIGN_TOP,
        'toggleButton' => ['label'=>'Login', 'class'=>'btn btn-default'],
        'header' => '<i class="glyphicon glyphicon-lock"></i> Enter credentials',
        'footer' => Html::button('Submit', [
                'class' => 'btn btn-sm btn-primary', 
                'onclick' => '$("#kv-login-form").trigger("submit")'
            ]) . Html::button('Reset', [
                'class' => 'btn btn-sm btn-default', 
                'onclick' => '$("#kv-login-form").trigger("reset")'
            ])
    ]);
    
    // form with an id used for action buttons in footer
    $form = ActiveForm::begin(['fieldConfig'=>['showLabels'=>false], 'options' => ['id'=>'kv-login-form']]);
    echo $form->field($model, 'v_co_icno')->textInput(['placeholder'=>'Enter user...']);
    echo $form->field($model, 'v_co_name')->passwordInput(['placeholder'=>'Enter password...']);
    ActiveForm::end();
    PopoverX::end();
    
// can use any tag/element. example for the span
// element (set the title or data-title attribute 
// to type in tooltip content)
echo 'Testing for ' . Html::tag('span', 'tooltip', [
    'title'=>'This is a test tooltip',
    'data-toggle'=>'tooltip',
    'style'=>'text-decoration: underline: cursor:pointer;'
]);

// can use any tag/element. example for the span
// element (set the title or data-title attribute 
// for popover title and the data-content attribute
// for the popover content)
echo '<br><br>Testing for ' . Html::tag('span', 'popover', [
    'data-title'=>'Heading',
    'data-content'=>'This is the content for the popover',
    'data-toggle'=>'popover',
    'style'=>'text-decoration: underline: cursor:pointer;'
]);





<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\widgets\TopMenuWidget;
use yii\widgets\ActiveForm;
use kartik\sortinput\SortableInput;

$items = [];
foreach ($models as $mod) {
    $items[$mod->id] = [
        'content' => '<i class="fa fa-sort"></i> '.$mod->label,
        'options' => ['data' => ['id'=>$mod->id]],
    ];
}

?>

<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1,2,3,4, 1179, 1180]]) ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Ubah Urutan Side Menu Bosku</strong></h2>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php
                $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['class' => 'form-horizontal']]);
        
                echo $form->field($model, 'parent_order')->widget(SortableInput::classname(), [
                    'items' => $items,
                    'hideInput' => true,
                    'options' => ['class'=>'form-control', 'readonly'=>true]
                ])->label(false);
            ?>    
                <div class="form-group pull-right">
                        <?= Html::submitButton('Update Urutan', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php    
                ActiveForm::end();
            ?>
        </div>
    </div></div>
</div>
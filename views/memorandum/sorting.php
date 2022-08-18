<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\lnpt\RefAkses;
use yii\helpers\ArrayHelper;
use kartik\sortinput\SortableInput;


$items = [];
foreach ($models as $mod) {
    $items[$mod->id] = [
        'content' => '<i class="fa fa-sort"></i> '.$mod->perkara,
        'options' => ['data' => ['id'=>$mod->id]],
    ];
}

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

   <?= Html::a('Kembali', ['senarai-pelaporan'], ['class' => 'btn btn-primary']) ?>
<div class="row">
 <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
                  
<div class="panel-body">
    <?php yii\widgets\Pjax::begin(['id' => 'update-menu']) ?>
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
    <?php yii\widgets\Pjax::end() ?>
</div>
    
        </div>
 </div>
</div>
            
                
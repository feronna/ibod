<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php

$this->registerJs(
   '$("document").ready(function(){ 
		$("#new_country").on("pjax:end", function() {
			$.pjax.reload({container:"#countries"});  //Reload GridView
		});
    });'
);
?>

<div class="countries-form">

<?php yii\widgets\Pjax::begin(['id' => 'new_country']) ?>
<?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>

    <?= $form->field($new_disease, 'description')->textInput(['maxlength' => 200]) ?>


    <div class="form-group">
        <?= Html::submitButton('Simpan',['class' => 'btn btn-success', 'data'=>['disabled-text'=>'Please wait..']]) ?>
    </div>

<?php ActiveForm::end(); ?>
<?php yii\widgets\Pjax::end() ?>
</div>
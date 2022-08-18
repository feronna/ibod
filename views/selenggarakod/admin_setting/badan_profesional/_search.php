<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\KlasifikasiPerkhidmatan;
use yii\helpers\Url;

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

<div class="x_title">
    <h2>Carian</h2>
    <div class="clearfix"></div>
</div>
<?php yii\widgets\Pjax::begin(['id' => 'new_country']) ?>
<?php $form = ActiveForm::begin([
    'action' => ['selenggarakod/set-badanprofesional-skim'],
    'method' => 'get',
    'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]
]); ?>

    <div class="form-group">
        <?=
        $form->field($carian, 'bp_id')->hiddenInput(['value' => $bp_id])->label(false);
        ?>
        <div class=" col-md-4 col-sm-4 col-xs-12">

            <?=
            $form->field($carian, 'gred_skim')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(KlasifikasiPerkhidmatan::find()->orderBy(['gred_skim' => SORT_ASC])->all(), 'gred_skim', 'gred_skim'),
                'options' => ['placeholder' => 'Pilih..', 'class' => 'form-control col-md-2 col-xs-12'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class=" col-md-1 col-sm-1 col-xs-12">
            <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Cari', ['class' => 'btn btn-primary', 'name' => 'submit_1', 'value' => '1']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
<?php yii\widgets\Pjax::end() ?>
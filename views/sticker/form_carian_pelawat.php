<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>

<?= $this->render('menu') ?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>  
<div class="x_panel"> 
    <div class="x_title">
        <h2><?= $title ?></h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">     

        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Nama: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-4">   
                    <?=
                    $form->field($model, 'id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\esticker\TblPelawat::find()->where(['not in','CatCd',[1]])->all(), 'id', 'CONm'),
                        'options' => ['placeholder' => 'Nama', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1">
                    <?= Html::submitButton('Cari', ['class' => 'btn btn-success', 'data'=>['disabled-text'=>'Sila Tunggu..']]) ?>
                </div>
            </div>
        </div>
 

        <?php ActiveForm::end(); ?>

    </div>
</div> 

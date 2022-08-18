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
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Kontraktor: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-4">   
                    <?php
                    $form->field($model, 'id_kontraktor')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\esticker\TblKontraktor::find()->where(['>','DATE(tarikhtamatsah)',date('Y-m-d')])->all(), 'apsu_suppid','apsu_lname'),
                        'options' => ['placeholder' => 'Kontraktor', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                    
                      <?=
                    $form->field($model, 'id_kontraktor')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\Kontraktor\SyarikatKontraktor::find()->all(), 'apsu_suppid', 'name'),
                        'options' => ['placeholder' => 'Kontraktor', 'class' => 'form-control col-md-7 col-xs-12'],
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

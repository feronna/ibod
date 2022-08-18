<?php
 
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?> 
<?= $this->render('menu') ?>
<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="x_panel"> 
        <div class="x_content">
            <?php $form = ActiveForm::begin(); ?>

            <div class="col-md-3 col-sm-3 col-xs-3 col-md-offset-4 col-sm-offset-4 col-xs-offset-4">
                <?= $form->field($permohonan, 'gl_ICNO')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => 'Nama Staff'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);?>
            </div>
            <div class="text-center col-md-1 col-sm-1 col-xs-1">
                <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?>  
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div> 

</div>  


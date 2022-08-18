<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\hronline\GredJawatan;
use app\models\mohonjawatan\TblOpenpos;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use app\widgets\TopMenuWidget;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $model app\models\mohonjawatan\TblPermohonan */
/* @var $form ActiveForm */

$this->registerJs(
    "$('#save-draft-btn').on('click', function (e) {
$.ajax({
   type: 'POST',
   url: draftUrl,
   data: $('#report-index').serialize()
});      
})",
    'my-button-handler'
);
?>
<?= TopMenuWidget::widget(['top_menu' => [18, 44, 45, 51], 'vars' => [
    ['label' => ''],
    //    ['label' => app\models\kontrak\Kontrak::totalPending(Yii::$app->user->getId())]
]]); ?>
<?php
$model->d_nama = $name;
// $model-> = $position;
?>
<div class="col-md-12 col-sm-12">
    <div class="x_panel">

        <div class="x_title">
            <h2>Permohonan Jawatan</h2>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>


            <div class="clearfix"></div>

            <label class="control-label col-md-4 col-sm-4 col-sm-4 col-xs-12">Card Language <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'language_id')->label(false)->widget(Select2::classname(), [
                    'data' => ['0' => 'Both (English & Malay)', '1' => 'English', '2' => 'Malay'],
                    'options' => [
                        'required' => true, 'placeholder' => 'Choose', 'class' => 'form-control col-md-7 col-xs-12',
                        'onchange' => 'status($(this).val())'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
            <div class="form-group">

                <label class="control-label col-md-2 col-sm-2 col-xs-12">Title<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'title_bi')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => false]); ?>

                </div>
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-sm-4 col-xs-12">Applicant Name<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php echo $form->field($model, 'd_nama')->label(false)->textInput(['id' => 'inputID', 'class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => false]); ?>
                    </div>
                </div>
                <div class="clearfix"></div>

                <br>

                <div class="clearfix"></div>
                <label class="control-label col-md-4 col-sm-4 col-sm-4 col-xs-12">Education Background<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-3 col-sm-3 col-sm-3 col-xs-12">English<span class="required"></span>
                    </label>
                    <?php echo $form->field($model, 'd_edu_bi_1')->label(false)->textArea(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => false, 'placeholder' => 'Skip if chosen Language is Malay Only']); ?>
                    <br>
                    <br>
                    <label class="control-label col-md-3 col-sm-3 col-sm-3 col-xs-12">Malay<span class="required">*</span>
                    </label>

                    <?php echo $form->field($model, 'd_edu_bm_1')->label(false)->textArea(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => false, 'placeholder' => 'Skip if chosen Language is English Only']); ?>

                </div>
                </li>
            </div>
            <div class="clearfix"></div>
            <br>
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 col-sm-4 col-xs-12">Position<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'title_bm')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => false]); ?>
                </div>
            </div>
            <div class="clearfix"></div>

            <!-- <div id="sym" style="display:none" class="form-group">
                 <label class="control-label col-md-4 col-sm-4 col-sm-4 col-xs-12">Education Background<span class="required">*</span>
                 </label>
                 <div class="col-md-6 col-sm-6 col-xs-12">
                 <?php echo $form->field($model, 'title_bm')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => false]); ?>
                <br>
                <br>
                 <?php echo $form->field($model, 'title_bm')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => false]); ?>

                 </div>
                 </li>
             </div> -->

            <div class="clearfix"></div>
            <br>
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 col-sm-4 col-xs-12">JFPIU<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'title_bm')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => false]); ?>
                </div>
            </div>
            <div class="clearfix"></div>

            <!-- <div id="sym" style="display:none" class="form-group">
                 <label class="control-label col-md-4 col-sm-4 col-sm-4 col-xs-12">Education Background<span class="required">*</span>
                 </label>
                 <div class="col-md-6 col-sm-6 col-xs-12">
                 <?php echo $form->field($model, 'title_bm')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => false]); ?>
                <br>
                <br>
                 <?php echo $form->field($model, 'title_bm')->label(false)->textInput(['class' => 'form-control col-md-3 col-sm-6 col-xs-12', 'disabled' => false]); ?>

                 </div>
                 </li>
             </div> -->

            <div class="clearfix"></div>

            <br>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar ', ['class' => 'btn btn-success', 'url' => ['index']]) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan Draf'), ['class' => 'btn btn-primary', 'name' => 'simpan', 'value' => 'submit_1'])
                    ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div> <!-- end of xpanel-->
</div> <!-- end of md-->



<?php
$script = <<< JS
        
        var input = document.getElementById('inputID');

input.onkeyup = function(){
    this.value = this.value.toUpperCase();
}
JS;
$this->registerJs($script, View::POS_END);
?>
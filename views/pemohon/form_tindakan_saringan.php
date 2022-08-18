<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $iklan app\iklans\ejobs\Iklan */
/* @var $form yii\widgets\ActiveForm */
?> 


<div class="x_panel"> 
    <div class="x_title">
        <h2>Tindakan</h2> 
        <div class="clearfix"></div>
    </div>

    <div class="x_content">   
        <div class="table-responsive">
            <table class="table table-sm jambo_table table-striped"> 
                <tr>
                    <th class="col-md-2 col-sm-3 col-xs-12 text-right">Nama: </th><td><?= $model2->biodataStaff->gelaran->Title . " " . ucwords(strtolower($model2->biodataStaff->CONm)) ?></td> 
                </tr>
                <tr>
                    <th class="col-md-2 col-sm-3 col-xs-12 text-right">Jawatan Semasa: </th>
                    <td><?= $model2->biodataStaff->jawatan->fname; ?></td> 
                </tr>
                <tr>
                    <th class="col-md-2 col-sm-3 col-xs-12 text-right">Jawatan yang dimohon: </th><td><?= $model2->iklan->jawatan->fname; ?></td> 
                </tr> 
                <tr>
                    <th class="col-md-2 col-sm-3 col-xs-12 text-right">Justifikasi: </th><td><?= $model2->pengakuanTxt; ?></td> 
                </tr> 
            </table>
        </div>
    </div>
    <div class="x_content">
        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Status Persetujuan <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <?=
                $form->field($model, 'status')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\ejobs\StatusSaringan::find()->where(['status_for' => $title])->all(), 'id', 'name'),
                    'options' => ['placeholder' => 'Pilih'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false);
                ?>
            </div>
        </div> 
        <div class="hide">
            <?= $form->field($model, 'ulasan_by')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?> 
            <?= $form->field($model, 'ulasan_at')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false); ?> 
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Ulasan <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <?= $form->field($model, 'desc')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>  
            </div>
        </div>  
        <?php if ($model->desc == null) { ?>
            <div class="form-group"> 
                <div class="col-sm-12 text-center">
                    <?php echo Html::a('Batal', ['pengesahan'], ['class' => 'btn btn-danger']); ?>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-primary']) ?>
                </div>
            </div> 
        <?php } ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>           


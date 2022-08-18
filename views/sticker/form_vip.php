<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;  
use dosamigos\datepicker\DatePicker;
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
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. K/P: 
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                    <?= $form->field($model, 'ICNO')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group"> 
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Gelaran: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group"> 
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Nama: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div> 
        <div class="form-group"> 
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Jawatan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                    <?= $form->field($model, 'post_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\RefGredLpu::find()->all(), 'id', 'seksyen'),
                        'options' => ['placeholder' => '....', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Alamat: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                    <?= $form->field($model, 'addr')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Poskod: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-3"> 
                    <?= $form->field($model, 'poskod')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Bandar: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-3"> 
                    <?= $form->field($model, 'city_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Bandar::find()->orderBy(['CityCd' => SORT_ASC])->all(), 'CityCd', 'City'),
                        'options' => ['placeholder' => 'Pilih Bandar', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Daerah: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-3"> 
                    <?= $form->field($model, 'state_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Negeri::find()->orderBy(['StateCd' => SORT_ASC])->all(), 'StateCd', 'State'),
                        'options' => ['placeholder' => 'Pilih Daerah', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div> 
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Telefon 1:  
                </label>
                <div class="col-md-4 col-sm-4 col-xs-4"> 
                    <?= $form->field($model, 'no_tel_1')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Telefon 2:  
                </label>
                <div class="col-md-4 col-sm-4 col-xs-4"> 
                    <?= $form->field($model, 'no_tel_2')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Telefon Bimbit:  
                </label>
                <div class="col-md-4 col-sm-4 col-xs-4"> 
                    <?= $form->field($model, 'no_phone')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Faks:  
                </label>
                <div class="col-md-4 col-sm-4 col-xs-4"> 
                    <?= $form->field($model, 'no_faks')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">E mel:  
                </label>
                <div class="col-md-4 col-sm-4 col-xs-4"> 
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div> 
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Gelaran PA:  
                </label>
                <div class="col-md-4 col-sm-4 col-xs-4"> 
                    <?= $form->field($model, 'pa_title_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Gelaran::find()->all(), 'TitleCd', 'Title'),
                        'options' => ['placeholder' => 'Pilih Gelaran', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
        
        <div class="form-group"> 
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Nama PA:  
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                    <?= $form->field($model, 'pa_name')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">E mel:  
                </label>
                <div class="col-md-4 col-sm-4 col-xs-4"> 
                    <?= $form->field($model, 'pa_email')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Telefon:  
                </label>
                <div class="col-md-4 col-sm-4 col-xs-4"> 
                    <?= $form->field($model, 'pa_phone')->textInput(['maxlength' => true])->label(false); ?>
                </div>
            </div>
        </div>
         
        <div class="hide">
            <?php if(Yii::$app->controller->action->id=='tambah-vip'){ ?>
            <?= $form->field($model, 'isActive')->hiddenInput(['value' => 1])->label(false); ?> 
            <?= $form->field($model, 'created_by')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?> 
            <?= $form->field($model, 'created_at')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false); ?> 
            <?php }?>
        </div>


        <div class="form-group text-center">
            <div class="row">
                <?= \yii\helpers\Html::a('Batal', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
                <?= Html::submitButton('Tambah / Simpan', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>   
        <?php ActiveForm::end(); ?>

    </div>
</div> 

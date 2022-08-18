<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1162], 'vars' => []]); ?>

<div class="col-md-12"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Kemaskini Tuntutan Rawatan Bukan Panel</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
        
        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">PEMOHON<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'icno')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->where(['IN','statLantikan', [1,3]])->orderBy(['CONm'=>SORT_ASC])->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => 'Carian Nama Kakitangan'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false); ?>
                </div>
            </div>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">NAMA KLINIK<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'nama_klinik')->textarea(['maxlength' => true, 'rows' => 2])->label(false); ?>
                </div>
            </div>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="used_dt">TARIKH TUNTUTAN<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <!--<input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">-->
                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'tuntutan_date',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
            </div>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">RAWATAN<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'rawatan')->textarea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">JUMLAH TUNTUTAN (RM)<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'tuntutan')->textInput(['maxlength' => true, 'rows' => 2])->label(false); ?>
                </div>
            </div>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">NO RESIT<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'no_resit')->textInput(['maxlength' => true, 'rows' => 2])->label(false); ?>
                </div>
            </div>
                   

            </div>
                   

            </div>
        
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                
                <p>
                    <?= Html::submitButton('<i class="fa fa-save" aria-hidden="true"></i> Simpan', ['class' => 'btn btn-success']) ?>
                    <?=
                    Html::a('<i class="fa fa-trash-o" aria-hidden="true"></i> Padam', ['deleteb', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ])
                    ?>
                </p>
            </div>
        </div>
        <?php ActiveForm::end();?>
     </div>




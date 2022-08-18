<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;
use app\widgets\TopMenuWidget;
use app\models\keselamatan\RefUnit;
?>

<?= $this->render('/keselamatan/_topmenu') ?>

<div class="col-md-12"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>KemasKini Waran</strong></h2>
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jawatan<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $form->field($model, 'jawatan')->label(false)->textInput(['class'=>'form-control col-md-3 col-sm-6 col-xs-12', 'disabled'=>true]); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Gred<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                <?php echo $form->field($model, 'gred')->label(false)->textInput(['class'=>'form-control col-md-3 col-sm-6 col-xs-12', 'disabled'=>true]); ?>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Jumlah Waran<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                <?php echo $form->field($model, 'jumlah_waran')->label(false)->textInput(['class'=>'form-control col-md-3 col-sm-6 col-xs-12', 'disabled'=>false]); ?>

                </div>
            </div>
      
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success','data' => ['confirm' => 'Anda Pasti Untuk Mengubah Jumlah Waran?']]) ?>
                    <?= Html::a('Cancel', ['/warrant/warrant-list'], ['class'=>'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>




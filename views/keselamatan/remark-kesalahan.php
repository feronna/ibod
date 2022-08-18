<?php

use yii\widgets\ActiveForm;
use app\models\kehadiran\RefReason;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\widgets\TopMenuWidget;
?>
<?= $this->render('/keselamatan/_topmenu') ?>

<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Nyatakan Alasan / Sebab Ketidakpatuhan kehadiran</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Kesalahan
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="form-control col-md-3 col-sm-6 col-xs-12 disabled"><?=$model->formatdate ?></div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Syif
                </label>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'syif')->label(false)->textInput(['class'=>'form-control col-md-3 col-sm-6 col-xs-12', 'disabled'=>true]); ?>
               
                </div>
            </div>
          <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Ketidakpatuhan
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-control col-md-3 col-sm-6 col-xs-12 disabled"><?=$model->statusH ?></div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Melulus
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" value="<?=$peg;?>" disabled />
                </div>
            </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">Alasan / Sebab <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'reason_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\keselamatan\RefFrequent::find()->all(), 'id', 'name'),
                        'options' => ['placeholder' => 'Pilih Sebab', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Dokumen Sokongan <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                          
                    <?php
                    if (!empty($model->namafile) && $model->namafile != 'deleted') {
                        echo Html::a(Yii::$app->FileManager->NameFile($model->namafile));
                        echo '&nbsp&nbsp&nbsp&nbsp';
                        if($model->id){
                            echo Html::a('Padam', ['deletegambar', 'id' => $model->id], ['class' => 'btn btn-danger']) . '<p>';
                        }
                        
                    }
                    else{
                       echo $form->field($model, 'namafile')->fileInput()->label(false);
                    }
                    ?>
                </div>
            </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'remark')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar Alasan/ Sebab', ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <!--form-->
              <div><h4><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rujukan </h4></strong></div>
                <ul>
                    <li><span class="label label-danger">THBH</span> : Tidak Hadir Baris Hakiki</li>
                    <li><span class="label label-danger">THH</span> : Tidak Hadir Hakiki </li>
                    <li><span class="label label-danger">THBLMJ</span> : Tidak Hadir Baris Lebihan Masa Jadual</li>
                    <li><span class="label label-danger">THBLMT</span> : Tidak Hadir Baris Lebihan Masa Tambahan</li>
                    <li><span class="label label-danger">THBKWLN</span> : Tidak Hadir Baris Kawalan</li>
                    <li><span class="label label-danger">THLMJ</span> : Tidak Hadir Lebihan Masa Jadual</li>
                    <li><span class="label label-danger">THLMT</span> : Tidak Hadir Lebihan Masa Tambahan</li>
                    <li><span class="label label-danger">THKWLN</span> : Tidak Hadir Kawalan</li>
                </ul>
        </div>
    </div>
</div>
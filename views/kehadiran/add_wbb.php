
<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\RefWp;
?>
<div class="col-md-12">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['site/index']) ?></li>
        <li><?= Html::a('Kehadiran', ['kehadiran/index']) ?></li>
        <li><?= Html::a('Senarai Staf Seliaan', ['kehadiran/senarai_kakitangan']) ?></li>
        <li><?= Html::a('Senarai WBB', ['kehadiran/senarai_wbb', 'id' => $id]) ?></li>
        <li>Tambah WBB Baru</li>
    </ol>
</div>

<div class="col-md-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Waktu Bekerja Berperingkat</strong><small>(WBB)</small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                <div class="col-md-12">
                    <h4><i class="fa fa-user"></i><strong>&nbsp;&nbsp;&nbsp;&nbsp;<?= $biodata->CONm . ' (' . $biodata->COOldID . ')' ?></strong></h4>
                    <h4><i class="fa fa-briefcase"></i>&nbsp;&nbsp;&nbsp;<?= $biodata->jawatan->fname ?></h4>
                    <h4><i class="fa fa-address-card"></i>&nbsp;&nbsp;<?= $biodata->department->fullname ?></h4>
                </div>
            </div>
            <hr>
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">Tambah WBB baru <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'wp_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(RefWp::find()->all(), 'id', 'detail'),
                        'options' => ['placeholder' => 'Pilih WP', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>


            <p style="color: green">
                *WBB yang ditambah akan terus Berstatus "APPROVED". Sila pastikan semua maklumat adalah betul.<br>
                *WBB yang ditambah secara automatik akan berkuatkuasa pada hari ini <?= date('d/m/Y'); ?> <br>
                *Sila gunakan cara ini sekiranya staf/kakitangan tidak dapat memohon secara atas talian.
            </p>


            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Tambah WBB', ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

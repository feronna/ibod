<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\RefWp;

?>


<div class="col-md-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>KEMASKINI PEGAWAI PERAKU/LULUS</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">NAMA KAKITANGAN 
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="form-control col-md-7 col-xs-12" type="text" disabled='true' value="<?= $biodata->CONm . ' (' . $biodata->COOldID . ')' ?>" />
                   
                </div>
            </div>
            <br>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">PEGAWAI PERAKU <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'peraku_icno')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->where(['status'=>1])->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => '--Terus kepada Peg. Pelulus--', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">PEGAWAI PELULUS <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'pelulus_icno')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->where(['status'=>1])->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => 'Pilih Pegawai Pelulus', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <p style="color: red">
                *Perubahan Pegawai Peraku/Pelulus adalah sama seperti dalam sistem e-cuti
            </p>
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;KEMBALI', ['kehadiran/staff-wbb'], ['class' => 'btn btn-primary']) ?>
                    <?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp;UPDATE', ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

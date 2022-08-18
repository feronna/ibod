<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use app\models\keselamatan\RefPosKawalan;
use app\models\keselamatan\RefUnit;
use dosamigos\datepicker\DatePicker;
?>


<div class="col-md-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>KemasKini Kesalahan</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>



            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Pilih Syif: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <?= $form->field($model, 'syif')->radioList(array('A'=>'Syif A','B'=>'Syif B','C'=>'Syif C'))->label(false); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Tarikh Kesalahan :
                </label>
                <div class="col-md-3 col-md-3 col-sm-3 col-sm-3 col-xs-12">

 <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'tarikh',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd',
                        ]
                    ]);
                    ?>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Sila Tanda Mana-mana Yang Berkenaan :
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'thtc')->checkbox(array(
					'label'=>'Tidak Hadir Bertugas (Tugas Hakiki) (THTC)',
					'labelOptions'=>array('style'=>'padding:5px;'),
					'disabled'=>false
					))
					->label('a.'); ?>
                    <?= $form->field($model, 'thlm')->checkbox(array(
					'label'=>'Tidak Hadir Bertugas Lebih Masa (THLM)',
					'labelOptions'=>array('style'=>'padding:5px;'),
					'disabled'=>false
					))
					->label('b.'); ?>
                    <?= $form->field($model, 'thtm')->checkbox(array(
					'label'=>'Tidak Hadir Tanpa Maklumat',
					'labelOptions'=>array('style'=>'padding:5px;'),
					'disabled'=>false
					))
					->label('c.'); ?>
                    <?= $form->field($model, 'lhb')->checkbox(array(
					'label'=>'Lewat Hadir Bertugas',
					'labelOptions'=>array('style'=>'padding:5px;'),
					'disabled'=>false
					))
					->label('d.'); ?>
                    <?= $form->field($model, 'mpktk')->checkbox(array(
					'label'=>'Meninggalkan Pos Kawalan Tanpa Kebenaran',
					'labelOptions'=>array('style'=>'padding:5px;'),
					'disabled'=>false
					))
					->label('e.'); ?>
                    <?= $form->field($model, 'mlasm')->checkbox(array(
					'label'=>'Membuat Laporan Awal Sebelum Masanya',
					'labelOptions'=>array('style'=>'padding:5px;'),
					'disabled'=>false
					))
					->label('f.'); ?>
                    <?= $form->field($model, 'thb')->checkbox(array(
					'label'=>'Tidak Hadir Baris : (THB)',
					'labelOptions'=>array('style'=>'padding:5px;'),
					'disabled'=>false
					))
					->label('g.'); ?>
                    <?= $form->field($model, 'thp')->checkbox(array(
					'label'=>'Tidak Hadir Penugasan',
					'labelOptions'=>array('style'=>'padding:5px;'),
					'disabled'=>false
					))
					->label('h.'); ?>
                    <?= $form->field($model, 'gmk')->checkbox(array(
					'label'=>'Gagal Melapor Kejadian',
					'labelOptions'=>array('style'=>'padding:5px;'),
					'disabled'=>false
					))
					->label('i.'); ?>
                  
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Lain - Lain Kesalahan:
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'lain_lain')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>

                </div>
            </div>


            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp;Hantar', ['class' => 'btn btn-success']) ?>
                    <button class="btn btn-primary" type="reset">Reset</button>

                </div>
            </div>

<?php ActiveForm::end(); ?>

            <br>

        </div>
    </div>
</div>

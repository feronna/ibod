<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\ejobs\TblpPermohonan;
use app\models\ejobs\Iklan;
?> 

<div class="x_panel">
    <div class="x_title">
        <h2>Halaman Utama</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content"> 

        <?php echo $this->render('menu_tab'); ?>

    </div>
</div>

<div class="x_panel">
    <div class="x_content">   
        <span class="required" style="color:red;">
            <strong>
                <?=
                strtoupper('Sila kemaskini maklumat peribadi anda sebelum membuat permohonan jawatan. Maklumat pendidikan wajib diisi  '
                        . 'untuk memudahkan proses saringan kelayakan. Permohonan boleh memohon lebih dari 1 jawatan'
                        . ' pada 1 masa. Permohonan yang tidak lengkap akan ditolak serta-merta. Sila pastikan maklumat peribadi lengkap sebelum membuat permohonan. ');
                ?>
            </strong>
        </span>
    </div>
</div>

<div class="x_panel">
    <div class="x_content">  
        <strong>
            Untuk maklumat lanjut, sila hubungi talian berikut:<br/><br/>
            <table>
                <tr><td>
                        Cik Rohana Mohd Rais <br/>
                        Pembantu Tadbir (P/O) <br/> 
                        E-mel: rohanamr@ums.edu.my
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
                    </td> 
                </tr>
            </table>
        </strong>  
    </div>
</div>

<?php
//if (!$biodata->activePermohonan) {
?>

<div class="x_panel"> 
    <div class="x_title">
        <h2>Permohonan Baru</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icno">Jawatan: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                echo $form->field($model, 'jawatanArr')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\app\models\ejobs\GredJawatan::find()
                                    ->where(['IN', 'id', Iklan::findActiveAds()])
                                    ->andWhere(['NOT IN', 'id', TblpPermohonan::findActiveApplication()])
                                    ->all(), 'id', 'fname'),
                    'options' => ['placeholder' => 'Pilih Jawatan', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false);
                ?>
            </div>
        </div>  
        <div class="form-group text-center">
            <div class="col-sm-12"> 
                <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']); ?>
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>  

<?php // } ?>
    
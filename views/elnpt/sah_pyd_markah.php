<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>
            
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        
        <div class="panel-body">
            <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
            <?php $form = ActiveForm::begin([
                'id' => 'login-form', 
                'options' => ['class' => 'form-horizontal form-label-left',
                    'data-pjax' => true],
                'fieldConfig' => ['template' => '{label}{input}'],
                ]); ?>
                
            <?php echo $form->errorSummary($model, [
//                'header' => 'Maaf, anda tidak dibenarkan untuk membuat pengesahan markah Borang eLNPT kerana terdapat maklumat wajib yang belum lengkap:'
                ]); ?>
            
            <div class="form-group">
                <label>1. Nyatakan justifikasi permohonan rayuan semakan semula markah LNPT anda.</label>
            </div>
            
            <div class="form-group">
                <div>
                    <?=
                        $form->field($model[0], '[0]alasan')->textArea([
//                                'placeholder' => 'Bil Pelajar',
                            'style' => 'resize: none;'
                            ])->label(false);
                    ?>
                </div>
            </div>
            
            <div class="form-group">
                <label>2. Nyatakan ulasan PPP berkaitan penilaiannya terhadap anda.</label>
            </div>
            
            <div class="form-group">
                <div>
                    <?=
                        $form->field($model[1], '[1]alasan')->textArea([
//                                'placeholder' => 'Bil Pelajar',
                            'style' => 'resize: none;'
                            ])->label(false);
                    ?>
                </div>
            </div>
            
            <div class="form-group">
                <label>3. Nyatakan ulasan PPK berkaitan penilaiannya terhadap anda.</label>
            </div>
            
            <div class="form-group">
                <div>
                    <?=
                        $form->field($model[2], '[2]alasan')->textArea([
//                                'placeholder' => 'Bil Pelajar',
                            'style' => 'resize: none;'
                            ])->label(false);
                    ?>
                </div>
            </div>
            
            <div class="form-group">
                <label>4. Nyatakan sebab-sebab mengapa anda percaya PPP dan PPK telah membuat penilaian yang tidak objektif, tidak adil dan tidak telus terhadap anda.</label>
            </div>
            
            <div class="form-group">
                <div>
                    <?=
                        $form->field($model[3], '[3]alasan')->textArea([
//                                'placeholder' => 'Bil Pelajar',
                            'style' => 'resize: none;'
                            ])->label(false);
                    ?>
                </div>
            </div>
            
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Kembali</span></button>
            
            <div class="form-group">
                <div class="pull-right">
                    <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            
            <?php ActiveForm::end(); ?>
            <?php yii\widgets\Pjax::end() ?>
        </div>
    </div>
    </div>
</div>       

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\lnpt\RefAkses;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
<?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td class="col-md-3 text-center">PYD</td>
                                <td class="text-center"><?= $model->pyd->CONm ?></td>
                                <td class="text-center" rowspan="2"><?= $form->field($model, 'reset_pyd_sah')->checkbox(['label' => '']); ?></td>
                            </tr>
                            <tr>
                                <td class="text-center">Pengesahan PYD</td>
                                <td class="text-center"><?= is_null($model->PYD_sah_datetime) ? '<i>(belum sah)</i>' : $model->PYD_sah_datetime ?></td>
                            </tr>
                            <tr>
                                <td class="text-center">PPP</td>
                                <td class="text-center"><?= is_null($model->ppp) ? '' : $model->ppp->CONm ?></td>
                                <td class="text-center" rowspan="2"><?= $form->field($model, 'reset_ppp_sah')->checkbox(['label' => '']); ?></td>
                            </tr>
                            <tr>
                                <td class="text-center">Pengesahan PPP</td>
                                <td class="text-center"><?= is_null($model->PPP_sah_datetime) ? '<i>(belum sah)</i>' : $model->PPP_sah_datetime ?></td>
                            </tr>
                            <tr>
                                <td class="text-center">PPK</td>
                                <td class="text-center"><?= is_null($model->ppk) ? '' :$model->ppk->CONm ?></td>
                                <td class="text-center" rowspan="2"><?= $form->field($model, 'reset_ppk_sah')->checkbox(['label' => '']); ?></td>
                            </tr>
                            <tr>
                                <td class="text-center">Pengesahan PPK</td>
                                <td class="text-center"><?= is_null($model->PPK_sah_datetime) ? '<i>(belum sah)</i>' : $model->PPK_sah_datetime ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div> 
        </div>   
    </div>    
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    
                    <div class="pull-right">
                       
                        <?= Html::submitButton('Reset', ['class' => 'btn btn-success']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                    <?php yii\widgets\Pjax::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
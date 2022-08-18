<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\aduan\RptTblAduan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rpt-tbl-aduan-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

    <div class="x_content">

        <div class="col-md-10 col-sm-10 col-xs-12">

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">

                    <div class="well well-lg" style="background-color: #eeeeee">

                        <?= $model->statusPenerima; ?>
                    </div>

                </div>
            </div>

        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
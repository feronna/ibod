<?php

use app\models\elnpt\elnpt2\RefKumpDept;
use app\models\hronline\Department;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\elnpt\elnpt2\TblKumpDeptSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-kump-dept-search">

    <?php $form = ActiveForm::begin([
        'action' => ['tambah-kump-dept'],
        'method' => 'get',
    ]); ?>

    <?=
        $form->field($model, 'ref_kump_dept_id')->label(false)->widget(Select2::classname(), [
            'data' => ArrayHelper::map(RefKumpDept::find()->orderBy(['kump_dept' => SORT_ASC,])->all(), 'id', 'kump_dept'),
            'hideSearch' => false,
            'options' => [
                'placeholder' => 'Cari Kumpulan',
                //'class' => 'form-control col-md-7 col-xs-12',
                //'id' => 'jenis_carian',
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <?=
        $form->field($model, 'dept_id')->label(false)->widget(Select2::classname(), [
            'data' => ArrayHelper::map(Department::find()->orderBy(['fullname' => SORT_ASC,])->all(), 'id', 'fullname'),
            'hideSearch' => false,
            'options' => [
                'placeholder' => 'Cari JFPIB',
                //'class' => 'form-control col-md-7 col-xs-12',
                //'id' => 'jenis_carian',
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
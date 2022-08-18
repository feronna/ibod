<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\TblprcobiodataSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="viewPayroll-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['index' => $model->COOldID],
                'method' => 'post',
        
    ]);
    ?>
    
    <div class="col-md-6 col-sm-6 col-xs-12 ">
         <input type="text" class="form-control " name="search"  aria-required="true" aria-invalid="true">
    </div>
    



    <div class="form-group ">
<?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Cari', ['class' => 'btn btn-primary', 'name' => 'cari', 'value' => 'submit_1']) ?>
    
        <button class="btn btn-primary" type="reset">Reset</button>
    </div>

<?php ActiveForm::end(); ?>

</div>

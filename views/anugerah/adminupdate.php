<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblanugerah */

$this->title = 'Kemaskini Anugerah';

?>

<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        
        <div class="x_content">
<div class="tblanugerah-update">

    <?= $this->render('_adminform', [
        'model' => $model,
    ]) ?>

</div>
        </div>
    </div>
</div>

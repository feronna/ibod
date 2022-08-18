<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblbahasa */

$this->title = 'Kemaskini Bahasa';

?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        
        <div class="x_content">
<div class="tblbahasa-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
       </div>
    </div>
</div>
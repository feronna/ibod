<?php

use yii\helpers\Html;



$this->title = 'Kemaskini Maklumat Biasiswa';
?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_content">
<div class="tblbiasiswa-update">

    <?= $this->render('_formbiasiswa', [
        'model' => $model, 
    ]) ?>

</div>
       </div>
    </div>
</div>
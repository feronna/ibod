<?php

use yii\helpers\Html;


$this->title = 'Kemaskini Keluarga';

?>
<div class="col-md-12 col-sm-12 col-xs-12 ">
    <div class="x_content">
        <div class="tblkeluarga-update">
            <?= $this->render('_form', [
                'model' => $model, 
                'disease' => $disease,
                'allergic' => $allergic,
                'new_disease' => $new_disease,
            ]) ?>
        </div>
    </div>
</div>
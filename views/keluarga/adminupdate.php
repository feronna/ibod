<?php

use yii\helpers\Html;

$this->title = 'Kemaskini Keluarga';

?>
<div class="col-md-12 col-sm-12 col-xs-12 ">
    <?= $this->render('_adminform', [
        'model' => $model, 'displaymaklumatpekerjaan' => $displaymaklumatpekerjaan, 'displaymaklumatperkahwinan' => $displaymaklumatperkahwinan,
    ]) ?>
</div>

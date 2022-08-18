<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpendidikan */

$this->title = 'Kemaskini Maklumat Pengajian';
?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_content">
<div class="tblpengajian-update">

    <?= $this->render('_formpengajian', [
        'model' => $model, 'iklan' => $iklan,
    ]) ?>

</div>
       </div>
    </div>
</div>
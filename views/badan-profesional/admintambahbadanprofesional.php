<?php

use yii\helpers\Html;

$this->title = 'Tambah Keahlian';
?>
<div class="col-md-12 col-sm-12 col-xs-12 ">
    <div class="x_content">
        <div class="tbl-badan-profesional-create">
            <?= $this->render('_adminform', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
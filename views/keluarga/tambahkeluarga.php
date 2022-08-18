<?php

use yii\helpers\Html;

$this->title = 'Tambah Keluarga';

?>
<div class="col-md-12 col-sm-12 col-xs-12 ">
    <div class="x_content">
        <div class="tblkeluarga-create">
            <?= $this->render('_formTambah', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
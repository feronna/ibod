<?php

use yii\helpers\Html;

$this->title = 'Add Passport';

?>
<div class="tblpasport-create">

    <?= $this->render('_adminformpaspot', [
        'paspot' => $paspot,
    ]) ?>

</div>
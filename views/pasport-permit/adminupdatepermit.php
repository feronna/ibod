<?php

use yii\helpers\Html;

$this->title = 'Update Work Permit';

?>
<div class="tblpermitkerja-update">

    <?= $this->render('_adminformpermit', [
        'permit' => $permit,
    ]) ?>

</div>
<?php

use yii\helpers\Html;

$this->title = 'Add Work Permit';

?>
<div class="tblpraddress-create">

    <?= $this->render('_adminformpermit', [
        'permit' => $permit,
    ]) ?>

</div>
<?php

use yii\helpers\Html;

$this->title = 'Update Work Permit';

?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
     <div class="x_content">
<div class="tblpermitkerja-update">

    <?= $this->render('_formpermit', [
        'permit'=>$permit,
    ]) ?>

</div>
        </div>
    </div>
</div>

<?php

use yii\helpers\Html;

$this->title = 'Add Passport';

?>
<div class="col-md-12 col-sm-12 col-xs-12 ">
    <div class="x_panel">
        <div class="x_content">
            <div class="tblpasport-create">

                <?= $this->render('_formpaspot', [
                    'paspot' => $paspot,
                ]) ?>

            </div>
        </div>
    </div>
</div>
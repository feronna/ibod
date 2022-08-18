<?php

$this->title = 'Tambah Anugerah';

?>

<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        
        <div class="x_content">

<div class="tblanugerah-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
        </div>
    </div>
</div>

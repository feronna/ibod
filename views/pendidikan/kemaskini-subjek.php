<?php

use yii\helpers\Html;

$this->title = 'Kemaskini Subjek';

?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_content">
<div class="tblsubjek-create">
  
    <?= $this->render('form_subjek', [
        'model' => $model,
        'title' => $title,
        'lvl' =>$lvl,
    ]) ?>
    

</div>
        </div>
    </div>
</div>
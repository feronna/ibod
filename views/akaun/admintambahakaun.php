<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblakaun */

$this->title = 'Tambah Akaun';

?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        
        <div class="x_content">
<div class="tblakaun-create">

    <?= $this->render('_adminform', [
        'model' => $model,
    ]) ?>

</div>

        </div>
    </div>
</div>
<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\datetime\DateTimePicker;

?>
<div class="pos-tbl-permohonan-create">

    <?= $this->render('_form', [
        'modelmel' => $modelmel,
        'modelsBarang' => $modelsBarang,
    ]) ?>

</div>

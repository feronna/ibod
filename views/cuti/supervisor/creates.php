<?php

use yii\helpers\Html;

?>

<?= $this->render('_forms', [
     'biodata' => $biodata,
     'layak' => $layak,
     'id' => $id,
     'modelCustomer' => $modelCustomer,
     'modelsAddress' => $modelsAddress,
     'jenis_cuti' => $jenis_cuti,
     'sick_leave_verifier' => $sick_leave_verifier,
]) ?>


<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\TblPtm */

//$this->title = 'Update Tbl Ptm: ' . $model->ICNO;
//$this->params['breadcrumbs'][] = ['label' => 'Tbl Ptms', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->ICNO, 'url' => ['view', 'id' => $model->ICNO]];
//$this->params['breadcrumbs'][] = 'Update';
?>


    <?= $this->render('_update', [
        'model' => $model,
        'data' => $data,
        'lapor' => $lapor,
     
//          'allbiodata' => $allbiodata,
    ]) ?>


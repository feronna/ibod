<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\elnpt\elnpt2\TblKumpDept */

// $this->title = 'Create Tbl Kump Dept';
// $this->params['breadcrumbs'][] = ['label' => 'Tbl Kump Depts', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-kump-dept-create">

    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">
                <div class="x_content">
                    <div class="row">
                        <?= $this->render('_form', [
                            'model' => $model,
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
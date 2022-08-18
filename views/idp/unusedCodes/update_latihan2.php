<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\latihan\IdpV */

$this->title = $model->tajuk_kursus;
//$this->params['breadcrumbs'][] = ['label' => 'Idp Vs', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->kursus_id, 'url' => ['view', 'id' => $model->kursus_id]];
//$this->params['breadcrumbs'][] = 'Update';

echo \app\widgets\TopMenuWidget::widget(['top_menu' => [59, 64], 'vars' => [
    ['label' => ''],
]]);
?>
<div class="idp-v-update">
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">  
        <div class="x_panel">
            <div class="x_title">
                <h2>Kemaskini Kursus : <?= Html::encode($this->title) ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div> <!-- ubah kat sini -->
                    <div class="table-responsive">

                        <?= $this->render('form_create_latihan', [
                            'model' => $model,
                        ]) ?>
                    </div>    
                </div> <!-- ubah sini -->
            </div>
        </div> <!-- x_content -->
    </div>
</div>
</div>
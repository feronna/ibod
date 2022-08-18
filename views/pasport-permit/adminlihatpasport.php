<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'View Passport';

?>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <p>
                <?= Html::a('Back', ['adminview', 'icno' => $paspot->ICNO], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Update', ['adminupdatepasport', 'id' => $paspot->id], ['class' => 'btn btn-primary']) ?>

            </p>

            <?= $this->render('_lihatpasport', [
                'paspot' => $paspot,
            ]); ?>


        </div>
    </div>
</div>
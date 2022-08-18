<?php

use yii\helpers\Html;


$this->title = 'Butiran Rawatan';
?>
<div class="col-md-12 col-sm-12 col-xs-12 alert alert-semi-transparent">
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <p>
                <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?>
            </p>
            <?=
            $this->render('display_medcare', [
                'model' => $model,
            ])
            ?>

        </div>
    </div>
</div>
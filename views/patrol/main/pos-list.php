<?php

use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'Pending for substitute approval';
?>
<?= $this->render('/patrol/_menu') ?>

<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-list-alt"></i>&nbsp;<strong>Senarai Gambar Pos Kawalan</strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?php if (!$model) { ?>
            <div class="tile-stats" style="padding: 10px">
                <h3 class="text-center">No Record Found..</h3>
            </div>

        <?php } else { ?>
            <?php foreach ($model as $models) { ?>
                <div class="tile-stats" style="padding: 10px">
                    <h1>
                        <p>  <strong style="font-size: 20px;">Pos Kawalan : <?= $models->pos_kawalan; ?> </strong></p>
                    </h1>
                    <div class="x_panel">
                        <div class="x_content">
                            <img height='60%' width="60%" src="<?= Yii::$app->FileManager->DisplayFile($models->file_hashcode); ?>"></span>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>

    </div>
</div>
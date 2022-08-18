<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

?>
<?= Yii::$app->controller->renderPartial('/survey/_menu'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-check-square-o"></i>&nbsp;<strong><?= $this->title ?></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <p style="color: green;font-size: 35px;font-weight: bold;" class="text-center">You have successfully cast your vote!</p>
                <?php
                echo DetailView::widget([
                    'model' => $pengundi,
                    'attributes' => [
                        'statusText:html',    // description attribute in HTML
                        'vote_dt:datetime', // creation date formatted as datetime
                    ],
                ]);
                ?>
                <div class="text-center">
                    <?= Html::a('<i class="fa fa-check-circle-o"></i>&nbsp;End Survey', ['index'], ['class' => 'btn btn-danger']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\system_core\TblAnnouncements */

$this->title = 'Add new Announcement';
?>

<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-bullhorn"></i>&nbsp;<strong><?= Html::encode($this->title) ?></strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?=
        $this->render('_form', [
            'model' => $model,
        ])
        ?>
   </div>
</div>
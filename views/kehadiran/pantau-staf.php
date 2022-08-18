<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\helpers\Url;

$this->title = "Pantau kakitangan seliaan";
?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-list"></i>&nbsp;<strong>Senarai kakitangan seliaan yang menunggu perakuan pegawai</strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?php
                echo ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $columnData,
                    'clearBuffers' => true,
                    'exportConfig' => [
                        ExportMenu::FORMAT_PDF => false,
                        ExportMenu::FORMAT_CSV => false,
                        ExportMenu::FORMAT_EXCEL => false,
                        ExportMenu::FORMAT_HTML => false,
                    ],
                ]); ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'pjax' => true, // pjax is set to always true for this demo
                    'columns' => $columnData,
                    'floatHeader'=>true,
                    'responsive'=>true,
                    'resizableColumns'=>true,
                    'responsiveWrap' => true
                ]); ?>
            </div>
        </div>
    </div>
</div>

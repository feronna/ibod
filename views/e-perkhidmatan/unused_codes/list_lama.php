<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;

//echo $this->render('/aduan/_topmenu');
echo $this->render('/e-perkhidmatan/contact');

$link_permit = '../permit/index?id='.$model->event_id;
$link_countdown = 'index/';
$link_kawalan = 'index/';
//$link_papan_tanda = '../papan-tanda/halaman-utama-papan-tanda?id='.$model->event_id;
$link_papan_tanda = '../papan-tanda/mohon?id='.$model->event_id;
//$link_parkir = '../parkir/halaman-utama-parkir?id='.$model->event_id;
$link_parkir = '../parkir/mohon?id='.$model->event_id;
?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Maklumat Program</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <!-- <li><a href="<?php //echo $link_permit ?>"><i class="fa fa-plus-square"></i></a></li> -->
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php Pjax::begin(); ?>
                <?php
                    if ($model->entry_date) {
                        //echo 'Keterangan </br></br>';
                        echo 'Nama Program :' . strtoupper($model->event_name) . '</br>';
                        echo 'Lokasi Program :' . strtoupper($model->location) . '</br>';
                        //echo strtoupper($model->biodata->department->fullname) . '</br></br>';
                        echo 'Tarikh Permohonan : ' . Yii::$app->formatter->asDate($model->entry_date, 'php:d-m-Y');
                        echo '</br></br>';
                    } else {
                        echo '';
                    }
                    ?>
                <?php Pjax::end(); ?>

            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Senarai Permohonan Permit Banner / Bunting / Poster</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a href="<?php echo $link_permit ?>"><i class="fa fa-plus-square"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php Pjax::begin(); ?>
                <?php
                // GridView::widget([
                //     'dataProvider' => $dataProvider,
                //     //'filterModel' => $searchModel,
                //     //'layout' => "{items}\n{pager}",
                //     'pager' => [
                //         'firstPageLabel' => 'Halaman Pertama',
                //         'lastPageLabel'  => 'Halaman Terakhir'
                //     ],
                //     'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>TIADA DATA</b></i>'],
                //     'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                //     //'columns' => $gridColumns,
                // ]);
                ?>
                <?php Pjax::end(); ?>

            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Senarai Permohonan Countdown</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a href="<?php echo $link_countdown ?>"><i class="fa fa-plus-square"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php Pjax::begin(); ?>
                <?php
                // GridView::widget([
                //     'dataProvider' => $dataProvider,
                //     //'filterModel' => $searchModel,
                //     //'layout' => "{items}\n{pager}",
                //     'pager' => [
                //         'firstPageLabel' => 'Halaman Pertama',
                //         'lastPageLabel'  => 'Halaman Terakhir'
                //     ],
                //     'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>TIADA DATA</b></i>'],
                //     'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                //     //'columns' => $gridColumns,
                // ]);
                ?>
                <?php Pjax::end(); ?>

            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Senarai Permohonan Kawalan Keselamatan</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a href="<?php echo $link_kawalan ?>"><i class="fa fa-plus-square"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php Pjax::begin(); ?>
                <?php
                // GridView::widget([
                //     'dataProvider' => $dataProvider,
                //     //'filterModel' => $searchModel,
                //     //'layout' => "{items}\n{pager}",
                //     'pager' => [
                //         'firstPageLabel' => 'Halaman Pertama',
                //         'lastPageLabel'  => 'Halaman Terakhir'
                //     ],
                //     'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>TIADA DATA</b></i>'],
                //     'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                //     //'columns' => $gridColumns,
                // ]);
                ?>
                <?php Pjax::end(); ?>

            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Senarai Permohonan Papan Tanda</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a href="<?php echo $link_papan_tanda ?>"><i class="fa fa-plus-square"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php Pjax::begin(); ?>
                <?php
                // GridView::widget([
                //     'dataProvider' => $dataProvider,
                //     //'filterModel' => $searchModel,
                //     //'layout' => "{items}\n{pager}",
                //     'pager' => [
                //         'firstPageLabel' => 'Halaman Pertama',
                //         'lastPageLabel'  => 'Halaman Terakhir'
                //     ],
                //     'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>TIADA DATA</b></i>'],
                //     'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                //     //'columns' => $gridColumns,
                // ]);
                ?>
                <?php Pjax::end(); ?>

            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Senarai Permohonan Parkir</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a href="<?php echo $link_parkir ?>"><i class="fa fa-plus-square"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php Pjax::begin(); ?>
                <?php
                // GridView::widget([
                //     'dataProvider' => $dataProvider,
                //     //'filterModel' => $searchModel,
                //     //'layout' => "{items}\n{pager}",
                //     'pager' => [
                //         'firstPageLabel' => 'Halaman Pertama',
                //         'lastPageLabel'  => 'Halaman Terakhir'
                //     ],
                //     'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '<i><b>TIADA DATA</b></i>'],
                //     'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                //     //'columns' => $gridColumns,
                // ]);
                ?>
                <?php Pjax::end(); ?>

            </div>
        </div>
    </div>
</div>


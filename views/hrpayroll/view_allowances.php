<?php

use yii\helpers\Html;
use yii\grid\GridView;

error_reporting(0);


$this->title = 'Senarai Elaun';
?>
<div class="tblprcobiodata-form">
    <div class="x_panel">
        <?= $this->render('_searchallowances', [
            'carian' => $carian,
        ]) ?>
    </div>
</div>

<div class="x_panel">
</br>
    <?php if(!empty($biodata)){ ?>
    <div class="row text-center">
        <div class="col-lg-1 col-sm-3 col-xs-12 text-center">
            <div class="col-lg-1 col-md-1 col-xs-12 text-center" rowspan="6" valign="top"><span><img height='100px' width="80px" src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(hash('sha1', $biodata->ICNO)); ?>.jpeg"></span></div>
        </div>
        <div class="col-lg-11 col-sm-9 col-xs-12">
            <div class="row">
                <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>Nama:</b></div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 text-left"><?= $biodata->gelaran->Title . " " . ucwords(strtolower($biodata->CONm)) ?></div>
                <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>No. KP / Paspot:</b></div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 text-left "><?= $biodata->ICNO ?></div>
            </div>
            <div class="row ">
                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jabatan:</b></div>
                <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= ucwords(strtolower($biodata->department->fullname)) ?></div>
                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Kampus Cawangan:</b></div>
                <div class="col-lg-4 col-sm-6 col-xs-6 text-left "><?= ucwords(strtolower($biodata->kampus->campus_name)) ?></div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>UMSPER:</b></div>
                <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $biodata->COOldID ?></div>
                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jawatan Disandang:</b></div>
                <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $biodata->jawatan->nama . " (" . $biodata->jawatan->gred . ")"; ?></div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Sandangan:</b></div>
                <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $biodata->statusSandangan->sandangan_name ?></div>
                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tarikh Mula Sandangan:</b></div>
                <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $biodata->displayStartSandangan ?></div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Jawatan:</b></div>
                <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $biodata->statusLantikan->ApmtStatusNm ?></div>
                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tempoh Lantikan:</b></div>
                <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $biodata->displayStartLantik ?> hingga <?= $biodata->tarikhbersara ?></div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Pekerja:</b></div>
                <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><span><?= $biodata->Status ? $biodata->serviceStatus->ServStatusNm : 'Not Set' ?></span></div>
                <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tarikh Mula Status:</b></div>
                <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $biodata->displayStartDateStatus ?></div>
            </div>
        </div>
    </div> </br>
    <?php } ?>
    
    <div class="x_title" style="color:#37393b;">
        <h2><?= Html::encode($this->title) ?></h2>
        <h5 class="pull-right"><?= Html::encode('Jumlah Carian: ') . $model->getCount() . " / " . $model->getTotalCount() ?></h5>
        <div class="clearfix"></div>
    </div>
    <div class="table-responsive">
        <?=
        GridView::widget([
            //'tableOptions' => [
            //  'class' => 'table table-striped jambo_table',
            //],
            'emptyText' => 'Tiada Rekod',
            'summary' => '',
            'dataProvider' => $model,
            'columns' => [
                [
                    'label' => 'Jenis Allowance ',
                    'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => 'it_income_desc',
                ],
                [
                    'label' => 'Jumlah (RM)',
                    'headerOptions' => ['class' => 'text-center dark', 'bgcolor' => 'grey'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => 'mpdh_paid_amt',
                ],
            ],
        ]);
        ?>
    </div>
</div>
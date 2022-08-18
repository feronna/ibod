<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\export\ExportMenu;
use app\models\lppums\TblLppTahun;
use app\models\hronline\Department;

$gridColumns = [
//    ['class' => 'yii\grid\SerialColumn'],
    [
        'label' => 'NAMA',
        'headerOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->pyd->CONm;

        },
        'format' => 'html',
    ],
    [
        'label' => 'UMSPER',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->pyd->COOldID;

        },
        'format' => 'html',
    ],
    [
        'label' => 'GRED',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->pyd->jawatan->gred;

        },
        'format' => 'html',
    ],
    [
        'label' => 'JAWATAN',
        'headerOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->pyd->jawatan->nama;

        },
        'format' => 'html',
    ], 
    [
        'label' => 'JFPIU',
        'headerOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->pyd->department->fullname;

        },
        'format' => 'html',
    ],
    [
        'label' => 'KUMPULAN',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->pyd->jawatan->skimPerkhidmatan->name;

        },
        'format' => 'html',
    ],
    [
        'label' => 'STATUS',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->pyd->serviceStatus->ServStatusNm;

        },
        'format' => 'html',
    ],            
    [
        'label' => 'LANTIKAN',
        'headerOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->pyd->statusLantikan->ApmtStatusNm;

        },
        'format' => 'html',
    ],
    [
        'label' => 'TARIKH LANTIKAN',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->pyd->startDateLantik;

        },
        'format' => 'html',
    ],
    [
        'label' => 'TARIKH SANDANGAN',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->pyd->startDateSandangan;

        },
        'format' => 'html',
    ],
    [
        'label' => 'TARIKH STATUS',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->pyd->startDateStatus;

        },
        'format' => 'html',
    ],
    [
        'label' => 'NAMA PPP',
        'headerOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return is_null($model->ppp) ? null : $model->ppp->CONm;

        },
        'format' => 'html',
    ], 
    [
        'label' => 'NAMA PPK',
        'headerOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return is_null($model->ppk) ? null : $model->ppk->CONm;

        },
        'format' => 'html',
    ],
    [
        'label' => 'TARIKH SAH DATETIME',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->PYD_sah_datetime;

        },
        'format' => 'html',
    ],            
    [
        'label' => 'MARKAH PPP',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return (is_null($model->markahSeluruh)) ? '0' : $model->markahSeluruh->markah_PPP;

        },
        'format' => 'html',
    ],
    [
        'label' => 'MARKAH PPK',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return (is_null($model->markahSeluruh)) ? '0' : $model->markahSeluruh->markah_PPK;

        },
        'format' => 'html',
    ],          
    [
        'label' => 'MARKAH PURATA',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return (is_null($model->markahSeluruh)) ? '0' : $model->markahSeluruh->markah_PP;

        },
        'format' => 'html',
    ],
    [
        'label' => 'BULAN PGT',
        'headerOptions' => ['class'=>'text-center'],
        'contentOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->bulanPgt->SalMoveMth;

        },
        'format' => 'html',
    ],            
    [
        'label' => 'CATATAN',
        'headerOptions' => ['class'=>'text-center'],
        'value' => function($model) {
            return $model->catatan;

        },
        'format' => 'html',
    ],            
//    ['class' => 'yii\grid\ActionColumn'],
];


/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<?= $this->render('_menuAdmin'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Carian Borang</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php $form = ActiveForm::begin(['id' => 'search',  'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left']]); ?>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                            $form->field($searchModel, 'CONm')->textInput([
                                'placeholder' => 'Cari Nama',
                                ])->label(false);
                        ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">No. KP / Pasport</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                            $form->field($searchModel, 'PYD')->textInput([
                                'placeholder' => 'Cari No. KP / Pasport',
                                ])->label(false);
                        ?>
                    </div>
                </div>
            
                <?php if ($this->context->action->id != 'penetap-pantau-pergerakan-borang') { ?>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">J/F/P/I/U</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                            $form->field($searchModel, 'jspiu')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Department::find()
//                                        ->innerJoin(['a' => 'elnpt.tbl_kump_dept'], 'a.dept_id = `hronline`.department.id')
                                        ->orderBy(['fullname' => SORT_ASC,])
                                        ->all(), 'id', 'fullname'),
                                'hideSearch' => false,
                                'options' => [
                                    'placeholder' => 'Cari JFPIU', 
                                    //'class' => 'form-control col-md-7 col-xs-12',
                                    //'id' => 'jenis_carian',
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>
                <?php } ?>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                            $form->field($searchModel, 'tahun')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(TblLppTahun::find()->orderBy(['lpp_tahun' => SORT_ASC,])->all(), 'lpp_tahun', 'lpp_tahun'),
                                'hideSearch' => true,
                                'options' => [
                                    'placeholder' => 'Pilih Tahun', 
                                    //'class' => 'form-control col-md-7 col-xs-12',
                                    //'id' => 'jenis_carian',
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                        <?= Html::submitButton('Cari', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Hasil Carian</strong></h2><div  class="pull-right"><?= ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns,
                'filename' => 'laporan_elnpt_pentadbiran_'.date('Y-m-d'),
                'clearBuffers' => true,
                'stream' => false,
                'folder' => '@app/web/files/elnpt/.',
                'linkPath' => '/files/elnpt/',
                'batchSize' => 10,
//                'deleteAfterSave' => true
            ]); ?></div>
            <div class="clearfix"></div>
            
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                    <?=
                        GridView::widget([
                            //'tableOptions' => [
                              //  'class' => 'table table-striped jambo_table',
                            //],
                            'emptyText' => 'Tiada Rekod',
                            'pager' => [
                                'class' => \kop\y2sp\ScrollPager::className(),
                                'container' => '.grid-view tbody',
                                'triggerOffset' => 10,
                                'item' => 'tr',
                                'paginationSelector' => '.grid-view .pagination',
                                'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer">{text}</a></td></tr>',
                             ],
                            'summary' => '',
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns
                        ]);
                    ?>
                </div>
        </div>
    </div>
    </div>
</div>       
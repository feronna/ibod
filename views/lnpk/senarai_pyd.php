<?php

use app\models\hronline\Tblprcobiodata;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

use app\models\lppums\TblLppTahun;

$tahunn = TblLppTahun::find()->where(['LIKE', 'lpp_aktif', 'y'])->one();

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<?php
echo $this->render('_menuUtama', ['kump_khidmat' => $kump_khidmat]);
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian Borang</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(['id' => 'search',  'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left'], 'action' => ['lnpk/senarai-pyd']]); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama PYD</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($searchModel, 'PYD')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Tblprcobiodata::find()->where(['!=', 'Status', 6])->all(), 'ICNO', 'CONm'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Carian ...',
                                //                                'id' => 'ppp'
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun Penilaian</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                        $form->field($searchModel, 'tahun')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(TblLppTahun::find()->orderBy(['lpp_tahun' => SORT_DESC,])->all(), 'lpp_tahun', 'lpp_tahun'),
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
                <h2><strong>Senarai PYD Yang Dinilai</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <p><b><?= ($this->context->action->id == 'senarai-pyd-ppk') ? '* Klik loceng untuk kembalikan borang kepada PPP jika perlu.' : (($this->context->action->id == 'senarai-pyd-ppp') ? '* Klik loceng untuk kembalikan borang kepada PYD jika perlu.' : '') ?></b></p>
                <div class="table-responsive">
                    <?=
                    GridView::widget([
                        //'tableOptions' => [
                        //  'class' => 'table table-striped jambo_table',
                        //],
                        'emptyText' => 'Tiada Rekod',
                        'summary' => '',
                        'pager' => [
                            'class' => \kop\y2sp\ScrollPager::className(),
                            'container' => '.grid-view tbody',
                            'triggerOffset' => 10,
                            'item' => 'tr',
                            'paginationSelector' => '.grid-view .pagination',
                            'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer">{text}</a></td></tr>',
                        ],
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'header' => 'BIL',
                                'headerOptions' => ['class' => 'text-center  col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'PYD',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return Html::a('<strong><u>' . $model->pyd->CONm . '</u></strong>', Url::to(['lnpk/bahagian1', 'lnpk_id' => $model->lnpk_id])) . '<br><small>' . $model->deptPyd->fullname . '</small>' .
                                        '<br><small>' . $model->gredPyd->nama . ' ' . $model->gredPyd->gred;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'STATUS BORANG',
                                'headerOptions' => ['class' => 'text-center col-md-2'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return (($model->PPP_sah == 0) ? '<span class="label label-danger">Belum Sah</span>' : '<span class="label label-success">Sudah Sah</span>');
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'PENILAIAN SELESAI',
                                'headerOptions' => ['class' => 'text-center  col-md-2'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return ($model->PPP_sah == 1)
                                        ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' :
                                        '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                                },
                                'format' => 'html',
                            ],
                        ],
                    ]);
                    ?>
                </div>
                <hr>
                <p><strong>*Klik nama PYD untuk membuat penilaian.</strong></p>
            </div>
        </div>
    </div>
</div>
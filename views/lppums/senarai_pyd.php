<?php


use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use app\models\lppums\TblLppTahun;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<?= $this->render('_menuUtama'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Pegawai Yang Dinilai (PYD) di Bawah Pengawasan Anda</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php $form = ActiveForm::begin(['method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => 1]]); ?>

                    <div class="form-group">
                        <div class="form-group nama">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_pyd">Nama PYD
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?=
                                $form->field($searchModel, 'CONm')->textInput(['id' => 'nama_pyd'])->label(false);
                                ?>
                            </div>
                        </div>

                        <div class="form-group nama">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kp_paspot">No. KP / Passport PYD
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?=
                                $form->field($searchModel, 'ICNO')->textInput(['id' => 'kp_paspot'])->label(false);
                                ?>
                            </div>
                        </div>

                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tahun">Tahun Penilaian</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?=
                            $form->field($searchModel, 'tahun')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(TblLppTahun::find()->orderBy(['lpp_tahun' => SORT_DESC])->all(), 'lpp_tahun', 'lpp_tahun'),
                                'hideSearch' => true,
                                'options' => [
                                    'placeholder' => 'Pilih Tahun',
                                    'class' => 'form-control col-md-7 col-xs-12',
                                    'id' => 'tahun',
                                ],
                                'pluginOptions' => [],
                            ]);
                            ?>
                        </div>
                    </div>

                    <?= $form->field($searchModel, 'jenis_carian')->hiddenInput(['value' => '3'])->label(false); ?>

                    <div class="form-group">
                        <div class="pull-right">
                            <?= Html::submitButton('Cari', ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>

                    <div class="ln_solid"></div>

                    <div class="table-responsive">
                        <?=
                        GridView::widget([
                            'emptyText' => 'Tiada Rekod',
                            'summary' => '',
                            'dataProvider' => $dataProvider,
                            'pager' => [
                                'class' => \kop\y2sp\ScrollPager::className(),
                                'container' => '.grid-view tbody',
                                'triggerOffset' => 10,
                                'item' => 'tr',
                                'paginationSelector' => '.grid-view .pagination',
                                'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer">{text}</a></td></tr>',
                            ],
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'header' => 'BIL',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [

                                    'label' => 'TAHUN PENILAIAN',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return  $model->tahun;
                                    },
                                    'format' => 'html',
                                ],
                                [

                                    'label' => 'PEGAWAI YANG DINILAI (PYD)',
                                    'headerOptions' => ['class' => 'column-title col-md-5'],
                                    'value' => function ($model) {
                                        return  Html::a('<strong>' . $model->pyd->CONm . '</strong>', Url::to(['lppums/bahagian1', 'lpp_id' => $model->lpp_id])) . '<br><small>' . $model->department->fullname . '</small>' .
                                            '<br><small>' . $model->gredJawatan->nama . ' ' . $model->gredJawatan->gred;
                                    },
                                    'format' => 'html',
                                ],
                                [

                                    'label' => 'PEGAWAI PENILAI',
                                    'headerOptions' => ['class' => 'text-center col-md-5'],

                                    'value' => function ($model) {
                                        if (!is_null($model->PPP)) {
                                            $ppp = $model->ppp->CONm;
                                        } else {
                                            $ppp = '<i>belum set</i>';
                                        }
                                        if (!is_null($model->PPK)) {
                                            $ppk = $model->ppk->CONm;
                                        } else {
                                            $ppk = '<i>belum set</i>';
                                        }

                                        return 'PPP : ' . $ppp . '<br>'
                                            . 'PPK : ' . $ppk;
                                    },
                                    'format' => 'html',
                                ],
                                [

                                    'label' => 'STATUS PENGESAHAN BORANG SKT',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        if ($model->PPP == \Yii::$app->user->identity->ICNO) {
                                            if ($model->PYD_sah != 1) {
                                                return '<span class="label label-default">Menunggu tindakan/pengesahan PYD</span>';
                                            } else if ($model->PPP_sah != 1) {
                                                return '<span class="label label-warning">Menunggu tindakan/pengesahan anda</span>';
                                            } else if ($model->PPP_sah == 1) {
                                                return '<span class="label label-success">Tindakan/pengesahan selesai</span>';
                                            }
                                        }

                                        if ($model->PPK == \Yii::$app->user->identity->ICNO) {
                                            if ($model->PYD_sah != 1) {
                                                return '<span class="label label-default">Menunggu tindakan/pengesahan PYD</span>';
                                            } else if ($model->PPP_sah != 1) {
                                                return '<span class="label label-default">Menunggu tindakan/pengesahan PPP</span>';
                                            } else if ($model->PPK_sah != 1) {
                                                return '<span class="label label-warning">Menunggu tindakan/pengesahan anda</span>';
                                            } else if ($model->PPK_sah == 1) {
                                                return '<span class="label label-success">Tindakan/pengesahan selesai</span>';
                                            }
                                        }
                                        return '';
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'MARKAH SEBELUM',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        if ($model->prevMarks) {
                                            $str = '';
                                            $str .= '<dl class="row">';
                                            foreach ($model->prevMarks as $pm) {
                                                $str .= '<dt class="col-sm-3">' . $pm->TAHUN . '</dt>';
                                                $str .= '<dd class="col-sm-9">' . $pm->MARKAH . '</dd>';
                                            }
                                            $str .= '</dl>';
                                            return $str;
                                        }

                                        return null;
                                    },
                                    'visible' => Yii::$app->user->identity->ICNO == 710503125371,
                                    'format' => 'html',
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
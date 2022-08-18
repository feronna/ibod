<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

use app\models\elnpt\TblLppTahun;

$tahunn = TblLppTahun::find()->where(['LIKE', 'lpp_aktif', 'y'])->one();

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<?= $this->render('_menuUtama'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian Borang</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(['id' => 'search',  'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left']]); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama PYD</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                        $form->field($searchModel, 'CONm')->textInput([
                            'placeholder' => 'Cari Nama',
                        ])->label(false);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun Penilaian</label>
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
                <h2><strong>Senarai Guru Yang Dinilai</strong></h2>
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
                                'label' => 'NAMA PYD',
                                'headerOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    switch ($model->tahun) {
                                        case 2020:
                                            $u = 'elnpt2/maklumat-guru';
                                            break;
                                        case 2021:
                                            $u = 'elnpt2/maklumat-guru';
                                            break;
                                        default:
                                            $u = 'elnpt/maklumat-guru';
                                    }

                                    return Html::a('<strong><u>' . $model->guru->CONm . '</u></strong>', [$u, 'lppid' => $model->lpp_id]) . '<br><small>' . $model->deptGuru->fullname . '</small>' .
                                        '<br><small>' . $model->gredGuru->nama . ' ' . $model->gredGuru->gred;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'TAHUN',
                                'headerOptions' => ['class' => 'text-center  col-md-2'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return $model->tahun;
                                },
                                'format' => 'html',
                            ],
                            [
                                'label' => 'STATUS BORANG',
                                'headerOptions' => ['class' => 'text-center'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return '<strong>PYD</strong> : ' . (($model->PYD_sah == 0) ? '<span class="label label-danger">Belum Sah</span>' : '<span class="label label-success">Sudah Sah</span>') . '<br>' .
                                        '<strong>PPP</strong> : ' . (($model->PPP_sah == 0) ? '<span class="label label-danger">Belum Sah</span>' : '<span class="label label-success">Sudah Sah</span>') . '<br>' .
                                        '<strong>PPK</strong> : ' . (($model->PPK_sah == 0) ? '<span class="label label-danger">Belum Sah</span>' : '<span class="label label-success">Sudah Sah</span>') . '<br>' .
                                        '<strong>PEER</strong> : ' . (($model->PEER_sah == 0) ? '<span class="label label-danger">Belum Sah</span>' : '<span class="label label-success">Sudah Sah</span>');
                                },
                                'format' => 'html',
                            ],
                            //                                [
                            //                                    'label' => 'HANTAR PERINGATAN',
                            //                                    'headerOptions' => ['class'=>'text-center  col-md-1'],
                            //                                    'value' => function($model) {
                            //                                        return '';
                            //                                    },
                            //                                    'format' => 'html',
                            //                                ],
                            [
                                'label' => 'PENILAIAN SELESAI',
                                'headerOptions' => ['class' => 'text-center  col-md-2'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return ($model->PYD_sah == 1 && $model->PPP_sah == 1
                                        && $model->PPK_sah == 1 && $model->PEER_sah == 1)
                                        ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' :
                                        '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                                },
                                'format' => 'html',
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => $label_revise,
                                //                                    'visible' => ($visible == 1),
                                'headerOptions' => ['class' => 'text-center  col-md-2'],
                                'contentOptions' => ['class' => 'text-center'],
                                'template' => '{reset}',
                                'buttons' => [
                                    'reset' => function ($url, $model) use ($tahunn) {
                                        if (
                                            $model->PPP == Yii::$app->user->identity->ICNO and $model->PYD_sah == 1 and
                                            date('Y-m-d H:i:s') <= $tahunn->penilaian_PPP_tamat
                                        ) {
                                            $url = Url::to(['elnpt/tendang-pyd', 'lppid' => $model->lpp_id]);
                                            return Html::button(
                                                '<span class="glyphicon glyphicon-bell"></span>',
                                                [
                                                    'class' => 'btn btn-default btn-sm',
                                                    'onclick' => "
                                                                if(confirm('Kembalikan borang kepada PYD ?')){
                                                                    $.ajax({
                                                                        type: 'POST',
                                                                        url: '" . $url . "',

                                                                        success: function(result) {
                                                                            if(result == 1) {
                                                                                 setTimeout(function(){
                                                                                    location.reload(); // then reload the page.(3)
                                                                               }, 1); 
                                                                            } else {
                                                                            }
                                                                        }, 
                                                                        error: function(result) {
                                                                            console.log(\"Ada Error\");
                                                                        }
                                                                    });
                                                                    return true;
                                                                }else{
                                                                    return false;
                                                                }
                                                                "

                                                ]
                                            );
                                        } else if (
                                            $model->PPK == Yii::$app->user->identity->ICNO  and $model->PPP_sah == 1 and
                                            date('Y-m-d H:i:s') <= $tahunn->penilaian_PPK_tamat
                                        ) {
                                            $url = Url::to(['elnpt/tendang-ppp', 'lppid' => $model->lpp_id]);
                                            return Html::button(
                                                '<span class="glyphicon glyphicon-bell"></span>',
                                                [
                                                    'class' => 'btn btn-default btn-sm',
                                                    'onclick' => "
                                                                if(confirm('Kembalikan borang kepada PPP ?')){
                                                                    $.ajax({
                                                                        type: 'POST',
                                                                        url: '" . $url . "',

                                                                        success: function(result) {
                                                                            if(result == 1) {
                                                                                 setTimeout(function(){
                                                                                    location.reload(); // then reload the page.(3)
                                                                               }, 1); 
                                                                            } else {
                                                                            }
                                                                        }, 
                                                                        error: function(result) {
                                                                            console.log(\"Ada Error\");
                                                                        }
                                                                    });
                                                                    return true;
                                                                }else{
                                                                    return false;
                                                                }
                                                                "

                                                ]
                                            );
                                        } else {
                                            return '';
                                        }
                                    },
                                ],
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
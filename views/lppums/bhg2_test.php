<?php
/* @var $this yii\web\View */

$js = <<<JS
     $('.modalButtonn').on('click', function () {
        $('#modalLnpkSkt').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
        $('#modalHeader').text('Tambah SKT');
    });

    $('.modalButtonn1').on('click', function () {
        $('#modalLnpkSkt').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
        $('#modalHeader').text('Kemaskini SKT');
    });
JS;
$this->registerJs($js, \yii\web\View::POS_READY);

use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

Modal::begin([
    'header' => '<strong id="modalHeader"></strong>',
    'id' => 'modalLnpkSkt',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();

$akses = \app\models\lppums\TblStafAkses::find()
    ->leftJoin('hrm.lppums_akses a', 'a.akses_id = hrm.lppums_staf_akses.akses_id')
    ->where(['hrm.lppums_staf_akses.ICNO' => Yii::$app->user->identity->ICNO])
    ->andWhere(['IS NOT', 'a.akses_set_akses', NULL])
    ->exists();

?>

<?= $this->render('_menuBorang', ['lppid' => $lpp->lpp_id]); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Bahagian II - Kegiatan dan Sumbangan Di Luar Tugas Rasmi / Latihan (Wajaran 5%)</strong> <?= (($lpp->PYD != Yii::$app->user->identity->ICNO)) ? '(' . $lpp->pyd->CONm . ' - ' . $lpp->tahun . ')' : '' ?></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <ul class="nav nav-tabs">
                        <li class="<?= $tab == '1' ? 'active' : '' ?>" role="presentation"><a data-toggle="tab" href="#1">Kegiatan dan Sumbangan Di Luar Tugas Rasmi</a></li>
                        <li class="<?= $tab == '2' ? 'active' : '' ?>" role="presentation"><a data-toggle="tab" href="#2">Latihan</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="1" class="tab-pane fade in <?= $tab == '1' ? 'active' : '' ?>">
                            <div style="padding-top: 20px;padding-bottom: 10px;padding-left: 20px;padding-right: 20px">
                                <p><strong>OUTPUT 1 : </strong><strong>KEGIATAN DAN SUMBANGAN DI LUAR TUGAS RASMI</strong></p>
                                <ol>
                                    <li>Keahlian dalam jawatankuasa.</li>
                                    <li>Penceramah jemputan (di luar skop tugas rasmi).</li>
                                    <li>Penyertaan dalam pertandingan (di luar skop tugas rasmi).</li>
                                    <li>Pengiktirafan (di luar skop tugas rasmi).</li>
                                    <li>Penyertaan aktiviti persatuan/NGO/komuniti/badan profesional.</li>
                                    <li>Penulisan artikel.</li>
                                    <li>Karya kreatif.</li>
                                    <li>Badan beruniform.</li>
                                    <li>Kejurulatihan/perundingan/fasilitator.</li>
                                    <li>Aktiviti lain (jika berkaitan).</li>
                                </ol>
                                <p><strong>DOKUMEN SOKONGAN:</strong></p>
                                <ul>
                                    <li>Surat lantikan/ sijil penyertaan/ surat atau sijil penghargaan.</li>
                                    <li>Dokumen lain yang berkaitan.</li>
                                </ul>
                                <p><strong>NOTA:</strong></p>
                                <ol>
                                    <li>Mengambil kira jumlah aktiviti sahaja (kuantiti), skala ikut dalam borang JPA. 1 aktiviti = 1 markah. 10 aktiviti = 10 markah.</li>
                                    <li>Setiap aktiviti jika terlibat sebagai penganjur tambahan 0.5 markah.</li>
                                    <li>Penyertaan aktiviti dalam kegiatan politik atau persatuan/kesatuan yang diragui/subversif tidak diambil kira.</li>
                                    <li>Sebarang bentuk aktiviti yang dibayar elaun (berbayar) tidak diambil kira.</li>
                                    <li>Lima tahap penglibatan iaitu Sangat Aktif, Aktif, Sederhana Aktif, Kurang Aktif, Tidak Aktif tanpa mengira peringkat penglibatan iaitu Komuniti / Jabatan / Daerah / Negeri / Negara / Antarabangsa dengan menggunakan skala 1 hingga 10 berikut:</li>
                                </ol>
                                <table class="table table-sm table-bordered text-center align-middle">
                                    <tbody>
                                        <tr>
                                            <td width="96">
                                                <p><strong>TAHAP</strong></p>
                                            </td>
                                            <td colspan="2" width="159">
                                                <p><strong>SANGAT AKTIF</strong></p>
                                            </td>
                                            <td colspan="2" width="159">
                                                <p><strong>AKTIF</strong></p>
                                            </td>
                                            <td colspan="2" width="159">
                                                <p><strong>SEDERHANA AKTIF</strong></p>
                                            </td>
                                            <td colspan="2" width="159">
                                                <p><strong>KURANG AKTIF</strong></p>
                                            </td>
                                            <td colspan="2" width="159">
                                                <p><strong>TIDAK AKTIF</strong></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="96">
                                                <p><strong>SKALA</strong></p>
                                            </td>
                                            <td width="80">
                                                <p>10</p>
                                            </td>
                                            <td width="80">
                                                <p>9</p>
                                            </td>
                                            <td width="80">
                                                <p>8</p>
                                            </td>
                                            <td width="80">
                                                <p>7</p>
                                            </td>
                                            <td width="80">
                                                <p>6</p>
                                            </td>
                                            <td width="80">
                                                <p>5</p>
                                            </td>
                                            <td width="80">
                                                <p>4</p>
                                            </td>
                                            <td width="80">
                                                <p>3</p>
                                            </td>
                                            <td width="80">
                                                <p>2</p>
                                            </td>
                                            <td width="80">
                                                <p>1</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <hr />

                            <div class="clearfix"></div>

                            <div class="table-responsive">
                                <?php Pjax::begin([
                                    'id' => 'grid_senarai', 'timeout' => false, 'enablePushState' => false
                                ]) ?>
                                <?=
                                GridView::widget([
                                    'striped' => false,
                                    'emptyText' => 'Tiada Rekod',
                                    'caption' => ($lpp->PPP ==  Yii::$app->user->identity->ICNO) ? '<p class="text-left"><sub>Klik butang <button class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-thumbs-down"></span> Tolak</button>untuk menolak dokumen yang telah dimuatnaik<br/>Klik butang <button class="btn btn-success btn-xs"><span class="glyphicon glyphicon-thumbs-up"></span> Terima</button>untuk mengesah dokumen yang telah dimuatnaik</sub></p>' : '',
                                    'summary' => '',
                                    'showPageSummary' => true,
                                    'pageSummaryContainer' => ['class' => 'text-center'],
                                    'dataProvider' => $dataProvider,
                                    'toolbar' => [],
                                    'panel' => [
                                        'heading' => ($lpp->PYD == Yii::$app->user->identity->ICNO && is_null($tt->pyd)) ? Html::button('Tambah Aktiviti', ['value' => Url::to(['lppums/tambah-aktiviti', 'lpp_id' => $lpp->lpp_id]), 'class' => 'pull-right btn-success btn-sm modalButtonn']) : '',
                                        'type' => 'default',
                                        // 'before' => Html::a('<i class="fas fa-plus"></i> Create Country', ['create'], ['class' => 'btn btn-success']),
                                        'footer' => false,
                                    ],
                                    // 'rowOptions' => function ($model) {
                                    //     if (date('m') != $model->month && ($model->month != date('m') - 1)) {
                                    //         return ['style' => 'background-color:rgb(235,235,228)'];
                                    //     }
                                    // },
                                    'columns' => [
                                        [
                                            'header' => 'BULAN',
                                            'headerOptions' => ['class' => 'text-center col-md-1'],
                                            'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                                            'value' => function ($model) {
                                                return ucfirst($model->monthLabel->slabel ?? '');
                                            },
                                            'group' => true,

                                        ],
                                        [
                                            'label' => 'PERANAN',
                                            'headerOptions' => ['class' => 'column-title text-center'],
                                            'value' => function ($model) {
                                                return '<sup>' . Yii::$app->formatter->asDate($model->updated_dt ?? $model->created_dt, 'dd/MM/yyyy') . '</sup><br>' . $model->ringkasan;
                                            },
                                            'format' => 'html',
                                        ],
                                        [
                                            'label' => 'RINGKASAN AKTIVITI',
                                            'headerOptions' => ['class' => 'column-title text-center'],
                                            'value' => function ($model) {
                                                return  $model->sasaran_kerja;
                                            },
                                            'format' => 'html',
                                        ],
                                        // [
                                        //     'label' => 'PENCAPAIAN SEBENAR',
                                        //     'headerOptions' => ['class' => 'column-title text-center'],
                                        //     'value' => function ($model) {
                                        //         return $model->capai;
                                        //     },
                                        //     'format' => 'html',
                                        // ],
                                        [
                                            'label' => 'DOKUMEN',
                                            'headerOptions' => ['class' => 'text-center col-md-1'],
                                            'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                                            'footerOptions' => ['style' => 'text-align: right;'],
                                            'value' => function ($model) {
                                                return ($model->document) ? Html::a("<i class='fa fa-file' aria-hidden='true'></i>
                                        ", Url::to(['lppums/view-file', 'hashfile' => $model->document->filehash, 'lpp_id' => $model->lpp_id]), ['data-pjax' => 0, 'target' => '_blank', 'class' => 'btn btn-xs btn-default']) : '';
                                            },
                                            'format' => 'raw',
                                            'pageSummary' => 'TOTAL',

                                        ],

                                        [
                                            'label' => 'ANGGARAN MARKAH',
                                            'hidden' => !(($lpp->PYD ==  Yii::$app->user->identity->ICNO) || ($lpp->PPP ==  Yii::$app->user->identity->ICNO) || $akses),
                                            'headerOptions' => ['class' => 'column-title text-center col-md-1'],
                                            'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                                            'footerOptions' => ['class' => 'text-center'],
                                            'value' => function ($model) {
                                                switch ($model->ringkasan) {
                                                    case 'Penganjur':
                                                        return 1.5;
                                                    case 'Peserta':
                                                        return 1.0;
                                                    default:
                                                        return null;
                                                }
                                            },
                                            'format' => 'raw',

                                            'pageSummary' => function ($summary, $data, $widget) {
                                                return min($summary, 10);
                                            }
                                        ],
                                        [
                                            'class' => 'kartik\grid\ActionColumn',
                                            'header' => 'TINDAKAN',
                                            'hidden' => !(($lpp->PYD ==  Yii::$app->user->identity->ICNO) && is_null($tt->pyd)),
                                            'headerOptions' => ['class' => 'text-center col-md-1'],
                                            'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                                            'template' => '{update} {delete}',

                                            'buttons' => [
                                                'update' => function ($url, $model) {
                                                    $url = Url::to(['lppums/edit-aktiviti', 'lpp_id' => $model->lpp_id, 'skt_id' => $model->id]);
                                                    return $model->id ? Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-xs modalButtonn1']) : '';
                                                },
                                                'delete' => function ($url, $model) {
                                                    $url = Url::to(['lppums/delete-aktiviti', 'lpp_id' => $model->lpp_id, 'skt_id' => $model->id]);
                                                    return $model->id ?  Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['title' => 'Delete', 'data-confirm' => 'Adakah anda pasti?', 'class' => 'btn btn-default btn-xs']) : '';
                                                },
                                            ],

                                        ],

                                        [
                                            'label' => 'MARKAH',
                                            'headerOptions' => ['class' => 'column-title text-center col-md-1'],
                                            'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                                            'footerOptions' => ['class' => 'text-center'],
                                            'hidden' => !(($lpp->PPP ==  Yii::$app->user->identity->ICNO)),
                                            'value' => function ($model) {
                                                if ($model->document) {
                                                    if ($model->document->verified_ppp) {
                                                        switch ($model->ringkasan) {
                                                            case 'Penganjur':
                                                                return 1.5;
                                                            case 'Peserta':
                                                                return 1.0;
                                                            default:
                                                                return null;
                                                        }
                                                    }
                                                    return 0;
                                                }
                                                return null;
                                            },
                                            'format' => 'raw',
                                            'pageSummary' => function ($summary, $data, $widget) {
                                                return min($summary, 10);
                                            },

                                        ],
                                        [
                                            'class' => '\kartik\grid\ActionColumn',
                                            'header' => 'PENGESAHAN PPP',
                                            'hidden' => !(($lpp->PPP ==  Yii::$app->user->identity->ICNO) && $lpp->PPP_sah == 0),
                                            'headerOptions' => ['class' => 'text-center col-md-1'],
                                            'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                                            'template' => '{approve}',
                                            'buttons' => [
                                                'approve' => function ($url, $model) {
                                                    $url = Url::to(['lppums/approve-skt-ppp', 'skt_id' => $model->id, 'aspek_id' => $model->aspek_id, 'lpp_id' => $model->lpp_id, 'bhg' => 0, 'order' => 0]);
                                                    return $model->id ?  Html::a(!isset($model->document->verified_ppp)  ? '<span class="glyphicon glyphicon-thumbs-up"></span> Terima' : '<span class="glyphicon glyphicon-thumbs-down"></span> Tolak', false, [
                                                        'title' => 'Approve',

                                                        'class' =>  !isset($model->document->verified_ppp)  ? 'btn btn-success btn-xs' : 'btn btn-danger btn-xs',
                                                        'onclick' => "
                                                                        $.ajax({
                                                                            type: 'POST',
                                                                            url: '" .  $url . "',
        
                                                                            success: function(result) {
                                                                                if(result) {
                                                                                    $.pjax.reload({
                                                                                        container: '#grid_senarai',
                                                                                    });
                                                                                } 
                                                                            }, 
                                                                            error: function(result) {
                                                                                console.log(\"Record not found\");
                                                                            }
                                                                        });
                                                                        
                                                                    ",
                                                    ]) : '';
                                                },
                                            ],

                                        ],
                                    ],
                                ]);
                                ?>
                                <?php Pjax::end() ?>
                            </div>

                        </div>
                        <div id="2" class="tab-pane fade in <?= $tab == '2' ? 'active' : '' ?>">
                            <div style="padding: 20px">
                                <p><strong>OUTPUT 2 : </strong><strong>LATIHAN</strong></p>
                                <ol>
                                    <li>Maklumat diperoleh daripada Sistem MyIDP UMS dalam kategori TERAS UNIVERSITI, TERAS SKIM DAN ELEKTIF.</li>
                                </ol>
                                <p><strong>DOKUMEN SOKONGAN:</strong></p>
                                <ul>
                                    <li>Maklumat diperoleh daripada Sistem MyIDP UMS.</li>
                                </ul>
                                <p><strong>NOTA:</strong></p>
                                <ol>
                                    <li>Jadual penetapan mata IDP mengikut gred jawatan.</li>
                                </ol>
                                <table class="table table-sm table-bordered text-center align-middle">
                                    <tbody>
                                        <tr>
                                            <td rowspan="2" width="119">
                                                <p><strong>KUMPULAN</strong></p>
                                            </td>
                                            <td rowspan="2" width="48">
                                                <p><strong>BIL</strong></p>
                                            </td>
                                            <td rowspan="2" width="190">
                                                <p><strong>JAWATAN &amp; GRED</strong></p>
                                            </td>
                                            <td rowspan="2" width="119">
                                                <p><strong>MATA MINIMUM</strong></p>
                                            </td>
                                            <td colspan="3" width="356">
                                                <p><strong>KOMPONEN</strong></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="119">
                                                <p><strong>TERAS UNIVERSITI</strong></p>
                                            </td>
                                            <td width="119">
                                                <p><strong>TERAS SKIM</strong></p>
                                            </td>
                                            <td width="119">
                                                <p><strong>ELEKTIF</strong></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td rowspan="7" width="119">
                                                <p>PENTADBIRAN</p>
                                            </td>
                                            <td width="48">
                                                <p>1</p>
                                            </td>
                                            <td width="190">
                                                <p>VU</p>
                                            </td>
                                            <td width="119">
                                                <p>12</p>
                                            </td>
                                            <td width="119">
                                                <p>-</p>
                                            </td>
                                            <td width="119">
                                                <p>6</p>
                                            </td>
                                            <td width="119">
                                                <p>6</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="48">
                                                <p>2</p>
                                            </td>
                                            <td width="190">
                                                <p>PENGURUSAN 54</p>
                                            </td>
                                            <td width="119">
                                                <p>16</p>
                                            </td>
                                            <td width="119">
                                                <p>-</p>
                                            </td>
                                            <td width="119">
                                                <p>6</p>
                                            </td>
                                            <td width="119">
                                                <p>10</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="48">
                                                <p>3</p>
                                            </td>
                                            <td width="190">
                                                <p>PENGURUSAN 48-52</p>
                                            </td>
                                            <td width="119">
                                                <p>18</p>
                                            </td>
                                            <td width="119">
                                                <p>-</p>
                                            </td>
                                            <td width="119">
                                                <p>12</p>
                                            </td>
                                            <td width="119">
                                                <p>6</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="48">
                                                <p>4</p>
                                            </td>
                                            <td width="190">
                                                <p>PENGURUSAN 41-44</p>
                                            </td>
                                            <td width="119">
                                                <p>24</p>
                                            </td>
                                            <td width="119">
                                                <p>6</p>
                                            </td>
                                            <td width="119">
                                                <p>12</p>
                                            </td>
                                            <td width="119">
                                                <p>6</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="48">
                                                <p>5</p>
                                            </td>
                                            <td width="190">
                                                <p>PELAKSANA 32-40</p>
                                            </td>
                                            <td width="119">
                                                <p>24</p>
                                            </td>
                                            <td width="119">
                                                <p>6</p>
                                            </td>
                                            <td width="119">
                                                <p>12</p>
                                            </td>
                                            <td width="119">
                                                <p>6</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="48">
                                                <p>6</p>
                                            </td>
                                            <td width="190">
                                                <p>PELAKSANA 17-29</p>
                                            </td>
                                            <td width="119">
                                                <p>24</p>
                                            </td>
                                            <td width="119">
                                                <p>6</p>
                                            </td>
                                            <td width="119">
                                                <p>12</p>
                                            </td>
                                            <td width="119">
                                                <p>6</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="48">
                                                <p>7</p>
                                            </td>
                                            <td width="190">
                                                <p>PELAKSANA 1-16</p>
                                            </td>
                                            <td width="119">
                                                <p>12</p>
                                            </td>
                                            <td width="119">
                                                <p>6</p>
                                            </td>
                                            <td width="119">
                                                <p>6</p>
                                            </td>
                                            <td width="119">
                                                <p>-</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="table-responsive">
                                <?=
                                GridView::widget([
                                    'striped' => false,
                                    'emptyText' => 'Tiada Rekod',
                                    'summary' => '',
                                    'dataProvider' => $dataProvider2,
                                    'columns' => [
                                        [
                                            'class' => 'yii\grid\SerialColumn',
                                            'header' => 'BIL',
                                            'headerOptions' => ['class' => 'text-center col-md-1'],
                                            'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                                        ],
                                        [
                                            'label' => 'JENIS',
                                            'headerOptions' => ['class' => 'column-title text-center'],
                                            'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                                            'value' => function ($model) {
                                                return $model->sasaran3->kompetensii;
                                            },
                                            'format' => 'html',
                                        ],
                                        [
                                            'label' => 'LATIHAN',
                                            'headerOptions' => ['class' => 'column-title text-center'],
                                            'value' => function ($model) {
                                                return $model->sasaran3->tajukLatihan;
                                            },
                                            'format' => 'html',
                                        ],
                                        [
                                            'label' => 'TARIKH MULA',
                                            'headerOptions' => ['class' => 'column-title text-center col-md-2'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'value' => function ($model) {
                                                $date1 = new DateTime($model->tarikhMula);
                                                $date2 = new DateTime($model->tarikhAkhir);
                                                $days  = $date2->diff($date1)->format('%a');
                                                return Yii::$app->formatter->asDate($model->tarikhMula, 'dd') . ' - ' . Yii::$app->formatter->asDate($model->tarikhAkhir, 'dd/MM/yyyy') . ' (' . ($days + 1) . ' hari)';
                                            },
                                            'format' => 'html',
                                        ],
                                        [
                                            'label' => 'LOKASI',
                                            'headerOptions' => ['class' => 'column-title text-center'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'value' => function ($model) {
                                                return $model->lokasiKursus;
                                            },
                                            'format' => 'html',
                                        ],
                                        [
                                            'label' => 'MATA MINIMA CPD',
                                            'headerOptions' => ['class' => 'column-title text-center col-md-1'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'value' => function ($model) use ($mataCpd) {
                                                return !is_null($mataCpd) ? (($mataCpd->idp_mata_min == 0) ? 'Dikecualikan' : $mataCpd->idp_mata_min) : '';
                                            },
                                            'format' => 'html',
                                            'group' => true
                                        ],
                                        [
                                            'label' => 'JUMLAH MATA CPD TERKUMPUL',
                                            'headerOptions' => ['class' => 'column-title text-center col-md-1'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'value' => function ($model) use ($mataCpd, $summ) {
                                                return !is_null($mataCpd) ?  (($mataCpd->idp_mata_min == 0) ? 'Dikecualikan' : $summ) : '';
                                            },
                                            'format' => 'html',
                                            'group' => true
                                        ],
                                    ],
                                ]);
                                ?>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <hr>
                    <?php if ($tt->isNewRecord) { ?>
                        <strong>Saya mengesahkan bahawa semua kenyataan di atas adalah benar.</strong>
                    <?php } ?>
                </div><br>

                <div class="row">
                    <?php if (($tt->isNewRecord) and $lpp->PYD == Yii::$app->user->identity->ICNO and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat . ' 23:59:59') or ($lpp->PYD == \Yii::$app->user->identity->ICNO and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) { ?>
                        <div class="col-md-3 col-xs-6" style="text-align:center">
                            <?= Html::a(
                                'Klik untuk tandatangan PYD',
                                ['lppums/bahagian2-test', 'lpp_id' => $_GET['lpp_id']],
                                [
                                    'class' => 'btn btn-default btn-primary',
                                    'data' => [
                                        'confirm' => 'Adakah anda pasti dengan tindakan ini?',
                                        'method' => 'post',
                                    ],
                                ]
                            ) ?>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-3 col-xs-6">
                        </div>
                    <?php } ?>
                    <div class="col-md-6 col-xs-0">
                    </div>
                    <div class="col-md-3 col-xs-6">
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-md-3 col-xs-6">
                        <?= Html::input('text', 'password1', ((is_null($tt)) ? '' : ((is_null($tt->pyd)) ? '' : $tt->pyd->CONm)), ['class' => 'form-control', 'disabled' => true, 'style' => 'text-align: center']) ?>
                    </div>
                    <div class="col-md-6 col-xs-0">
                    </div>
                    <div class="col-md-3 col-xs-6">
                        <?= Html::input('text', 'password1', ((is_null($tt)) ? '' : ((is_null($tt->sumbangan_tt_date)) ? '' : Yii::$app->formatter->asDateTime($tt->sumbangan_tt_date . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A"))), ['class' => 'form-control', 'disabled' => true, 'style' => 'text-align: center']) ?>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-md-3 col-xs-6" style="text-align: center">
                        Tandatangan PYD
                    </div>
                    <div class="col-md-6 col-xs-0">
                    </div>
                    <div class="col-md-3 col-xs-6" style="text-align: center">
                        Tarikh
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php

use yii\bootstrap\Alert;
use app\models\elnpt\TblLppTahun;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//if($lpp->PYD == Yii::$app->user->identity->ICNO) {
//// javascript for triggering the dialogs
//$js = <<< JS
//$( document ).ready(function() {
//    krajeeDialog.alert("Sila berhubung dengan PPP anda untuk membuat Subject Verification sebelum penilaian bermula.")
//});
//JS;
// 
//// register your javascript
//$this->registerJs($js);
//}
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
use kartik\dialog\Dialog;
use yii\bootstrap\Modal;
use app\models\elnpt\elnpt2\TblPnP;

$abc = 1;
$curr_year = $lpp->tahun;

$grid = GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        // ['class' => 'yii\grid\SerialColumn'],
        'fullname',
        'status',
        'sumber'
    ],
]);

$semester = [
    // '1-' . ($curr_year - 1) . '/' . ($curr_year) . '' => '1 - ' . ($curr_year - 1) . '/' . ($curr_year) . '',
    '2-' . ($curr_year - 1) . '/' . ($curr_year) . '' => '2-' . ($curr_year - 1) . '/' . ($curr_year) . '',
    '3-' . ($curr_year - 1) . '/' . ($curr_year) . '' => '3-' . ($curr_year - 1) . '/' . ($curr_year) . '',
    '1-' . ($curr_year) . '/' . ($curr_year + 1) . '' => '1-' . ($curr_year) . '/' . ($curr_year + 1) . '',
    // '2-' . ($curr_year) . '/' . ($curr_year + 1) . '' => '2 - ' . ($curr_year) . '/' . ($curr_year + 1) . '',
    // '3-' . ($curr_year) . '/' . ($curr_year + 1) . '' => '3 - ' . ($curr_year) . '/' . ($curr_year + 1) . '',
    'Nursing' => [
        '1-' . ($curr_year - 1) . '/' . ($curr_year) . '' => '1-' . ($curr_year - 1) . '/' . ($curr_year) . '',
    ]
];

if ($lpp->jfpiu == 138) {
    // array_merge($semester, [
    //     'Rotation 1' => 'Rotation 1',
    //     'Rotation 2' => 'Rotation 2',
    //     'Rotation 3' => 'Rotation 3',
    //     'Rotation 4' => 'Rotation 4',
    //     'Rotation 5' => 'Rotation 5',
    //     'Rotation 6' => 'Rotation 6',
    // ]);
    $semester = $semester + [
        '[R1-' . ($curr_year - 1) . '/' . ($curr_year) . ']' => 'Rotation 1',
        '[R2-' . ($curr_year - 1) . '/' . ($curr_year) . ']' => 'Rotation 2',
        '[R3-' . ($curr_year - 1) . '/' . ($curr_year) . ']' => 'Rotation 3',
        '[R4-' . ($curr_year - 1) . '/' . ($curr_year) . ']' => 'Rotation 4',
        '[R5-' . ($curr_year - 1) . '/' . ($curr_year) . ']' => 'Rotation 5',
        '[R6-' . ($curr_year - 1) . '/' . ($curr_year) . ']' => 'Rotation 6',
    ];
}


// if ($lpp->PYD == Yii::$app->user->identity->ICNO && $lpp->PYD_sah == 0) {
//     if $check {
//         $flag = true;
//     } else {
//         $flag = false;
//     }
// } else {
//     $flag = true;
// }

echo Dialog::widget();

?>

<?php
//Alert::widget([
//    'options' => ['class' => 'alert-warning'],
//    'body' => '<font color="black">
//                    <strong>INFO</strong><br>
//                    <p>
//                        Data untuk Blended Learning belum ditarik.
//                    </p>
//                </font>',
//]);
?>
<?php $form = ActiveForm::begin(); ?>
<div class="table-responsive">

    <table class="table table-sm table-bordered">
        <tr>
            <th class="text-center" rowspan="2">BIL.</th>
            <th class="text-center" rowspan="2">KOD KURSUS</th>
            <th class="text-center" rowspan="2">NAMA KURSUS</th>
            <th class="text-center" rowspan="2">SKOP TUGAS</th>
            <th class="text-center" rowspan="2">STATUS PENGENDALIAN</th>
            <th class="text-center" rowspan="2">PENGLIBATAN TUTOR / DEMONSTRATOR</th>
            <th class="text-center" rowspan="2">SEKSYEN</th>
            <th class="text-center" rowspan="2">BIL. PELAJAR</th>
            <th class="text-center" rowspan="2">SEMESTER</th>
            <th class="text-center" rowspan="2">STATUS KURSUS</th>
            <th class="text-center" colspan="3">JAM F2F UNTUK 14 MINGGU</th>

            <th class="text-center" rowspan="2">STATUS FAIL PENGAJARAN</th>

            <th class="text-center" rowspan="2">STATUS Smartv3</th>
            <th class="text-center" rowspan="2">PK07 (DELIVERY OF LECTURES)</th>
            <th class="text-center" rowspan="2">DOKUMEN SOKONGAN</th>
            <?php if ($lpp->PYD == Yii::$app->user->identity->ICNO && $lpp->PYD_sah == 0) { ?>
                <th class="text-center" rowspan="2">TINDAKAN</th>
            <?php } ?>

        </tr>
        <tr>
            <th class="text-center" colspan="1">JAM SYARAHAN
                <small><a data-toggle="tooltip" data-placement="top" title="Per Semester (Face-to-face)">
                        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                    </a></small>
            </th>
            <th class="text-center" colspan="1">JAM TUTORIAL
                <small><a data-toggle="tooltip" data-placement="top" title="Per Semester (Face-to-face)">
                        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                    </a></small>
            </th>
            <th class="text-center" colspan="1">JAM MAKMAL / LAIN-LAIN
                <small><a data-toggle="tooltip" data-placement="top" title="Per Semester (Face-to-face)">
                        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                    </a></small>
            </th>
        </tr>

        <?php if (empty($data)) { ?>
            <tr>
                <td colspan="17">Tiada rekod dijumpai.</td>
            </tr>

            <?php } else {
            foreach ($data as $ind => $dt) {
                if (!isset($input[$ind])) {
                    // continue;
                    $input[$ind] = new TblPnP();
                }
            ?>

                <?php
                // necessary for update action.
                // if (! $input[$ind]->isNewRecord) {
                echo Html::activeHiddenInput($input[$ind], "[$ind]id_pnp");
                // }
                ?>

                <tr>
                    <td class="col-md-1 text-center" style="text-align:center"><?= $abc++; ?></td>
                    <td class="col-md-1 text-center" style="text-align:center"><?= $dt['kod_kursus']; ?></td>
                    <td class="col-md-1 text-center" style="text-align:center"><?= $dt['nama_kursus']; ?></td>
                    <td class="col-md-1 text-center" style="text-align:center">
                        <?php if ($dt['manual'] == '0') { ?>
                            <?=
                            $form->field($input[$ind], "[$ind]skop_tugas")->label(false)->widget(Select2::classname(), [
                                'data' => [
                                    // 0 => 'TIADA', 
                                    'Pensyarah' => 'Pensyarah',
                                    'Penyelaras' => 'Penyelaras',
                                    'Pensyarah_Penyelaras' => 'Pensyarah & Penyelaras',
                                    'Tutor' => 'Tutor',
                                ],
                                'hideSearch' => true,
                                'options' => [
                                    'disabled' => ($lpp->PYD == Yii::$app->user->identity->ICNO ? $check : true)
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        <?php } else { ?>
                        <?= $dt['skop_tugas'] == 'Pensyarah_Penyelaras' ? 'Pensyarah & Penyelaras' : $dt['skop_tugas'];
                        } ?>
                    </td>
                    <td class="col-md-1 text-center" style="text-align:center">
                        <?php if ($dt['manual'] == '0') { ?>
                            <?=
                            $form->field($input[$ind], "[$ind]status_pengendalian")->label(false)->widget(Select2::classname(), [
                                'data' => [
                                    // 0 => 'TIADA', 
                                    'DIKENDALIKAN OLEH SAYA SEORANG SAHAJA' => 'DIKENDALIKAN OLEH SAYA SEORANG SAHAJA',
                                    'DIKENDALIKAN OLEH 2 ORANG' => 'DIKENDALIKAN OLEH 2 ORANG',
                                    'DIKENDALIKAN OLEH 3 ORANG' => 'DIKENDALIKAN OLEH 3 ORANG',
                                    'DIKENDALIKAN OLEH 4 ORANG' => 'DIKENDALIKAN OLEH 4 ORANG',
                                    'DIKENDALIKAN OLEH 5 ORANG' => 'DIKENDALIKAN OLEH 5 ORANG',
                                    'DIKENDALIKAN OLEH LEBIH 5 ORANG' => 'DIKENDALIKAN OLEH LEBIH 5 ORANG',
                                ],
                                'hideSearch' => true,
                                'options' => [
                                    'disabled' => ($lpp->PYD == Yii::$app->user->identity->ICNO ? $check : true)
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        <?php } else { ?>
                        <?= $dt['status_pengendalian'];
                        } ?>
                    </td>
                    <td class="col-md-1 text-center" style="text-align:center">
                        <?php if ($dt['manual'] == '0') { ?>
                            <?=
                            $form->field($input[$ind], "[$ind]penglibatan")->label(false)->widget(Select2::classname(), [
                                'data' => [
                                    'TIADA' => 'TIADA',
                                    'ADA' => 'ADA',
                                ],
                                'hideSearch' => true,
                                'options' => [
                                    'disabled' => ($lpp->PYD == Yii::$app->user->identity->ICNO ? $check : true)
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        <?php } else { ?>
                        <?= $dt['penglibatan'];
                        } ?>
                    </td>
                    <td class="col-md-1 text-center" style="text-align:center">
                        <?php if ($dt['manual'] == '0') { ?>
                            <?= $dt['SEKSYEN']; ?>
                            <?= $form->field($input[$ind], "[$ind]seksyen")->hiddenInput(['value' => $dt['seksyen']])->label(false) ?>
                        <?php } else { ?>
                        <?= $form->field($input[$ind], "[$ind]seksyen")->textInput(['style' => 'text-align:center', 'placeholder' => '0', 'disabled' => ($lpp->PYD == Yii::$app->user->identity->ICNO ? $check : true)])->label(false);
                        } ?>
                    </td>
                    <td class="col-md-1 text-center" style="text-align:center">
                        <?php if ($dt['manual'] == '0') { ?>
                            <?= $dt['bil_pelajar']; ?>
                            <?= $form->field($input[$ind], "[$ind]bil_pelajar")->hiddenInput(['value' => $dt['bil_pelajar']])->label(false) ?>
                        <?php } else { ?>
                        <?= $form->field($input[$ind], "[$ind]bil_pelajar")->textInput(['style' => 'text-align:center', 'placeholder' => '0', 'disabled' => ($lpp->PYD == Yii::$app->user->identity->ICNO ? $check : true)])->label(false);
                        } ?>
                    </td>
                    <td class="col-md-1 text-center" style="text-align:center">
                        <?php if ($dt['manual'] == '0') { ?>
                            <?= $dt['semester']; ?>
                        <?php } else { ?>
                        <?=
                            // $form->field($input[$ind], "[$ind]semester")->textInput(['style' => 'text-align:center', 'placeholder' => '0'])->label(false);
                            $form->field($input[$ind], "[$ind]semester")->label(false)->widget(Select2::classname(), [
                                'data' => $semester,
                                'hideSearch' => true,
                                'options' => [
                                    'placeholder' => 'Carian ...',
                                    //                                'id' => 'ppp'
                                    //'class' => 'form-control col-md-7 col-xs-12',
                                    //'id' => 'jenis_carian',
                                    'disabled' => ($lpp->PYD == Yii::$app->user->identity->ICNO ? $check : true)
                                ],
                                // 'pluginOptions' => [
                                //     'allowClear' => true
                                // ],
                            ]);
                        } ?>
                        <?=
                        ($input[$ind]->semester == '1-2019/2020') ? '<i>*Semester 1-2019/2020 hanya digunapakai untuk kursus <b>Nursing</b> sahaja.</i>' : '';
                        ?>
                    </td>
                    <td class="text-center" style="text-align:center">
                        <?=
                        $form->field($input[$ind], "[$ind]status_kursus")->label(false)->widget(Select2::classname(), [
                            'data' => [
                                'HAKIKI' => 'HAKIKI',
                                'BERBAYAR' => 'BERBAYAR',
                            ],
                            'hideSearch' => true,
                            'options' => [
                                'placeholder' => 'Carian ...',
                                //                                'id' => 'ppp'
                                //'class' => 'form-control col-md-7 col-xs-12',
                                //'id' => 'jenis_carian',
                                'disabled' => ($lpp->PYD == Yii::$app->user->identity->ICNO ? $check : true)
                            ],
                            // 'pluginOptions' => [
                            //     'allowClear' => true
                            // ],
                        ]);
                        ?></td>
                    <td class="col-md-1 text-center" style="text-align:center"><?= $form->field($input[$ind], "[$ind]jam_syarahan")->textInput(['style' => 'text-align:center', 'placeholder' => '0', 'disabled' => ($lpp->PYD == Yii::$app->user->identity->ICNO ? $check : true)])->label(false); ?></td>
                    <td class="col-md-1 text-center" style="text-align:center"><?= $form->field($input[$ind], "[$ind]jam_tutorial")->textInput(['style' => 'text-align:center', 'placeholder' => '0', 'disabled' => ($lpp->PYD == Yii::$app->user->identity->ICNO ? $check : true)])->label(false); ?></td>
                    <td class="col-md-1 text-center" style="text-align:center"><?= $form->field($input[$ind], "[$ind]jam_amali")->textInput(['style' => 'text-align:center', 'placeholder' => '0', 'disabled' => ($lpp->PYD == Yii::$app->user->identity->ICNO ? $check : true)])->label(false); ?></td>

                    <td class="text-center" style="text-align:center">
                        <?=
                        $form->field($input[$ind], "[$ind]status_fail")->label(false)->widget(Select2::classname(), [
                            'data' => [
                                'Tiada' => 'Tiada',
                                'Ada - Lengkap' => 'Ada - Lengkap',
                                'Ada - Tidak Lengkap' => 'Ada - Tidak Lengkap',
                            ],
                            'hideSearch' => true,
                            'options' => [
                                'placeholder' => 'Carian ...',
                                //                                'id' => 'ppp'
                                //'class' => 'form-control col-md-7 col-xs-12',
                                //'id' => 'jenis_carian',
                                'disabled' => ($lpp->PYD == Yii::$app->user->identity->ICNO ? $check : true)
                            ],
                            // 'pluginOptions' => [
                            //     'allowClear' => true
                            // ],
                        ]);
                        ?></td>
                    <td class="col-md-1 text-center" style="text-align:center">
                        <?php if (isset($dt['status'])) { ?>
                            <?= ($dt['status'] == 'Pass') ? '<font color="green">PASS</font>' :
                                '<font color="red">FAIL</font>'; ?>
                        <?php } else {
                            echo '<font color="orange">UNAVAILABLE</font>';
                        }
                        ?>
                    </td>

                    <td class="col-md-1 text-center" style="text-align:center">
                        <?= (Yii::$app->formatter->asDecimal($dt['pk07']) == 0.0) ? '<font color="orange">N/A</font>' : '<font color="green">PASS</font>'; ?>
                    </td>

                    <td class="col-md-1 text-center" style="text-align:center">
                        <?= (strlen($dt['file_hash']) == 0 && !is_null($dt['file_hash'])) ? 'SMP UMS' : Html::a("<i class='fa fa-file ' aria-hidden='true'></i>
                        ", Url::to(['elnpt2/view-file', 'hashfile' => $dt['file_hash'], 'lppid' => $lppid]), ['target' => '_blank', 'class' => 'btn btn-xs btn-default']) . '<br>' . (!empty($dt['ver_by']) ? '<font color="green">Verified</font>' : '<font color="red">Unverified</font>') . '<br>' ?>
                        <?php
                        echo $this->render('_verifyPPP', [
                            'ind' => $ind,
                            'lpp' => $lpp,
                            'check' => $check,
                            'lppid' => $lppid,
                            'file_hash' => $dt['file_hash'],
                            'ver_by' => $dt['ver_by'],
                        ]);
                        ?>
                    </td>
                    <?php if ($lpp->PYD == Yii::$app->user->identity->ICNO && $lpp->PYD_sah == 0) { ?>
                        <?php if ($dt['manual'] == '1') {
                            // if ($lpp->PYD == Yii::$app->user->identity->ICNO && $lpp->PYD_sah == 0) { 
                        ?>
                            <td class="col-md-2 text-center" style="text-align:center"><?= (!$check) ? Html::button('<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>',  ['value' => Url::to(['elnpt2/update-pnp', 'id' => $ind, 'lppid' => $lppid]), 'class' => 'btn btn-default btn-sm modalButton']) : ''; ?>
                                <?= (!$check) ? Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::to(['elnpt2/delete-pnp', 'id' => $ind, 'lppid' => $lppid]), [
                                    'class' => 'btn btn-default btn-sm',
                                    // 'data' => [
                                    //     'confirm' => 'Are you sure you want to delete this item?',
                                    //     'method' => 'post',
                                    // ],
                                ]) : ''; ?></td>
                        <?php //}
                        } else { ?>
                            <td class="col-md-2 text-center" style="text-align:center">SMP UMS</td>

                    <?php }
                    } ?>
                </tr>
        <?php }
        } ?>
    </table>

</div>
<p>
<div style="clear: both;" class="form-group pull-right">
    <?= (($lpp->PYD == Yii::$app->user->identity->ICNO ? !$check : false)) ? Html::submitButton('Simpan', ['class' => 'btn btn-primary', 'value' => 'create_add', 'name' => 'submit']) : '' ?>
</div>
</p>
<?php ActiveForm::end(); ?>
<br>
<?php if (!is_null($dataProvider)) { ?>
    <?=
    \yiister\gentelella\widgets\Accordion::widget(
        [
            'items' => [
                [
                    'title' => 'Click to view Raw Data Smartv2 / Smartv3 SMP',
                    'active' => true,
                    'content' => '<div class="table-responsive">' .
                        $grid
                        . '</div><p align="justify">Table atas ini mengandungi raw data Smartv2 / Smartv3 yang ditarik dari SMP. Sila pastikan <b>Kod Kursus</b> dan <b>Semester</b> adalah betul dan sama dengan data di Table pertama. Sebarang <b>tambahan simbol</b> / <b>ejaan salah</b> / <b>simbol salah</b> hendaklah dibetulkan di SMP.</p>'

                ],
            ],
        ]
    );
    ?>
<?php } ?>

<?=
\yiister\gentelella\widgets\Accordion::widget(
    [
        'items' => [
            [
                'title' => 'Click to view',
                'active' => false,
                'content' => '<p align="justify">1. MOHD ZULFADHLEE BIN ABD NASYIR <br>(Pen. Pegawai Teknologi Maklumat (ext:103235, email : zulfadhlee@ums.edu.my,  Pusat E-Pembelajaran)


                    <br><br>2. NORAZZALEZA BINTI BERTLY <br>Pen. Pegawai Teknologi maklumat (ext :104279 norazzaleha@ums.edu.my, Pusat E-Pembelajaran)
                    
                    <br><br>Helpdesk PEP : 207802<br><br>Sekiranya mengalami masalah berkaitan status Blended Learning sila berhubung dengan pegawai-pegawai diatas.</p>'
            ],
        ],
    ]
);
?>

<div style="clear: both;"><br>
    <hr>
    <dl class="dl-horizontal">
        <dt>Jenis Syarahan</dt>
        <dd></dd>
        <dt>Hakiki</dt>
        <dd>Subjek yang tidak dibayar elaun tambahan.</dd>
        <dt>Berbayar</dt>
        <dd>Subjek yang dibayar elaun tambahan selain gaji bulanan.</dd>
    </dl>
    <p><strong>Nota : Skor PK07 (Delivery of Lectures) bagi subjek Semester 1 Sesi <?= $lpp->tahun; ?> / <?= $lpp->tahun + 1; ?> dikira berdasarkan data yang diterima setakat 11 Februari <?= $lpp->tahun + 1; ?> sahaja.</strong></p>
    <p><strong>Nota : Sila masukan no. seksyen di ruang disediakan untuk jana skor PK07.</strong></p>
</div>
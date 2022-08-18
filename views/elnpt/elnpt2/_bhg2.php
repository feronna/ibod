<?php

use kartik\checkbox\CheckboxX;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use GuzzleHttp\Exception\ClientException;
// use app\models\elnpt\TblLppTahun;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$grid = GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'Nomatrik',
        'NamaPelajar',
        'KodSesi_Sem',
        'TahapPenyeliaanBM',
        'StatusPengajianBM',
        'LevelPengajian'
    ],
]);

?>
<?php $form = ActiveForm::begin(); ?>
<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <tr>
            <th class="text-center" rowspan="3">BIL.</th>
            <th class="text-center col-md-4" rowspan="3">TAHAP PENYELIAAN</th>
            <th class="text-center" colspan="6">BILANGAN PELAJAR DISELIA YANG AKTIF (TERKUMPUL)</th>
            <th class="text-center" rowspan="3">DOKUMEN SOKONGAN</th>

            <th class="text-center" rowspan="3">VERIFIKASI (PPP)</th>
        </tr>
        <tr>
            <th class="text-center" colspan="3">SEBAGAI PENYELIA UTAMA/PENGERUSI</th>
            <th class="text-center" colspan="3">SEBAGAI PENYELIA BERSAMA/AHLI</th>
        </tr>
        <tr>
            <th class="text-center">BELUM PERLANJUTAN</th>
            <th class="text-center">TELAH PERLANJUTAN (2 SEMESTER ATAU KURANG)</th>
            <th class="text-center">TELAH PERLANJUTAN</th>
            <th class="text-center">BELUM PERLANJUTAN</th>
            <th class="text-center">TELAH PERLANJUTAN (2 SEMESTER ATAU KURANG)</th>
            <th class="text-center">TELAH PERLANJUTAN</th>
        </tr>
        <?php
        $cnt = 1;
        foreach ($data as $ind => $data) { ?>
            <tr>
                <td class="text-center"><?= $cnt; ?></td>
                <td><?php
                    switch ($ind) {
                        case 'PHD':
                            echo 'PhD (Penyelidikan)';
                            break;
                        case 'MASTER':
                            echo 'Sarjana (Penyelidikan)';
                            break;
                        case 'M.Phil.':
                            echo 'DrPH (Doctor of Public Health)';
                            break;
                    }
                    ?></td>
                <td class="text-center"><?= $data['utama_belum'] ?></td>
                <td class="text-center"><?= $data['utama_telah_sem'] ?></td>
                <td class="text-center"><?= $data['utama_telah'] ?></td>
                <td class="text-center"><?= $data['sama_belum'] ?></td>
                <td class="text-center"><?= $data['sama_telah_sem'] ?></td>
                <td class="text-center"><?= $data['sama_telah'] ?></td>
                <td class="text-center">SYSTEM</td>
                <td class="text-center">VERIFIED</td>
            </tr>
        <?php $cnt++;
        } ?>

        <?php
        foreach ($input as $index => $inp) {
            if ($input[$index]->tahap_penyeliaan >= 6) {
                try {
                    $myFile = $input[$index]->fileHash($input[$index]->lpp_id, 2, $input[$index]->id);
                    // Yii::$app->FileManager->DisplayFile($myFile);
                } catch (Exception $e) {
                    continue;
                } catch (ClientException $e) {
                    continue;
                }
            }
        ?>
            <tr>
                <td class="text-center">
                    <?= $cnt; ?>

                    <?= (($input[$index]->tahap_penyeliaan >= 6) && ($lpp->PYD == \Yii::$app->user->identity->ICNO ? !$check : false)
                        // or ($dt['id'] != '0' and $lpp->PYD == \Yii::$app->user->identity->ICNO  
                        // // and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO)
                        // )
                    ) ? Html::button('<i class="fa fa-edit"></i>', ['value' => Url::toRoute(['elnpt2/update-penyeliaan', 'id' => $input[$index]->id, 'lppid' => $input[$index]->lpp_id]), 'class' => 'btn btn-warning btn-xs modalButton']) . Html::a('<i class="fa fa-trash"></i>', ['elnpt2/delete-penyeliaan', 'id' => $input[$index]->id, 'lppid' => $input[$index]->lpp_id], ['class' => 'btn btn-danger btn-xs']) : '' ?>

                </td>
                <td><?php
                    // switch ($cnt) {
                    //     case 4:
                    //         echo 'Sarjana (Kerja Kursus)';
                    //         break;
                    //     case 5:
                    //         echo 'Sarjana Muda (Projek Tahun Akhir/Latihan Industri/Latihan Amali/Praktikum/PUPUK)';
                    //         break;
                    // }

                    switch ($input[$index]->tahap_penyeliaan) {
                        case 4:
                            echo 'Sarjana (Kerja Kursus)';
                            break;
                        case 5:
                            echo 'Sarjana Muda (Projek Tahun Akhir/ Latihan Industri/ Latihan Amali/ Praktikum/ PUPUK)';
                            break;
                        case 6:
                            echo 'PhD (Penyelidikan) - Penyeliaan Luar';
                            break;
                        case 7:
                            echo 'Sarjana (Penyelidikan) - Penyeliaan Luar';
                            break;
                        case 8:
                            echo 'DrPH (Doctor of Public Health) - Penyeliaan Luar';
                            break;
                    }
                    ?>
                </td>
                <td><?= $form->field($inp, "[$index]utama_belum")->textInput(['placeholder' => "0", 'style' => "text-align:center;",  'disabled' => ($lpp->PYD == Yii::$app->user->identity->ICNO ? $check : true)])->label(false) ?></td>
                <td><?= $form->field($inp, "[$index]utama_telah_sem")->textInput(['placeholder' => "0", 'style' => "text-align:center;",  'disabled' => ($lpp->PYD == Yii::$app->user->identity->ICNO ? $check : true)])->label(false) ?></td>
                <td><?= $form->field($inp, "[$index]utama_telah")->textInput(['placeholder' => "0", 'style' => "text-align:center;",  'disabled' => ($lpp->PYD == Yii::$app->user->identity->ICNO ? $check : true)])->label(false) ?></td>
                <td><?= $form->field($inp, "[$index]sama_belum")->textInput(['placeholder' => "0", 'style' => "text-align:center;",  'disabled' => ($lpp->PYD == Yii::$app->user->identity->ICNO ? $check : true)])->label(false) ?></td>
                <td><?= $form->field($inp, "[$index]sama_telah_sem")->textInput(['placeholder' => "0", 'style' => "text-align:center;",  'disabled' => ($lpp->PYD == Yii::$app->user->identity->ICNO ? $check : true)])->label(false) ?></td>
                <td><?= $form->field($inp, "[$index]sama_telah")->textInput(['placeholder' => "0", 'style' => "text-align:center;",  'disabled' => ($lpp->PYD == Yii::$app->user->identity->ICNO ? $check : true)])->label(false) ?></td>
                <td class="text-center">
                    <?= ($input[$index]->tahap_penyeliaan >= 6) ? Html::a("<i class='fa fa-file ' aria-hidden='true'></i>
                        ", Url::to(['elnpt2/view-file', 'hashfile' => $myFile, 'lppid' => $lppid]), ['target' => '_blank', 'class' => 'btn btn-xs btn-default']) : '' . '-' ?></td>
                <td class="text-center">
                    <?= $form->field($inp, "[$index]verified_by")->widget(CheckboxX::classname(), ['options' => ['value' => is_null($inp->verified_by) ? 0 : 1, 'disabled' => ($lpp->PPP == Yii::$app->user->identity->ICNO ? $check : true)], 'pluginOptions' => ['threeState' => false]])->label(false); ?>
                </td>
            </tr>
        <?php $cnt++;
        } ?>

    </table>
</div>

<div style="clear: both;" class="form-group pull-right">
    <?= (!$check) ? Html::submitButton('Simpan', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please wait..']]) : '' ?>
</div>

<?php ActiveForm::end(); ?>
<br>

<?php if (!is_null($dataProvider)) { ?>

    <?=
    \yiister\gentelella\widgets\Accordion::widget(
        [
            'items' => [
                [
                    'title' => 'Click to view',
                    'active' => true,
                    'content' => '<div class="table-responsive">' .
                        $grid
                        . '</div>'

                ],
            ],
        ]
    );
    ?>
<?php } ?>

<div style="clear: both;"><br>
    <hr>

    <dl class="dl-horizontal">
        <dt>Belum Perlanjutan</dt>
        <dd>Pelajar masih dalam tempoh pengajian yang ditetapkan seperti yang dinyatakan dalam surat tawaran menyambung pengajian.</dd>
        <dt>Telah Perlanjutan </dt>
        <dd>Pelajar telah memohon untuk <i>extend</i> tempoh pengajian melebihi tempoh yang dinyatakan dalam surat tawaran menyambung pengajian.</dd>
    </dl>

</div>
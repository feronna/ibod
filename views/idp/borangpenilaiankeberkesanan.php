<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\detail\DetailView;
use kartik\grid\GridView;

echo $this->render('/idp/_topmenu');

?>
<style>
    .btn-info:active,
    .btn-info.active,
    .open>.dropdown-toggle.btn-info {
        color: #fff;
        background-color: #0000FF;
        background-image: none;
        border-color: #269abc;
    }
</style>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5>Penilaian Keberkesanan Kursus<h3><span class="label label-primary" style="color: white"><?= ucwords($modelLatihan->tajukLatihan) . ' Siri ' . ucwords(strtolower($modelSiri->siri)) ?></span></h3>
                </h5>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h5>
                    <h3><span class="label label-success" style="color: white">Maklumat Kakitangan</span></h3>
                </h5>
                <div class="clearfix"></div>
            </div>
            <div class="well">
                <b>NAMA : <?= ucwords(strtoupper($model3->gelaran->Title)) . ' ' . $model3->CONm; ?>
                    <br>UMS-PER : <?= $model3->COOldID; ?>
                    <br>JAWATAN DISANDANG : <?= ucwords(strtoupper($model3->jawatan->nama)) ?>&nbsp;(<?= $model3->jawatan->gred ?>)
                    <br>TEMPOH PERKHIDMATAN DI GRED SEMASA : <?php echo $model3->tempohKhidmatGredSemasa; ?>
                    <br>TAHAP :
                    <?php
                    if ($model3->tahapKhidmat == '3') {
                        echo "LANJUTAN";
                    } elseif ($model3->tahapKhidmat == '2') {
                        echo "PERTENGAHAN";
                    } else {
                        echo "ASAS";
                    }
                    ?>
                    <br>
                    <?php

                    if (!$model5) {

                        echo "<div style='color:red'>
                                                    SILA BERHUBUNG DENGAN PENYELIA CUTI/STARS UNTUK MENGEMASKINI MAKLUMAT PEGAWAI PERAKU/PELULUS.
                                                        </div>";
                    } else {

                        if ($model5->peraku || $model5->pelulus) {

                            if (($model4->DisplayPeraku($model3->ICNO))) {
                                echo "PEGAWAI PERAKU : ";

                                if ($model4->DisplayPeraku($model3->ICNO) != "TERUS KEPADA PEGAWAI MELULUS") {
                                    echo ucwords(strtoupper($model5->peraku->gelaran->Title));
                                }
                                echo ' ';
                                echo $model4->DisplayPeraku($model3->ICNO);
                                echo "<br>";
                                echo "PEGAWAI PELULUS : ";
                                echo ucwords(strtoupper($model5->pelulus->gelaran->Title)) . ' ' . $model4->DisplayPelulus($model3->ICNO);
                            } else {
                                echo "PEGAWAI PELULUS : ";
                                echo ucwords(strtoupper($model5->pelulus->gelaran->Title)) . ' ' . $model4->DisplayPelulus($model3->ICNO);
                            }
                        }
                    }
                    ?>
                </b>
            </div> <!-- closed div class well -->
            <div class="x_content">

            </div>
        </div> <!-- closed div class x_panel -->
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-pencil" aria-hidden="true"></i> Borang Penilaian Keberkesanan Diisi Kakitangan</h2>
            <div class="clearfix"></div>
        </div>
        <br>

        <hr>
        <div class="x_title">
            <h2><i class="fa fa-pencil" aria-hidden="true"></i> Ringkasan Program</h2>
            <div class="clearfix"></div>
            <h4>Keberkesanan Program Pembangunan Profesional Individu
                <br>(Individual Effectiveness of Professional Development Programme)
            </h4>
        </div>
        <div class="x_content">
            <?php $form = ActiveForm::begin(['options' => ['id' => 'borangpl']]);
            $modelN->scenario = 'bm'; ?>
            <?= $form->field($modelN, 'ringkasanLatihan')->textarea(['rows' => '6', 'disabled' => $modelN->ringkasanLatihan ? true : false])->label('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> RINGKASAN') ?>
            <table class="items table table-bordered table-condensed" width="100%" border="1">
                <tbody>
                    <tr>
                        <td colspan="10">
                            <div align="center"><strong>Skala Penilaian (<em>Evaluation Scale</em>) </strong></div>
                        </td>
                    </tr>
                    <tr>
                        <td width="5%">
                            <div align="center">1</div>
                        </td>
                        <td width="15%">
                            <div align="center"><strong>Sangat Tidak Setuju<br>
                                    <em>(Strongly Disagree)</em></strong></div>
                        </td>
                        <td width="5%">
                            <div align="center">2</div>
                        </td>
                        <td width="15%">
                            <div align="center"><strong>Tidak Setuju<br>
                                    <em>(Disagree)</em></strong></div>
                        </td>
                        <td width="5%">
                            <div align="center">3</div>
                        </td>
                        <td width="15%">
                            <div align="center"><strong>Sederhana<br>
                                    <em>(Moderate)</em></strong></div>
                        </td>
                        <td width="5%">
                            <div align="center">4</div>
                        </td>
                        <td width="15%">
                            <div align="center"><strong>Setuju<br>
                                    <em>(Agree)</em></strong></div>
                        </td>
                        <td width="5%">
                            <div align="center">5</div>
                        </td>
                        <td width="15%">
                            <div align="center"><strong>Sangat Setuju<br>
                                    <em>(Strongly Agree)</em></strong></div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <?= GridView::widget([
                'summary' => '',
                //'emptyText' => 'Tiada rekod penetapan SKT',
                'dataProvider' => $dataProviderN,
                'columns' => [
                    [
                        'label' => 'BIL',
                        'headerOptions' => ['class' => 'text-center', 'style' => 'display: none;',],
                        'contentOptions' => ['class' => 'text-center', 'style' => 'width:5%'],
                        'attribute' => 'soalanID',
                    ],
                    [
                        'label' => 'PERKARA / DESCRIPTIONS',
                        'headerOptions' => ['class' => 'text-center', 'colspan' => '2',],
                        'contentOptions' => ['style' => 'width:60%'],
                        'attribute' => 'soalan',
                        'format' => 'html'

                    ],
                    [
                        'label' => 'SKALA / SCALE',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center', 'style' => 'width:15%'],
                        'value' => function ($model) use ($modelN, $form) {
                            $data = [1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'];

                            //return $form->field($model1, "q$model->id")->radioButtonGroup($data)->label(false);
                            return $form->field($modelN, "$model->soalanID")->radioButtonGroup($data, [
                                'class' => 'btn-group-sm',
                                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-info', 'disabled' => $modelN->statusBorang == 2 || $modelN->statusBorang == 3? true : false]]
                            ])->label(false);
                        },
                        'format' => 'raw'
                    ],
                ],
            ]);
            ?>
        </div>
        <?php if ($modelN->checkBorangStatuskk($modelN->siriLatihanID, $modelN->pesertaID) == 1) { ?>
            <div class="form-group pull-right">
                <div class=""><?= Html::submitButton('Hantar / Submit', ['class' => 'btn btn-success', 'disabled' => $modelN->statusBorang == 2 ? true : false]) ?></div>
            </div>
            <?php } else {
            if ($modelN->tarikhStafIsi) { ?>
                <div class="form-group pull-right">
                    <div class="">Borang kakitangan telah dihantar pada <?php echo $modelN->tarikhStafIsi; ?></div>
                </div>
            <?php } else { ?>
                <div class="form-group pull-right">
                    <div class="">Borang kakitangan telah dihantar.</div>
                </div>
        <?php }
        } ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-pencil" aria-hidden="true"></i> Borang Penilaian Keberkesanan Diisi Ketua Jabatan</h2>
            <div class="clearfix"></div>
        </div>
        <br>

        <hr>
        
        <div class="x_content">
            <?php $form = ActiveForm::begin(['options' => ['id' => 'borangpl']]);
            $modelN->scenario = 'bm'; ?>
            <?php //$form->field($modelN, 'ringkasanLatihan')->textarea(['rows' => '6', 'disabled' => $modelN->ringkasanLatihan ? true : false])->label('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> RINGKASAN') ?>
            <table class="items table table-bordered table-condensed" width="100%" border="1">
                <tbody>
                    <tr>
                        <td colspan="10">
                            <div align="center"><strong>Skala Penilaian (<em>Evaluation Scale</em>) </strong></div>
                        </td>
                    </tr>
                    <tr>
                        <td width="5%">
                            <div align="center">1</div>
                        </td>
                        <td width="15%">
                            <div align="center"><strong>Sangat Tidak Setuju<br>
                                    <em>(Strongly Disagree)</em></strong></div>
                        </td>
                        <td width="5%">
                            <div align="center">2</div>
                        </td>
                        <td width="15%">
                            <div align="center"><strong>Tidak Setuju<br>
                                    <em>(Disagree)</em></strong></div>
                        </td>
                        <td width="5%">
                            <div align="center">3</div>
                        </td>
                        <td width="15%">
                            <div align="center"><strong>Sederhana<br>
                                    <em>(Moderate)</em></strong></div>
                        </td>
                        <td width="5%">
                            <div align="center">4</div>
                        </td>
                        <td width="15%">
                            <div align="center"><strong>Setuju<br>
                                    <em>(Agree)</em></strong></div>
                        </td>
                        <td width="5%">
                            <div align="center">5</div>
                        </td>
                        <td width="15%">
                            <div align="center"><strong>Sangat Setuju<br>
                                    <em>(Strongly Agree)</em></strong></div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <?= GridView::widget([
                'summary' => '',
                //'emptyText' => 'Tiada rekod penetapan SKT',
                'dataProvider' => $dataProviderM,
                'columns' => [
                    [
                        'label' => 'BIL',
                        'headerOptions' => ['class' => 'text-center', 'style' => 'display: none;',],
                        'contentOptions' => ['class' => 'text-center', 'style' => 'width:5%'],
                        'attribute' => 'soalanID',
                    ],
                    [
                        'label' => 'PERKARA / DESCRIPTIONS',
                        'headerOptions' => ['class' => 'text-center', 'colspan' => '2',],
                        'contentOptions' => ['style' => 'width:60%'],
                        'attribute' => 'soalan',
                        'format' => 'html'

                    ],
                    [
                        'label' => 'SKALA / SCALE',
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center', 'style' => 'width:15%'],
                        'value' => function ($model) use ($modelN, $form) {
                            $data = [1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'];

                            //return $form->field($model1, "q$model->id")->radioButtonGroup($data)->label(false);
                            return $form->field($modelN, "$model->soalanID")->radioButtonGroup($data, [
                                'class' => 'btn-group-sm',
                                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-info', 'disabled' => $modelN->statusBorang == 3 ? true : false]]
                            ])->label(false);
                        },
                        'format' => 'raw'
                    ],
                ],
            ]);
            ?>
        </div>
        <?php if ($modelN->checkBorangStatuskk($modelN->siriLatihanID, $modelN->pesertaID) == 2) { ?>
            <div class="form-group pull-right">
                <div class=""><?= Html::submitButton('Hantar / Submit', ['class' => 'btn btn-success', 'disabled' => $modelN->statusBorang == 3 ? true : false]) ?></div>
            </div>
            <?php } else {
            if ($modelN->tarikhKetuaIsi) { ?>
                <div class="form-group pull-right">
                    <div class="">Borang penilaian enam bulan telah dihantar pada <?php echo $modelN->tarikhKetuaIsi; ?></div>
                </div>
            <?php } else { ?>
                <div class="form-group pull-right">
                    <div class="">Borang penilaian enam bulan telah dihantar.</div>
                </div>
        <?php }
        } ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>

</div>
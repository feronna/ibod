<?php

use app\models\keselamatan\TblRekod;
use app\models\keselamatan\TblRollcall;
use yii\helpers\Html;
use yii\helpers\Url;


Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
Yii::$app->response->headers->add('Content-Type', 'application/pdf');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div style='border: solid black; padding-left: 15px; margin: 15px; font-size: 12.5px'>
    <h5><strong>Name : </strong><u><?= $biodata->CONm ?></u></h5>
    <h5><strong>Position : </strong><u><?= $biodata->jawatan->fname ?></u></h5>
    <h5><strong>J / F / P / I / B : </strong><u><?= $biodata->department->fullname ?></u></h5>
    <h5><strong>Tempoh Lantikan : </strong><u><?= $biodata->displayStartLantik  ?></u></h5>
    <h5><strong>Year : </strong><u><?= Yii::$app->getRequest()->getQueryParam('tahun') ?></u></h5>
    <h5><strong>Month : </strong><u><?= Yii::$app->getRequest()->getQueryParam('bulan') ?></u></h5>

</div>
<br>

<table class="table table-sm table-bordered table-striped" style="font-size: 12.5px">
<thead>
                                <tr>
                                    <th colspan="2" class="text-center"></th>
                                    <th colspan="4" class="text-center">Syif</th>
                                    <th colspan="4" class="text-center">Catatan/KeHadiran</th>
                                    <th colspan="2" class="text-center"></th>
                                </tr>
                                <tr class="headings">
                                    <th class="text-center">Hari</th>
                                    <th class="text-center">Tarikh</th>
                                    <th class="text-center">Hakiki</th>
                                    <th class="text-center">LMJ</th>
                                    <th class="text-center">LMT</th>
                                    <th class="text-center">Kawalan</th>
                                    <th class="text-center">Hakiki</th>
                                    <th class="text-center">LMJ</th>
                                    <th class="text-center">LMT</th>
                                    <th class="text-center">Kawalan</th>
                                    <th colspan="2" class="text-center">Catatan</th>

                                </tr>
                            </thead>
                            <?php foreach ($var as $k => $v) { ?>
                                <tr>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::DisplayDay($v) ?></td>
                                    <td class="text-center" style="text-align:center"><?= date("d/m/Y", strtotime($v)); ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::DisplayHakiki(Yii::$app->getRequest()->getQueryParam('id'), $v) ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::DisplayLmj(Yii::$app->getRequest()->getQueryParam('id'), $v) ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::DisplayLmt(Yii::$app->getRequest()->getQueryParam('id'), $v) ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::DisplayKawalan(Yii::$app->getRequest()->getQueryParam('id'), $v) ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::StatusHakiki(Yii::$app->getRequest()->getQueryParam('id'), $v) ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::StatusLmj(Yii::$app->getRequest()->getQueryParam('id'), $v) ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::StatusLmt(Yii::$app->getRequest()->getQueryParam('id'), $v) ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::StatusKawalan(Yii::$app->getRequest()->getQueryParam('id'), $v) ?></td>
                                    <td class="text-center" style="text-align:center"><?= TblRollcall::catatan(Yii::$app->getRequest()->getQueryParam('id'), $v) ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <th colspan="5" class="text-center">Jumlah</th>
                                <th colspan="1" class="text-center">H</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'THBH', '0') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'THBLMJ', '0') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'THBLMT', '0') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'THBKWLN', '0') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">THB</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'THBH', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'THBLMJ', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'THBLMT', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'THBKWLN', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">THTC</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'THTC', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'THTC', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'THTC', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'THTC', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <!--                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">THTC</th>
                                <td class="text-center"  style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'THTC', '1') ?></td>
                                <td class="text-center"  style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'THTC', '1') ?></td>
                                <td class="text-center"  style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'THTC', '1') ?></td>
                                <td class="text-center"  style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'THTC', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>-->
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">CR</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'CR', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'CR', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'CR', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'CR', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">CS</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'CS', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'CS', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'CS', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">CK</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'CK', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'CK', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'CK', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'CK', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">CTR</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'CTR', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'CTR', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'CTR', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'CTR', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">CGKA</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'CGKA', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'CGKA', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'CGKA', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'CGKA', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">CKA</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'CKA', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'CKA', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'CKA', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'CKA', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">CG</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'CG', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'CG', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'CG', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'CG', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">CSG</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'CSG', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'CSG', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'CSG', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'CSG', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">CTG</th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'CTG', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'CTG', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'CTG', '1') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'CTG', '1') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                            <tr>
                                <th colspan="5" class="text-center"> </th>
                                <th colspan="1" class="text-center">STS
                                    <?= Html::button('', ['id' => 'modalButton', 'value' => Url::to(['list-sts', 'id' => Yii::$app->getRequest()->getQueryParam('id'), 'month' => Yii::$app->getRequest()->getQueryParam('bulan'), 'year' => Yii::$app->getRequest()->getQueryParam('tahun')]), 'class' => 'fa fa-eye mapBtn']); ?></th>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'H', $icno, 'status', 'STS') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMJ', $icno, 'status', 'STS') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'LMT', $icno, 'status', 'STS') ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::CountHadir(Yii::$app->getRequest()->getQueryParam('tahun'),Yii::$app->getRequest()->getQueryParam('bulan'), 'KWLN', $icno, 'status', 'STS') ?></td>
                                <th colspan="1" class="text-center"></th>

                            </tr>
                        </table>




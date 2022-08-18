<?php

use app\models\keselamatan\TblRekod;
use app\models\keselamatan\TblRollcall;
use yii\helpers\Html;
use yii\helpers\Url;


Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
Yii::$app->response->headers->add('Content-Type', 'application/pdf');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<br>
<div class="table-responsive">
                    <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                            <tr>
                            <th rowspan = "2" colspan = '1' class="text-center">BIL</th>
                            <th rowspan = "2" colspan = '1' class="text-center">PERKARA</th>
                            <th colspan = '12' class="text-center">BULAN</th>
                        </tr>
                        <tr>
                         
                            <th class="text-center">JAN</th>
                            <th class="text-center">FEB</th>
                            <th class="text-center">MAC</th>
                            <th class="text-center">APR</th>
                            <th class="text-center">MEI</th>
                            <th class="text-center">JUN</th>
                            <th class="text-center">JUL</th>
                            <th class="text-center">OGOS</th>
                            <th class="text-center">SEPT</th>
                            <th class="text-center">OKT</th>
                            <th class="text-center">NOV</th>
                            <th class="text-center">DIS</th>
                          
                        </tr>
                        </thead>

                        <?php for ($var;$var <= 15;$var++) { ?>
                                <tr>
                                <td class="text-center" style="text-align:center"><?= $bil++ ?></td>
                                <td class="text-center" style="text-align:center"><?= $arr[$var] ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(1, $arr[$var], Yii::$app->getRequest()->getQueryParam('camp')) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(2, $arr[$var],Yii::$app->getRequest()->getQueryParam('camp')) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(3, $arr[$var],Yii::$app->getRequest()->getQueryParam('camp')) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(4, $arr[$var],Yii::$app->getRequest()->getQueryParam('camp')) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(5, $arr[$var],Yii::$app->getRequest()->getQueryParam('camp')) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(6, $arr[$var],Yii::$app->getRequest()->getQueryParam('camp')) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(7, $arr[$var],Yii::$app->getRequest()->getQueryParam('camp')) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(8, $arr[$var],Yii::$app->getRequest()->getQueryParam('camp')) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(9, $arr[$var],Yii::$app->getRequest()->getQueryParam('camp')) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(10, $arr[$var],Yii::$app->getRequest()->getQueryParam('camp')) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(11, $arr[$var],Yii::$app->getRequest()->getQueryParam('camp')) ?></td>
                                <td class="text-center" style="text-align:center"><?= TblRollcall::countReport(12, $arr[$var],Yii::$app->getRequest()->getQueryParam('camp')) ?></td>

                                </tr>
                                
                            <?php } ?>
                        </table>
                    </div>

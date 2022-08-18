<?php

use aryelds\sweetalert\SweetAlert;
use yii\helpers\Html;

$this->registerJsFile('@web/js/circleprogress.js?n=' . date('d-m-y'));
error_reporting(0);
?>
<style>
    .app1 {
        width: 200px;
        background-color: #efefef;
        height: 70px;
        white-space: normal;
    }

    .appname {
        text-align: center;
        vertical-align: middle;
        height: 70px;
        width: 100px;
        margin: 10px;
        margin-left: 70px;
        font-size: 14px;
        overflow: hidden;
        display: table-cell;
    }

    div.scrollmenu {
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap;
    }

    .labelc {
        font-size: 14px;
    }

    .canvasc {
        display: inline-block;
        position: absolute;
        top: 0;
        left: 0;
    }

    .spanc {
        color: #555;
        display: grid;
        text-align: center;
        font-family: sans-serif;
        font-size: 16px;
        align-items: center;
        vertical-align: middle;
        height: 100px;
    }

    .appname {
        white-space: normal;

    }

    .table>tbody>tr>td,
    .table>tfoot>tr>td {
        border-top: none;
    }

    .table {
        width: auto;
        margin-bottom: 3px;
        overflow-x: auto;
    }
</style>

<?php 
//  echo SweetAlert::widget([
//     'options' => [
//         'title' => "Makluman",
//         'text' => "Kakitangan dikehendaki untuk membuat semakan maklumat peribadi dan pastikan maklumat peribadi tersebut terkini dan tepat",
//         'type' => SweetAlert::TYPE_INFO,
//         'animation' => 'slide-from-top',
//         //        'showCancelButton' => true,
//         //        'confirmButtonColor' => "#DD6B55",
//         'confirmButtonText' => "Tutup",
//         'closeOnConfirm' => true,
//     ],
// ]);
?>

<?php if ($pendingtask) { ?>
    <div class="row">
        <div class="x_panel scrollmenu">
            <div class="x_title">
                <h2><i class="fa fa-check-square-o"></i> Task to do</h2>
                <div class="clearfix"></div>
            </div>
            <table class="table" style="text-align: center">
                <tr>
                    <?php foreach ($pendingtask as $p) { ?>
                        <td>
                            <div class="col-md-12 col-sm-12 col-xs-12 app1" style="padding-left:0px">
                                <?= Html::a(
                                    '<div class="col-md-4 col-sm-4 col-xs-4" style="height: 100%; background-color: #3c5977; color:white;"><br>
                            <i style="font-size:26px;" class="fa fa-' . $p->icon . '"></i>
                            <div style="position: absolute;top: 0px;
                            right: 1px;
                            font-size: 18px;"><span class="badge bg-red">' . $p->count . '</span></div>
                            </div>
                            <div class="appname">' . $p->name . '</div>',
                                    [$p->url]
                                ) ?>
                            </div>
                        </td><?php } ?>
                </tr>
            </table>
        </div>
    </div><?php } ?>
<div class="row">
    <div class="scrollmenu">
        <table class="table" style="text-align: center">
            <tr>
                <td width="500px;">
                    <div class="x_panel">
                        <div class="labelc"><i class="fa fa-book"></i> CUTI</div>
                        <div class="chart" id="graph" data-text="<?= $info->cuti ?>" data-size="100" data-line="10" data-percent="<?= $info->percentagecuti ?>"></div>
                    </div>
                </td>

                <td width="500px;">
                    <div class="x_panel">
                        <div class="labelc"><i class="fa fa-book"></i> MyIDP</div>
                        <div class="chart" id="graph" data-text="<?= $info->idp ?>" data-size="100" data-line="10" data-percent="<?= $info->percentageidp ?>"></div>
                    </div>
                </td>

                <td width="500px;">
                    <div class="x_panel">
                        <div class="labelc"><i class="fa fa-heart"></i> MyHealth</div>
                        <div class="chart" id="graph" data-size="100" data-line="10" data-percent="<?= $info->percentageklinik ?>">

                            <span class="spanc" style="font-size: 12px; line-height: 1.5em">RM <br><?= $info->klinikpanel . ' / ' ?><br><?= $info->total_klinikpanel ?></span>
                        </div>
                    </div>
                </td>

                <td width="500px;">
                    <div class="x_panel">
                        <div class="labelc"><i class="fa fa-clock-o"></i> <?= $type ?></div>
                        <div class="chart" id="graph" data-color="<?= $data['color'] ?>" data-text="<?= $data['color'] ?>" data-size="100" data-line="10" data-percent="100"></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <?php echo $this->render($placeholder, $data) ?>
    <?= $this->render('summary', ['info' => $info]) ?>
    <?= $peg ? $this->render('onleave', ['onleave' => $onleave]) : $this->render('upevent', ['upevent' => $upevent]) ?>
</div>
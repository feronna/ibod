<?php
/* @var $this yii\web\View */

$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
//use yii\helpers\Html;
//use yii\widgets\Pjax;
use yii\bootstrap\Alert;

use app\models\elnpt\testing\TblTestingAccess;

$numOfCols = (sizeof($rubric)  < 3) ? sizeof($rubric) : 3;
$rowCount = 0;
$bootstrapColWidth = 12 / $numOfCols;

$bhg = ArrayHelper::getColumn($mrkh_all, 'bahagian');
$markah = ArrayHelper::getColumn($mrkh_all, 'markah');

$lpp = app\models\elnpt\TblMain::findOne(['lpp_id' => $lppid]);

$admin = TblTestingAccess::findOne(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1]);

//\yii\helpers\VarDumper::dump($items, 10, true);
?>

<?php
Modal::begin([
    'header' => '<strong>Pengesahan Pengajaran & Pembelajaran</strong>',
    'id' => 'modal',
    'size' => 'modal-xs',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<?= $this->render('_semakMenu', ['mrkh_all' => $menu, 'lppid' => $lppid]); ?>

<?php
if ($bhgian->id == 4 or $bhgian->id == 5) {
    echo Alert::widget([
        'options' => ['class' => 'alert-warning'],
        'body' => '<font color="black">
                    <strong>INFO</strong><br>
                    <p>
                        Bagi Penerbitan, PPP & PPK tidak perlu membuat pemarkahan. Markah yang di bahagian ini mengambil kira markah yang telah auto-generated.
                    </p>
                </font>',
    ]);
}
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Bahagian <?= $bhgian->id ?> : <?= $bhgian->bahagian ?> - <?= $lpp->guru->CONm; ?></strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php
                    if (is_null($data)) {
                        echo '';
                    } else {
                        if (is_null($input)) {
                            echo $this->render('_bhg' . $bhgian->id, [
                                'data' => $data,
                                'data2' => isset($data2) ? $data2 : null,
                                'lppid' => $lppid,
                                'lpp' => $lpp,
                                'tahun' => $tahun,
                                'req' => $req
                                //'input' => $input,
                            ]);
                        } else {
                            echo $this->render('_bhg' . $bhgian->id, [
                                'data' => $data,
                                'data2' => isset($data2) ? $data2 : null,
                                'lppid' => $lppid,
                                'input' => $input,
                                'lpp' => $lpp,
                                'tahun' => $tahun,
                                'req' => $req
                            ]);
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php Pjax::begin(); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Aspek Penilaian</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php if (
                        $bhgian->id != 9 and (($lpp->PPP == Yii::$app->user->identity->ICNO && date('Y-m-d H:i:s') <= $tahun->penilaian_PPP_tamat && $lpp->PPP_sah == 0) or
                            ($lpp->PPK == Yii::$app->user->identity->ICNO && date('Y-m-d H:i:s') <= $tahun->penilaian_PPK_tamat && $lpp->PPK_sah == 0))
                        or ((is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO)) or $admin
                    ) { ?>
                        <div style='padding: 15px; border: 1px dashed red;' class="table-bordered">
                            <p>Nota : <b>(Internal Server Error / Markah PYD tidak tally / Bahagian 4 dan 5)</b> Sila tekan butang <?= Html::a("<i class='fa fa-refresh' aria-hidden='true'></i>
                        ", ['elnpt/semak-lpp', 'lppid' => $lppid, 'bhg_no' => $bhgian->id], ['class' => 'btn btn-xs btn-primary']); ?> ini untuk <i>update</i> markah PYD yang terkini.</p>
                            <?= Html::beginForm(['/elnpt/semak-lpp?lppid=' . $lppid . '&bhg_no=' . $bhgian->id], 'post', []) ?>
                        </div>

                        <br>
                    <?php } ?>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center">Aspek Penilaian</th>
                                <?php if ($bhgian->id != 9) { ?>

                                    <th class="text-center col-md-2">Markah PYD <sub>(100%)</sub></th>
                                <?php } ?>
                                <th class="text-center col-md-2">Markah PPP <sub>(100%)</sub></th>
                                <th class="text-center col-md-2">Markah PPK <sub>(100%)</sub></th>
                                <?php if ($bhgian->id == 9) { ?>
                                    <th class="text-center col-md-2">Markah PEER <sub>(100%)</sub></th>
                                <?php } ?>
                            </tr>
                            <?php foreach ($mrkh_bhg as $ind => $all) { ?>
                                <tr>
                                    <th><?= $all['aspek']; ?> <?= ($bhgian->id != 9) ? Html::hiddenInput("aspek_id[$ind]", $all['id']) : ''; ?></th>
                                    <?php if ($bhgian->id != 9) { ?>

                                        <th class="col-md-1 text-center" style="text-align:center"><?= $all['markah_pyd']; ?> <sub><?= ' / ' . $all['pemberat']; ?></sub> </th>
                                    <?php } ?>
                                    <th class="col-md-2 text-center">
                                        <div class="input-group col-lg-10 col-lg-offset-1 text-center">
                                            <?php if ($bhgian->id != 9) { ?>
                                                <?= (($lpp->PPP == Yii::$app->user->identity->ICNO && $lpp->PYD_sah == 1 && $lpp->PPP_sah == 0 && ($bhgian->id != 4 and $bhgian->id != 5) and (date('Y-m-d H:i:s') <= $tahun->penilaian_PPP_tamat))
                                                    or ($lpp->PPP == \Yii::$app->user->identity->ICNO  and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO)))
                                                    ? Html::textInput("markah_ppp[$ind]", is_null($all['markah_ppp']) ? '0.0' : $all['markah_ppp'], ['type' => 'number', 'min' => 0, 'max' => $all['pemberat'], 'step' => '0.01', 'class' => 'form-control input-sm', 'placeholder' => '0.0', 'style' => 'text-align:center; width:75%',]) : (($lpp->PPP == Yii::$app->user->identity->ICNO or
                                                        $lpp->PPK == Yii::$app->user->identity->ICNO or
                                                        app\models\elnpt\testing\TblTestingAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->exists() or $lpp->PPP == Yii::$app->user->identity->ICNO) ? $all['markah_ppp'] : 'PPP') ?> <?= '<sub>/ ' . $all['pemberat'] . '</sub>' ?>
                                            <?php } else { ?>
                                                <?= is_null($all['markah_ppp']) ? '0.00' : (($lpp->PPP == Yii::$app->user->identity->ICNO or $lpp->PPK == Yii::$app->user->identity->ICNO or app\models\elnpt\testing\TblTestingAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->exists())
                                                    ? $all['markah_ppp'] : 'PPP'); ?> <?= '<sub>/ ' . $all['pemberat'] . '</sub>' ?>
                                            <?php } ?>
                                        </div>
                                    </th>
                                    <th class="col-md-2 text-center" style="text-align:center">
                                        <div class="input-group col-lg-10 col-lg-offset-1 text-center">
                                            <?php if ($bhgian->id != 9) { ?>
                                                <?= (($lpp->PPK == Yii::$app->user->identity->ICNO  && $lpp->PPP_sah == 1 && $lpp->PPK_sah == 0 && ($bhgian->id != 4 and $bhgian->id != 5) and (date('Y-m-d H:i:s') <= $tahun->penilaian_PPK_tamat))
                                                    or ($lpp->PPK == \Yii::$app->user->identity->ICNO  and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) ? Html::textInput("markah_ppk[$ind]", is_null($all['markah_ppk']) ? '0.0' : $all['markah_ppk'], ['type' => 'number', 'min' => 0, 'max' => $all['pemberat'], 'step' => '0.01', 'class' => 'form-control input-sm', 'placeholder' => '0.0', 'style' => 'text-align:center; width:75%',]) : ((app\models\elnpt\testing\TblTestingAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->exists() or $lpp->PPK == Yii::$app->user->identity->ICNO) ? $all['markah_ppk'] : 'PPK') ?> <?= '<sub>/ ' . $all['pemberat'] . '</sub>' ?>
                                            <?php } else { ?>
                                                <?= is_null($all['markah_ppk']) ? '0.00' : (($lpp->PPK == Yii::$app->user->identity->ICNO or app\models\elnpt\testing\TblTestingAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->exists()) ? $all['markah_ppk'] : 'PPK'); ?> <?= '<sub>/ ' . $all['pemberat'] . '</sub>' ?>
                                            <?php } ?>
                                        </div>
                                    </th>
                                    <?php if ($bhgian->id == 9) { ?>
                                        <th class="col-md-2 text-center" style="text-align:center">
                                            <div class="input-group col-lg-10 col-lg-offset-1 text-center">
                                                <?php if ($bhgian->id != 9) { ?>
                                                    <?= (($lpp->PEER == Yii::$app->user->identity->ICNO  && $lpp->PPP_sah == 1 && $lpp->PEER_sah == 0 and (date('Y-m-d H:i:s') <= $tahun->penilaian_PEER_tamat))
                                                        or ($lpp->PEER == \Yii::$app->user->identity->ICNO  and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) ? Html::textInput("markah_peer[$ind]", is_null($all['markah_peer']) ? '0.0' : $all['markah_peer'], ['type' => 'number', 'min' => 0, 'max' => $all['pemberat'], 'step' => '0.01', 'class' => 'form-control input-sm', 'placeholder' => '0.0', 'style' => 'text-align:center; width:75%',]) : ((app\models\elnpt\testing\TblTestingAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->exists() or $lpp->PEER == Yii::$app->user->identity->ICNO) ? $all['markah_peer'] : 'PEER') ?> <?= '<sub>/ ' . $all['pemberat'] . '</sub>' ?>
                                                <?php } else { ?>
                                                    <?= is_null($all['markah_peer']) ? '0.00' : (($lpp->PEER == Yii::$app->user->identity->ICNO or app\models\elnpt\testing\TblTestingAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->exists()) ? $all['markah_peer'] : 'PEER'); ?> <?= '<sub>/ ' . $all['pemberat'] . '</sub>' ?>
                                                <?php } ?>
                                            </div>
                                        </th>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <?php if ($bhgian->id != 9 and $bhgian->id != 4 and $bhgian->id != 5) { ?>
                        <div class="form-group pull-right">
                            <?= (($lpp->PPP == Yii::$app->user->identity->ICNO  && $lpp->PYD_sah == 1 && $lpp->PPP_sah == 0 and (date('Y-m-d H:i:s') <= $tahun->penilaian_PPP_tamat)) or
                                ($lpp->PPK == Yii::$app->user->identity->ICNO  && $lpp->PPP_sah == 1 && $lpp->PPK_sah == 0 and (date('Y-m-d H:i:s') <= $tahun->penilaian_PPK_tamat)) or
                                ($lpp->PEER == Yii::$app->user->identity->ICNO  && $lpp->PYD_sah == 1 && $lpp->PEER_sah == 0 and (date('Y-m-d H:i:s') <= $tahun->penilaian_PEER_tamat)) or
                                ((is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) ?
                                Html::submitButton('Submit', ['class' => 'btn btn-primary']) : ''; ?>
                        </div>
                    <?php } ?>
                    <?= Html::endForm(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php Pjax::end(); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Markah Keseluruhan (PPP + PPK)</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <?php foreach ($bhg as $b) { ?>
                                    <th class="text-center"><?= $b; ?></th>
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php foreach ($markah as $ind => $m) { ?>
                                    <th class="text-center"><?= is_null($m) ? '0<sub>/' . $pemberat[$ind]['pemberat'] . '</sub>' : $m . '<sub>/' . $pemberat[$ind]['pemberat'] . '</sub>'; ?></th>
                                <?php } ?>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Rubrik Pemarkahan</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php foreach ($rubric as $ind => $rub) { ?>
                        <div class="col-md-<?php echo $bootstrapColWidth; ?>">
                            <strong>Rubrik <?= $ind ?></strong>
                            <p>
                                <table class="table table-sm table-bordered">

                                    <tr>
                                        <th>Penilaian</th>

                                        <th class="text-center">Peratus</th>
                                    </tr>

                                    <?php foreach ($rub as $rb) { ?>
                                        <tr>
                                            <td><?= $rb['penilaian']; ?></td>

                                            <td class="text-center" style="text-align:center"><?= $rb['peratus']; ?></td>
                                        </tr>
                                    <?php } ?>

                                </table>
                            </p>
                        </div>
                    <?php
                        $rowCount++;
                        if ($rowCount % $numOfCols == 0) {
                            echo '</div><div class="row">';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
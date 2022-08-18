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

$this->registerCss("
    td {
        color: black;
        font-size: 15px;
    }
");

$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
// use yii\bootstrap\Alert;

use app\models\elnpt\testing\TblTestingAccess;

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
<?php
echo $this->render('//elnpt/elnpt2/_semakMenu', ['mrkh_all' => $menu, 'lppid' => $lppid]);
?>

<?php
// if ($bahagian->id == 4 or $bahagian->id == 5) {
//     echo Alert::widget([
//         'options' => ['class' => 'alert-warning'],
//         'body' => '<font color="black">
//                     <strong>INFO</strong><br>
//                     <p>
//                         Bagi Penerbitan, PPP & PPK tidak perlu membuat pemarkahan. Markah yang di bahagian ini mengambil kira markah yang telah auto-generated.
//                     </p>
//                 </font>',
//     ]);
// }
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Bahagian <?= $bahagian->id ?> : <?= $bahagian->bahagian ?> - <?= $lpp->guru->CONm; ?></strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php
                    if (is_null($data) && ($bahagian->id != 11)) {
                        echo '';
                    } else {
                        if (is_null($input)) {
                            echo $this->render('//elnpt/elnpt2/_bhg' . $bahagian->id, [
                                'data' => $data,
                                'data2' => isset($data2) ? $data2 : null,
                                'lppid' => $lppid,
                                'lpp' => $lpp,
                                'tahun' => $tahun,
                                'req' => $req,
                                //'input' => $input,
                                'dataProvider' => isset($dataProvider) ? $dataProvider : null,
                                'check' => isset($check) ? $check : false,
                            ]);
                        } else {
                            echo $this->render('//elnpt/elnpt2/_bhg' . $bahagian->id, [
                                'data' => $data,
                                'data2' => isset($data2) ? $data2 : null,
                                'lppid' => $lppid,
                                'input' => $input,
                                'lpp' => $lpp,
                                'tahun' => $tahun,
                                'req' => $req,
                                'dataProvider' => isset($dataProvider) ? $dataProvider : null,
                                'check' => isset($check) ? $check : false,
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

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center">Aspek Penilaian</th>
                                <?php if ($bahagian->id != 10) { ?>

                                    <th class="text-center col-md-2">Markah PYD <sub>(100%)</sub></th>
                                <?php } ?>
                                <th class="text-center col-md-2">Markah PPP <sub>(100%)</sub></th>
                                <th class="text-center col-md-2">Markah PPK <sub>(100%)</sub></th>
                                <?php if ($bahagian->id == 10) { ?>
                                    <th class="text-center col-md-2">Markah PEER <sub>(100%)</sub></th>
                                <?php } ?>
                            </tr>
                            <?php foreach ($mrkh_bhg as $ind => $all) { ?>
                                <tr>
                                    <th><?= $mrkh_bhg[$ind]['desc']; ?></th>
                                    <?php if ($bahagian->id != 10) { ?>

                                        <th class="col-md-1 text-center" style="text-align:center"><?= Yii::$app->formatter->asDecimal($mrkh_bhg[$ind]['markah_pyd']); ?> <sub><?= ' / ' . Yii::$app->formatter->asDecimal($mrkh_bhg[$ind]['pemberat']); ?></sub> </th>
                                    <?php } ?>
                                    <th class="col-md-2 text-center">
                                        <div class="input-group col-lg-10 col-lg-offset-1 text-center">
                                            <?php if ($bahagian->id != 10) { ?>
                                                <?= (($lpp->PPP == Yii::$app->user->identity->ICNO or
                                                    $lpp->PPK == Yii::$app->user->identity->ICNO or
                                                    app\models\elnpt\testing\TblTestingAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->exists() or $lpp->PPP == Yii::$app->user->identity->ICNO) ? Yii::$app->formatter->asDecimal($mrkh_bhg[$ind]['markah_ppp']) : 'PPP') ?> <?= '<sub>/ ' . $mrkh_bhg[$ind]['pemberat'] . '</sub>' ?>
                                            <?php } else { ?>
                                                <?= is_null($mrkh_bhg[$ind]['markah_ppp']) ? '0.00' : (($lpp->PPP == Yii::$app->user->identity->ICNO or $lpp->PPK == Yii::$app->user->identity->ICNO or app\models\elnpt\testing\TblTestingAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->exists())
                                                    ? Yii::$app->formatter->asDecimal($mrkh_bhg[$ind]['markah_ppp']) : 'PPP'); ?> <?= '<sub>/ ' . $mrkh_bhg[$ind]['pemberat'] . '</sub>' ?>
                                            <?php } ?>
                                        </div>
                                    </th>
                                    <th class="col-md-2 text-center" style="text-align:center">
                                        <div class="input-group col-lg-10 col-lg-offset-1 text-center">
                                            <?php if ($bahagian->id != 10) { ?>
                                                <?= ((app\models\elnpt\testing\TblTestingAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->exists() or $lpp->PPK == Yii::$app->user->identity->ICNO) ? Yii::$app->formatter->asDecimal($mrkh_bhg[$ind]['markah_ppk']) : 'PPK') ?> <?= '<sub>/ ' . $mrkh_bhg[$ind]['pemberat'] . '</sub>' ?>
                                            <?php } else { ?>
                                                <?= is_null($mrkh_bhg[$ind]['markah_ppk']) ? '0.00' : (($lpp->PPK == Yii::$app->user->identity->ICNO or app\models\elnpt\testing\TblTestingAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->exists()) ? Yii::$app->formatter->asDecimal($mrkh_bhg[$ind]['markah_ppk']) : 'PPK'); ?> <?= '<sub>/ ' . $mrkh_bhg[$ind]['pemberat'] . '</sub>' ?>
                                            <?php } ?>
                                        </div>
                                    </th>
                                    <?php if ($bahagian->id == 10) { ?>
                                        <th class="col-md-2 text-center" style="text-align:center">
                                            <div class="input-group col-lg-10 col-lg-offset-1 text-center">
                                                <?php if ($bahagian->id != 10) { ?>
                                                    <?= ((app\models\elnpt\testing\TblTestingAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->exists() or $lpp->PEER == Yii::$app->user->identity->ICNO) ? Yii::$app->formatter->asDecimal($mrkh_bhg[$ind]['markah_peer']) : 'PEER') ?> <?= '<sub>/ ' . $mrkh_bhg[$ind]['pemberat'] . '</sub>' ?>
                                                <?php } else { ?>
                                                    <?= is_null($mrkh_bhg[$ind]['markah_peer']) ? '0.00' : (($lpp->PEER == Yii::$app->user->identity->ICNO or app\models\elnpt\testing\TblTestingAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->exists()) ? Yii::$app->formatter->asDecimal($mrkh_bhg[$ind]['markah_peer']) : 'PEER'); ?> <?= '<sub>/ ' . $mrkh_bhg[$ind]['pemberat'] . '</sub>' ?>
                                                <?php } ?>
                                            </div>
                                        </th>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
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
                                <?php
                                if (($bahagian->id == 10) && ($lpp->PEER == Yii::$app->user->identity->ICNO)) {
                                    foreach ($markah as $ind => $m) { ?>
                                        <th class="text-center"><?= is_null($m) ? '0<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>' : (($ind == 9) ? $m : '-') . '<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>'; ?></th>
                                    <?php }
                                } else {
                                    foreach ($markah as $ind => $m) { ?>
                                        <th class="text-center"><?= is_null($m) ? '0<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>' : Yii::$app->formatter->asDecimal($m * 100) . '<sub> / ' . $pemberat[$ind]['pemberat'] . '</sub>'; ?></th>
                                <?php }
                                } ?>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (1 == 1) {
    echo $this->render('//elnpt/elnpt2/_skor', ['bahagian' => $bahagian, 'ruberik' => $ruberik]);
}
?>

<?php
if ($bahagian->id != 9) {
    echo $this->render('//elnpt/elnpt2/_rubrik', ['bahagian' => $bahagian, 'ruberik' => $ruberik, 'lpp' => isset($lpp) ? $lpp : false]);
} ?>
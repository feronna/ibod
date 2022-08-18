<?php
/* @var $this yii\web\View */

$this->registerCss("
    td {
        color: black;
        font-size: 15px;
    }
");

$js = <<<js
    $('.modalButtonn').on('click', function () {
        $('#modall').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
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

// $bhg = ArrayHelper::getColumn($mrkh_all, 'bahagian');
// $markah = ArrayHelper::getColumn($mrkh_all, 'markah');

// $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y']);

//$mrkh_bhg_pemberat = TblPemberatBhg::find()
//                ->select(['pemberat'])
//                ->where(['kump_dept_id' => $dept, 'kump_gred_id' => $gred])
//                ->asArray()
//                ->all();

//\yii\helpers\VarDumper::dump($items, 10, true);
?>

<?php
Modal::begin([
    'header' => '<strong>Tambah / Kemaskini</strong>',
    'id' => 'modall',
    'size' => 'modal-lg',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false
    ]
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<?php
Modal::begin([
    'header' => '<strong>Tambah / Kemaskini</strong>',
    'id' => 'modal',
    'size' => 'modal-lg',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false
    ]
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>


<?php
echo $this->render('//elnpt/elnpt2/_menu', ['menu' => $menu, 'lppid' => $lppid, 'sah' => isset($lpp) ? $lpp->PYD_sah : false]);
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Bahagian <?= $bahagian->id ?> : <?= $bahagian->bahagian ?></strong></h2>

                <?= (is_null($url_create) || ($check)) ? '' : Html::button('Tambah Data', ['value' => $url_create, 'class' => 'pull-right btn-success btn-sm modalButtonn']) ?>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php
                    echo $this->render('_bhg' . $bahagian->id, [
                        'data' => isset($data) ? $data : null,
                        // 'data2' => isset($data2) ? $data2 : null,
                        'lppid' => isset($lppid) ? $lppid : null,
                        'lpp' => isset($lpp) ? $lpp : null,
                        'check' => isset($check) ? $check : false,
                        // 'tahun' => $tahun,
                        // 'req' => $req
                        'input' => isset($input) ? $input : null,
                        'dataProvider' => isset($dataProvider) ? $dataProvider : null,
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

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

                                    <th class="text-center col-md-2">Markah PYD</th>
                                <?php } ?>
                                <?php if (1 == 0 || $bahagian->id == 10) { ?>
                                    <th class="text-center col-md-2">Markah PPP</th>
                                    <th class="text-center col-md-2">Markah PPK</th>
                                <?php } ?>
                                <?php if ($bahagian->id == 10) { ?>
                                    <th class="text-center col-md-2">Markah PEER</th>
                                <?php } ?>
                            </tr>
                            <?php foreach ($mrkh_bhg as $ind => $all) { ?>
                                <tr>
                                    <th><?= $all['desc']; ?></th>
                                    <?php if ($bahagian->id != 10) { ?>
                                        <th class="col-md-1 text-center" style="text-align:center"><?= Yii::$app->formatter->asDecimal($all['markah_pyd']); ?> <sub><?= ' / ' . Yii::$app->formatter->asDecimal($all['pemberat']); ?></sub> </th>
                                    <?php } ?>
                                    <?php if (1 == 0 || $bahagian->id == 10) { ?>
                                        <th class="col-md-1 text-center" style="text-align:center">

                                            <?= is_null($all['markah_ppp']) ? 'PPP' : 'PPP' ?> <sub><?= ' / ' . Yii::$app->formatter->asDecimal($all['pemberat']); ?></sub>

                                        </th>
                                        <th class="col-md-1 text-center" style="text-align:center">

                                            <?= is_null($all['markah_ppk']) ? 'PPK' : 'PPK' ?> <sub><?= ' / ' . Yii::$app->formatter->asDecimal($all['pemberat']); ?></sub>

                                        </th>
                                    <?php } ?>
                                    <?php if ($bahagian->id == 10) { ?>
                                        <th class="col-md-1 text-center" style="text-align:center">

                                            <?= is_null($all['markah_peer']) ? 'PEER' : 'PEER' ?> <sub><?= ' / ' . Yii::$app->formatter->asDecimal($all['pemberat']); ?></sub>

                                        </th>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                            <tr>
                                <th style="text-align:right">JUMLAH</th>
                                <?php if ($bahagian->id != 10) { ?>
                                    <th style="text-align:center"><?= Yii::$app->formatter->asDecimal(array_sum(ArrayHelper::getColumn($mrkh_bhg, 'markah_pyd')), 2); ?></th>
                                <?php } ?>
                                <?php if (1 == 0 || $bahagian->id == 10) { ?>
                                    <th style="text-align:center"><?= Yii::$app->formatter->asDecimal(array_sum(ArrayHelper::getColumn($mrkh_bhg, 'markah_ppp')), 2); ?></th>
                                    <th style="text-align:center"><?= Yii::$app->formatter->asDecimal(array_sum(ArrayHelper::getColumn($mrkh_bhg, 'markah_ppk')), 2); ?></th>
                                <?php } ?>
                                <?php if ($bahagian->id == 10) { ?>
                                    <th style="text-align:center"><?= Yii::$app->formatter->asDecimal(array_sum(ArrayHelper::getColumn($mrkh_bhg, 'markah_peer')), 2); ?></th>
                                <?php } ?>
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
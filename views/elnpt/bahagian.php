<?php
/* @var $this yii\web\View */

$js=<<<js
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
use app\models\elnpt\TblLppTahun;
use kartik\spinner\Spinner;

$numOfCols = (sizeof($rubric)  < 3) ? sizeof($rubric) : 3;
$rowCount = 0;
$bootstrapColWidth = 12 / $numOfCols;

$bhg = ArrayHelper::getColumn($mrkh_all, 'bahagian');
$markah = ArrayHelper::getColumn($mrkh_all, 'markah');

$tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y']);

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
        'id' => 'modal',
        'size' => 'modal-xs',
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
?>

<?= $this->render('_menu', ['mrkh_all' => $menu, 'lppid' => $lppid]); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Bahagian <?= $bhgian->id?> : <?= $bhgian->bahagian?></strong></h2> <?= (is_null($url_create) 
                        or ($lpp->PYD_sah == 1) or (date('Y-m-d H:i:s') >= $tahun->pengisian_PYD_tamat)) ? '' 
        : Html::button('Tambah Data', ['value' => $url_create, 'class' => 'pull-right btn-success btn-sm modalButton']); ?>
                
                <?= (!is_null($url_create) AND $lpp->PYD == \Yii::$app->user->identity->ICNO  AND (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))
                ? Html::button('Tambah Data', ['value' => $url_create, 'class' => 'pull-right btn-success btn-sm modalButton']) : ''?>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php 
                        if (is_null($data)) {
                            echo '';
                        }else {
                            if (is_null($input)) {
                                echo $this->render('_bhg'.$bhgian->id, [
                                    'data' => $data,
                                    'data2' => isset($data2) ? $data2 : null,
                                    'lppid' => $lppid,
                                    'lpp' => isset($lpp) ? $lpp : null,
                                    'tahun' => $tahun,
                                    'req' => $req
                                    //'input' => $input,
                                ]);
                            }else {
                                echo $this->render('_bhg'.$bhgian->id, [
                                    'data' => $data,
                                    'data2' => isset($data2) ? $data2 : null,
                                    'lppid' => $lppid,
                                    'input' => $input,
                                    'lpp' => isset($lpp) ? $lpp : null,
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
                                <?php if($bhgian->id != 9) { ?>
                                
                                <th class="text-center col-md-2">Markah PYD</th>
                                <?php } ?>
                                <th class="text-center col-md-2">Markah PPP</th>
                                <th class="text-center col-md-2">Markah PPK</th>
                                <?php if($bhgian->id == 9) { ?>
                                <th class="text-center col-md-2">Markah PEER</th>
                                <?php } ?>
                            </tr>
                            <?php foreach ($mrkh_bhg as $ind => $all) { ?>
                            <tr>
                                <th><?= $all['desc']; ?></th>
                                <?php if($bhgian->id != 9) { ?>
                                
                                <th class="col-md-1 text-center"  style="text-align:center"><?= $all['markah_pyd']; ?> <sub><?= ' / '.$all['pemberat']; ?></sub> </th>
                                <?php } ?>
                                <th class="col-md-1 text-center" style="text-align:center">
                                    
                                        <?= is_null($all['markah_ppp']) ? 'PPP' : $all['markah_ppp']?> <sub><?= ' / '.$all['pemberat']; ?></sub>
                                    
                                </th>
                                <th class="col-md-1 text-center"  style="text-align:center">
                                    
                                        <?= is_null($all['markah_ppk']) ? 'PPK' : $all['markah_ppk']?> <sub><?= ' / '.$all['pemberat']; ?></sub>
                                    
                                </th>
                                <?php if($bhgian->id == 9) { ?>
                                
                                <th class="col-md-1 text-center"  style="text-align:center">
                                    <?= is_null($all['markah_peer']) ? 'PEER' : 'PEER'?> <sub><?= ' / '.$all['pemberat']; ?></sub>
                                </th>
                                
                                <?php } ?>
                            </tr>
                            <?php } ?>
                            <?php if($bhgian->id != 9) { ?>
                            <tr>
                                <th style="text-align:right">JUMLAH</th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg, 'markah_pyd')); ?></th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg, 'markah_ppp')); ?></th>
                                <th style="text-align:center"><?= array_sum(ArrayHelper::getColumn($mrkh_bhg, 'markah_ppk')); ?></th>
                            </tr>
                            <?php } ?>
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
                <h2><strong> <?= ($bhgian->id != 9) ? 'Markah Keseluruhan (PPP + PPK)' : 'Markah Keseluruhan (PPP + PPK + PEER)' ?> </strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php if($lpp->PPP_sah == 1 and $lpp->PPK_sah == 1 and $lpp->PEER_sah == 1) { ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <?php foreach($bhg as $b) {?>
                                <th class="text-center"><?= $b; ?></th>
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php foreach($markah as $ind => $m) {?>
                                <th class="text-center"><?= is_null($m) ? '0<sub> / '.$pemberat[$ind]['pemberat'].'</sub>' : $m.'<sub> / '.$pemberat[$ind]['pemberat'].'</sub>'; ?></th>
                                <?php } ?>
                            </tr>
                        </table>
                    </div>
                    <?php } else {
//                        echo '<div class="border border-secondary p-3 rounded">';
                            echo Spinner::widget(['preset' => 'medium', 'align' => 'left', 'color' => 'blue', 'caption' => 'Menunggu penilaian selesai &hellip;']);
//                            echo '<div class="clearfix"></div>';
//                        echo '</div>';
                    } ?>
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
                    <?php foreach($rubric as $ind => $rub) {?>
                        <div class="col-md-<?php echo $bootstrapColWidth; ?>">
                            <strong>Rubrik <?= $ind?></strong>
                                <p>
                                    <table class="table table-sm table-bordered">

                                        <tr>
                                            <th>Penilaian</th>
                                            
                                            <th class="text-center">Peratus (%)</th>
                                        </tr>

                                        <?php foreach ($rub as $rb) { ?>
                                        <tr>
                                            <td><?= $rb['penilaian']; ?></td>
                                            
                                            <td class="text-center"  style="text-align:center"><?= $rb['peratus']; ?></td>
                                        </tr>
                                        <?php } ?>

                                    </table>
                                </p>
                        </div>
                    <?php
                        $rowCount++;
                        if($rowCount % $numOfCols == 0) {
                            echo '</div><div class="row">';
                            
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
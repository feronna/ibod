<?php

use yii\helpers\Html;
use app\models\myidp\AdminJfpiu;
use app\models\myidp\UrusetiaLatihan;
use app\models\hronline\Tblprcobiodata;

$model = UrusetiaLatihan::find()->where(['level' => '1'])->one();
$model2 = UrusetiaLatihan::find()->where(['level' => '2'])->one();

$dept = Tblprcobiodata::find()->where(['ICNO' => Yii::$app->user->getId()])->select('DeptId');

$model3 = AdminJfpiu::find()
    ->joinWith('biodata.jawatan.skimPerkhidmatan')
    ->where(['DeptId' => $dept, 'kumpkhidmat.id' => '5'])
    ->orWhere(['DeptId' => $dept, 'kumpkhidmat.id' => '6'])
    ->limit(3)
    ->all();


$count = 0;
if ($model3) {
    $count = count($model3);
}

?>

<div class="contact-person">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Sistem MyIDP</h2>
                    <div class="clearfix"></div>
                </div>
                <strong>
                    Untuk maklumat lanjut, sila hubungi talian berikut: <br /><br />
                    <table>
                        <tr>
                            <td>
                                <?= strtoupper($model->biodata->displayGelaran . ' ' . $model->biodata->CONm) ?><br />
                                <?= ucwords(strtolower($model->biodata->jawatan->nama)) . ' (' . ucwords(strtoupper($model->biodata->jawatan->gred)) . ')'; ?><br />
                                Emel (<?= $model->biodata->COEmail ?>)<br />
                                <?= ucwords(strtoupper($model2->biodata->department->fullname)); ?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>

                            <td>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?= strtoupper($model2->biodata->displayGelaran . ' ' . $model2->biodata->CONm) ?><br />
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?= ucwords(strtolower($model2->biodata->jawatan->nama)) . ' (' . ucwords(strtoupper($model2->biodata->jawatan->gred)) . ')'; ?><br />
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                Emel (<?= $model2->biodata->COEmail ?>)<br />
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?= ucwords(strtoupper($model2->biodata->department->fullname)); ?>
                            </td>

                        </tr>
                    </table>
                </strong>

                <?php if ($count > 0) { ?>
                    <div class="x_title">
                        <div class="clearfix"></div>
                    </div>
                    <strong>
                        Untuk maklumat lanjut berkenaan permohonan mata IDP berkumpulan atau individu, boleh hubungi talian berikut: <br /><br />
                        <table>
                            <tr>

                                <?php foreach ($model3 as $m) {

                                ?>
                                    <td>
                                        <?= strtoupper($m->biodata->displayGelaran . ' ' . $m->biodata->CONm) ?><br />
                                        <?= ucwords(strtolower($m->biodata->jawatan->nama)) . ' (' . ucwords(strtoupper($m->biodata->jawatan->gred)) . ')'; ?><br />
                                        Emel (<?= $m->biodata->COEmail ?>)<br />
                                        <?= ucwords(strtoupper($m->biodata->department->fullname)); ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                    </td>
                                <?php } ?>


                            </tr>
                        </table>
                    </strong>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
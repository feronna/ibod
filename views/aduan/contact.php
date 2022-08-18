<?php

use yii\helpers\Html;
use app\models\aduan\RptTblAccess;

$model = RptTblAccess::find()->where(['access_type' => 'urusetia', 'level' => '1'])->one();
$model2 = RptTblAccess::find()->where(['access_type' => 'urusetia', 'level' => '2'])->one();

?>

<div class="contact-person">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Sistem E - Aduan</h2>
                    <div class="clearfix"></div>
                </div>
                <strong>
                    Untuk maklumat lanjut, sila hubungi talian berikut: <br /><br />
                    <table>
                        <tr>
                            <td>
                                <?= strtoupper($model->biodata->displayGelaran . ' ' . $model->biodata->CONm) ?><br />
                                <?= ucwords(strtolower($model->biodata->jawatan->nama)) . ' (' . ucwords(strtoupper($model->biodata->jawatan->gred)) . ')'; ?><br />
                                Tel: 088320000 (<?= $model->biodata->COHPhoneNo ?>)
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>

                            <td>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?= strtoupper($model2->biodata->displayGelaran . ' ' . $model2->biodata->CONm) ?><br />
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?= ucwords(strtolower($model2->biodata->jawatan->nama)) . ' (' . ucwords(strtoupper($model2->biodata->jawatan->gred)) . ')'; ?><br />
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                Tel: 088320000 (<?= $model2->biodata->COHPhoneNo ?>)
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>

                            <td>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                HOTLINE BKUMS<br />
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                Tel: 0127922979
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>

                        </tr>
                    </table>
                </strong>
            </div>
        </div>
    </div>
</div>
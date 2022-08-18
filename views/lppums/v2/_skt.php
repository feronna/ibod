<?php

use app\models\lppums\v2\RefAspek;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\db\Query;

$aspeks = RefAspek::find()->where(['bahagian_id' => $bhg])->orderBy(['aspek_order' => SORT_ASC])->all();
$nonPemimpin = true;

$items = [];
foreach ($aspeks as $ind => $aspek) {
    if ($bhg == 2) {
        if ($aspek['aspek_label'] == '1. ciri-ciri pemimpin') {
            if (in_array($lpp->pyd->jawatan->skimPerkhidmatan->id, [5, 6])) {
                $nonPemimpin = false;
                continue;
            }
        }
    }
    $queryCopy = clone $query;
    $items[$ind]['title'] = (!$nonPemimpin && ($bhg == 2)) ? substr_replace(strtoupper($aspek['aspek_label']), $ind, 0, 1) : strtoupper($aspek['aspek_label']);
    $items[$ind]['active'] = true;
    $items[$ind]['content'] = ($aspek['aspek_order'] != '23') ? $this->render('_accskt', ['desc' => $aspek['aspek_desc'], 'query' => $queryCopy->rightJoin(['c' => 'hrm.`lppums_v2_ref_months`'], 'c.`month` = a.`month` and a.`aspek_id` = ' . $aspek->id . ' and a.`lpp_id` = ' . $lppid . ' and a.`deleted_dt` IS NULL')->orderBy(['c.month' => SORT_ASC, 'a.updated_dt' => SORT_ASC, 'a.created_dt' => SORT_ASC]), 'aspekId' => $aspek->id, 'lpp' => $lpp, 'akses' => $akses, 'tt' => $tt, 'currTab' => $currTab]) : $this->render('_umum', ['lpp' => $lpp, 'desc' => $aspek['aspek_desc'], 'aspekId' => $aspek->id]);
    // $nonPemimpin = true;
}
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <?=
        \yiister\gentelella\widgets\Accordion::widget(
            [
                'items' => $items,
            ]
        );
        ?>
    </div>
</div>
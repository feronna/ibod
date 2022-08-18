<?php

use app\models\lppums\v2\RefMonths;

$months = RefMonths::find()->indexBy('month')->asArray()->all();

$aktiviti = \app\models\myidp\SiriLatihan::find()
    ->select(['c.`month`, `hrd`.`idp_SiriLatihan`.*'])
    ->joinWith('sasaran5.sasaran55')
    ->rightJoin(['c' => '`hrm`.`lppums_v2_ref_months`'], '`c`.`month` =  MONTH(`hrd`.`idp_SiriLatihan`.`tarikhMula`)')
    ->where(['idp_kehadiran.staffID' => $lpp->pyd->ICNO])
    ->andWhere(['idp_kehadiran.kategoriKursusID' => [1]])
    ->andWhere(['YEAR(idp_kehadiran.tarikhMasa)' => $lpp->tahun])
    ->orderBy(['c.`month`' => SORT_ASC]);

$dataProvider2 = new yii\data\ArrayDataProvider([
    // 'query' => $aktiviti,
    // 'pagination' => false,
    // 'sort' => [
    //     'defaultOrder' => ['tarikhMula' => SORT_ASC],
    // ],
    'allModels' => $aktiviti->all(),
]);

?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">
                    <p><i><?= $desc; ?></i></p>

                    <?= \app\models\lppums\v2\RefAspek::aspekInfo($aspekId); ?>

                    <hr />
                    <div class="clearfix"></div>

                    <div class="table-responsive">
                        <?=
                        \kartik\grid\GridView::widget([
                            'emptyText' => 'Tiada Rekod',
                            'striped' => false,
                            'summary' => '',
                            'dataProvider' => $dataProvider2,
                            'showFooter' => false,
                            'columns' => [
                                [
                                    'header' => 'BULAN',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align:middle'],
                                    'value' => function ($model) use ($months) {
                                        return ucfirst($months[intval(date('m', strtotime($model->tarikhMula)))]['slabel']);
                                    },
                                    'group' => true,

                                ],
                                [
                                    'label' => 'RINGKASAN AKTIVITI / PROJEK',
                                    'headerOptions' => ['class' => 'column-title text-center'],
                                    // 'contentOptions' => ['style' => 'vertical-align:middle'],
                                    // 'value' => function ($model) {
                                    //     return '<sup>' . Yii::$app->formatter->asDate($model->updated_dt ?? $model->created_dt, 'dd/MM/yyyy') . '</sup><br>' . $model->ringkasan;
                                    // },
                                    'value' => function ($model) {
                                        return $model->sasaran3->tajukLatihan;
                                    },
                                    'format' => 'html',
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
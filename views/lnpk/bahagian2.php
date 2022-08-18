<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

?>

<?php
echo $this->render('_menuBorang', ['lnpk_id' => $lnpk->lnpk_id]);
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>KRITERIA PENILAIAN</strong><?= $lnpk->isAdmin() ? '<sup> View as Admin</sup>' : '' ?><?= ' - ' . $lnpk->pyd->CONm ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?= $this->render('_arahan', ['jenisBorang' => $lnpk->lnpk_jenis]) ?>

                    <table class="table table-bordered">
                        <caption style="caption-side:bottom; text-align:center">Skala Penilaian</caption>
                        <thead>
                            <tr>
                                <th colspan="2" style="text-align: center;">Sangat Rendah</th>
                                <th colspan="2" style="text-align: center;">Rendah</th>
                                <th colspan="2" style="text-align: center;">Sederhana</th>
                                <th colspan="2" style="text-align: center;">Tinggi</th>
                                <th colspan="2" style="text-align: center;">Sangat Tinggi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center;">1</td>
                                <td style="text-align: center;">2</td>
                                <td style="text-align: center;">3</td>
                                <td style="text-align: center;">4</td>
                                <td style="text-align: center;">5</td>
                                <td style="text-align: center;">6</td>
                                <td style="text-align: center;">7</td>
                                <td style="text-align: center;">8</td>
                                <td style="text-align: center;">9</td>
                                <td style="text-align: center;">10</td>
                            <tr>
                            </tr>
                        </tbody>
                    </table>

                    <?php $form = ActiveForm::begin(); ?>

                    <div class="table-responsive">
                        <?=
                        GridView::widget([
                            'emptyText' => 'Tiada Rekod',
                            'summary' => '',
                            'dataProvider' => $dataProvider,
                            'showFooter' => true,
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'header' => 'BIL',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'label' => 'KRITERIA',
                                    'headerOptions' => ['class' => 'column-title text-center'],
                                    'value' => function ($model) {
                                        return '<b>' . $model->kriteria_label . '</b><br/>' . $model->kriteria_desc;
                                    },
                                    'format' => 'html',
                                ],
                                [
                                    'label' => 'MARKAH ' . ($lnpk->isPP ? 'PP' : 'PPP'),
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) use ($form, $lnpk) {
                                        return $form->field($model, "[{$model->array_id}]id_ref_kriteria")->label(false)->hiddenInput(['value' => $model->kriteria_id]) . '' . $form->field($model, "[{$model->array_id}]kriteria_markah_ppp")->textInput(['type' => 'number', 'min' => 0, 'max' => 10, 'style' => 'text-align: center;', 'placeholder' => 0, 'disabled' => ($lnpk->disableInputPPP())])->label(false);
                                    },
                                    'format' => 'raw',
                                    'footer' => '<center><b><font style="font-size:20px">' . $totalPPP . '</font> / 100</b></center>',
                                    'visible' => !($lnpk->hideInputPPP()),
                                ],
                                [
                                    'label' => 'MARKAH PPK',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) use ($form, $lnpk) {
                                        return $form->field($model, "[{$model->array_id}]id_ref_kriteria")->label(false)->hiddenInput(['value' => $model->kriteria_id]) . '' . $form->field($model, "[{$model->array_id}]kriteria_markah_ppk")->textInput(['type' => 'number', 'min' => 0, 'max' => 10, 'style' => 'text-align: center;', 'placeholder' => 0, 'disabled' => ($lnpk->disableInputPPK())])->label(false);
                                    },
                                    'format' => 'raw',
                                    'footer' => '<center><b><font style="font-size:20px">' . $totalPPK . '</font> / 100</b></center>',
                                    'visible' => !($lnpk->hideInputPPK()),
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                    <?= (!$lnpk->isPYD() && !$lnpk->disableButton()) ? Html::submitButton('Simpan', ['class' => 'btn btn-primary pull-right']) : '' ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php //$this->render('_skalaPenilaianPrestasi'); 
?>
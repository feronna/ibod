<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$akses = app\models\lppums\TblStafAkses::find()
    ->where(['ICNO' => Yii::$app->user->identity->ICNO])
    ->andWhere(['IN', 'akses_id', [1]])
    ->exists();

?>

<script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML' async></script>

<?php
// javascript for triggering the dialogs
$js = <<< JS
    function delay(callback, ms) {
        var timer = 0;
    return function() {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
        callback.apply(context, args);
        }, ms || 0);
    };
    }

    $("[id*='markah_PPK']").keyup(delay(function (e) {
        if (this.value.length <= this.maxLength) {
        $(this).parent().parent().parent().closest('tr').nextAll().eq(1).find("[id*='markah_PPK']").focus();
        //$(this).parent().parent().parent().closest('tr').nextAll().eq(1).find("[id*='markah_PPK']").val("");
        //   alert('asdad');
        }
    }, 900));

    $("[id*='markah_PPP']").keyup(delay(function (e) {
        if (this.value.length <= this.maxLength) {
        $(this).parent().parent().parent().closest('tr').nextAll().eq(1).find("[id*='markah_PPP']").focus();
        //$(this).parent().parent().parent().closest('tr').nextAll().eq(1).find("[id*='markah_PPP']").val("");
        //   alert('asdad');
        }
    }, 900));

    $('.modalButtonn').on('click', function () {
        $('#modalSkt').modal('show')
                .find('#modalContent1')
                .load($(this).attr('value'));
        $('#modalHeader').text('Senarai SKT');
    });
JS;

// register your javascript
$this->registerJs($js);

Modal::begin([
    'header' => '<strong id="modalHeader"></strong>',
    'id' => 'modalSkt',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent1'></div>";
Modal::end();
?>

<?= $this->render('_menuBorang', ['lppid' => $lpp->lpp_id]); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Bahagian IV - Pengetahuan Dan Kemahiran</strong> (Wajaran <?= $mrkhBhg['markah_bahagian'] ?>%) <?= (($lpp->PYD != Yii::$app->user->identity->ICNO)) ? '(' . $lpp->pyd->CONm. ' - ' . $lpp->tahun. ')' : '' ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <p>
                        Pegawai Penilai dikehendaki memberikan penilaian berasaskan penjelasan tiap-tiap kriteria yang dinyatakan dengan menggunakan skala 1 hingga 10:
                    </p>

                    <?php $form1 = ActiveForm::begin(); ?>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center col-md-1">Bil</th>
                                <th class="text-center">Kriteria</th>
                                <th class="text-center col-md-1">PPP</th>
                                <th class="text-center col-md-1">PPK</th>
                            </tr>

                            <?php
                            $abc = 0;

                            foreach ($lpp_mrkh as $ind => $p) { ?>

                                <?php
                                // necessary for update action.
                                if (!$p->isNewRecord) {
                                    echo Html::activeHiddenInput($p, "[{$ind}]bhk_id");
                                } else {
                                    echo Html::activeHiddenInput($p, "[{$ind}]bhk_id", ['value' => $kriteria[$abc]['bhk_id']]);
                                }
                                ?>

                                <tr>
                                    <td class="text-center"><?= $abc + 1; ?></td>
                                    <td><?= '<b>' . $kriteria[$abc]['kriteria']['kriteria_label'] . ' ' . Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => Url::to(['lppums/senarai-skt', 'lpp_id' => $lpp->lpp_id, 'order' => $kriteria[$abc]['kriteria_id'], 'bhg' => $kriteria[$abc]['bahagian_id']]), 'class' => ' btn btn-default btn-xs modalButtonn']) . '</b><br>' . $kriteria[$abc]['kriteria']['kriteria']; ?></td>
                                    <td class="text-center"><?= (($lpp->PPP == \Yii::$app->user->identity->ICNO) or ($lpp->PPK == \Yii::$app->user->identity->ICNO)) ? $form1->field($p, "[$ind]markah_PPP")->textInput([
                                                                'id' => "[$ind]markah_PPP", 'class' => 'form-control', 'placeholder' => '0.0', 'style' => 'text-align:center', 'maxlength' => 2
                                                                //, 'onfocus' => "this.value=''"
                                                                , 'disabled' => ($lpp->PPP_sah == 1) or ($lpp->PPK == \Yii::$app->user->identity->ICNO and is_null($lpp->PP_ALL))
                                                            ])->label(false) : ($akses ? $p->markah_PPP : 'PPP'); ?></td>
                                    <td class="text-center"><?= (($lpp->PPK == \Yii::$app->user->identity->ICNO)) ? $form1->field($p, "[$ind]markah_PPK")->textInput([
                                                                'id' => "[$ind]markah_PPK", 'class' => 'form-control', 'placeholder' => '0.0', 'style' => 'text-align:center', 'maxlength' => 2
                                                                //, 'onfocus' => "this.value=''"
                                                                , 'disabled' => ($lpp->PPK_sah == 1)  or ($lpp->PPP_sah == 0)
                                                            ])->label(false) : ($akses ? $p->markah_PPK : 'PPK'); ?></td>
                                </tr>
                            <?php
                                $abc = $abc + 1;
                            } ?>

                            <tr>
                                <th colspan="2" class="text-center">Jumlah markah mengikut wajaran</th>
                                <th class="text-center">
                                    <math>
                                        <mfrac>
                                            <mn><?= ($akses or ($lpp->PPP == \Yii::$app->user->identity->ICNO) or ($lpp->PPK == \Yii::$app->user->identity->ICNO)) ? \Yii::$app->formatter->asDecimal(array_sum(array_column($jumlah, 'markah_PPP')), 0) : ''; ?></mn>
                                            <mn><?= $abc * 10 ?></mn>
                                        </mfrac>
                                        <mo>x</mo>
                                        <mn><?= $mrkhBhg['markah_bahagian'] ?></mn>
                                        <mo>=</mo>
                                        <mn>
                                            <?php
                                            $sum = array_sum(array_column($jumlah, 'markah_PPP'));
                                            $total = ($sum / ($abc * 10)) * $mrkhBhg['markah_bahagian'];
                                            echo ($akses or ($lpp->PPP == \Yii::$app->user->identity->ICNO) or ($lpp->PPK == \Yii::$app->user->identity->ICNO)) ? \Yii::$app->formatter->asDecimal($total, 2) : '';
                                            ?>
                                        </mn>
                                    </math>
                                </th>
                                <th class="text-center">
                                    <math>
                                        <mfrac>
                                            <mn><?= ($akses or ($lpp->PPK == \Yii::$app->user->identity->ICNO)) ? \Yii::$app->formatter->asDecimal(array_sum(array_column($jumlah, 'markah_PPK')), 0) : ''; ?></mn>
                                            <mn><?= $abc * 10 ?></mn>
                                        </mfrac>
                                        <mo>x</mo>
                                        <mn><?= $mrkhBhg['markah_bahagian'] ?></mn>
                                        <mo>=</mo>
                                        <mn>
                                            <?php
                                            $sum = array_sum(array_column($jumlah, 'markah_PPK'));
                                            $total = ($sum / ($abc * 10)) * $mrkhBhg['markah_bahagian'];
                                            echo ($akses or ($lpp->PPK == \Yii::$app->user->identity->ICNO)) ? \Yii::$app->formatter->asDecimal($total, 2) : '';
                                            ?>
                                        </mn>
                                    </math>
                                </th>
                            </tr>

                        </table>
                    </div>


                    <?php if (($lpp->PPP == \Yii::$app->user->identity->ICNO && ($lpp->PPP_sah == 0)) or ($lpp->PPK == \Yii::$app->user->identity->ICNO && ($lpp->PPK_sah == 0))) { ?>
                        <div class="form-group pull-right">
                            <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>

                        </div>
                    <?php } ?>


                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->render('_skalaPenilaianPrestasi'); ?>
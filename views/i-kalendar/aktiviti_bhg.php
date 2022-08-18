<?php
$js = <<<js
$('.modalButton').on('click', function () {
    $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
});
js;
$this->registerJs($js);

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\web\JsExpression;
use kartik\widgets\StarRating;
use yii\widgets\ActiveForm;

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

?>

<?php
Modal::begin([
    'header' => '<h4>Kemaskini Aktiviti</h4>',
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
    'footer' => '<a data-confirm="Adakah anda pasti untuk memadamnya?" data-method="post" id="modalDelete" class="btn btn-danger">Padam</a>',
    // 'toggleButton' => ['label' => 'click me'],
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    // 'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<?= $this->render('_menuAdmin'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian Aktiviti Perancangan</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(['id' => 'search',  'method' => 'post', 'options' => ['class' => 'form-horizontal form-label-left']]); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                        $form->field($model, 'tahun')->label(false)->widget(Select2::classname(), [
                            'data' => [
                                '2021' => '2021',
                            ],
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Sila pilih ...',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Bulan</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                        $form->field($model, 'bulan')->label(false)->widget(Select2::classname(), [
                            'data' => [
                                '1' => 'Jan',
                                '2' => 'Feb',
                                '3' => 'Mar',
                                '4' => 'Apr',
                                '5' => 'Mei',
                                '6' => 'Jun',
                                '7' => 'Jul',
                                '8' => 'Ogos',
                                '9' => 'Sept',
                                '10' => 'Okt',
                                '11' => 'Nov',
                                '12' => 'Dis',
                            ],
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Sila pilih ...',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Bahagian</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                        $form->field($model, 'bahagian')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\ikalendar\RefHrCategories::find()->where(['sub_of' => 1])->all(), 'category_id', 'name'),
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Sila pilih ...',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary'])
                        ?>
                        <?= Html::submitButton('Cari', ['class' => 'btn btn-success'])
                        ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Senarai Aktiviti Perancangan</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">

                    <?php
                    foreach ($laporan as $ind => $lap) {
                    ?>
                        <ul>
                            <li>
                                <strong4><?= $ind; ?></strong4>
                            </li>
                        </ul>
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center">BIL</th>
                                <th class="text-center">TARIKH</th>
                                <th class="text-center">NAMA AKTIVITI</th>
                                <th class="text-center">PERINGKAT</th>
                                <th class="text-center">STATUS</th>
                            </tr>
                            <?php
                            $i = 0;
                            foreach ($lap as $lp) {
                                $i++;
                                $url = Url::to(['i-kalendar/update', 'id' => $lp['event_id']]);
                            ?>
                                <tr>
                                    <td class="text-center">
                                        <?= $i; ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $lp['date']; ?>
                                    </td>
                                    <td>
                                        <?= $lp['nama_aktiviti']; ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $lp['Peringkat']; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php $tmp = $lp['status'] . ($lp['tarikh_tunda'] ? '<br/>Tarikh Selesai ' . $lp['tarikh_tunda'] : '');
                                        // switch (true){
                                        //     case stristr($tmp,'berlingo'):
                                        //        include 'berlingo.php';
                                        //        break;
                                        //     case stristr($tmp,'c4'):
                                        //        include 'c4.php';
                                        //        break;
                                        //  }
                                        ?>
                                        <?=
                                        Html::a($tmp, false,  ['value' =>  $url, 'class' => 'showModalButton', 'title' => 'Tambah Aktiviti']); ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    <?php    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
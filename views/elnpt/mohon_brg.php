<?php
/* @var $this yii\web\View */

//use Yii;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Alert;

?>

<?= $this->render('_menuUtama'); ?>

<?= Alert::widget([
    'options' => ['class' => 'alert-warning'],
    'body' => '<font color="black"><strong>PERINGATAN KEPADA SEMUA PEMOHON BORANG LPP</strong><br><br>
                <p>
                Sila pastikan maklumat berikut:
                <ul>
                <li> Nama</li>
                <li> No. Kad Pengenalan</li>
                <li> Jawatan dan Gred</li>
                <li> JSPIU</li>
                </ul>

                adalah tepat <b>SEBELUM</b> memohon borang Laporan Penilaian Prestasi.

                <br><br>Pembetulan maklumat tersebut perlu dirujuk pada bahagian HRMIS (Pejabat Pendaftar).

                <br><br>Sebarang pembetulan yang dibuat <b>SELEPAS</b> memohon borang Laporan Penilaian Prestasi akan menyebabkan anda perlu memohon borang yang berasingan bagi maklumat yang telah dikemaskini.

                <br><br>Sekian.
                </p></font>',
]);?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Permohonan borang Laporan Penilaian Prestasi Tahunan</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <p>Pastikan maklumat anda adalah tepat sebelum memohon borang Laporan Penilaian Prestasi.</p>
                    <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th class="col-md-2" style="text-align: right">Nama Guru</th>
                            <td><?= Yii::$app->user->identity->CONm ?></td>
                        </tr>
                        <tr>
                            <th class="col-md-2" style="text-align: right">No Kad Pengenalan</th>
                            <td><?= Yii::$app->user->identity->ICNO ?></td>
                        </tr>
                        <tr>
                            <th class="col-md-2" style="text-align: right">Jawatan / Gred</th>
                            <td>
                                <?php 
                                   $tmp = app\models\elnpt\GredJawatan::findGred(Yii::$app->user->identity->gredJawatan);
                                   echo $tmp->fname;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="col-md-2" style="text-align: right">JSPIU</th>
                            <td>
                                <?php 
                                   $tmp = app\models\elnpt\Department::findDept(Yii::$app->user->identity->DeptId);
                                   echo $tmp->fullname;
                                ?>
                            </td>
                        </tr>
                    </table>
                    </div>
                    <?php $form = ActiveForm::begin(['id' => 'contactform', 'options' => ['class' => 'form-inline text-center']]); ?>
                        <div class="form-group">
                            <label class="control-label">
                                Berdasarkan ketetapan di atas, saya ingin mengisi borang Laporan Penilaian Prestasi bagi tahun penilaian </label>
                                <?=
                                    $form->field($model, 'tahun')->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(app\models\elnpt\TblLppTahun::find()->where(['LIKE', 'lpp_aktif', 'y'])->orderBy(['lpp_tahun' => SORT_DESC,])->all(), 'lpp_tahun', 'lpp_tahun'),
                                        'hideSearch' => true,
                                        'options' => [
                                          'placeholder' => 'Tahun',
                                            //'id'=>'jabatan',
                                            //'class' => 'form-control'
                                          ],
                                        ])
                                    ->label(false);
                                ?>
                        </div>
                        <br>
                        <div class="form-group">
                            <?= Html::submitButton('Mohon Borang', ['class' => 'btn btn-success btn-sm']) ?>
                        </div>    
                    <?php ActiveForm::end(); ?><br>
                </div>
            </div>
            <div class="x_footer">
                <small>* Sekiranya terdapat ralat pada maklumat di atas, sila berhubung dengan pihak Pendaftar (bahagian HROnline) berkenaan cara untuk mengemaskini maklumat tersebut.</small>
            </div>
        </div>
    </div>
</div>
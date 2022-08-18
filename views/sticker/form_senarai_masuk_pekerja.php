<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$request = Yii::$app->request;
?>

<?= $this->render('menu') ?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>  
<div class="x_panel"> 
    <div class="x_title">
        <h2>Carian</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">    
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Nama Pekerja: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-4">  
                    <?=
                    $form->field($model, 'ICNO')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\Kontraktor\Kontraktor::find()->where(['id_kontraktor' => $request->get('id') . ' '])->andWhere(['Status' => 1])->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => 'Nama', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1">
<?= Html::submitButton('Cari', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Sila Tunggu..']]) ?>
                </div>
            </div>
        </div>

    </div>
</div> 

<div class="x_panel"> 
    <div class="x_title">
        <h2>Rekod Pekerja</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">  <br/>    
        <?php
        if ($syarikat) {
            ?>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Nama Syarikat/Pemilik: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6"> 
    <?= $form->field($syarikat, 'apsu_lname')->textInput(['maxlength' => true, 'disabled' => true])->label(false); ?>
                    </div>
                </div>
            </div> 
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Alamat: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6"> 
    <?= $form->field($syarikat, 'apsu_address1')->textInput(['maxlength' => true, 'disabled' => true])->label(false); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Tel: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">  
    <?= $form->field($syarikat, 'apsu_phone')->textInput(['maxlength' => true, 'disabled' => true])->label(false); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Emel: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">  
    <?= $form->field($syarikat, 'apsu_email')->textInput(['maxlength' => true, 'disabled' => true])->label(false); ?>
                    </div>
                </div>
            </div>
            <?php
        }
        ?> 
<?php ActiveForm::end(); ?><br/>   <br/>   
        <div class="table-responsive"> 
            <table class="table table-sm table-bordered jambo_table table-striped"> 

                <?php
                if ($record) {
                    $bil = 1;
                    ?>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">No. K/P</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Tindakan</th> 
                        <th class="text-center">Tarikh/Masa (Kerja Terakhir)</th> 
                    </tr>
    <?php foreach ($record as $l) { ?>

                        <tr>
                            <td class="text-center"><?= $bil; ?></td> 
                            <td class="text-center"><?= $l->ICNO ? $l->ICNO : ''; ?></td> 
                            <td class="text-center"><?= $l->CONm ? $l->CONm : ''; ?></td>  
                            <td class="text-center">  
                                <?php
                                if ($l->aktifSenaraiHitam) {
                                    echo 'SENARAI HITAM';
                                }elseif (empty($l->aktifDaftarMasuk)) {
                                    echo Html::a('<i class="fa fa-sign-in" aria-hidden="true"></i> Daftar Masuk', ['daftar-kontraktor', 'id' => $l->id], ['class' => 'btn btn-primary btn-sm']);
                                } else {
                                    echo Html::a('<i class="fa fa-ban" aria-hidden="true"></i>', ['senarai-hitam-kontraktor','id'=>$l->ICNO,'url'=>Yii::$app->controller->action->id,'flag' => 1], ['class' => 'btn btn-danger btn-sm']).''.Html::a('<i class="fa fa-sign-out" aria-hidden="true"></i> Daftar Keluar', ['daftar-kontraktor', 'id' => $l->id], ['class' => 'btn btn-warning btn-sm']);
                                }
                                ?>
                            </td> 
                            <td class="text-center">  
                                <?php
                                if ($l->aktifDaftarMasuk) {
                                    echo '<b><i>Waktu Masuk</i></b> : ' . $l->logMasukTerakhir->check_in;
                                }elseif ($l->logMasukTerakhir) {
                                    echo '<b><i>Waktu Masuk</i></b> : ' . $l->logMasukTerakhir->check_in . '<br/><b><i>Waktu Keluar</i></b> : ' . $l->logMasukTerakhir->check_out;
                                }
                                ?>
                            </td> 
                        </tr>

                        <?php
                        $bil++;
                    }
                }
                ?>
            </table>
        </div>

    </div>
</div> 

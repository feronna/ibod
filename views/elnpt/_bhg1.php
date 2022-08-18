<?php
use yii\bootstrap\Alert;
use app\models\elnpt\TblLppTahun;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 
$lpp = app\models\elnpt\TblMain::findOne(['lpp_id' => $lppid]);
$tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y']);

//if($lpp->PYD == Yii::$app->user->identity->ICNO) {
//// javascript for triggering the dialogs
//$js = <<< JS
//$( document ).ready(function() {
//    krajeeDialog.alert("Sila berhubung dengan PPP anda untuk membuat Subject Verification sebelum penilaian bermula.")
//});
//JS;
// 
//// register your javascript
//$this->registerJs($js);
//}

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
use kartik\dialog\Dialog;

$abc = 1;


// if($lpp->PYD == Yii::$app->user->identity->ICNO) {
//     if($lpp->PYD_sah == 1){
//         $flag = true;
//     }else{
//         $flag = false;
//     }
// }else {
//     $flag = true;
// }

if($lpp->PYD == Yii::$app->user->identity->ICNO) {
    if(!$req){
        $flag = true;
        if($lpp->PYD_sah == 1){
            $flag = true;
        }else {
            $flag = false;
        }
    }else {
        $flag = false;
    }
}else {
    $flag = true;
}

echo Dialog::widget();

?>

<?php
//Alert::widget([
//    'options' => ['class' => 'alert-warning'],
//    'body' => '<font color="black">
//                    <strong>INFO</strong><br>
//                    <p>
//                        Data untuk Blended Learning belum ditarik.
//                    </p>
//                </font>',
//]);
?>

<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <tr>
            <th class="text-center" rowspan="2">BIL.</th>
            
            <th class="text-center" rowspan="2">PPP SAH</th>
            
            <th class="text-center" rowspan="2">KOD KURSUS</th>
            <th class="text-center" rowspan="2">NAMA KURSUS</th>
            <th class="text-center" rowspan="2">BIL. PELAJAR</th>
            <th class="text-center" rowspan="2">SEKSYEN</th>
            <th class="text-center" rowspan="2">SEMESTER</th>
            <th class="text-center" rowspan="2">JAM KREDIT</th>
            <th class="text-center" colspan="1">JAM SYARAHAN
                <small><a data-toggle="tooltip" data-placement="top" title="Per Semester (Face-to-face)">
                            <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                    </a></small>
            </th>
            <th class="text-center" colspan="1">JAM TUTORIAL
            <small><a data-toggle="tooltip" data-placement="top" title="Per Semester (Face-to-face)">
                            <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                </a></small></th>
            <th class="text-center" colspan="1">JAM MAKMAL / LAIN-LAIN
            <small><a data-toggle="tooltip" data-placement="top" title="Per Semester (Face-to-face)">
                            <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                </a></small></th>
            <th class="text-center" rowspan="2">TEACHING FILE</th>
            
            <th class="text-center" rowspan="2">JENIS SYARAHAN</th>
            <th class="text-center" rowspan="2">BIL. PENGAJAR BERSAMA<br><sub>(Selain PYD)</sub></th>
            <th class="text-center" rowspan="2">BLENDED LEARNING</th>
            
            
            
        </tr>
        <tr>
            <th class="text-center">Waktu Perdana</th>
            <th class="text-center">Waktu Perdana</th>
            <th class="text-center">Waktu Perdana</th>
        </tr>
        <?php if(empty($data)) { ?>
        <tr>
            <td colspan="17">Tiada rekod dijumpai.</td>
        </tr></table></div>
        <?php }else{ 
            $form = ActiveForm::begin();
            foreach ($input as $ind => $inp) {
                if(!isset($data[$inp->ref_id])) {
                    continue;
                }
                ?>
        <tr>
            <td class="col-md-1 text-center"  style="text-align:center"><?= $abc++; ?> <?= ($data[$inp->ref_id]['DISPLAY'] == 1 && $lpp->PYD == Yii::$app->user->identity->ICNO && $lpp->PYD_sah == 0  AND (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat)
                    or ($data[$inp->ref_id]['DISPLAY'] == 1 AND $lpp->PYD == \Yii::$app->user->identity->ICNO  AND (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) ? Html::button('<i class="fa fa-edit"></i>', ['value' => Url::toRoute(['elnpt/update-pnp', 'id' => $data[$inp->ref_id]['AutoId'], 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-warning btn-xs modalButton']).Html::a('<i class="fa fa-trash"></i>', ['elnpt/delete-pnp', 'id' => $data[$inp->ref_id]['AutoId'], 'lppid' => $lpp->lpp_id], ['class' => 'btn btn-danger btn-xs']) : '' ?> <?= ($data[$inp->ref_id]['DISPLAY'] == 1 && $lpp->PYD != Yii::$app->user->identity->ICNO) ? '*' : '' ?></td>
           
            <td class="col-md-1 text-center"  style="text-align:center">
                <?= 
                ($lpp->PPP == Yii::$app->user->identity->ICNO AND (date('Y-m-d H:i:s') <= $tahun->penilaian_PPP_tamat)) ?
                    $form->field($inp, "[$ind]sah_ppp")->checkbox(['label' => null])
                        : '<strong>'.$inp->pppSah.'</strong>'; ?>
            </td>
            
            <td class="col-md-1 text-center"  style="text-align:center"><?= $data[$inp->ref_id]['SMP07_KodMP']; ?></td>
            <td class="col-md-2"><?= $data[$inp->ref_id]['NAMAKURSUS']; ?></td>
            <td class="col-md-1 text-center"  style="text-align:center"><?= $data[$inp->ref_id]['BILPELAJAR']; ?></td>
            <td class="col-md-1 text-center"  style="text-align:center"><?= $data[$inp->ref_id]['SEKSYEN']; ?></td>
            <td class="col-md-1 text-center"  style="text-align:center"><?= $data[$inp->ref_id]['SESI']; ?></td>
            <td class="col-md-1 text-center"  style="text-align:center"><?= $data[$inp->ref_id]['JAMKREDIT']; ?></td>
            <td class="col-md-1 text-center"  style="text-align:center"><?= $form->field($inp, "[$ind]waktu_perdana_s")->textInput(['style' => 'text-align:center', 'placeholder' => '0', 'disabled' => $flag])->label(false); ?></td>
            
            <td class="col-md-1 text-center"  style="text-align:center"><?= $form->field($inp, "[$ind]waktu_perdana_t")->textInput(['style' => 'text-align:center', 'placeholder' => '0', 'disabled' => $flag])->label(false); ?></td>
            
            <td class="col-md-1 text-center"  style="text-align:center"><?= $form->field($inp, "[$ind]waktu_perdana_m")->textInput(['style' => 'text-align:center', 'placeholder' => '0', 'disabled' => $flag])->label(false); ?></td>
            
            <td class="col-md-1 text-center"  style="text-align:center">
                <?=
                    ($lpp->PYD == Yii::$app->user->identity->ICNO) ?
            
                    ($form->field($inp, "[$ind]teaching_file")->label(false)->widget(Select2::classname(), [
                        'data' => ['1' => 'ADA',
                            '0.5' => 'ADA - TIDAK LENGKAP',
                            '0' => 'TIADA KURSUS'],
                        'hideSearch' => true,
                        'initValueText' => 'TIADA KURSUS',
                        'options' => [
                            'placeholder' => 'Select ...', 
                            //'class' => 'form-control col-md-7 col-xs-12',
                            //'id' => 'jenis_carian',
                            ],
                        'pluginOptions' => [
                            //'allowClear' => true
                            'disabled' => $flag
                        ],
                    ])) : $inp->teachingFileDesc;
                ?>
            </td>
            
            <td class="col-md-1 text-center"  style="text-align:center">
                <?=
                    ($lpp->PYD == Yii::$app->user->identity->ICNO) ?
            
                    ($form->field($inp, "[$ind]jenis_syarahan")->label(false)->widget(Select2::classname(), [
                        'data' => ['0' => 'HAKIKI',
                            '1' => 'BERBAYAR'],
                        'hideSearch' => true,
                        'initValueText' => '0',
                        'options' => [
//                            'placeholder' => 'Select ...', 
                            //'class' => 'form-control col-md-7 col-xs-12',
                            //'id' => 'jenis_carian',
                            ],
                        'pluginOptions' => [
                            //'allowClear' => true
                            'disabled' => $flag
                        ],
                    ])) : $inp->jenisSyarahan;
                ?>
            </td>
            <td class="col-md-1 text-center"  style="text-align:center">
                <?=
                    ($lpp->PYD == Yii::$app->user->identity->ICNO) ?
            
                    ($form->field($inp, "[$ind]bil_pengajar")->label(false)->widget(Select2::classname(), [
                        'data' => [0 => '0',
                            1 => '1',
                            2 => '2',
                            3 => '3',
                            4 => '4',
                            5 => '5',],
                        'hideSearch' => true,
                        'initValueText' => '0',
                        'options' => [
//                            'placeholder' => 'Select ...', 
                            //'class' => 'form-control col-md-7 col-xs-12',
                            //'id' => 'jenis_carian',
                            ],
                        'pluginOptions' => [
                            //'allowClear' => true
                            'disabled' => $flag
                        ],
                    ])) : $inp->bilPengajar;
                ?>
            </td>
            <td class="col-md-1 text-center"  style="text-align:center">
                <?php if(isset($data[$inp->ref_id]['status'])) { ?>
                <?= ($data[$inp->ref_id]['status'] == 1) ? '<font color="green">PASS</font>' :
                    '<font color="red">FAIL</font>' ; ?>
                <?php } else {
                    echo '<font color="orange">UNAVAILABLE</font>' ;
                }
?>
            </td>
            
                
            
            
            
        </tr>
        <?php } ?>
        </table></div>
        
        <?php if(($lpp->PYD == Yii::$app->user->identity->ICNO AND $lpp->PYD_sah == 0) AND (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat) OR
                ($lpp->PYD == \Yii::$app->user->identity->ICNO  AND (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) { ?>
        <br>
        <div style="clear: both;" class="form-group pull-right">
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary', 'value'=>'create_add', 'name'=>'submit']) ?>
            </div>    
        <?php } ?>
        
        <?php if(($lpp->PPP == Yii::$app->user->identity->ICNO AND $lpp->PPP_sah == 0 AND (date('Y-m-d H:i:s') <= $tahun->penilaian_PPP_tamat))) { ?>
        <br>
        <div style="clear: both;" class="form-group pull-right">
            <?= Html::submitButton('Sahkan', ['class' => 'btn btn-primary', 'value'=>'create_add', 'name'=>'submit']) ?>
        </div>    
        <?php } ?>
        
        <?php ActiveForm::end(); } ?>
        
        <div style="clear: both;">
            <br>
            <div class="table-responsive">
                <?= Html::img('@web/images/elnpt/bhg1.png');?>
            </div>
        </div>
    
        <div style="clear: both;"><br><hr>
            
            <dl class="dl-horizontal">
                <dt>Jenis Syarahan</dt><dd></dd>
            <dt>Hakiki</dt>
            <dd>Subjek yang tidak dibayar elaun tambahan.</dd>
            <dt>Berbayar</dt>
            <dd>Subjek yang dibayar elaun tambahan selain gaji bulanan.</dd>
            </dl>
            
            <?php if(($lpp->PPP == Yii::$app->user->identity->ICNO) OR ($lpp->PPK == Yii::$app->user->identity->ICNO)) { ?>
            <p><i>* Kursus yang ditambah secara manual oleh PYD.</i></p>
            <?php } ?>
             <?php if(($lpp->PYD == Yii::$app->user->identity->ICNO)) { ?>
            <p><i><strong>* Markah PYD hanya dapat dilihat setelah pengesahan oleh Ketua Program / PPP. <br>Selepas pengesahan dari Ketua Program / PPP, PYD hendaklah tekan butang Simpan untuk menjana markah.</strong></i></p>
        <?php } ?></div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
error_reporting(0);
?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<div class="row"> 
    <div class="x_panel">
        
        <div class="col-md-12 col-sm-3 col-xs-12"> 
                <div class="x_title">
                    <h2><strong><i class="fa fa-book"></i> Teaching and Learning</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <i>[FROM SMP & eLNPT]</i>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                    <?php if($model->icno == Yii::$app->user->getId()){?>
                    <h2 style="color:green">Filter by 'Semester / Session' Based on Current Contract {<?= $model->startdatelantik?> - <?= $model->enddatelantik?>}</h2><?php }?>
            
                    <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center" rowspan="2">No</th>
                                    <th class="text-center" rowspan="2">Course Title</th>
                                    <th class="text-center" rowspan="2">Course Code</th>
                                    <th class="text-center" rowspan="2">Semester / Session</th>
                                    <th class="text-center" rowspan="2">No. of Students</th>
                                    <th class="text-center" rowspan="2">Credits Hour</th>
                                    <th class="text-center" colspan="2">Co. Teaching</th>
                                </tr>
                                <tr class="headings">
                                    <th class="column-title text-center">Yes</th>
                                    <th class="column-title text-center">No</th>
                                </tr>
                            </thead>
                             <?php $bil1=1;
                             
                            $pnp = array_filter($model->pengajaran, function ($var) use ($model){
                            return 
                            (substr($var['SESI'], -9) > $model->sesimulakontrak || (substr($var['SESI'], -9) == $model->sesimulakontrak && substr($var['SESI'], 0,1) >= $model->semmulakontrak)
                            );
                            });
                            if ($pnp) { ?>
                                <?php foreach ($pnp as $l) {
                                    if(!$l->jamwaktu){?>
                            
                                <tr>
                                    <td class="text-center"><?= $bil1++; ?>*</td>
                                    <td class="text-center"><?= $l->NAMAKURSUS; ?></td>
                                    <td class="text-center"><?= $l->SMP07_KodMP; ?></td>
                                    <td class="text-center"><?= $l->SESI; ?></td>
                                    <td class="text-center"><?= $l->BILPELAJAR; ?></td>
                                    <td class="text-center"><?= $l->JAMKREDIT; ?></td>
                                    <td class="text-center"><input type="radio" name="smp<?=$l->AutoId?>" value="y" <?php if($l->coteaching){if($l->coteaching->coteaching === 'y'){echo "checked";}}?>></td>
                                    <td class="text-center"><input type="radio" name="smp<?=$l->AutoId?>" value="n" <?php if($l->coteaching){if($l->coteaching->coteaching === 'n'){echo "checked";}}?>></td>
                                    
                                    
                                </tr>
                                <?php }}
                                foreach ($pnp as $l) {
                                    if($l->jamwaktu){?>
                            
                                <tr>
                                    <td class="text-center"><?= $bil1++; ?>*</td>
                                    <td class="text-center"><?= $l->NAMAKURSUS; ?></td>
                                    <td class="text-center"><?= $l->SMP07_KodMP; ?></td>
                                    <td class="text-center"><?= $l->SESI; ?></td>
                                    <td class="text-center"><?= $l->BILPELAJAR; ?></td>
                                    <td class="text-center"><?= $l->JAMKREDIT; ?></td>
                                    <td class="text-center"><?= $l->jamwaktu->bil_pengajar > 0? '&#10004;':'';?></td>
                                    <td class="text-center"><?= $l->jamwaktu->bil_pengajar === 0? '&#10004;':'';?></td>
                                    
                                </tr>
                            <?php $exists = '1'; }}}?>

                                <?php 
                                if ($model->elnpt) { 
                                    foreach ($model->elnpt as $lppid){
                                        
                                        $pengajaranelnpt1 = app\models\elnpt\TblPengajaranPembelajaran::find()->where(['lpp_id' => $lppid->lpp_id])->all();
                                        
                                        $pnpe = array_filter($pengajaranelnpt1, function ($var) use ($model){
                                        return 
                                        (substr($var['sesi'], -9) > $model->sesimulakontrak || (substr($var['sesi'], -9) == $model->sesimulakontrak && substr($var['sesi'], 0,1) >= $model->semmulakontrak)
                                        );
                                        });
                                        
                                        if(!$pnpe){
                                           $pengajaranelnpt2 = app\models\elnpt\elnpt2\TblPengajaranPembelajaran::find()->where(['lpp_id' => $lppid->lpp_id])->all();
                                            
                                            foreach ($pengajaranelnpt2 as $p) {
                                                    $l = \app\models\elnpt\elnpt2\TblPnP::find()->where(['id_pnp' => $p->id])->one();
                                                    $do = \app\models\elnpt\elnpt2\TblDocuments::find()->where(['id_table' => $p->id, 'bhg_no' => 1])->one();
                                            if((substr($l->semester, -9) > $model->sesimulakontrak || (substr($l->semester, -9) == $model->sesimulakontrak && substr($l->semester, 0,1) >= $model->semmulakontrak))&& $do->verified_by){
                                                if($pnp){$cekp = array_filter($pnp, function ($var) use ($p, $l){
                                                return $var['SMP07_KodMP'] == $p->kod_kursus && $var['SESI'] == $l->semester && $var['BILPELAJAR'] == $l->bil_pelajar;
                                                }); }
                                                
                                                if(!$cekp){
                                                ?>
                                            <tr>
                                                <td class="text-center"><?= $bil1++; ?><span style="color: red">*</span></td>
                                                <td class="text-center"><?= $p->nama_kursus; ?></td>
                                                <td class="text-center"><?= $p->kod_kursus; ?></td>
                                                <td class="text-center"><?= $l->semester; ?></td>
                                                <td class="text-center"><?= $l->bil_pelajar; ?></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"><?php if($p->penglibatan == 'ADA') {echo '&#10004;';} ?></td>
                                                <td class="text-center"><?php if($p->penglibatan == 'TIADA') {echo '&#10004;';} ?></td>
                                            </tr>
                                
                                            <?php } }
                                    }
                                        }else{
                                            
                                            foreach ($pnpe1 as $l) {
                                            if($l->pppsah->sah_ppp == '1'){
                                                if($pnp){$cekp = array_filter($pnp, function ($var) use ($l){
                                                return $var['SMP07_KodMP'] == $l->kod_kursus && $var['SESI'] == $l->semester && $var['BILPELAJAR'] == $l->bil_pelajar;
                                                }); }
                                                
                                                if(!$cekp){
                                                    ?>
                                            <tr>
                                                <td class="text-center"><?= $bil1++; ?><span style="color: red">*</span></td>
                                                <td class="text-center"><?= $l->nama_kursus; ?></td>
                                                <td class="text-center"><?= $l->kod_kursus; ?></td>
                                                <td class="text-center"><?= $l->sesi; ?></td>
                                                <td class="text-center"><?= $l->bil_pelajar; ?></td>
                                                <td class="text-center"><?= $l->jam_kredit; ?></td>
                                                <td class="text-center"><?php if($l->pppsah->bil_pengajar > 0) {echo '&#10004;';} ?></td>
                                                <td class="text-center"><?php if($l->pppsah->bil_pengajar == '0') {echo '&#10004;';} ?></td>
                                            </tr>

                                            <?php } }
                                                }
                                            
                                        }
                                }
                                }?>
                        </table>
                        <ul>
                            <a>* : From SMP</a><br>
                <a><span style="color: red">*</span> : Verified P&P From LNPT (Manually)</a>
            </ul>
                    </div>
        </div>
        <?php ?>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 
                    ]) ?>
            </div>
        </div>
        <?php  ActiveForm::end();?>
    </div>
    </div>






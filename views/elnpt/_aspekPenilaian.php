<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
?>

<?php Pjax::begin(); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Aspek Penilaian</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <p>Note : Sila tekan butang <?= Html::a("<i class='fa fa-refresh' aria-hidden='true'></i>
                        ", ['elnpt/update-markah-pyd', 'lppid' => $lppid, 'bhg_no' => $bhgian->id], ['class' => 'btn btn-xs btn-default']);?> untuk <i>update</i> markah PYD yang terkini.</p>
                    <?= Html::beginForm(['/elnpt/semak-lpp?lppid='.$lppid.'&bhg_no='.$bhgian->id], 'post', []) ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th class="text-center">Aspek Penilaian</th>
                                <?php if($bhgian->id != 9) { ?>
                                
                                <th class="text-center col-md-2">Markah PYD <sub>(100%)</sub></th>
                                <?php } ?>
                                <th class="text-center col-md-2">Markah PPP <sub>(100%)</sub></th>
                                <th class="text-center col-md-2">Markah PPK <sub>(100%)</sub></th>
                                <?php if($bhgian->id == 9) { ?>
                                <th class="text-center col-md-2">Markah PEER <sub>(100%)</sub></th>
                                <?php } ?>
                            </tr>
                            <?php foreach ($mrkh_bhg as $ind => $all) { ?>
                            <tr>
                                <th><?= $all['aspek']; ?> <?= ($bhgian->id != 9) ? Html::hiddenInput("aspek_id[$ind]", $all['id']) : ''; ?></th>
                                <?php if($bhgian->id != 9) { ?>
                                
                                <th class="col-md-1 text-center"  style="text-align:center"><?= $all['markah_pyd']; ?> <sub><?= ' / '.$all['pemberat']; ?></sub> </th>
                                <?php } ?>
                                <th class="col-md-2 text-center">
                                    <div class="input-group col-lg-10 col-lg-offset-1 text-center">
                                        <?php if($bhgian->id != 9) { ?>
                                        <?= ($lpp->PPP == Yii::$app->user->identity->ICNO && $lpp->PYD_sah == 1) ? Html::textInput("markah_ppp[$ind]", is_null($all['markah_ppp']) ? '0.0' : $all['markah_ppp'], ['type' => 'number', 'min' => 0, 'max' => $all['pemberat'], 'step' => '0.01', 'class' => 'form-control input-sm', 'placeholder' => '0.0', 'style' => 'text-align:center; width:75%', ]) : ( $lpp->PPK == Yii::$app->user->identity->ICNO ? $all['markah_ppp'] : 'PPP') ?> <?=  '<sub>/ '.$all['pemberat'].'</sub>' ?>
                                        <?php }else { ?>
                                        <?= is_null($all['markah_ppp']) ? '0.00' : $all['markah_ppp']; ?> <?=  '<sub>/ '.$all['pemberat'].'</sub>' ?>
                                        <?php } ?>
                                    </div>
                                </th>
                                <th class="col-md-2 text-center"  style="text-align:center">
                                    <div class="input-group col-lg-10 col-lg-offset-1 text-center">
                                        <?php if($bhgian->id != 9) { ?>
                                        <?= ($lpp->PPK == Yii::$app->user->identity->ICNO  && $lpp->PPP_sah == 1) ? Html::textInput("markah_ppk[$ind]", is_null($all['markah_ppk']) ? '0.0' : $all['markah_ppk'], ['type' => 'number', 'min' => 0, 'max' => $all['pemberat'], 'step' => '0.01', 'class' => 'form-control input-sm', 'placeholder' => '0.0', 'style' => 'text-align:center; width:75%', ]) : 'PPK' ?> <?= '<sub>/ '.$all['pemberat'].'</sub>' ?>
                                        <?php }else { ?>
                                        <?= is_null($all['markah_ppk']) ? '0.00' : $all['markah_ppk']; ?> <?=  '<sub>/ '.$all['pemberat'].'</sub>' ?>
                                        <?php } ?>
                                    </div>
                                </th>
                                <?php if($bhgian->id == 9) { ?>
                                <th class="col-md-2 text-center"  style="text-align:center">
                                    <div class="input-group col-lg-10 col-lg-offset-1 text-center">
                                        <?php if($bhgian->id != 9) { ?>
                                        <?= ($lpp->PEER == Yii::$app->user->identity->ICNO  && $lpp->PPP_sah == 1) ? Html::textInput("markah_peer[$ind]", is_null($all['markah_peer']) ? '0.0' : $all['markah_peer'], ['type' => 'number', 'min' => 0, 'max' => $all['pemberat'], 'step' => '0.01', 'class' => 'form-control input-sm', 'placeholder' => '0.0', 'style' => 'text-align:center; width:75%', ]) : 'PEER' ?> <?= '<sub>/ '.$all['pemberat'].'</sub>' ?>
                                        <?php }else { ?>
                                        <?= is_null($all['markah_peer']) ? '0.00' : $all['markah_peer']; ?> <?=  '<sub>/ '.$all['pemberat'].'</sub>' ?>
                                        <?php } ?>
                                    </div>
                                </th>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <?php if($bhgian->id != 9) { ?>
                    <div class="form-group pull-right">
                        <?= (($lpp->PPP == Yii::$app->user->identity->ICNO  && $lpp->PYD_sah == 1) or 
                            ($lpp->PPK == Yii::$app->user->identity->ICNO  && $lpp->PPP_sah == 1) or 
                            ($lpp->PEER == Yii::$app->user->identity->ICNO  && $lpp->PYD_sah == 1)) ? 
                        Html::submitButton('Submit', ['class' => 'btn btn-primary']) : ''; ?>
                    </div>
                    <?php } ?>
                    <?= Html::endForm(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php Pjax::end(); ?>
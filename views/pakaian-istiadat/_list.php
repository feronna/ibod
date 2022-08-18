<?php
use yii\helpers\Html;
 
?>

<table class="table table-striped table-bordered jambo_table" >
                        <thead>
                            <th scope="col" colspan=17" width="30%" class="headings"><center>PAKAIAN ISTIADAT<br>
                            <tr class="headings">
                            <th class="text-center">Bil</th>
                            <th class="text-center">Nama Pemohon</th>
                            <th class="text-center">Tarik Mohon</th> 
                            <th class="text-center">Status Ketua BSM</th>
                            <th class="text-center">Dokumen Sokongan</th>       
                            <th class="text-center">Salinan Surat</th>     
                            <th class="text-center">Tindakan</th>
                            
                            </tr>
                        </thead>
                    <?php if ($model) { ?>
                        <?php foreach ($model as $list) { ?>
                            <tr>
                                 <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                                <td class="text-center"><?php echo $list->kakitangan->CONm ?>    </td>
                                <td class="text-center"><?php echo $list->entrydate; ?> </td> 
                                 <?php if ($list->status_kj == 'DILULUSKAN' && $list->entry_type != 2) { ?>
                                    <td class="text-center"><?php echo $list->statuspp; ?></td>
                                <?php } else { ?><td class="text-center"><?php echo $list->statuskj; ?></td>
                                <?php } ?>  
                                    
                                <td class="text-left">
                                   <?php if($list->isActive2 == '1'){?>
                                   <?= \yii\helpers\Html::a(' RESIT', Yii::$app->FileManager->DisplayFile($list->dokumen_sokongan), ['class'=>'fa fa-download', 'target' => '_blank'])?><br> 
                                   <?= \yii\helpers\Html::a(' DOKUMEN SOKONGAN', Yii::$app->FileManager->DisplayFile($list->dokumen_sokongan2), ['class'=>'fa fa-download', 'target' => '_blank'])?>
                                </td>  <?php }?>
                                
                                <?php if ($list->jeniskemudahan == '10') { ?>
                                <td style=" ">
                                 <?php if($list->isActive2 == '1' && $list->jeniskemudahan == '10'){?>
                                <div class="container" align="center">
                                <?= \yii\helpers\Html::a(' KELULUSAN KETUA BSM', ['pakaian-istiadat/slulus', 'id' => $list->id], ['class'=>'fa fa-download', 'target' => '_blank'])?></td>
                                <?php }?>   
                                <?php }?>
                                
                                    <?php if ($list->stat_bendahari == 'MENUNGGU TINDAKAN' || $list->stat_bendahari == 'DALAM PROSES BAYARAN') { ?>
                                <td class="text-center"><?= Html::a('<i class="fa fa-eye">', ["pakaian-istiadat/tindakan_bendahari", 'id' => $list->id]); ?></td>
                                <?php } else { ?><td class="text-center"><?= Html::a('<i class="fa fa-eye">', ["pakaian-istiadat/tindakan_bendahari", 'id' => $list->id]); ?></td>
                                <?php } ?>
                                 
                                
                                <?php }?> 
                            </tr>
                         
                    <?php } else { ?> 
                        <tr>
                            <td colspan="9" class="align-center text-center"><i>Belum ada Tindakan lagi</i></td>
                        </tr>
                    <?php } ?>
                </table>
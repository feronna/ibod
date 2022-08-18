<?php
use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\helpers\Url;

// use dosamigos\datepicker\DatePicker;
// use yii\web\UploadedFile;
// use yii\helpers\ArrayHelper;

?>


<div class="row"> 
        <div class="col-xs-12 col-md-12 col-lg-12" >

    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Permohonan Baharu</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center" >BIL </th>
<!--                        <th class="column-title text-center">JENIS PERMOHONAN</th>-->
                        <th class="column-title text-center">TINDAKAN</th>
                        <th class="column-title text-center">TARIKH PERMOHONAN</th>
                        <th class="column-title text-center">TARIKH DIPERAKUKAN KETUA JABATAN</th>
                        <th class="column-title text-center">TARIKH DILULUSKAN BSM</th>
                        <th class="column-title text-center">STATUS</th>
                        <th class="column-title text-center">KEPUTUSAN PERMOHONAN</th>
                        <th class="column-title text-center">SALINAN SURAT</th>
                        <th class="column-title text-center">TEMPAH TIKET PENERBANGAN</th>
                       
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $bil=1;
                    if($status){
                    foreach ($status as $statuss) { 
                        ?>
                        <tr>
                            <td style="width:10%;"><?= $bil++; ?></td>
                            <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['cutibelajar/lihat-permohonan', "id"=> $statuss->id], ['class' => 'btn btn-default btn-xs']) ?></td>  
<!--                            <td style="width:10%;"><?= $statuss->borang->alt; ?></td>-->
                            <td style="width:30%;"><?= $statuss->tarikh_m; ?></td>
                            <td style="width:30%;"><?= $statuss->app_date; ?></td>
                            <td style="width:30%;"><?= $statuss->ver_date;?></td>
                            <td style="width:30%;"><?= $statuss->statuss; ?></td>
                            <td style="width:30%;"><?= $statuss->ulasan_bsm; ?></td>
                            <td style="width:40%;">
                                <?php if($statuss->status == 'LULUS'){?>
                                <div class="container" align="center">
                                    <button type="button" style="border:none; background-color: transparent;" data-toggle="collapse" data-target='#demo<?php echo $statuss->id?>'><i class="fa fa-chevron-up"></i></button>
                                <div id='demo<?php echo $statuss->id?>' class="collapse" style="text-align: left; padding-left: 10%;">
                                <?php if($statuss->dokumen->dokumen){ ?>
                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($statuss->dokumen->dokumen), true); ?>" target="_blank" ><i class="fa fa-download"></i> <?= ucwords(strtolower($statuss->dokumen->tajuk))?></a><br>
                                <?php }
                                
                                ?><br>
                                </div>
                              </div>
                                  </td>
                            <?php }?>

                                  <td>
                                      <?php if($statuss->status == 'LULUS')
                                      {
                                      echo Html::a('Mohon', ['tiketpenerbangan/borang-permohonan'], ['class' => 'btn btn-primary btn-xs', 'target'=>'_blank']); }?>
                                 
                                  </td>
                           
                          
                        </tr>
                    <?php }} else{?>
                     
                   
                    <tr>
                        <td colspan="8" class="text-center"><i>Tiada Rekod Ditemui</i></td>                     
                    </tr>
                  <?php  
                } ?>
                </tbody>
            </table>
            
        </div>
        </div>
    </div>
</div>
</div>




<div class="row"> 
        <div class="col-xs-12 col-md-12 col-lg-12" >

   
        </div></div>
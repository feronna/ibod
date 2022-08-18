<?php
use yii\helpers\Html;
use yii\helpers\Url;
error_reporting(0);
?>
<style>
    .html-marquee {
        height: auto;
        /*background-color:#ffff33;*/
        /*font-family:Cursive;*/
        font-size:14px;
        color:red;
        /*border-width:4;*/
        /*border-style:dotted;*/
        /*border-color:#ff0000;*/
    }
</style>
<?= $this->render('/ln/_topmenu') ?>


<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Lampiran A</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">BIL.</th>
                        <th class="column-title text-center">NAMA</th>
                        <th class="column-title text-center">TARIKH MOHON</th>
                        <th class="column-title text-center">STATUS LN-1</th>
                        <th class="column-title text-center">TINDAKAN</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $bil=1;
                    if($model){
                    foreach ($model as $m) { 
                        ?>
                        <tr>
                            <td style="width:10%;"><?= $bil++; ?></td>
                            <td style="width:30%;"><?= $m->kakitangan->CONm; ?></td>
                            <td style="width:20%;"><?= $m->entrydate; ?></td>
                            <td style="width:20%;"><?= $m->statusss; ?></td>
                            <td align= 'center'>
                            <?php if($m->lampiran_a != NULL){?>
                                  <?php if($m->lampiran_a){ ?>
                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($m->lampiran_a), true); ?>" target="_blank" ><i class="fa fa-download">&nbsp;<u>Muat Turun Lampiran A</u></i> </a><br>
                                    <?php } ?>  
                                    <?php }else{
                            echo "Lampiran A Belum Dihantar";
                            }?>
                            </td> 
                        </tr>
                    <?php }} ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>
</div>




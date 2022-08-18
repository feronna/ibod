<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\hronline\GredJawatan;
use app\models\mohonjawatan\TblOpenpos;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\helpers\Url;
use app\widgets\TopMenuWidget;
/* @var $this yii\web\View */
/* @var $searchModel app\models\mohonjawatan\TblOpenposSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Tbl Openpos';
//$this->params['breadcrumbs'][] = $this->title;
?>
<?= TopMenuWidget::widget(['top_menu' => [18,44,45,51], 'vars' => [
    ['label' => ''],
//    ['label' => app\models\kontrak\Kontrak::totalPending(Yii::$app->user->getId())]
]]); ?>

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
<marquee class="html-marquee" direction="left" behavior="scroll" scrollamount="8">
    <p>
        1. Untuk maklumat lanjut berkaitan permohonan jawatan, sila berhubung dengan Puan NORFIRDAYU BINTI IBRAHIM di talian 088-320000 Samb. 1523 / FREDERICK ASSIN di talian 088-320000 Samb. 1088.
        
    </p>
</marquee>
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Permohonan Jawatan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
         <?php if (!$visible) { ?>
       
         <?php }else { ?>
         &nbsp <a href="<?= Url::to(['uploadlist']); ?>" class="btn btn-primary btn-md rounded">
            <span class="icon"><i class="fa fa-plus"></i>&nbsp;</span><strong>Muat Naik Dokumen</strong></a>
        <a href="<?= Url::to(['indexs']); ?>" class="btn btn-primary btn-md rounded">
            <strong>Dokumen dimuat Naik </strong></a>
         <?php } ?>
        <div class="x_content">
            <div class="table-responsive">

                <table class="table table-striped jambo_table">
                    <thead>
                        <tr>
                            <th class="text-center">Bil</th>
                            <th class="text-center">Nama Kakitangan</th>
                            <th class="text-center">Jawatan Dipohon</th>
                            <th class="text-center">Unit Ditetapkan</th>
                            <th class="text-center">Tarikh Permohonan</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Tindakan</th>

                        </tr>
                    </thead>
                    <?php if ($model) { ?>
                        <?php foreach ($model as $v_list) { ?>
                            <tr>
                                <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                                <td class="text-center"><?php echo $v_list->kakitangan->CONm; ?></td>
                                <td class="text-justify"><?php echo $v_list->gredjawatan->fname; ?></td>
                                <td class="text-center"><?php echo $v_list->unit; ?></td>
                                <td class="text-center"><?php echo $v_list->tarikhmohon; ?></td>
                                <?php if ($v_list->status == 'VERIFIED') { ?>
                                    <td class="text-center"><?php echo $v_list->statusLabel; ?></td>
                                <?php } else { ?><td class="text-center"><?php echo $v_list->statuskj; ?></td>
                                <?php } ?>
                                <?php if ($v_list->status_kj == 'PINDAAN' || $v_list->status_kj == 'DRAFT') { ?>
                                    <td class="text-center"><?= Html::a('<i class="fa fa-edit">', ["openpos/updatepermohonan", 'id' => $v_list->id]); ?></td>
                                <?php } else { ?><td class="text-center">  <?php } ?>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="3" class="align-center text-center"><i>Belum ada Tindakan lagi</i></td>
                        </tr>
                    <?php } ?>
                </table>
                <ul>
                    <li><span class="label label-warning">Baru</span> : Permohonan Baru</li>
                    <li><span class="label label-default">DRAF</span> : Permohonan Hanya Disimpan Sebagai Draf</li>
                    <li><span class="label label-success">DIPERAKUI</span> : Permohonan Telah Diluluskan Oleh Ketua Jabatan</li>  
                    <li><span class="label label-primary">DISAHKAN</span> : Permohonan Telah Diluluskan Oleh Pengawai Perjawatan</li>
                    <li><span class="label label-danger">TIDAK DILULUSKAN</span> : Permohonan Tidak Diluluskan</li>

                </ul>
            </div>
        </div>
    </div>
</div>

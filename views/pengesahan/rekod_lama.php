<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\export\ExportMenu;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\pengesahan\PengesahanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
 error_reporting(0); 
?>

<?= $this->render('/pengesahan/_topmenu') ?>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Jumlah Pengesahan Dalam Perkhidmatan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a></li>-->
            </ul>
            <div class="clearfix"></div>
            </div>
            
           <div class="x_content"> 
            <table class="table table-sm table-bordered jambo_table table-striped text-center">
                <tr> 
                    <td width="40%" align="left">JUMLAH PERMOHONAN KESELURUHAN</td>
                    <td width="40%"><span class="required" style="color:red;"> <b><?= $jumlah_permohonan_pentadbiran; ?></b></span>
                </tr>

                <tr> 
                    <td width="40%" align="left">JUMLAH PERMOHONAN DILULUSKAN [PENTADBIRAN]</td>
                    <td width="40%"><span class="required" style="color:red;"> <b><?= $jumlah_permohonan_pentadbiran_berjaya; ?></b></span>
                </tr>

                <tr> 
                    <td width="40%" align="left">JUMLAH PERMOHONAN DITOLAK [PENTADBIRAN]</td>
                    <td width="40%"><span class="required" style="color:red;"> <b><?= $jumlah_permohonan_pentadbiran_gagal; ?></b></span>
                </tr>
                
                <tr> 
                    <td width="40%" align="left">JUMLAH PERMOHONAN DILULUSKAN [AKADEMIK]</td>
                    <td width="40%"><span class="required" style="color:red;"> <b><?= $jumlah_permohonan_akademik_berjaya; ?></b></span>
                </tr>

                <tr> 
                    <td width="40%" align="left">JUMLAH PERMOHONAN DITOLAK [AKADEMIK]</td>
                    <td width="40%"><span class="required" style="color:red;"> <b><?= $jumlah_permohonan_akademik_gagal; ?></b></span>
                </tr>

            </table>
            </div>
        </div>
</div>
</div>

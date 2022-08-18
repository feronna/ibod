<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\hronline\GredJawatan;
use app\models\mohonjawatan\TblOpenpos;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\mohonjawatan\TblOpenposSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Tbl Openpos';
//$this->params['breadcrumbs'][] = $this->title;
?>
<?php echo $this->render('/openpos/_menu'); ?>

<div class="col-md-12"> 
    <div class="x_panel">

        <div class="x_content">
            <table class="table table-striped jambo_table">
                <thead>
                    <tr>
                        <th class="text-center">Bil</th>
                        <th class="text-center">Nama Kakitangan</th>
                        <th class="text-center">Jawatan Dipohon</th>
                        <th class="text-center">Unit Ditetapkan</th>
                        <th class="text-center">Tarikh Permohonan</th>
                        <th class="text-center">Status</th>

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
                            <td class="text-center"><?php echo $v_list->statusLabel; ?></td>


                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="3" class="align-center text-center"><i>Belum ada Tindakan lagi</i></td>
                    </tr>
                <?php } ?>
            </table>
            <ul>
                <li><span class="label label-primary">DISAHKAN</span> : Permohonan Telah Diluluskan Oleh Pengawai Perjawatan</li>
                <li><span class="label label-danger">TIDAK DILULUSKAN</span> : Permohonan Tidak Diluluskan</li>

            </ul>
        </div>
    </div>
</div>


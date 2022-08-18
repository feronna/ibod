<?php //
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
//use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\latihan\IdpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'MyIDP';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
//            ['class' => 'yii\grid\SerialColumn'],

            'tahun',
            'v_mata_minima',
            'v_mata_terkumpul',
            'v_matamin_teras_uni',
            'v_idp_teras_uni',
            'v_matamin_teras_skim',
            'v_idp_teras_skim',
            'v_matamin_elektif',
            'v_idp_elektif',

//           ['class' => 'yii\grid\ActionColumn'],
        ];

//echo $this->render('/idp/layouts/_menu');
/* Menu */
echo \app\widgets\TopMenuWidget::widget(['top_menu' => [59, 64, 68], 'vars' => [
    ['label' => ''],
]]);
?>
<div class="x_panel">
    <div class="x_title">
        <h2><?= Html::encode($this->title) ?></h2>
        <div class="clearfix"></div>
    </div> <!-- closed div class x_title -->
    <div class="well">
        <b><?= $model->v_co_name ?>
        <br><?= $model->v_co_umsper ?>
        <br><?= $model->v_co_jwtn ?>&nbsp;(<?= $model->v_co_gred ?>)
        <br><?= ucwords(strtoupper($model->v_co_dept_fn)) ?>,&nbsp; <?= $model->v_co_campus ?>
        <br>TEMPOH PERKHIDMATAN DI GRED SEMASA : <?= $model->tempohKhidmatGredSemasa; ?>
        <br>TAHAP : <?php echo $model->tahapKhidmat; ?>
        <br>PEGAWAI PELULUS KURSUS JFPIU: <?= $model->pegawaiPelulus; ?>
        </b>
    </div> <!-- closed div class well -->
    <div class="x_content">
        <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead>
                    <tr class="headings" >
                        <th class="column-title text-center">Tahun </th>
                        <th class="column-title text-center">Mata IDP Minimum Kumpulan</th>
                        <th class="column-title text-center">Mata IDP Dibawa Ke Hadapan</th>
                        <th class="column-title text-center" colspan="2">Wajib Teras Universiti</th>
                        <th class="column-title text-center" colspan="2">Wajib Teras Skim</th>
                        <th class="column-title text-center" colspan="2">Elektif</th>
                        <th class="column-title text-center">Jumlah Mata IDP Semasa</th>
                        <th class="column-title text-center">Jumlah Mata IDP Yang Diambil kira</th>
                        <th class="column-title text-center">Sumbangan Kepada Markah LNPT (8%)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $model->tahun ?></td>
                        <td><?= $model->v_mata_minima ?></td>
                        <td><?= $model->v_mata_terkumpul ?></td>
                        <td><?= $model->v_matamin_teras_uni ?></td>
                        <td><?= $model->v_idp_teras_uni ?></td>
                        <td><?= $model->v_matamin_teras_skim ?></td>
                        <td><?= $model->v_idp_teras_skim ?></td>
                        <td><?= $model->v_matamin_elektif ?></td>
                        <td><?= $model->v_cf_elektif ?></td>
                    </tr>
                </tbody>     
            </table>
<!--            <ul>
                <li><span class="label label-warning">Dalam Tindakan KP</span> : Menunggu persetujuan dari Ketua Pentadbiran</li>
                <li><span class="label label-info">Dalam Tindakan KJ</span> : Menunggu perakuan dari Ketua Jabatan</li>
                <li><span class="label label-primary">Dalam Tindakan BSM</span> : Menunggu kelulusan dari BSM</li>
                <li><span class="label label-success">Berjaya</span> : Diluluskan</li> 
                <li><span class="label label-danger">Ditolak</span> : Tidak Diluluskan</li>
            </ul>-->
        </div>
        </div>
</div> <!-- closed div class x_panel -->
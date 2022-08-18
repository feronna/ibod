<?php
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

//            ['class' => 'yii\grid\ActionColumn'],
        ];

echo $this->render('/idp/layouts/_menu');
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
        <br>TAHAP : <?php echo $model->tahap2; ?>
        <br>PEGAWAI PELULUS KURSUS JFPIU: <?= $model->pegawaiPelulus; ?>
        </b>
    </div> <!-- closed div class well -->
    <div class="table-responsive">
    
    <?= 
//        GridView::widget([
//        'dataProvider' => $dataProvider,
//        'layout' => '{items}{pager}',
//        //'filterModel' => $searchModel,
//        'columns' => $gridColumns,
//        'options' => ['class' => 'table table-condensed'],    
//        //'pjax'=>true,
//        //'pjaxSettings'=>[
//        //'neverTimeout'=>true,
//        //'beforeGrid'=>'My fancy content before.',
//        //'afterGrid'=>'My fancy content after.',
//        //],
//        //'resizableColumns'=>true,
//        //'resizeStorageKey'=>Yii::$app->user->id . '-' . date("m"),
//        
////        'columns' => [
//////            ['class' => 'yii\grid\SerialColumn'],
////
////            'tahun',
////            'v_mata_minima',
////            'v_mata_terkumpul',
////            'v_matamin_teras_uni',
////            'v_idp_teras_uni',
////            'v_matamin_teras_skim',
////            'v_idp_teras_skim',
////            'v_matamin_elektif',
////            'v_idp_elektif',
////
//////            ['class' => 'yii\grid\ActionColumn'],
////        ],
//        //'responsive'=>true,
//        //'hover'=>true
//    ]); 
        ?>   
</div>
    <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Permohonan Pelantikan Semula Kontrak</strong></h2>
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
                        <th class="column-title text-center">BIL </th>
                        <th class="column-title text-center">TARIKH PERMOHONAN</th>
                        <th class="column-title text-center">STATUS</th>
                       
                        <th class="column-title text-center">TINDAKAN</th>
                    </tr>
                </thead>
            </table>
            <ul>
                <li><span class="label label-warning">Dalam Tindakan KP</span> : Menunggu persetujuan dari Ketua Pentadbiran</li>
                <li><span class="label label-info">Dalam Tindakan KJ</span> : Menunggu perakuan dari Ketua Jabatan</li>
                <li><span class="label label-primary">Dalam Tindakan BSM</span> : Menunggu kelulusan dari BSM</li>
                <li><span class="label label-success">Berjaya</span> : Diluluskan</li> 
                <li><span class="label label-danger">Ditolak</span> : Tidak Diluluskan</li>
            </ul>
        </div>
        </div>
    </div>
</div>
</div> <!-- closed div class x_panel -->

<?php
                    $bil = 1;
                    ?>
                    
                    <table class="table table-striped jambo_table">
                                        <thead>
                                            <tr>
                                                <th class="text-left" style="text-align:center">Bil</th>
<!--                                                <th class="text-left">Kod Latihan</th>-->
                                                <th class="text-left">Tajuk Latihan</th>
                                                <th class="text-left">Penggubal Modul</th>
                                                <th class="text-left">Tahun Ditawarkan</th>
                                                <th class="text-left">Kategori Jawatan</th>
                                                <th class="text-left">Kampus</th>
                                                <th class="text-left">Tindakan</th>   
                                            </tr>
                                            </tr>
                                        </thead>
                                        <tbody>
                           <?php    if ($senaraiLatihan) {
                                        foreach ($senaraiLatihan as $lat2) {
                                            ?>
                                            <tr>
                                            <td class="text-left" style="text-align:center"><?= $bil++; ?></td>
<!--                                            <td class="text-left"><?= $lat2->kursus_id ?></td>-->
                                            <td class="text-left"><?= ucwords(strtolower($lat2->tajuk_kursus)) ?></td>
                                            <td class="text-left"><?= ucwords(strtolower($lat2->pemilik_modul)) ?></td>
                                            <td class="text-left"><?= ucwords(strtolower($lat2->tahun_ditawarkan)) ?></td>
                                            <td class="text-left"><?= ucwords(strtolower($lat2->kategoriJawatan->kategoriJawatanName)) ?></td>
                                            <td class="text-left"><?= ucwords(strtolower($lat2->campusName->campus_name)) ?></td>
                                            <td class="text-center">
                                                    <?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['selenggarakod/'.$lat2->kursus_id]) ?>
                                                  | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['selenggarakod/'.$lat2->kursus_id]) ?>
                                                  | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['deletekod', 'id' => $lat2->kursus_id],
                                                          ['data' => ['confirm' => 'Anda ingin Membuang Rekod ini?', 'method' => 'post', ],]) ?> 
                                            </td> 
                                            </tr>
                                            <?php
                                        }
                                    }else { ?>
                                    <tr>
                                        <td colspan="3" class="align-center text-left"><i>Dalam proses.</i></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>

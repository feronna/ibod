<?php

//use yii\helpers\Html;
//use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel app\models\Pergigian\PergigianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
error_reporting(0);
?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1261, 1264, 1291], 'vars' => []]); ?>

<?= $this->render('_inquiry') ?>
<div class="pergigian-index">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-list"></i><strong> Senarai Tuntutan Rawatan Pergigian / Pembelian Kaca Mata</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
            </ul>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered jambo_table">
                    <thead>
                        <tr class="headings">
                            <th class="column-title">BIL </th>
                            <th class="column-title">NAMA KLINIK / NAMA KEDAI KACA MATA</th>
                            <th class="column-title text_center">TARIKH RAWATAN / PEMBELIAN</th>
                            <th class="column-title text_center">JUMLAH TUNTUTAN</th>
                            <th class="column-title text-center">STATUS</th>
                            <th class="column-title text-center">TINDAKAN</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($model) { ?>
                            <?php foreach ($model as $models) { ?>
                                <tr>
                                    <td><?= $bil++; ?></td>
                                    <td><?php if ($models->jenis_tuntutan_id == 1) {
                                            if ($models->klinik_gigi_id == 174) {
                                                echo $models->lain;
                                            } else {
                                                echo $models->klinikname;
                                            }
                                        } else {
                                            echo $models->kacamata;
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center"><?= Yii::$app->formatter->asDate($models->used_dt, 'php:d M Y'); ?></td>
                                    <td class="text-center"><?= Yii::$app->formatter->asCurrency($models->jumlah_tuntutan, 'RM '); ?></td>
                                    <td class="text-center"><?php echo $models->statusK; ?></td>
                                    <td class="text-center"><?php
                                                            if ($models->status === 'DILULUSKAN' && $models->id_status === 0) {
                                                                echo \yii\helpers\Html::a(' Borang Tuntutan', ['pergigian/borang-tuntutan', 'id' => $models->tuntutan_gigi_id], ['class' => 'fa fa-download', 'target' => '_blank']);
                                                            } else {
                                                                echo '';
                                                            }
                                                            ?> </td>

                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="12" class="align-center text-center"><i>Belum ada tuntutan</i></td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
                <ul>
                    <li><span class="label label-warning">BARU</span> : Tuntutan Baru</li>
                    <li><span class="label label-primary">DISEMAK</span> : Tuntutan Telah Disemak</li>
                    <li><span class="label label-success">DILULUSKAN</span> : Tuntutan Telah Diluluskan</li>
                    <li><span class="label label-default">ARAHAN BAYARAN KEPADA BENDAHARI</span> : Menunggu Tindakan Dari Bendahari</li>
                    <li><span class="label label-danger">DITOLAK</span> : Tidak Diluluskan</li>

                </ul>
            </div>
        </div>
    </div>
</div>
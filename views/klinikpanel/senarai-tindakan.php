<?php

use yii\helpers\Html;
//use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel app\models\Pergigian\PergigianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
// error_reporting(0);
?>

<div class="col-md-12 col-xs-12">
</div>

<div class="col-md-12 col-xs-12">
    <div class="x_panel">
        <div class="x_content">
            <p>
                <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?>
            </p>
        </div>
        <div class="x_title">
            <h2><i class="fa fa-list"></i><strong> Senarai Menunggu Tindakan</strong></h2>
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
                            <th class="column-title">NAMA KAKITANGAN </th>
                            <th class="column-title">PERMOHONAN KALI</th>
                            <th class="column-title">TARIKH MOHON </th>
                            <th class="column-title">JUMLAH MOHON</th>
                            <th class="column-title">BAKI PERUNTUKAN</th>
                            <th class="column-title">STATUS PERMOHONAN</th>
                            <th class="column-title">TINDAKAN</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($model) { ?>
                            <?php foreach ($model as $models) { ?>
                                <tr>
                                    <td><?= $bil++; ?></td>
                                    <td><?php echo $models->kakitangan->kakitangan->CONm; ?> </td>
                                    <td><?php if ($models->entry_id == 1) {
                                            echo 'PERTAMA';
                                        } else {
                                            echo 'KEDUA';
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center"><?= $models->entry_dt; ?></td>
                                    <td class="text-center"><?= Yii::$app->formatter->asCurrency($models->jumlah_mohon, 'RM '); ?></td>
                                    <td class="text-center"><?= Yii::$app->formatter->asCurrency($models->kakitangan->current_balance, 'RM '); ?></td>
                                    <td class="text-center"><?php echo $models->statusS; ?></td>

                                    <td class="text-center">
                                        <?php if ($models->status == 0) {
                                            echo Html::a('<span class="fa fa-eye"></span>', ['klinikpanel/papar-peraku', 'id' => $models->id]);
                                        } else if ($models->status == 1) {
                                            echo Html::a('<span class="fa fa-eye"></span>', ['klinikpanel/papar-penyemak', 'id' => $models->id]);
                                        } else if ($models->status == 2) {
                                            echo Html::a('<span class="fa fa-eye"></span>', ['klinikpanel/papar-perakubsm', 'id' => $models->id]);
                                        } else if ($models->status == 5) {
                                            echo Html::a('<span class="fa fa-eye"></span>', ['klinikpanel/papar-pendaftar', 'id' => $models->id]);
                                        }
                                        ?></td>




                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="12" class="align-center text-center"><i>Belum ada permohonan</i></td>
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
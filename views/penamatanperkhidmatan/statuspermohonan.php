<?php
use yii\helpers\Html;

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

<?= $this->render('_topmenu') ?>
<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Permohonan Penamatan Perkhidmatan</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">BIL </th>
                        <th class="column-title text-center">JENIS PENAMATAN</th>
                        <th class="column-title text-center">TARIKH TERAKHIR BEKERJA</th>
                        <th class="column-title text-center">TARIKH PERMOHONAN</th>
                        <th class="column-title text-center">STATUS BENDAHARI</th>
                        <th class="column-title text-center">STATUS PERPUSTAKAAN</th>
                        <th class="column-title text-center">STATUS JTMK</th>
                        <th class="column-title text-center">STATUS PPUU</th>
                        <?= $model->job_category !=1? '':'<th class="column-title text-center">STATUS PPPI</th>'?>
                        <th class="column-title text-center">STATUS JFPIU</th>
                        <th class="column-title text-center">STATUS BSM</th>
                    </tr>
                </thead>
                <tbody>
                   <?php 
                    $bil=1;
                    if($model){
                    foreach ($model as $model) { 
                        ?>
                        <tr>
                            <td><?= $bil++; ?></td>
                            <td><?= $model->jenisPenamatan->jenis; ?></td>
                            <td><?= $model->tarikh_terakhirbekerja; ?></td>
                            <td><?= $model->tarikh_mohon; ?></td>
                            <td><?php
                            echo $model->status_bn==1? Html::button($model->statusbn.'<br><a class="fa fa-hand-o-up"></a>', ['id' => 'modalButton', 'value' => 'lihatbelumselesai?id='.$model->id.'&dept_id=8&tarikh='.$model->tarikhbn.'','style'=>'background-color: transparent; 
                                    border: none;', 'class' => 'mapBtn'])
                                    : $model->statusbn; ?></td>
                            <td><?php echo $model->status_perpustakaan==1? Html::button($model->statusperpustakaan.'<br><a class="fa fa-hand-o-up"></a>', ['id' => 'modalButton', 'value' => 'lihatbelumselesai?id='.$model->id.'&dept_id=13&tarikh='.$model->tarikhperpustakaan.'','style'=>'background-color: transparent; 
                                    border: none;', 'class' => 'mapBtn']): $model->statusperpustakaan; ?></td>
                            <td><?php echo $model->status_jtmk==1? Html::button($model->statusjtmk.'<br><a class="fa fa-hand-o-up"></a>', ['id' => 'modalButton', 'value' => 'lihatbelumselesai?id='.$model->id.'&dept_id=35&tarikh='.$model->tarikhjtmk.'','style'=>'background-color: transparent; 
                                    border: none;', 'class' => 'mapBtn']): $model->statusjtmk; ?></td>
                            <td><?php echo $model->status_ppuu==1? Html::button($model->statusppuu.'<br><a class="fa fa-hand-o-up"></a>', ['id' => 'modalButton', 'value' => 'lihatbelumselesai?id='.$model->id.'&dept_id=181&tarikh='.$model->tarikhppuu.'','style'=>'background-color: transparent; 
                                    border: none;', 'class' => 'mapBtn']): $model->statusppuu; ?></td>
                            <?php if($model->job_category === 1){?>
                            <td><?php echo $model->status_pppi==1? Html::button($model->statuspppi.'<br><a class="fa fa-hand-o-up"></a>', ['id' => 'modalButton', 'value' => 'lihatbelumselesai?id=17'.$model->id.'&dept_id=8&tarikh='.$model->tarikhpppi.'','style'=>'background-color: transparent; 
                            border: none;', 'class' => 'mapBtn']): $model->statuspppi; ?></td><?php }?>
                            <td><?php echo $model->status_jfpiu==1? Html::button($model->statusjfpiu.'<br><a class="fa fa-hand-o-up"></a>', ['id' => 'modalButton', 'value' => 'lihatbelumselesai?id='.$model->id.'&dept_id=158&tarikh='.$model->tarikhjfpiu.'','style'=>'background-color: transparent; 
                                    border: none;', 'class' => 'mapBtn']): $model->statusjfpiu; ?></td>
                            <td><?php echo $model->status_bsm==1? Html::button($model->statusbsm.'<br><a class="fa fa-hand-o-up"></a>', ['id' => 'modalButton', 'value' => 'lihatbelumselesai?id='.$model->id.'&dept_id=158&tarikh='.$model->tarikhbsm.'','style'=>'background-color: transparent; 
                                    border: none;', 'class' => 'mapBtn']): $model->statusbsm; ?></td>
                        </tr>
                    <?php }} ?>
                </tbody>
            </table>
            <ul>
                <li><span class="label label-warning">Menunggu</span> : Menunggu kelulusan</li>
                <li><span class="label label-success">Selesai</span> : Diluluskan</li> 
                <li><span class="label label-danger">Belum Selesai</span> : Tidak Diluluskan</li>
            </ul>
        </div>
        </div>
    </div>
</div>

<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Permohonan Pemendekan Tempoh Notis</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">BIL </th>
                        <th class="column-title text-center">JENIS PENAMATAN</th>
                        <th class="column-title text-center">TARIKH TERAKHIR BEKERJA</th>
                        <th class="column-title text-center">TARIKH PERMOHONAN</th>
                        <th class="column-title text-center">DOKUMEN SOKONGAN</th>
                        <th class="column-title text-center">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                   <?php 
                    $bil=1;
                    if($mod){
                    foreach ($mod as $model) { 
                        ?>
                        <tr>
                            <td><?= $bil++; ?></td>
                            <td><?= $model->jenisPenamatan->jenis; ?></td>
                            <td><?= $model->tarikh_terakhirbekerja; ?></td>
                            <td><?= $model->tarikh_mohon; ?></td>
                            <td><?= $model->dokumenpendeknotis==NULL? '':'<a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumenpendeknotis), true); ?>" target="_blank" ><i></i><u>Dokumen Sokongan.pdf</u></a>'?></td>
                            <td><?= $model->statusbsm; ?></td>
                        </tr>
                    <?php }} ?>
                </tbody>
            </table>
            <ul>
                <li><span class="label label-warning">Menunggu</span> : Menunggu kelulusan</li>
                <li><span class="label label-success">Berjaya</span> : Diluluskan</li> 
                <li><span class="label label-danger">Ditolak</span> : Tidak Diluluskan</li>
            </ul>
        </div>
        </div>
    </div>
</div>



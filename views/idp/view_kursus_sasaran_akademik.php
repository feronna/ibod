<?php
use yii\helpers\Html;
use kartik\grid\GridView;

echo $this->render('/idp/_topmenu');

error_reporting(0);

/* * * for popover PENCERAMAH & INFO **** */
$js = <<< 'SCRIPT'
/* To initialize BS3 tooltips set this below */
$(function () { 
    $("[data-toggle='tooltip']").tooltip(); 
});
/* To initialize BS3 popovers set this below */
$(function () { 
   $("[data-toggle='popover']").popover();
//    $("[data-trigger='focus']").popover();
//    $('.popover-dismiss').popover({
//        trigger: 'focus'
//        })
});
//$(function() {
//    // use the popoverButton plugin
//    $('#kv-btn-1').popoverButton({
//        placement: 'left', 
//        target: '#myPopover5'
//    });
//});
$(function() {
    $('#testHover').popoverButton({
        trigger: 'hover focus',
        target: '#myPopover6'
    });
});
SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);
?>
<!---- Hide previous modal screen ---->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#modal").on('hidden.bs.modal', function(){
        $('#modalContent').empty();
  });
    });
</script>
<!--- /Hide previous modal screen ---->
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
                <h4>Panduan</h4>
                <div class="clearfix"></div>
        </div>
        <ul>
            <li><span class="btn btn-info btn-md"><i class="fa fa-info-circle"></i> INFO</span> : Info lanjut berkenaan kursus.</li>
            <li><span class="btn btn-primary btn-md"> PILIH SIRI</span> : Sila klik untuk melihat siri kursus yang ditawarkan.</li>
            <li><span class="btn btn-success btn-md"> TELAH MEMOHON</span> : Anda telah memohon kursus ini.</li>
            <li><span class="btn btn-warning btn-md"> TELAH HADIR</span> : Anda telah hadir kursus ini.</li>
            <li><span class="btn btn-danger btn-md"> PERMOHONAN DITUTUP</span> : Permohonan ditutup bagi kursus ini.</li>
        </ul>
    </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Permohonan Kursus Anjuran Dalaman</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">

        <div class="x_panel">
            <div class="x_title">
                <h2>Kursus Teras</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div> <!-- ubah kat sini -->
                    <?php
                    $bil = 1;
                    if ($terasSasaran) {
                        ?>
                        <table class="table table-striped jambo_table">
                            <thead>
                                <tr>
                                    <th class="text-left" style="text-align:center">Bil</th>
<!--                                    <th class="text-left">Kod Kursus</th>-->
                                    <th class="text-left" style="width: 500px">Nama Kursus</th>
                                    <th class="text-left">Info</th>
                                    <th class="text-center">Tindakan</th>
                                </tr>
                            </thead>
                            <?php
                            foreach ($terasSasaran as $lat2) {
                                //checking
//                                if ($lat2->sasaran->kepakaran) {
//                                    foreach ($lat2->sasaran->kepakaran as $model) {
//                                        $data[] = $model->bidKepakaran;
//                                        $data2[] = $model->bidang;
//                                    }
//                                } else {
//                                    $data = [];
//                                    $data2 = [];
//                                }
                                
                                if ($lat2->checkPohon($lat2->kursusLatihanID) == 2){
                                    //$v = Html::button('TELAH MEMOHON', ['class' => 'btn-sm btn-success btn-block', 'disabled' => true]);
                                    //$v = Html::button('TELAH MEMOHON', ['value' => 'latihan-dipohon?id='.$lat2->kursusLatihanID, 'class' => 'mapBtn btn-sm btn-success btn-block']);
                                    
                                    if ($lat2->checkHadir($lat2->kursusLatihanID) == 1){
                                        $v = Html::button('TELAH HADIR', ['value' => 'latihan-dihadiri?id='.$lat2->kursusLatihanID, 'class' => 'mapBtn btn-sm btn-warning btn-block']);
                                    } else {
                                        $v = Html::button('TELAH MEMOHON', ['value' => 'latihan-dipohon?id='.$lat2->kursusLatihanID, 'class' => 'mapBtn btn-sm btn-success btn-block']);
                                    }
                                    
                                } elseif ($lat2->checkPohon($lat2->kursusLatihanID) == 1){
                                    $v = Html::button('TELAH DIJEMPUT', ['class' => 'btn-sm btn-danger btn-block', 'disabled' => true]);
                                } elseif ($lat2->checkHadir($lat2->kursusLatihanID) == 1){
                                    $v = Html::button('TELAH HADIR', ['value' => 'latihan-dihadiri?id='.$lat2->kursusLatihanID, 'class' => 'mapBtn btn-sm btn-warning btn-block']);
                                    //$v = Html::button('MOHON LATIHAN', ['value' => 'mohon-latihan?kategori=6', 'class' => 'mapBtn btn-sm btn-primary btn-block']);
                                } else {
                                    if ($lat2->checkSiri($lat2->kursusLatihanID) == 1){
                                        $v = Html::button('PILIH SIRI', ['value' => 'mohon-latihan?id='.$lat2->kursusLatihanID.'&kategori=3', 'class' => 'mapBtn btn-sm btn-primary btn-block']);
                                    } else {
                                        $v = Html::button('PERMOHONAN DITUTUP', ['value' => 'mohon-latihan?id='.$lat2->kursusLatihanID.'&kategori=3', 'class' => 'mapBtn btn-sm btn-danger btn-block']);
                                    }
                                }

                                if ($lat2->kursusLatihanID) {
                                    echo
                                    //is_null($lat2->sasaran) ? '' :
                                            '<tr>'
                                            .'<td class="text-left" style="text-align:center">'
                                            .$bil++
                                            .'</td>'
//                                            .'<td class="text-left">'.$lat2->kursusLatihanID.'</td>'
                                            .'<td class="text-left">'.ucwords(strtolower($lat2->tajukLatihan)).'</td>'
                                            .'<td class="text-left">'
                                            .Html::tag('span', '<i class="fa fa-info-circle"></i> INFO', [
                                                'data-html' => 'true',
                                                'data-title' => '<b>'.ucwords(strtolower($lat2->tajukLatihan)).'</b>',
                                                'data-content' => '<b>Pemilik Modul : </b>'.ucwords(strtolower($lat2->penggubalModul))
                                                .'<br>'
                                                .'<br><b>Tahun Ditawarkan : </b>'.ucwords(strtolower($lat2->tahunTawaran))
                                                .'<br>'
                                                .'<br><b>Sinopsis Kursus : </b>'.$lat2->sinopsisKursus,
                                                'data-toggle' => 'popover',
                                                'data-placement' => 'right',
                                                'data-trigger' => 'hover',
                                                'class' => 'btn btn-info',
                                                'style' => 'text-decoration: underline: cursor:pointer;'
                                            ])
                                            .'</td>';
                                        echo '<td>'
                                            .$v
                                            . '</td>'
                                            . '</tr>';
                                }
                                $data = [];
                                $data2 = [];
                            } ?>
                            </table>
                       <?php } else {
                            ?>
                            <table class="table table-striped jambo_table">
                                <tr>
                                    <td colspan="3" class="align-center text-left"><i>Dalam proses.</i></td>
                                </tr>
                            </table>
                        <?php } ?>
                </div> <!-- ubah sini -->
            </div> <!-- x_content -->
        </div>
        <div class="x_panel">
            <div class="x_title">
                <h2>Kursus Elektif</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div> <!-- ubah kat sini -->
                    <?php
                    $bil = 1;
                    if ($elektifSasaran) {
                        ?>
                        <table class="table table-striped jambo_table">
                            <thead>
                                <tr>
                                    <th class="text-center">Bil</th>
<!--                                    <th class="text-left">Kod Kursus</th>-->
                                    <th class="text-left" style="width: 500px">Nama Kursus</th>
                                    <th class="text-left">Info</th>
<!--                                    <th class="text-left">Penceramah</th>-->
                                    <th class="text-left">Tindakan</th>
                                </tr>
                            </thead>
                            <?php
                            foreach ($elektifSasaran as $lat2) {
                                //checking
//                                if ($lat2->sasaran->sasaran3->kepakaran) {
//                                    foreach ($lat2->sasaran->sasaran3->kepakaran as $model) {
//                                        $data[] = $model->bidKepakaran;
//                                        $data2[] = $model->bidang;
//                                    }
//                                } else {
//                                    $data = [];
//                                    $data2 = [];
//                                }
                                
                                if ($lat2->checkPohon($lat2->kursusLatihanID) == 2){
                                    //$v = Html::button('TELAH MEMOHON', ['class' => 'btn-sm btn-success btn-block', 'disabled' => true]);
                                    //$v = Html::button('TELAH MEMOHON', ['value' => 'latihan-dipohon?id='.$lat2->kursusLatihanID, 'class' => 'mapBtn btn-sm btn-success btn-block']);
                                    
                                    if ($lat2->checkHadir($lat2->kursusLatihanID) == 1){
                                        $v = Html::button('TELAH HADIR', ['value' => 'latihan-dihadiri?id='.$lat2->kursusLatihanID, 'class' => 'mapBtn btn-sm btn-warning btn-block']);
                                    } else {
                                        $v = Html::button('TELAH MEMOHON', ['value' => 'latihan-dipohon?id='.$lat2->kursusLatihanID, 'class' => 'mapBtn btn-sm btn-success btn-block']);
                                    }
                                    
                                } elseif ($lat2->checkPohon($lat2->kursusLatihanID) == 1){
                                    $v = Html::button('TELAH DIJEMPUT', ['class' => 'btn-sm btn-danger btn-block', 'disabled' => true]);
                                } elseif ($lat2->checkHadir($lat2->kursusLatihanID) == 1){
                                    $v = Html::button('TELAH HADIR', ['value' => 'latihan-dihadiri?id='.$lat2->kursusLatihanID, 'class' => 'mapBtn btn-sm btn-warning btn-block']);
                                    //$v = Html::button('MOHON LATIHAN', ['value' => 'mohon-latihan?kategori=6', 'class' => 'mapBtn btn-sm btn-primary btn-block']);
                                } else {
                                    if ($lat2->checkSiri($lat2->kursusLatihanID) == 1){
                                        $v = Html::button('PILIH SIRI', ['value' => 'mohon-latihan?id='.$lat2->kursusLatihanID.'&kategori=4', 'class' => 'mapBtn btn-sm btn-primary btn-block']);
                                    } else {
                                        $v = Html::button('PERMOHONAN DITUTUP', ['value' => 'mohon-latihan?id='.$lat2->kursusLatihanID.'&kategori=4', 'class' => 'mapBtn btn-sm btn-danger btn-block']);
                                    }
                                }

                                if ($lat2->kursusLatihanID) {
                                    echo
                                    //is_null($lat2->sasaran) ? '' :
                                            '<tr>'
                                            .'<td class="text-left" style="text-align:center">'
                                            .$bil++
                                            .'</td>'
//                                            .'<td class="text-left">'.$lat2->kursusLatihanID.'</td>'
                                            .'<td class="text-left">'.ucwords(strtolower($lat2->tajukLatihan)).'</td>'
                                            .'<td class="text-left">'
                                            .Html::tag('span', '<i class="fa fa-info-circle"></i> INFO', [
                                                'data-html' => 'true',
                                                'data-title' => '<b>'.ucwords(strtolower($lat2->tajukLatihan)).'</b>',
                                                'data-content' => '<b>Pemilik Modul : </b>'.ucwords(strtolower($lat2->penggubalModul))
                                                .'<br>'
                                                .'<br><b>Tahun Ditawarkan : </b>'.ucwords(strtolower($lat2->tahunTawaran))
                                                .'<br>'
                                                .'<br><b>Sinopsis Kursus : </b>'.$lat2->sinopsisKursus,
                                                'data-toggle' => 'popover',
                                                'data-placement' => 'right',
                                                'data-trigger' => 'hover',
                                                'class' => 'btn btn-info',
                                                'style' => 'text-decoration: underline: cursor:pointer;'
                                            ])
                                            .'</td>';
                                        echo '<td>'
                                            .$v
                                            . '</td>'
                                            . '</tr>';
                                }
                                $data = [];
                                $data2 = [];
                            } ?>
                            </table>
                    <?php } else {
                            ?>
                            <table class="table table-striped jambo_table">
                                <tr>
                                    <td colspan="3" class="align-center text-left"><i>Dalam proses.</i></td>
                                </tr>
                            </table>
                        <?php } ?>
                </div> <!-- ubah sini -->
            </div> <!-- x_content -->
        </div>
        <div class="x_panel">
            <div class="x_title">
                <h2>Kursus Umum</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div> <!-- ubah kat sini -->
                    <?php
                    $bil = 1;
                    if ($umumSasaran) {
                        ?>
                        <table class="table table-striped jambo_table">
                            <thead>
                                <tr>
                                    <th class="text-center">Bil</th>
<!--                                    <th class="text-left">Kod Kursus</th>-->
                                    <th class="text-left" style="width: 500px">Nama Kursus</th>
                                    <th class="text-left">Info</th>
<!--                                    <th class="text-left">Penceramah</th>-->
                                    <th class="text-left">Tindakan</th>
                                </tr>
                            </thead>
                            <?php
                            foreach ($umumSasaran as $lat2) {
                                //checking
//                                if ($lat2->sasaran->kepakaran) {
//                                    foreach ($lat2->sasaran->kepakaran as $model) {
//                                        $data[] = $model->bidKepakaran;
//                                        $data2[] = $model->bidang;
//                                    }
//                                } else {
//                                    $data = [];
//                                    $data2 = [];
//                                }
                                
                                if ($lat2->checkPohon($lat2->kursusLatihanID) == 2){
                                    //$v = Html::button('TELAH MEMOHON', ['class' => 'btn-sm btn-success btn-block', 'disabled' => true]);
                                    //$v = Html::button('TELAH MEMOHON', ['value' => 'latihan-dipohon?id='.$lat2->kursusLatihanID, 'class' => 'mapBtn btn-sm btn-success btn-block']);
                                    
                                    if ($lat2->checkHadir($lat2->kursusLatihanID) == 1){
                                        $v = Html::button('TELAH HADIR', ['value' => 'latihan-dihadiri?id='.$lat2->kursusLatihanID, 'class' => 'mapBtn btn-sm btn-warning btn-block']);
                                    } else {
                                        $v = Html::button('TELAH MEMOHON', ['value' => 'latihan-dipohon?id='.$lat2->kursusLatihanID, 'class' => 'mapBtn btn-sm btn-success btn-block']);
                                    }
                                    
                                } elseif ($lat2->checkPohon($lat2->kursusLatihanID) == 1){
                                    $v = Html::button('TELAH DIJEMPUT', ['class' => 'btn-sm btn-danger btn-block', 'disabled' => true]);
                                } elseif ($lat2->checkHadir($lat2->kursusLatihanID) == 1){
                                    $v = Html::button('TELAH HADIR', ['value' => 'latihan-dihadiri?id='.$lat2->kursusLatihanID, 'class' => 'mapBtn btn-sm btn-warning btn-block']);
                                    //$v = Html::button('MOHON LATIHAN', ['value' => 'mohon-latihan?kategori=6', 'class' => 'mapBtn btn-sm btn-primary btn-block']);
                                } else {
                                    if ($lat2->checkSiri($lat2->kursusLatihanID) == 1){
                                        $v = Html::button('PILIH SIRI', ['value' => 'mohon-latihan?id='.$lat2->kursusLatihanID.'&kategori=1', 'class' => 'mapBtn btn-sm btn-primary btn-block']);
                                    } else {
                                        $v = Html::button('PERMOHONAN DITUTUP', ['value' => 'mohon-latihan?id='.$lat2->kursusLatihanID.'&kategori=1', 'class' => 'mapBtn btn-sm btn-danger btn-block']);
                                    }
                                }
                                
                                if ($lat2->kursusLatihanID) {
                                    echo
                                    //is_null($lat2->sasaran) ? '' :
                                            '<tr>'
                                            .'<td class="text-left" style="text-align:center">'
                                            .$bil++
                                            .'</td>'
//                                            .'<td class="text-left">'.$lat2->kursusLatihanID.'</td>'
                                            .'<td class="text-left">'.ucwords(strtolower($lat2->tajukLatihan)).'</td>'
                                            .'<td class="text-left">'
                                            .Html::tag('span', '<i class="fa fa-info-circle"></i> INFO', [
                                                'data-html' => 'true',
                                                'data-title' => '<b>'.ucwords(strtolower($lat2->tajukLatihan)).'</b>',
                                                'data-content' => '<b>Pemilik Modul : </b>'.ucwords(strtolower($lat2->penggubalModul))
                                                .'<br>'
                                                .'<br><b>Tahun Ditawarkan : </b>'.ucwords(strtolower($lat2->tahunTawaran))
                                                .'<br>'
                                                .'<br><b>Sinopsis Kursus : </b>'.$lat2->sinopsisKursus,
                                                'data-toggle' => 'popover',
                                                'data-placement' => 'right',
                                                'data-trigger' => 'hover',
                                                'class' => 'btn btn-info',
                                                'style' => 'text-decoration: underline: cursor:pointer;'
                                            ])
                                            .'</td>';
                                        echo '<td>'
                                            .$v
                                            . '</td>'
                                            . '</tr>';
                                }
                                $data = [];
                                $data2 = [];
                                
                                
                                
                            } ?>
                            </table>
                    <?php  } else {
                            ?>
                            <table class="table table-striped jambo_table">
                                <tr>
                                    <td colspan="3" class="align-center text-left"><i>Dalam proses.</i></td>
                                </tr>
                            </table>
                        <?php } ?>
                </div> <!-- ubah sini -->   
            </div> <!-- x_content -->
        </div>
    </div>
</div>

</div> <!-- x_content -->
        </div>
    </div>
</div>

<!-- <div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Jemputan Kursus</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
               <?php 
//                         GridView::widget([
//                             'dataProvider' => $dataProvider,
//                             //'filterModel' => $kursusJemputan,
//                             'emptyText' => 'Tiada jemputan ditemui.',
//                             'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
//                             'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
//                             'columns' => [
//                                 ['class' => 'kartik\grid\SerialColumn',
//                                     'header' => 'Bil',
//                                     'vAlign' => 'middle',
//                                     'hAlign' => 'center',
//                                 ],
// //                                'jemputanID',
//                                 //'siriLatihanID',
//                                 //'jabatan.shortname',
// //                                [
// //                                    'label' => 'Kategori Jawatan',
// //                                    'format' => 'raw',
// //                                    'value' => 'jobCategoryy',
// //                                ],
//                                 [
//                                     'label' => 'Nama Kursus',
//                                     'vAlign' => 'middle',
//                                     'hAlign' => 'center',
//                                     'format' => 'raw',
//                                     'value' => 'siriKursus.sasaran3.tajukLatihan',
//                                 ],
//                                 [
//                                     'label' => 'Tarikh',
//                                     'vAlign' => 'middle',
//                                     'hAlign' => 'center',
//                                     'format' => 'raw',
//                                     'value' => function ($model){               
//                                                     if (($model->siriKursus->tarikhMula != null) && ($model->siriKursus->tarikhMula != 0000-00-00)){

//                                                         $myDateTime = DateTime::createFromFormat('Y-m-d', $model->siriKursus->tarikhMula);
//                                                         $formatteddate = $myDateTime->format('d/m/Y');

//                                                         $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->siriKursus->tarikhAkhir);
//                                                         $formatteddate2 = $myDateTime2->format('d/m/Y');

//                                                         if ($formatteddate == $formatteddate2 ){
//                                                             $formatteddate = $formatteddate;    
//                                                         } else {
//                                                             $formatteddate = $formatteddate.' - '.$formatteddate2;
//                                                         }

//                                                     } else {
//                                                         $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
//                                                     } 
//                                                     return $formatteddate;
//                                                 },
//                                 ],
//                                 [
//                                     'label' => 'Lokasi ',
//                                     'vAlign' => 'middle',
//                                     'hAlign' => 'center',
//                                     'format' => 'raw',
//                                     'value'=> 'siriKursus.lokasi',
//                                 ],
//                                 [
//                                     'label' => 'Kampus',
//                                     'vAlign' => 'middle',
//                                     'hAlign' => 'center',
//                                     'format' => 'raw',
//                                     'value' => 'siriKursus.campusName.campus_name',
//                                 ],
//                                 [
//                                     'label' => 'Info',
//                                     'vAlign' => 'middle',
//                                     'hAlign' => 'center',
//                                     'format' => 'raw',
//                                     'value' => function ($data) {
//                                             return Html::tag('span', '<i class="fa fa-info-circle"></i> INFO', [
//                                                 'data-html' => 'true',
//                                                 //'data-title' => '<b>'.ucwords(strtolower($data->siriKursus->sasaran3->tajukLatihan)).'</b>',
//                                                 'data-content' => '<b>Pemilik Modul : </b>'.ucwords(strtolower($data->siriKursus->sasaran3->penggubalModul))
//                                                 .'<br>'
//                                                 .'<br><b>Tahun Ditawarkan : </b>'.ucwords(strtolower($data->siriKursus->sasaran3->tahunTawaran))
//                                                 .'<br>'
//                                                 .'<br><b>Sinopsis Kursus : </b>'.$data->siriKursus->sasaran3->sinopsisKursus,
//                                                 'data-toggle' => 'popover',
//                                                 'data-placement' => 'left',
//                                                 'data-trigger' => 'hover',
//                                                 'class' => 'btn btn-info',
//                                                 'style' => 'text-decoration: underline: cursor:pointer;'
//                                             ]); // $data['name'] for array data, e.g. using SqlDataProvider.
//                                         },
//                                 ],
//                                 [
//                                     'label' => 'Jenis Kursus',
//                                     'vAlign' => 'middle',
//                                     'hAlign' => 'center',
//                                     'format' => 'raw',
//                                     'value' => 'kategoriKursus.jenisKursus',
//                                 ],
//                             ],
//                         ]); 
                        ?> 
            </div>
        </div>
    </div>
</div> -->
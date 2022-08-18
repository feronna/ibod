
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;


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


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#modal").on('hidden.bs.modal', function(){
        $('#modalContent').empty();
  });
    });
</script>


<?php

$statusLabel = [
        0 => '<span class="label label-danger">BELUM DIPERAKUKAN</span>',
        1 => '<span class="label label-success">DIPERAKUKAN</span>',
        2 => '<span class="label label-danger">DITOLAK</span>',
];

?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            
               
<?php
echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'label' => 'Bil.JPU',
            'format' =>  'raw',
           'value' => function ($data) {
            return  strtoupper($data->tblRekod->bil_jpu). '&nbsp'. "Kali Ke-". '&nbsp'.strtoupper($data->tblRekod->kali_ke);
         }
        ],
          [
            'format' => 'raw',
            'label' => 'Minit',
            'attribute' =>  'tblRekod.perkara',
        ],
                
                   [
            'format' => 'raw',
            'label' => 'Perkara',
             'value' => function ($data) {
            return $data->perkara;
         }
        ],
                
             [
            'attribute' => 'file',
            'label' => 'Lampiran Dokumen',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->tblRekod->doc_name) {
                    return Html::a(''  . $model->tblRekod->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $model->tblRekod->hashcode, $schema = true), ['target' => '_blank',  'style' =>  'text-decoration: underline; color:green']);
                } else {
                    return 'Tiada Lampiran';
                }
            }

        ],
        
         [
            'label' => 'Tarikh Mesyuarat',
            'attribute' =>  'tblRekod.tarikhRekod',
        ],
                
                  [
            'label' => 'Tarikh Akhir Penghantaran Maklumbalas',
            'attribute' =>  'tblRekod.tarikhTamat',
        ],
        
        [
            'label' => 'Status Index' ,
           'format' => 'raw',
            'attribute' =>  'tblRekod.statusMemorandum',
        ],
        
 
//         [
//            'label' => 'Urusetia JAFPIB',
//            'format' => 'raw',
//            'value' => function ($data) {
//            return  strtoupper($data->tblRekod->kakitanganPtj->department->fullname);
//         }
//         
//        ],
                
//     [
//            'label' => 'Urusetia JAFPIB',
//            'format' => 'raw',
//            'value' => function ($data) {
//            return  strtoupper($data->penyeliaPtj->CONm);
//         }
//                 
//        ],  
//                
//          [
//            'label' => 'Pegawai JAFPIB',
//            'format' => 'raw',
//            'value' => function ($data) {
//            return  strtoupper($data->pegawaiPeraku->CONm);
//         }
//                 
//        ],  
  
//        
//        [
//            'label' => 'Maklumbalas',
//            'format' => 'raw',
//            'value' => function ($data) {
//            
//            return Html::a($data->TugasUtama($data->id) );
//         }
//         
//        ]
         

    ],
]);
        
   ?>
            
            
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-list"></i> Senarai Tindakan JAFPIB</strong></h2>
                
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title">Bil</th>
                        <th class="column-title">Jabatan </th>
                        <th class="column-title">Nama Penyelia </th>
                        <th class="column-title">Nama Pegawai Peraku</th>

                    </tr>

                </thead>
                <tbody>

                  <?php if($tindakan) {
                             foreach ($tindakan as $key=>$tindakan){ ?>
                        <tr>

                            <td><?= $key+1?></td>
                            <td><?= strtoupper($tindakan->department->fullname)?></td>
                            <td><?= strtoupper($tindakan->penyelia2->CONm)?></td>
                            <td><?= strtoupper($tindakan->pegawaiPeraku->CONm)?></td>
                           </td>

                        </tr>
                           
                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="6" class="text-center">Tiada Rekod Pemakluman</td>                     
                    </tr>
                  <?php  
                } ?>
                        
                      </table>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-list"></i> Senarai Pemakluman Memorandum</strong></h2>
                
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title">Bil</th>
                        <th class="column-title">Nama Pegawai </th>
                        <th class="column-title">Jabatan </th>
                        <th class="column-title">Tarikh Makluman </th>
                    </tr>

                </thead>
                <tbody>

                  <?php if($senaraiPemakluman) {
                             foreach ($senaraiPemakluman as $key=>$senaraiPemakluman){ ?>
                        <tr>

                            <td><?= $key+1?></td>
                            <td><?= strtoupper($senaraiPemakluman->namaPemakluman->CONm)?></td>
                            <td><?= strtoupper($senaraiPemakluman->jabatanPemakluman->fullname)?></td>
                            <td><?= strtoupper($senaraiPemakluman->tarikhPemakluman)?></td>
                           </td>

                        </tr>
                           
                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="6" class="text-center">Tiada Rekod Pemakluman</td>                     
                    </tr>
                  <?php  
                } ?>
                        
                      </table>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-list"></i> Senarai Maklumbalas JAFPIB</strong></h2>
                
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title">Bil</th>
                        <th class="column-title">Tarikh Maklumbalas </th>
                        <th class="column-title">Pemaklumbalas </th>                
                        <th class="column-title">Jabatan </th>
                        <th class="column-title">Maklumbalas </th>
                        <th class="column-title">Lampiran </th>
                        <th class="column-title">Status Perakuan </th>
                        <th class="column-title">Tindakan </th>
                    </tr>

                </thead>
                <tbody>

                  <?php if($senaraiPtj) {
                             foreach ($senaraiPtj as $key=>$senaraiPtj){ ?>
                        <tr>

                            <td style="width:5%"><?= $key+1?></td>
                            <td style="width:5%"><?= $senaraiPtj->tarikhMaklumbalas; ?></td>
                            <td style="width:5%"><?= strtoupper($senaraiPtj->kakitangan->CONm)?></td>
                            <td style="width:5%"><?= strtoupper($senaraiPtj->kakitangan->department->shortname);?></td>
                            <td style="width:70%"><?= $senaraiPtj->maklumbalas_ptj?></td>
                            <td><?php              
                            if ($senaraiPtj->doc_name) {
                             echo  Html::a(''  . $senaraiPtj->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $senaraiPtj->hashcode, $schema = true), ['target' => '_blank', 'style' =>  'text-decoration: underline; color:green' ]);
                            } else {
                                echo 'Tiada Lampiran';
                            }?></td>
                            <td style="width:5%"><?= $statusLabel[$senaraiPtj->status_kj]?></td>
                           <td style="width:5%"><?php
                             $t = Url::to(['detail-maklumbalas-ptj',  'id_rekod' => $senaraiPtj->id_rekod, 'id' => $senaraiPtj->id]);
                                echo Html::button('<span class="fa fa-eye"></span>', ['value' => Url::to($t), 'class' => 'btn btn-default modalButton']) 
//                               echo Html::tag('span', '<i class="fa fa-info-circle"></i> INFO', [
//                                                'data-html' => 'true',
//                                              //  'data-title' => '<b>'.ucwords(strtolower($lat2->tajukLatihan)).'</b>',
//                                                'data-content' => '<b>Ketua Jabatan/Dekan:'. '<br>'. strtoupper($senaraiPtj->pegawaiPeraku->CONm).'</b>'.'<br>'
//                                                 .'<b>Status Perakuan:'.'<br>'. $statusLabel[$senaraiPtj->status_kj].'</b>'.'<br>'
//                                                 .'<b>Tarikh Perakuan:'.'<br>'.  $senaraiPtj->tarikh_perakuan.'</b>'
//                                                 .'<b>Perakuan Ketua:'. '<br>'. strtoupper($senaraiPtj->perakuan_kj).'</b>',
//                                                'data-toggle' => 'popover',
//                                                'data-placement' => 'right',
//                                                'data-trigger' => 'hover',
//                                                'class' => 'btn btn-primary btn-xs',
//                                                'style' => 'text-decoration: underline: cursor:pointer;'
//                                            ])
//                                            ?>
                           </td>

                        </tr>
                           
                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="6" class="text-center">Tiada Rekod Maklumbalas</td>                     
                    </tr>
                  <?php  
                } ?>
                        
                      </table>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-list"></i> Senarai Maklumbalas Urusetia</strong></h2>
                
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title">Bil</th>
                        <th class="column-title">Tarikh Maklumbalas </th>
                        <th class="column-title">Pemaklumbalas </th>
                        <th class="column-title">Jabatan </th>
                        <th class="column-title">Maklumbalas </th>
                        <th class="column-title">Lampiran </th>
                        
                    </tr>

                </thead>
                <tbody>

                  <?php if($senarai) {
                             foreach ($senarai as $key=>$senarai){ ?>
                        <tr>

                            <td><?= $key+1?></td>
                            <td><?= $senarai->tarikhMaklumbalas; ?></td>
                            <td><?= $senarai->kakitangan->CONm ;?></td>
                            <td><?= $senarai->kakitangan->department->shortname;?></td>
                            <td><?= $senarai->maklumbalas?></td>
                                  <td><?php              
                            if ($senarai->doc_name) {
                             echo  Html::a(''  . $senarai->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $senarai->hashcode, $schema = true), ['target' => '_blank', 'style' =>  'text-decoration: underline; color:green' ]);
                            } else {
                                echo 'Tiada Lampiran';
                            }?></td>
                 

                        </tr>
                           
                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="6" class="text-center">Tiada Rekod Maklumbalas</td>                     
                    </tr>
                  <?php  
                } ?>
                        
                      </table>
                </form>
            </div>
        </div>
    </div>
</div>

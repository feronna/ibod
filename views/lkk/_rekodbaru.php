<div class="row"> 
    <div class="col-xs-12 col-md-12 col-lg-12" >
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-th-list"></i> Senarai Laporan Kemajuan Kursus (LKK)</strong></h2>
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
                        <th class="column-title text-center">SEMESTER </th>
                        <th class="column-title text-center">SESI </th>
                        <th class="column-title text-center">TARIKH HANTAR LAPORAN</th>
                        <th class="column-title text-center">STATUS</th>
                        <th class="column-title text-center">TINDAKAN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $bil=1;
                    if($status){
                    foreach ($status as $statuss) { 
                        ?>
                        <tr>
                            <td style="width:10%;"><?= $bil++; ?></td>
                             <td style="width:30%;"><?= $statuss->semester; ?></td>
                            <td style="width:30%;"><?= $statuss->session; ?></td>
                            <td style="width:30%;"><?= $statuss->tarikh_hantar; ?></td>
                            <td ><?= $statuss->statuss; ?></td>
                        
                         <td style="width:30%;">
                            <?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', 
    ['lkk/lihat-permohonan', "id"=> $statuss->reportID], ['class' => 'btn btn-default btn-xs']) ?>
               <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete?id='.$statuss->reportID], ['class' => 'btn btn-default btn-xs',
                                        'data' => [
                                        'confirm' => 'Anda ingin membuang rekod ini?',
                                        'method' => 'post',
                                        ],
                                    ])
                                  ?>
         </td>  

                        </tr>
                    <?php }}    else{?>
                     
                   
                    <tr>
                        <td colspan="8" class="text-center"><i>Tiada Rekod Ditemui</i></td>                     
                    </tr>
                  <?php  
                } ?>

                </tbody>
            </table>
           
        </div>
        </div>
       
    </div>
</div>
</div>
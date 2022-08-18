<?php

use yii\helpers\Html;



$title = $this->title = 'MaklumatPegawai';
?>

<div class="x_panel">
<?php if ($models == false){
   echo $this->render('_menu1', ['title' => $title]) ;      
}else{
    echo $this->render('_menu4', ['title' => $title]) ;   
}
?>
    

              <div class="x_title">
            <h2><strong>BAHAGIAN 1 - Keterangan Mengenai Pegawai</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
           <div class="x_title">
                <h2><strong><i class="fa fa-user"></i> Maklumat Pegawai</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                
                
                <form id="w0" class="form-horizontal form-label-left" action="" method="post">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Penuh
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">

                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $maklumat->CONm?>" disabled="">

                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">No Kad Pengenalan
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">

                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $maklumat->ICNO?>" disabled="">

                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
               
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Jawatan
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">

                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $maklumat->jawatan->nama . " (" . $maklumat->jawatan->gred . ")"; ?>" disabled="">

                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                            <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Jawatan
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">

                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $maklumat->statusLantikan->ApmtStatusNm ?>" disabled="">

                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Lantikan di UMS
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">

                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $maklumat->displayStartDateSandangan ?>" disabled="">

                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                            <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">JFPIU
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">

                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= ucwords(strtolower($maklumat->department->fullname))  ?>" disabled="">

                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                              
                                   <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Lantikan Pertama
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">

                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $maklumat->mulaLantikan->tarikhMulalantikan?>" disabled="">

                                <div class="help-block"></div>
                            </div>
                        </div>
                     

      
               
                </form>
            </div>
        </div>
    

     
    
            <div class="x_title">
                <h2><strong><i class="fa fa-user"></i> Maklumat Pasangan</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title">Bil</th>
                        <th class="column-title">Nama Pasangan</th>
                        <th class="column-title">No Kad Pengenalan</th>
                        <th class="column-title">Ikatan / Bekas</th>
                    

                        
                        <th></th>
                    </tr>

                </thead>
                <tbody>


                    <?php $bil=1; foreach ($pasangan as $pasangans) { ?>

                        <tr>

                            <td><?= $bil++ ?></td>
                            <td><?= $pasangans->FmyNm ?></td>
                            <td><?= $pasangans->FamilyId?></td>
                            <td><?= $pasangans->hubunganKeluarga->RelNm?></td>
                           

                        </tr>
                    <?php } ?>
                </tbody>

                     </table>
                </form>
                  <?= Html::a('Tambah Maklumat', ['biodata/viewuser'], ['class' => 'btn btn-primary']) ?>
            </div>
</div>

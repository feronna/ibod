<?php

use app\models\cbelajar\TblPengajian;
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_content ">
            <div class="x_panel">

                <div class="table-responsive">

                    <table class="table table-striped table-sm  table-bordered">
                        <thead>

                            <tr class="headings">
                                <th colspan="2" style="background-color:lightseagreen;color:white"><center>




                            STATISTIK KAKITANGAN AKADEMIK DAN PENTADBIRAN MENGIKUT PERINGKUT PENGAJIAN</center></th>
                        </tr>
                        <tr> 
                            <th style="width:10%" align="right">POS DOKTORAL</th>
                            <td style="width:20%">
                                <span class="label label-success">  <?= TblPengajian::TotalbyPos(1); ?> ORANG</span>
                            </td>

                        </tr>
                        <tr> 
                            <th style="width:10%" align="right">POS BASIK</th>
                            <td style="width:20%">
                                <span class="label label-success"> <?= TblPengajian::TotalbyPosbasik(1); ?> ORANG</span>
                            </td>

                        </tr>
                        
                        <tr> 
                            <th style="width:10%" align="right">CUTI SABATIKAL</th>
                            <td style="width:20%">
                                <span class="label label-success"> <?= TblPengajian::TotalbySabatikal(1); ?> ORANG</span>
                            </td>

                        </tr>
                        
                         <tr> 
                            <th style="width:10%" align="right">LATIHAN INDUSTRI - IR</th>
                            <td style="width:20%">
                                <span class="label label-success"> <?= TblPengajian::TotalbyLatihan(1); ?> ORANG</span>
                            </td>

                        </tr>
                        
                        <tr> 
                            <th style="width:10%" align="right">DOKTOR FALSAFAH</th>
                            <td style="width:20%">
                                <span class="label label-success"> <?= TblPengajian::TotalbyEduLevel(1); ?> ORANG</span>
                            </td>

                        </tr>
                        
                        <tr> 
                            <th style="width:10%" align="right">SARJANA KEPAKARAN</th>
                            <td style="width:20%">
                                <span class="label label-success">
                               <?= TblPengajian::TotalbySarjanakepakaran(1); ?> ORANG</span>
                            </td>

                        </tr>
                        
                        <tr> 
                            <th style="width:50%" align="right">SARJANA</th>
                            <td style="width:50%">
                                <span class="label label-success"><?= TblPengajian::TotalbySarjana(1); ?> ORANG</span>
                            </td>

                        </tr>
                        
                        <tr> 
                            <th style="width:10%" align="right">SARJANA MUDA</th>
                            <td style="width:20%">
                                <span class="label label-success"> <?= TblPengajian::TotalbySarjanamuda(1); ?> ORANG</span>
                            </td>

                        </tr>
                        
                        <tr> 
                            <th style="width:10%" align="right">DIPLOMA</th>
                            <td style="width:20%">
                                <span class="label label-success">  <?= TblPengajian::TotalbyDiploma(1); ?> ORANG</span>
                            </td>

                        </tr>
                        
                         <tr> 
                            <th style="width:10%" align="right">JUMLAH</th>
                            <td style="width:20%">
                              <span class="label label-warning">  <?= TblPengajian::TotalbyDiploma(1) + TblPengajian::TotalbyEduLevel(1)
                                    + TblPengajian::TotalbyLatihan(1) + TblPengajian::TotalbyPos(1)
                                    + TblPengajian::TotalbyPosbasik(1) + TblPengajian::TotalbySabatikal(1)
                                    + TblPengajian::TotalbySarjana(1) + TblPengajian::TotalbySarjanakepakaran(1)
                                        + TblPengajian::TotalbySarjanamuda(1); ?> ORANG</span>
                            </td>

                        </tr>




<!--                                <tr class="headings">
    <th class="column-title text-center">Telah Dimuatnaik</th>
    <th class="column-title text-center">Belum Dimuatnaik</th>
</tr>-->
                        </thead>


<!--                                   // <td class="text-center">
   <?//php
if (!$k->namafile)
  {
echo '&#10008;'; }?></td>

</tr>-->


                    </table>
                </div> 

            </div>
        </div>
    </div></div>

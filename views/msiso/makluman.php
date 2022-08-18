<?php
use kartik\grid\GridView;

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 25px; font-size: 14x ">
YBhg. Prof. Datuk Dr./Prof. Dr /Tuan/ Puan <br><br>
<strong>AKTIVITI AUDIT DALAM MS ISO 9001:2015 PADA TAHUN <?php echo $model->year ?><strong> 
</div>

        <div style="margin-bottom: 25px; "> 
            Dengan hormatnya perkara diatas dirujuk.
            <br> 
        </div> 

        <div style="margin-bottom: 15px; text-align:justify">
           2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sukacita dimaklumkan bahawa aktiviti audit dalam MS ISO 9001:2015 
           (Skop Pengurusan Pengajaran & Pembelajaran (Prasiswazah dan Pascasiswazah), Penyelidikan, Penerbitan, Khidmat Masyarakat, 
           Pengantarabangsaan dan Semua Pengurusan Perkhidmatan Sokongan) akan dilaksanakan mengikut ketetapan berikut:
        </div>

        <div style="margin-bottom: 10px; text-align:justify">
        <strong> Makluman aktiviti audit dalam MS ISO 9001:2015 :</strong>
        </div>

        <div class="x_content">
                <div class="table-responsive">

                    <table class="table table-bordered" style=" font-size: 11px;"> 

                    <tr>
                       <td colspan="6" style="text-align:center; background-color:#527e72" color="white" height="25px" ><strong> </strong></td>
                     </tr>
                        <tr>  
                        <td colspan="3"  height="25px"> <strong>&nbsp;JAFPIB</strong> </td> 
                        <td  colspan="3"  height="25px">&nbsp;<?php echo $model->dept ?> </td> 
                        </tr>

                        <tr>
                        <td colspan="3"  height="25px"> <strong>&nbsp;CADANGAN TARIKH</strong> </td>
                        <td  colspan="3"  height="25px">&nbsp;<?php echo $model->auditDt ?> </td> 
                        </tr>

                        <tr>
                        <td colspan="3"  height="25px"> <strong>&nbsp; MASA</strong> </td> 
                        <td  colspan="3"  height="25px">&nbsp; <?php echo $model->from_audit_time ?> - <?php echo $model->to_audit_time ?> </td> 
                        </tr> 
                    </table>
                </div>
        </div> 

        </div>
        <div style="margin-bottom: 15px; text-align:justify">
        <strong>Maklumat Pasukan Juruaudit dalam MS ISO 9001:2015: </strong>
        </div>

        <div style="margin-bottom: 10px">
        <table class="table table-bordered" style=" font-size: 11px;"> 
                     <tr>
                       <td colspan="12" style="text-align:center; background-color:lightgrey" color="white" height="25px" ><strong> </strong></td>
                     </tr>
                     
                    <tr> 
                 <td colspan="4"  height="25px" font-size: 11px;><center><strong>BIL</strong></center></td> 
                 <td colspan="2"  height="25px" font-size: 11px;><center><strong>NAMA JURUADIT DALAM</strong></center></td> 
                 <td colspan="2"  height="25px" font-size: 11px;><center><strong>NO.TELEFON</strong></center></td>
                 <td colspan="4"  height="25px" font-size: 11px;><center><strong>EMEL</strong></center></td> 
                
                    
                     </tr>
                     
                     <?php if($auditor) { 
                       foreach ($auditor as $auditor) { 
                    ?>
                     <tr>  
                    
                     <td  colspan="4"  height="25px"><center><?php echo $bil++ ?></center></td> 
                     <td  colspan="2"  height="25px"><left> &nbsp;<?php echo $auditor->kakitangan->CONm ?> </left></td>
                     <td  colspan="2"  height="25px"><center><?php echo $auditor->kakitangan->COOffTelNo ?> (No. UC: <?php echo $auditor->kakitangan->COOUCTelNo ?>  <?php //echo $auditor->kakitangan->COOffTelNoExtn ?>) </center></td>
                     <td  colspan="4"  height="25px"><center><?php echo $auditor->kakitangan->COEmail ?> </center></td> 
                     </tr>
                      
                       <?php } 

                    } else{
                        ?>
                        <tr>
                            <td colspan="10" class="text-center">Tiada Rekod</td>                     
                        </tr>
                      <?php  
                    } ?>  
              
        </table>
 </div>
        </div>

        <div style="margin-bottom: 13px; text-align:justify">

        3.   Sehubungan dengan itu, mohon jasa baik pihak YBhg. Prof. Datuk Dr./Prof. Dr /Tuan/ Puan agar dapat memberi 
        kerjasama sepanjang aktiviti audit dalam dijalankan. 

        </div>

        <div style="margin-bottom: 10px; text-align:justify">

        Perhatian dan Kerjasama daripada pihak YBhg. Prof. Datuk Dr./Prof. Dr /Tuan/ Puan amatlah dihargai dan didahului 
        dengan ucapan ribuan terima kasih.

        </div>
        </div>
        
       
        
        
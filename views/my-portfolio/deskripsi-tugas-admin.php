 <?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
use app\models\ptb\TblPbpu;
error_reporting(0);

?>

<style>
th {
  background-color: #2290F0;
  color: white;
  text-align: center;
}

</style>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                    <h2>Job Description (JD)</h2>
              <p align="right" >
              <?= Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?> 
               
                </p>
                <div class="clearfix"></div>
            </div>
          <div class="x_content">
                  <div class="table-responsive">
                <table class="table table-sm table-bordered">
                       
                 
                    <tr>
                        <th   <td style="width:700px; height:20px"<th colspan="5"><strong> MAKLUMAT UMUM </strong></td></th>
                    </tr>
                    <tr>
                        <td></td>
                     <td colspan="1" style="width:200px; height:20px"><strong>GELARAN JAWATAN</strong></td>
                     <td style="width:500px; height:20px"><?= strtoupper($deskripsi->jawatan)?></td>
                     <td style="width:200px; height:20px"><strong>KETUA PERKHIDMATAN</strong></td>
                     <td style="width:500px; height:auto">KETUA PENGARAH PENDIDIKAN TINGGI</td>
                     </tr>
                     <tr>
                              <td></td>
                     <td><strong>RINGKASAN GELARAN JAWATAN</strong></td>
                     <td><?=strtoupper( $deskripsi->ringkasan_gelaran )?></td>
                     <td><strong>KEDUDUKAN DI WARAN PERJAWATAN</strong></td>
                     <td>TIDAK BERKENAAN</td>
                     </tr>
                     <tr>
                              <td></td>
                         <td><strong>GRED JAWATAN</strong></td>
                     <td><?= strtoupper($deskripsi->jawatanss->gred) ?></td>
                     <td><strong>BIDANG UTAMA</strong></td>
                     <td><?= strtoupper($deskripsi->bidang_utama) ?></td>
                     </tr>
                     <tr>
                              <td></td>
                      <td><strong>GRED JD</strong></td>
                     <td><?= strtoupper($deskripsi->greds->gred)?></td>
                     <td><strong>SUB BIDANG</strong></td>
                     <td><?= strtoupper($deskripsi->sub_bidang) ?></td>
                     </tr>
                     <tr>
                              <td></td>
                         <td><strong>STATUS JAWATAN</strong></td>
                     <td><?= strtoupper($deskripsi->status_jawatan)?></td>
                     <td><strong>DISEDIAKAN OLEH</strong></td>
                     <td><?= strtoupper($deskripsi->name) ?></td>
                     </tr>
                    <tr>
                             <td></td>
                        <td><strong>HIRARKI 1 (BAHAGIAN)</strong></td>
                     <td><?=strtoupper( $deskripsi->department->fullname)?></td>
                     <td><strong>DISEMAK OLEH</strong></td>
                     <td><?= strtoupper($deskripsi->ketuaPerkhidmatan->CONm)?></td>
                     </tr>
                      <tr>
                               <td></td>
                          <td><strong>HIRARKI 2 (CAWANGAN /SEKTOR/ UNIT)</strong></td>
                     <td><?= strtoupper($deskripsi->hirarki_2)?></td>
                     <td><strong>DILULUSKAN OLEH</strong></td>
                     <td><?= strtoupper($deskripsi->ketuaJabatan->CONm) ?></td>
                     </tr>
                    <tr>
                             <td></td>
                        <td><strong>SKIM PERKHIDMATAN</strong></td>
                     <td><?= strtoupper($deskripsi->skim_perkhidmatan)?></td>
                     <td><strong>TARIKH DOKUMEN</strong></td>
                     <td><?= strtoupper($deskripsi->tarikhDokumen)?></td>
                     </tr>
                      
                    <tr>
                        <th  colspan="5"<td style="width:500px; height: 20px">TUJUAN PEWUJUDAN JAWATAN</strong></td></th>
                        
                    </tr>
                    <tr> <td colspan="6" style="text-align:justify"><?= ucwords(strtolower($deskripsi->kata_kerja))?> <?php echo $deskripsi->object?>  <?php echo $deskripsi->tujuan?></td></tr>
                    
                    <tr>
                           <th colspan="1" <td style="width:50px; height: 20px">Bil.</strong></td></th>
                          
                         <th colspan="2"<td style="width:200px; height: 20px"><strong>AKAUNTABILITI</strong></td></th>
                         <th  colspan="2" <td style="width:500px; height: 20px">TUGAS UTAMA</strong></td></th>
                  
                    </tr>
                  <?php if($akauntabiliti) {
                    
                   foreach ($akauntabiliti as $key=>$item){
                    
                ?>
                        <tr>
                            <td colspan="1"align="center"><?= $key+1?></td>
                            
                            <td colspan="2">
                           <?= ucwords(strtolower($item->kata_kerja))?> <?= $item->object?> <?= $item->description?>
                           <td colspan="2">
                             <?= $item->TugasUtama3($item->id)?></td>
                              </tr> 
                                              
                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                    
                  
           
                      
                      
           
                    <tr>
                        <th  <td style="width:50px; height: 20px">Bil.</strong></td></th>
                         <th colspan="2" <td style="width:200px; height: 20px">DIMENSI</strong></td></th>
                         <th colspan="3"<td style="width:500px; height: 20px">SKOP</strong></td></th>
                   
                    </tr>
                               <?php if($lihatDimensi) {
                    
                   foreach ($lihatDimensi as $key=>$item){?>
                    <tr>
                            <td align="center"><?= $key+1?></td>
                            <td colspan="2">
                            <?= ucwords(strtolower($item->dimensi))?><td colspan="2">
                             <?= ucwords(strtolower($item->dimensi_utama))?>
                            
                            </td>
                             
                        </tr>
                                                   

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                    <tr>
                         <th  <td   height="25px"><strong>Bil.</strong></td></th>
                        <th  <td  colspan="2" height="25px"><strong>KELAYAKAN AKADEMIK / IKHTISAS</strong></td></th>
                        <th   <td   height="25px"  colspan="3"><strong>BIDANG</strong></td></th>
                    </tr>
                          <?php if($ikhtisas) {
                    
                   foreach ($ikhtisas as $key=>$item){?>
                        <tr>
                         <td><?= $key+1?></td>
                         <td colspan="2"  height="25px" > <?= ucwords(strtolower($item->refPendidikan->HighestEduLevel))?></td>
                         <td colspan="3"  height="25px" > <?= ucwords(strtolower($item->bidang))?></td>
                       </tr>
                                                   

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                      
                     
                         <tr>
                         <th>Bil.</th>
                         <th <td colspan="4"><strong>SYARAT TAMBAHAN</strong></td>
                      
                    </tr>
                    <?php if($syarat) {
                    
                   foreach ($syarat as $key=>$items){
                    
                ?>
                        <tr>
                            <td width="50px" align="center"><?= $key+1?></td>
                            <td colspan="4">
                         
                            <?=ucwords(strtolower($items->syarat_tambahan))?>
                      
                           </td>
                            </tr>
                        
                         </tr>
                                                   

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                         <tr>
                             <th>Bil. </th>
                        <th colspan="4"><strong> KOMPETENSI</strong></td>
                        
                    </tr>
                    
                    <?php if($lihatKompetensi) {
                    
                   foreach ($lihatKompetensi as $key=>$item){?>
                    <tr>
                            <td width="50px" align="center"><?= $key+1?></td>
                            <td colspan="4">
                            <?= ucwords(strtolower($item->kompetensi))?></td>
                
                           </tr>
                        
                         </tr>
                                                   

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                  
                     <tr>
                         <th>Bil.</th>
                         <th colspan="4"><strong>PENGALAMAN</strong></td>
                  
                    </tr>
                  <?php if($pengalaman) {
                    
                   foreach ($pengalaman as $key=>$item){
                    
                ?>
                        <tr>
                            <td width="50px" align="center"><?= $key+1?></td>
                            <td colspan="4">
                             <?= ucwords(strtolower($item->tempoh))?> <?= ucwords(strtolower($item->pengalaman))?></td>
                              </tr>
                                                   

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
              
                      </table>
             
 
 </div>
</div>
</div>
 </div> 
</div>
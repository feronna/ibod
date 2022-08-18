<?php
?>

        <?php echo $this->render('/ptb/_menu'); ?>

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Nota Serah Tugas Pengganti</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
           <div class="x_content">
                    <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tr>
                    <th class="text-center">Bil</th>
                    <th class="text-center">Nama</th>
                     <th class="text-center">Salinan Nota Serah Tugas</th>
                       <th class="text-center">Catatan Ketua JFPIU</th>
                      <th class="text-center">Tarikh Diserahkan</th> 
                </tr>
                 <?php foreach ($nota_pengganti as $bil=>$item): ?>
            
                        <tr>
                            <td><?= $bil+1 ?></td>
                            <td><?= $item->pemohon_name?></td>
                            <td align='center'>
                                     
                            <?= \yii\helpers\Html::a('', ['ptb/tugas-generate-letter', 'id' => $item->id], ['class'=>'fa fa-download', 'target' => '_blank']) ?>
                                       
                                   
                           </td>
                     
                               <td><?= $item->catatan_pengganti?></td>
                          <td align='center'>
                        <?php  if ($item->update != null){
                   echo  $item->updates;
                  }else{
                    echo 'Tugas belum diserahkan';
                 }
                            ?>
                            
                            
                         </td>
                        </tr>
  
  
                        
                <?php endforeach; ?>
              
            </table>
        </div>
    </div>
</div>
</div>
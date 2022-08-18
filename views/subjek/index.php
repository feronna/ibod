<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpraddress */

$this->title = $level;

?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         <?= Html::a('Kembali', ['pendidikan/view', 'icno' => $ICNO], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('Tambah Mata Pelajaran', ['tambahmatapelajaran', 'EduAch_id'=>$EduAch_id, 'ICNO'=>$ICNO, 'EduCd'=>$EduCd, 'level'=>$level], ['class' => 'btn btn-primary']) ?>   
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>Subjek</th>
                    <th>Gred</th>
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php if($subjek) {
                    
                   foreach ($subjek as $subjekkakitangan) {
                    
                ?>
                   
                <tr>
                    <td><?= $subjekkakitangan->subjek->subject_name; ?></td>
                    <td><?= $subjekkakitangan->gred->grade_name; ?></td>
                    <td class="text-center"><?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update', 'id' => $subjekkakitangan->id, 'ICNO'=>$ICNO, 'EduCd'=>$EduCd, 'level'=>$level]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $subjekkakitangan->id, 'ICNO'=>$ICNO, 'EduCd'=>$EduCd], [
                         'data' => [
                                   'confirm' => 'Anda ingin membuang rekod ini?',
                                   'method' => 'post',
                                       ],
                                    ]) ?></td>  
                </tr>

                <?php }
                 }
                   
                else{
                    ?>
                    <tr>
                        <td colspan="3" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                   } 
                ?>
            </table>
            </div>
        </div>
    </div>
</div>




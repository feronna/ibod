<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ptb\TblTugasBelumSelesaiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nota Serah Tugas';
$this->params['breadcrumbs'][] = $this->title;
$statusLabel = [
        1 => '<span class="label label-primary">Nota Serah Tugas selesai dihantar</span>',
        0 => '<span class="label label-danger">Nota Serah Tugas belum dihantar</span>',
    
];
?>

       <?php echo $this->render('/ptb/_menu'); ?>
    
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Nota Serah Tugas</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="respon"
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tr>
                    <th class="text-center">Bil</th>
                    <th class="text-center">Nama Pemohon</th>
                    <th class="text-center">Nama Penerima</th>
                    <th class="text-center">Salinan Surat</th>
                      <th class="text-center">Tarikh Surat Dihantar</th>
	            <th class="text-center">Status Surat</th>
                  
                     <th class="text-center">Tindakan</th>
                
         </tr>
                </thead>
                <tbody>
                    <?php 
                    if($lihatNota){
                    foreach ($lihatNota as $key => $lihatNota) { 
                        ?>
                        <tr>
                            <td><?= $key+1?></td>
                            <td align='center'><?= $lihatNota->pemohon_name?></td>
                            <td align='center'><?= \app\models\hronline\Department::find()->where(['id' => $lihatNota->old_dept])->one()->chiefBiodata->CONm?></td>
                             <td align= 'center'>
                                   <?php  if ($lihatNota->serahTugas->tugas_id != null){
            echo \yii\helpers\Html::a('', ['ptb/tugas-generate-letter', 'id' => $lihatNota->id], ['class'=>'fa fa-download', 'target' => '_blank']) ;
                  }else{
                    echo '';
                 }
                ?>
                                      
                                       
                               
                       </td>
                           <td align= 'center'>
                        <?php  if ($lihatNota->tarikh_individu_hantar != null){
                   echo  $lihatNota->tarikhIndividuHantar;
                  }else{
                    echo 'Surat Belum Dihantar';
                 }
                ?>
                            
                            
                            </td>
                           
                            <td align= 'center'>
                                     <?=$statusLabel[$lihatNota->nota_sent]?>
                            </td>
           
           <td align='center'>
                        <?php  if ($lihatNota->serahTugas->tugas_id != null){
                        echo Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['serah-tugas-individu', 'id' => $lihatNota->id]),'style'=>'background-color: transparent; 
                        border: none;',  'class' => 'fa fa-edit mapBtn'])?></td>
                    <?php }else{
                        echo 'Serah Tugas Belum Wujud';
                    }
                    
                    
                    
                        }} ?>
                            
                            
                         
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

   
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
       
        <div class="x_content">
       <div class="tbl-serah-tugas-index">

 
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
    
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            'senarai_tugas',
            'tugas_belum_selesai',
            'kedudukan_sekarang',
            'tindakan_susulan',
            'rujukan_fail',
            'senarai_harta_benda',
            'kedudukan_kewangan',
            'catatan',

         
            ['class' => 'yii\grid\ActionColumn','template'=>'{update} {delete}'],
        ],
    ]); ?>
</div>
</div>
</div>
    </div>
    </div>

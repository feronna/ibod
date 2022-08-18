<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\GredJawatan;
use app\models\hronline\Department;
use yii\widgets\LinkPager;
use app\models\hronline\Kumpkhidmat;

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\TblprcobiodataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Senarai Kakitangan 5 tahun ke atas di jabatan semasa';
?>


<div class="tblprcobiodata-form" >

    <?php $form = ActiveForm::begin([
        'action' => ['sejarah-penempatan'],
        'method' => 'get',
    'options' => ['class' => 'form-horizontal form-label-left']
    ]); ?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel" style="background-color:#b4c4d4;color:#37393b;">
        <div class="x_title">
            <h2>Carian</h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
     <div class="x_content">
            <div class="form-group ">
                <div class="form-group">
                <div class=" col-md-2 col-sm-2 col-xs-12">
                    <?=
                    $form->field($carian, 'jenis_carian')->label(false)->widget(Select2::classname(), [
                        'data' => ["1"=>"Nama","2"=>"UMSPER"],
                        'options' => ['placeholder' => 'Jenis Carian', 'class' => 'form-control col-md-2 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?> 
                </div>
                <div class=" col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($carian, 'carian_data')->textInput(['placeholder'=>'Nama / UMSPER'])->label(false) ?> 
                </div>
                <div class=" col-md-3 col-sm-3 col-xs-12">
                    <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Cari', ['class' => 'btn btn-primary']) ?> 
                </div>
                
                
                </div>
                <div class="form-group">
                   <div class=" col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($carian, 'carian_department')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Department::find()->all(), 'id', 'shortname'),
                        'options' => ['placeholder' => 'Jabatan', 'class' => 'form-control col-md-4 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
              
                 </div>
                
                  <div class="form-group">
                     <div class=" col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($carian, 'carian_jawatan')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(GredJawatan::find()->all(), 'id', 'fname'),
                        'options' => ['placeholder' => 'Jawatan', 'class' => 'form-control col-md-4 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
              
                 </div>
            </div>           
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
</div>


<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
             <h2>Senarai Kakitangan 5 Tahun Ke atas di Jabatan Semasa</h2>
             <div align="right">
             </div>
       
            <div class="clearfix"></div>
     
           
        <div class="x_content">
            <div class="table-responsive">
                <div class="tblprcobiodata-index">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <thead>
                            <tr class="headings">
                              
                                <th style="width: 300px">No KP / Paspot</th>
                                <th style="width: 800px">Nama</th>
                                <th style="width: 800px">UMSPER</th>
                                <th style="width: 800px">Jawatan dan Gred</th>
                                <th style="width: 800px">JFPIU</th>
                                <th style="width: 800px">Kampus</th>
                                <th style="width: 800px">Tempoh Penempatan Semasa</th>
                              
                            </tr>
                        </thead>   
                        <!--A-->
                        
                        <?php
                            #foreach data
                        
                          foreach ($model->getModels() as $key=>$data) {
//                           foreach($lists as $key=>$data){
                                if($past_5 >= strtotime($data['jabatanSemasa2']['date_start'])){ ?>
                        
                                <tr>  
<!--                                    <td width="10px"><?= $key+1?></td>-->
                                    <td><?= $data->ICNO?></td>
                                    <td><?= $data->CONm ?></td>
                                    <td><?= $data->COOldID?></td>
                                    <td><?= $data->jawatan->nama ?>  (<?= $data->jawatan->gred?>)</td>
                                    <td><?= $data->department->fullname ?></td>
                                    <td><?= $data->kampus->campus_name?></td>
                                    <td><?php

                                        $date1 = date_create(date('d-m-Y'));
                                        $date2 = date_create($data['jabatanSemasa2']['date_start']);
                                        $tempohPenempatan = date_diff($date1, $date2)->format('%y Tahun %m Bulan %d Hari');
                                        echo $tempohPenempatan;
                                        ?>
                                   </td>
                                 
                                </tr>
                               <?php 
                           } }
                        ?>
                    </table>
                </div>
            </div>
 
            <?php
                echo LinkPager::widget([
                    'pagination' => $model->pagination,
                ]);
            ?>
          
        </div>
    </div>

</div>
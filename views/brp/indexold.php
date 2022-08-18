<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\GredJawatan;
use app\models\hronline\Department;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\TblprcobiodataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rekod Perkhidmatan';
?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <?php echo $this->render('/brp/_menu');?>



    <div class="x_panel">
        <div class="x_title">
            <h2>Carian Kakitangan</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a></li>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content ">
            <?= $this->render('_search',['model'=>$model1]); ?>
        </div>
    </div>




    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <div class="tblprcobiodata-index">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <thead>
                            <tr class="headings">
                        
                                <th style="width: 800px">No KP / Paspot</th>
                                <th style="width: 800px">UMSPER</th>
                                <th style="width: 800px">Nama Kakitangan</th>
                                <th style="width: 800px">Gred </th>
                                <th style="width: 800px">Jabatan</th>
                                <th style="width: 800px">Status Lantikan</th>
                                <th style="width: 800px">Status Pekerja</th>
                                <th class="text-center" style="width:auto">Tindakan</th>   
                            </tr>
                        </thead>   
                        <!--A-->
                          <?php 
                   
                
                                foreach ($model  as $data) :?>
                                <tr>
                                 
                                    <td><?= $data->ICNO ?></td>
                                    <td><?= $data->COOldID ?></td>
                                    <td><?= $data->CONm ?></td>
                                    <td>
                                    <?= $data->jawatan->nama . " (" . $data->jawatan->gred . ")"; ?></td>
                                    <td><?= $data->displayDepartment ?></td>
                                    <td><?= $data->statusLantikan->ApmtStatusNm ?></td>
                                    <td><?= $data->displayServiceStatus ?></td>
                                    <td class="text-center">
                                        <?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['view','id'=>$data->ICNO]) ?>
                                        <?= Html::a('<i class="fa fa-book" aria-hidden="true"></i>', ['book','id'=>$data->ICNO], ['target'=>'_blank']) ?>
                                        
                                    </td>  
                                </tr>
                                 <?php endforeach;
?>
                    </table>
                </div>
            </div>
            
               <?= LinkPager::widget([
                'pagination' => $pages,
                
            ]) ;?>
        </div>
    </div>
</div>

